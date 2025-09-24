#!/bin/bash

# WordPress Test Suite Setup Script for Tour Operator Plugin
# This script sets up the WordPress testing environment

set -e

# Configuration
DB_NAME=${1-tour_operator_test}
DB_USER=${2-root}
DB_PASS=${3-}
DB_HOST=${4-localhost}
WP_VERSION=${5-latest}
SKIP_DB_CREATE=${6-false}

# Set the tests directory
WP_TESTS_DIR=${WP_TESTS_DIR-/tmp/wordpress-tests-lib}
WP_CORE_DIR=${WP_CORE_DIR-/tmp/wordpress/}

echo "Setting up WordPress test environment..."
echo "DB_NAME: $DB_NAME"
echo "DB_USER: $DB_USER"
echo "DB_HOST: $DB_HOST"
echo "WP_VERSION: $WP_VERSION"
echo "WP_TESTS_DIR: $WP_TESTS_DIR"
echo "WP_CORE_DIR: $WP_CORE_DIR"

# Download the WordPress test suite
download_wp_testsuite() {
	# Portable in-place argument for both GNU sed and Mac OSX sed
	if [[ $(uname -s) == 'Darwin' ]]; then
		local ioption='-i .bak'
	else
		local ioption='-i'
	fi

	# Set up testing suite if it doesn't yet exist
	if [ ! -d "$WP_TESTS_DIR" ]; then
		# Set up testing suite
		mkdir -p "$WP_TESTS_DIR"
		cd "$WP_TESTS_DIR"

		if [ $WP_VERSION == 'latest' ]; then
			local BRANCH='trunk'
		elif [[ $WP_VERSION =~ ^[0-9]+\.[0-9]+\.(x|latest)$ ]]; then
			# version x.x.x or x.x.latest
			local BRANCH="branches/${WP_VERSION%.*}"
		elif [[ $WP_VERSION =~ [0-9]+\.[0-9]+$ ]]; then
			# version x.x
			local BRANCH="branches/$WP_VERSION"
		elif [[ $WP_VERSION =~ (nightly|trunk) ]]; then
			local BRANCH='trunk'
		else
			# tag
			local BRANCH="tags/$WP_VERSION"
		fi

		echo "Downloading WordPress test suite from branch: $BRANCH"

		# Try to download using curl/wget
		if command -v curl > /dev/null; then
			echo "Using curl to download test files..."
			mkdir -p includes data

			# Download essential files
			curl -s "https://develop.svn.wordpress.org/$BRANCH/tests/phpunit/includes/functions.php" -o "includes/functions.php" || echo "Failed to download functions.php"
			curl -s "https://develop.svn.wordpress.org/$BRANCH/tests/phpunit/includes/bootstrap.php" -o "includes/bootstrap.php" || echo "Failed to download bootstrap.php"
			curl -s "https://develop.svn.wordpress.org/$BRANCH/tests/phpunit/includes/testcase.php" -o "includes/testcase.php" || echo "Failed to download testcase.php"

		elif command -v wget > /dev/null; then
			echo "Using wget to download test files..."
			mkdir -p includes data

			wget -q "https://develop.svn.wordpress.org/$BRANCH/tests/phpunit/includes/functions.php" -O "includes/functions.php" || echo "Failed to download functions.php"
			wget -q "https://develop.svn.wordpress.org/$BRANCH/tests/phpunit/includes/bootstrap.php" -O "includes/bootstrap.php" || echo "Failed to download bootstrap.php"
			wget -q "https://develop.svn.wordpress.org/$BRANCH/tests/phpunit/includes/testcase.php" -O "includes/testcase.php" || echo "Failed to download testcase.php"

		else
			echo "Neither curl nor wget found. Creating minimal test suite..."
			create_minimal_test_suite
		fi
	fi
}

# Create a minimal test suite if downloads fail
create_minimal_test_suite() {
	echo "Creating minimal WordPress test suite..."
	mkdir -p "$WP_TESTS_DIR/includes"

	# Create a minimal functions.php
	cat > "$WP_TESTS_DIR/includes/functions.php" << 'EOF'
<?php
/**
 * Minimal WordPress test suite functions
 */

if ( ! function_exists( 'tests_add_filter' ) ) {
	function tests_add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		add_filter( $tag, $function_to_add, $priority, $accepted_args );
	}
}

