<?php
/**
 * Tour Operator helper functions
 *
 * @package   Tour_Operator
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeed
 **/

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

	if ( 'lsx' === $parts[0] ) {
		$path = LSX_TO_PATH . 'includes/classes/';
		array_shift( $parts );
		$name = array_shift( $parts );

		if ( file_exists( $path . $name ) ) {
			$file = str_replace( '_', '-', strtolower( array_pop( $parts ) ) );
			if ( ! empty( $parts ) ) {
				$path .= '/' . implode( '/', $parts );
			}
			$class_file = $path . $name . '/class-' . $file . '.php';
			if ( file_exists( $class_file ) ) {
				include_once $class_file;

				return;
			}
		}
		$name = str_replace( '_', '-', strtolower( $name ) );

		if ( file_exists( LSX_TO_PATH . 'includes/classes/class-' . $name . '.php' ) ) {
			include_once LSX_TO_PATH . 'includes/classes/class-' . $name . '.php';
		}
	}

}

/**
 * Tour Operator wrapper to load and manipulate the overall instances.
 *
 * @since 1.0.7
 * @return  \lsx\Tour_Operator  A single instance
 */
function tour_operator() {
	// Init tour operator and return object.
	return \lsx\Tour_Operator::init();
}

/**
 * LSX Helper to manipulate shared assets.
 *
 * @since 1.1.0
 */
function lsx_share() {
	// init shared.
	return \lsx\Share::init();
}
