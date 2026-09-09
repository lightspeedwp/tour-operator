<?php
/**
 * WordPress test-suite configuration.
 *
 * This file is not loaded directly. The WordPress test bootstrap loads
 * vendor/wp-phpunit/wp-phpunit/wp-tests-config.php, which requires this file via the
 * WP_PHPUNIT__TESTS_CONFIG environment variable that phpunit.xml sets, and then defines
 * $table_prefix itself from WP_PHPUNIT__TABLE_PREFIX.
 *
 * Every value is read from the environment so the same file works locally and in CI
 * without edits. WordPress core comes from the roots/wordpress-no-content Composer
 * package, so the core version is pinned in composer.lock and there is no download step.
 *
 * No functions are declared here: PHPUnit loads the bootstrap inside a function, so a
 * declaration at this point would be a global side effect of that call.
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

// getenv() returns false when unset; '?:' also catches an empty string, which is what an
// unset variable looks like when passed through a CI matrix.
define( 'DB_NAME', getenv( 'WP_TESTS_DB_NAME' ) ?: 'tour_operator_test' );
define( 'DB_USER', getenv( 'WP_TESTS_DB_USER' ) ?: 'root' );
define( 'DB_PASSWORD', false === getenv( 'WP_TESTS_DB_PASSWORD' ) ? '' : getenv( 'WP_TESTS_DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'WP_TESTS_DB_HOST' ) ?: '127.0.0.1' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define( 'WP_TESTS_DOMAIN', getenv( 'WP_TESTS_DOMAIN' ) ?: 'example.org' );
define( 'WP_TESTS_EMAIL', getenv( 'WP_TESTS_EMAIL' ) ?: 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Tour Operator Tests' );

define( 'WP_PHP_BINARY', 'php' );
define( 'WPLANG', '' );

define( 'WP_DEBUG', true );

// '0' is falsy in PHP, so an explicit "0" from the environment correctly means single site.
define( 'WP_TESTS_MULTISITE', (bool) ( getenv( 'WP_TESTS_MULTISITE' ) ?: false ) );

// The Composer-installed WordPress core. Must end in a trailing slash.
define( 'ABSPATH', dirname( __DIR__ ) . '/vendor/roots/wordpress-no-content/' );