if ( ! function_exists( 'add_filter' ) ) {
	function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		// Minimal implementation
		return true;
	}
}

// Define minimal WordPress constants
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', '/tmp/wordpress/' );
}

if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}
EOF

	# Create a minimal bootstrap.php
	cat > "$WP_TESTS_DIR/includes/bootstrap.php" << 'EOF'
<?php
/**
 * Minimal WordPress test bootstrap
 */

// Require the functions file
require_once __DIR__ . '/functions.php';

echo "WordPress test environment loaded (minimal version)\n";
EOF
}

# Download WordPress core
download_wp_core() {
	mkdir -p "$WP_CORE_DIR"

	if [ $WP_VERSION == 'latest' ]; then
		local ARCHIVE_NAME='latest'
	elif [[ $WP_VERSION =~ [0-9]+\.[0-9]+ ]]; then
		# https serves multiple builds for releases like 4.9.1
		# we want the non-https release archive
		local ARCHIVE_NAME="wordpress-$WP_VERSION"
	else
		local ARCHIVE_NAME="wordpress-$WP_VERSION"
	fi

	echo "Downloading WordPress core version: $WP_VERSION"

	if command -v curl > /dev/null; then
		curl -s "https://wordpress.org/${ARCHIVE_NAME}.tar.gz" | tar --strip-components=1 -xzf - -C "$WP_CORE_DIR" || echo "Failed to download WordPress core"
	elif command -v wget > /dev/null; then
		wget -nv -O- "https://wordpress.org/${ARCHIVE_NAME}.tar.gz" | tar --strip-components=1 -xzf - -C "$WP_CORE_DIR" || echo "Failed to download WordPress core"
	else
		echo "Cannot download WordPress core - neither curl nor wget available"
	fi
}

# Create database
create_db() {
	if [ ${SKIP_DB_CREATE} = "true" ]; then
		echo "Skipping database creation..."
		return 0
	fi

	# Parse DB_HOST for port or socket references
	local PARTS=(${DB_HOST//\:/ })
	local DB_HOSTNAME=${PARTS[0]};
	local DB_SOCK_OR_PORT=${PARTS[1]};
	local EXTRA=""

	if ! [ -z $DB_HOSTNAME ] ; then
		if [ $(echo $DB_SOCK_OR_PORT | grep -e '^[0-9]\{1,\}$') ]; then
			EXTRA=" --host=$DB_HOSTNAME --port=$DB_SOCK_OR_PORT --protocol=tcp"
		elif ! [ -z $DB_SOCK_OR_PORT ] ; then
			EXTRA=" --socket=$DB_SOCK_OR_PORT"
		elif ! [ -z $DB_HOSTNAME ] ; then
			EXTRA=" --host=$DB_HOSTNAME --protocol=tcp"
		fi
	fi

	echo "Creating database $DB_NAME..."

	# Create database
	if command -v mysql > /dev/null; then
		mysql --user="$DB_USER" --password="$DB_PASS"$EXTRA -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;" 2>/dev/null || echo "Database creation may have failed or database already exists"
	else
		echo "MySQL client not found - skipping database creation"
		echo "You may need to create the database '$DB_NAME' manually"
	fi
}

# Main execution
echo "Starting WordPress test environment setup..."

download_wp_testsuite
download_wp_core
create_db

echo "WordPress test environment setup complete!"
echo ""
echo "To use this environment, set these environment variables:"
echo "export WP_TESTS_DIR='$WP_TESTS_DIR'"
echo "export WP_CORE_DIR='$WP_CORE_DIR'"
echo "export WP_TESTS_DB_NAME='$DB_NAME'"
echo "export WP_TESTS_DB_USER='$DB_USER'"
echo "export WP_TESTS_DB_PASSWORD='$DB_PASS'"
echo "export WP_TESTS_DB_HOST='$DB_HOST'"
echo ""
echo "Then run: composer test:wp"
