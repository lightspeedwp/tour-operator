<?php

/**
 * PHPUnit bootstrap file for Tour Operator Plugin
 *
 * @package Tour_Operator
 */

// Define testing constants
if (! defined('LSX_TO_TESTING')) {
	define('LSX_TO_TESTING', true);
}

// Composer autoload also runs wp-phpunit's __loaded.php, which exports WP_PHPUNIT__DIR.
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

// The WordPress test suite comes from the wp-phpunit/wp-phpunit package. WP_TESTS_DIR
// still wins so an externally installed suite can be used instead.
$_tests_dir = getenv('WP_TESTS_DIR');

if (! $_tests_dir) {
	$_tests_dir = getenv('WP_PHPUNIT__DIR');
}

if (! $_tests_dir || ! file_exists($_tests_dir . '/includes/functions.php')) {
	echo "Could not find the WordPress test suite.\n";
	echo "Run 'composer install' to fetch wp-phpunit/wp-phpunit, or set WP_TESTS_DIR.\n";
	exit(1);
}

// Give access to tests_add_filter() function
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested
 */
function _manually_load_plugin()
{
	// Define plugin constants
	// Do not pre-define LSX_TO_PATH, LSX_TO_URL or LSX_TO_VER here. The plugin defines
	// all three itself, and defining them first wins — which previously pinned
	// LSX_TO_VER to a hardcoded 2.1.0 for the whole test run regardless of the real
	// plugin version.
	require dirname(__DIR__, 2) . '/tour-operator.php';
}

tests_add_filter('muplugins_loaded', '_manually_load_plugin');

/**
 * Set up test database and WordPress environment
 */
function _setup_test_environment()
{
	// Flush rewrite rules
	global $wp_rewrite;
	$wp_rewrite->init();
	$wp_rewrite->flush_rules();

	// Create required pages or posts for testing
	// This can be extended based on plugin requirements
}

tests_add_filter('wp_loaded', '_setup_test_environment');

/**
 * Install WooCommerce if needed for integration tests
 */
function _maybe_install_woocommerce()
{
	if (class_exists('WooCommerce')) {
		// Activate WooCommerce for tests that need it
		$GLOBALS['wc_notices'] = [];
	}
}

tests_add_filter('init', '_maybe_install_woocommerce');

// Start up the WP testing environment
require $_tests_dir . '/includes/bootstrap.php';

// Load test utilities
require_once __DIR__ . '/utils/class-tour-operator-test-case.php';
require_once __DIR__ . '/utils/class-tour-operator-factory.php';
