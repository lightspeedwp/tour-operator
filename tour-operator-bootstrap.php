<?php
/**
 * LSX Tour Operator Bootstrapper
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 LightSpeed
 */
// If this file is called directly, abort.
if ( defined( 'WPINC' ) ) {

	if ( ! defined( 'DEBUG_SCRIPTS' ) ) {
		define( 'LSX_TO_ASSET_DEBUG', '.min' );
	} else {
		define( 'LSX_TO_ASSET_DEBUG', '' );
	}

	require_once( LSX_TO_PATH . 'vendor/cmb2/init.php' );
	require_once( LSX_TO_PATH . 'vendor/cmb2-field-map/cmb-field-map.php' );
	require_once( LSX_TO_PATH . 'vendor/cmb-field-select2/cmb-field-select2.php' );
	require_once( LSX_TO_PATH . 'vendor/content-models/create-content-model.php' );

	// Template Tags.
	require_once( LSX_TO_PATH . 'includes/template-tags/general.php' );
	require_once( LSX_TO_PATH . 'includes/template-tags/helpers.php' );
	require_once( LSX_TO_PATH . 'includes/template-tags/addons.php' );
	require_once( LSX_TO_PATH . 'includes/template-tags/accommodation.php' );
	require_once( LSX_TO_PATH . 'includes/template-tags/destination.php' );
	require_once( LSX_TO_PATH . 'includes/template-tags/tour.php' );
	require_once( LSX_TO_PATH . 'includes/template-tags/maps.php' );
	require_once( LSX_TO_PATH . 'includes/template-tags/videos.php' );

	// General Includes.
	require_once( LSX_TO_PATH . 'includes/customizer.php' );
	require_once( LSX_TO_PATH . 'includes/layout.php' );
	require_once( LSX_TO_PATH . 'includes/shortcodes.php' );

	add_action( 'after_setup_theme', function() {
		require_once( LSX_TO_PATH . 'includes/actions.php' );
	} );

	// include context helper & autoloader.
	require_once( LSX_TO_PATH . 'includes/tour-operator.php' );
	// Include functions.
	require_once( LSX_TO_PATH . 'includes/functions.php' );

	// Register tour operator autoloader.
	spl_autoload_register( 'tour_operator_autoload_class', true, false );

	// init legacy.
	\lsx\legacy\Tour_Operator::get_instance();

	// Init Plugin.
	tour_operator();
}
