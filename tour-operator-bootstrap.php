<?php
/**
 * Tour Operator Bootstrapper
 *
 * @package   tour_operator
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
// If this file is called directly, abort.
if ( defined( 'WPINC' ) ) {

	if ( ! defined( 'DEBUG_SCRIPTS' ) ) {
		define( 'LSX_TO_ASSET_DEBUG', '.min' );
	} else {
		define( 'LSX_TO_ASSET_DEBUG', '' );
	}

	// include context helper functions and autoloader.
	require_once( LSX_TO_PATH . 'includes/functions.php' );
	// include core class.
	// @todo Make autoloaded and init.
	require_once( LSX_TO_PATH . 'module.php' );

	// Register tour operator autoloader.
	spl_autoload_register( 'tour_operator_autoload_class', true, false );

	// Init Plugin.
	add_action( 'plugins_loaded', 'tour_operator' );
}
