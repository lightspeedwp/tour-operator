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
 * A template tag to output the banner bg src
 *
 * @package     lsx-banners
 * @subpackage  template-tag
 * @category    image
 */
function lsx_banner_src() {
	global $lsx_banners;
	$lsx_banners->frontend->banner();
}

/**
 * Returns a true or false if there is a banner.
 *
 * @package     lsx-banners
 * @subpackage  template-tag
 * @category    conditional
 */
function lsx_has_banner() {
	global $lsx_banners;
	return $lsx_banners->has_banner;
}

/**
 * Returns a true or false if there is a banner.
 *
 * @package     lsx-banners
 * @subpackage  template-tag
 * @category    conditional
 */
function lsx_is_banner_disabled() {
	global $lsx_banners;
	return $lsx_banners->frontend->banner_disabled;
}

/**
 * Down Arrow navigation for the homepage banner
 *
 * @package     lsx-banners
 * @subpackage  template-tag
 * @category    shortcode
 */
function lsx_banner_navigation( $echo = false ) {
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

