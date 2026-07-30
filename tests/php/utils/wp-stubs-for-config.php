<?php

/**
 * Minimal WordPress / LSX function stubs so metabox config files can be
 * included in standalone (non-WP) PHPUnit runs. Only what config-tour.php uses.
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

if (! function_exists('esc_html__')) {
	function esc_html__($text, $domain = 'default')
	{
		return $text;
	}
}

if (! function_exists('__')) {
	function __($text, $domain = 'default')
	{
		return $text;
	}
}

if (! function_exists('apply_filters')) {
	function apply_filters($hook, $value)
	{
		return $value;
	}
}

if (! function_exists('post_type_exists')) {
	function post_type_exists($post_type)
	{
		return true;
	}
}

if (! function_exists('lsx_to_get_drink_basis_options')) {
	function lsx_to_get_drink_basis_options()
	{
		return array();
	}
}

if (! function_exists('lsx_to_get_room_basis_options')) {
	function lsx_to_get_room_basis_options()
	{
		return array();
	}
}

if (! function_exists('tour_operator')) {
	function tour_operator()
	{
		static $instance;
		if (null === $instance) {
			$instance = new class {
				public $options = array();
			};
		}
		return $instance;
	}
}
