<?php
/**
 * LSX Tour Operator - settings page config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$page = array(
	'page_title'    => esc_html__( 'LSX Tour Operator Settings', 'tour-operator' ),
	'menu_title'    => esc_html__( 'Settings', 'tour-operator' ),
	'capability'    => 'manage_options',
	'icon'          => 'dashicons-book-alt',
	'parent_slug'   => 'tour-operator',
	'slug'          => 'lsx-to-settings',
	'menu_position' => 90,
	'assets'        => array(
		'callback' => function () {
		},
	),
	'callback'      => function () {
		include( LSX_TO_PATH . 'includes/partials/settings.php' );
	},
);

return $page;
