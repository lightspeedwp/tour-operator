<?php
/**
 * Tour Operator Helper Functions
 *
 * @package   tour_operator
 * @author    David Cramer
 * @license   GPL-2.0+
 * @copyright 2017 David Cramer
 */


/**
 * Tour Operator class autoloader.
 * It locates and finds class via classes folder structure.
 *
 * @since 1.0.7
 *
 * @param string $class class name to be checked and loaded.
 */
function tour_operator_autoload_class( $class ) {
	$parts = explode( '\\', $class );
	$name  = strtolower( str_replace( '_', '-', array_shift( $parts ) ) );
	if ( file_exists( LSX_TO_PATH . 'classes/' . $name ) ) {
		if ( ! empty( $parts ) ) {
			$name .= '/' . implode( '/', $parts );
		}
		$class_file = LSX_TO_PATH . 'classes/class-' . $name . '.php';
		if ( file_exists( $class_file ) ) {
			include_once $class_file;
		}
	} elseif ( empty( $parts ) && file_exists( LSX_TO_PATH . 'classes/class-' . $name . '.php' ) ) {
		include_once LSX_TO_PATH . 'classes/class-' . $name . '.php';
	}
}

/**
 * Tour Operator Helper to load and manipulate the overall instance.
 *
 * @since 1.0.7
 * @return  Tour_Operator  A single instance
 */
function tour_operator() {
	// Init tour operator and return object.
	return Tour_Operator::get_instance();
}

if ( ! function_exists( 'cmb_init' ) && ! class_exists( 'CMB_Meta_Box' ) ) {
	if ( is_file( LSX_TO_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php' ) ) {
		require_once( LSX_TO_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php' );
	}
}

// Classes
require_once( LSX_TO_PATH . 'classes/class-fields.php' );

// Template Tags
require_once( LSX_TO_PATH . 'includes/template-tags/general.php' );
require_once( LSX_TO_PATH . 'includes/template-tags/helpers.php' );
require_once( LSX_TO_PATH . 'includes/template-tags/addons.php' );
require_once( LSX_TO_PATH . 'includes/template-tags/accommodation.php' );
require_once( LSX_TO_PATH . 'includes/template-tags/destination.php' );
require_once( LSX_TO_PATH . 'includes/template-tags/tour.php' );

// General Includes
require_once( LSX_TO_PATH . 'includes/post-expirator.php' );
require_once( LSX_TO_PATH . 'includes/post-order.php' );
require_once( LSX_TO_PATH . 'includes/customizer.php' );
require_once( LSX_TO_PATH . 'includes/layout.php' );
require_once( LSX_TO_PATH . 'includes/actions.php' );

// Widgets
require_once( LSX_TO_PATH . 'includes/widgets/post-type-widget.php' );
require_once( LSX_TO_PATH . 'includes/widgets/taxonomy-widget.php' );
require_once( LSX_TO_PATH . 'includes/widgets/cta-widget.php' );


/**
 * Returns an array of the tour taxonomies.
 *
 * @since unknown
 * @return array List of tour operator taxonomies.
 */
function lsx_to_get_taxonomies() {
	return tour_operator()->get_taxonomies();
}

/**
 * Returns an array of the tour post types.
 *
 * @since unknown
 * @return array List of tour operator post types.
 */
function lsx_to_get_post_types() {
	return tour_operator()->get_post_types();
}
