<?php
/**
 * Template Tags
 *
 * @package   LSX Banners
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeed
 */

/**
 * Down Arrow navigation for the homepage banner
 *
 * @package     lsx-banners
 * @subpackage  template-tag
 * @category    shortcode
 */
function to_banner_navigation( $echo = false ) {
	$atts = array(
		'extra-top' => '0',
	);

	if ( is_array( $echo ) ) {
		$atts = shortcode_atts( $atts, $echo, 'banner_navigation' );
	}

	$return = '<div class="banner-easing"><a class="btn-scroll-to" href="#main" data-extra-top="' . $atts['extra-top'] . '"><i class="fa fa-angle-down" aria-hidden="true"></i></a></div>';

	if ( true === $echo ) {
		echo esc_attr( $return );
	} else {
		return $return;
	}
}

