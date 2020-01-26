<?php
/**
 * Tour Operator - Destinations Post Type config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$post_type = array(
	'class'              => \lsx\legacy\Destination::get_instance(),
	'menu_icon'          => 'dashicons-admin-site',
	'labels'             => array(
		'name'               => esc_html__( 'Destinations', 'tour-operator' ),
		'singular_name'      => esc_html__( 'Destination', 'tour-operator' ),
		'add_new'            => esc_html__( 'Add New', 'tour-operator' ),
		'add_new_item'       => esc_html__( 'Add Destination', 'tour-operator' ),
		'edit_item'          => esc_html__( 'Edit Destination', 'tour-operator' ),
		'new_item'           => esc_html__( 'New Destination', 'tour-operator' ),
		'all_items'          => esc_html__( 'Destinations', 'tour-operator' ),
		'view_item'          => esc_html__( 'View Destination', 'tour-operator' ),
		'search_items'       => esc_html__( 'Search Destinations', 'tour-operator' ),
		'not_found'          => esc_html__( 'No destinations found', 'tour-operator' ),
		'not_found_in_trash' => esc_html__( 'No destinations found in Trash', 'tour-operator' ),
		'parent_item_colon'  => '',
		'menu_name'          => esc_html__( 'Destinations', 'tour-operator' ),
	),
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => 'tour-operator',
	'menu_position'      => 10,
	'query_var'          => true,
	'rewrite'            => array(
		'slug' => 'destination',
		),
	'capability_type'    => 'page',
	'has_archive'        => 'destinations',
	'hierarchical'       => true,
	'supports'           => array(
		'title',
		'editor',
		'thumbnail',
		'excerpt',
		'custom-fields',
		'page-attributes',
	),
	'show_in_rest'       => true,
	'rest_base'          => 'destinations',
	'rest_controller_class' => 'WP_REST_Posts_Controller',
	'show_in_graphql'     => true,
	'graphql_single_name' => 'Destination',
	'graphql_plural_name' => 'Destinations',
);

return $post_type;
