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

// Set up the WordPress testing environment
$_tests_dir = getenv('WP_TESTS_DIR');

// If WP_TESTS_DIR is not set, try to find it
if (! $_tests_dir) {
	$_tests_dir = rtrim(sys_get_temp_dir(), '/\\') . '/wordpress-tests-lib';
}

// If it still doesn't exist, try common locations
if (! file_exists($_tests_dir . '/includes/functions.php')) {
	$possible_locations = [
		'/tmp/wordpress-tests-lib',
		dirname(__DIR__) . '/wordpress-tests-lib',
		dirname(dirname(dirname(__DIR__))) . '/wordpress-tests-lib',
	];

	foreach ($possible_locations as $location) {
		if (file_exists($location . '/includes/functions.php')) {
			$_tests_dir = $location;
			break;
		}
	}
}

if (! file_exists($_tests_dir . '/includes/functions.php')) {
	echo "Could not find WordPress test suite. Please set WP_TESTS_DIR environment variable.\n";
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
	if (! defined('LSX_TO_PATH')) {
		define('LSX_TO_PATH', dirname(dirname(__FILE__)) . '/');
	}

	if (! defined('LSX_TO_URL')) {
		define('LSX_TO_URL', plugin_dir_url(dirname(__FILE__)));
	}

	if (! defined('LSX_TO_VER')) {
		define('LSX_TO_VER', '2.1.0');
	}

	// Load the plugin
	require dirname(dirname(__FILE__)) . '/tour-operator.php';
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
