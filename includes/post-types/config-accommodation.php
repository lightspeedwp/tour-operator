<?php
/**
 * LSX Tour Operator - Accommodation Post Type config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$post_type = array(
	'class'               => \lsx\legacy\Accommodation::get_instance(),
	'menu_icon'           => 'dashicons-admin-multisite',
	'labels'              => array(
		'name'               => esc_html__( 'Accommodation', 'tour-operator' ),
		'singular_name'      => esc_html__( 'Accommodation', 'tour-operator' ),
		'add_new'            => esc_html__( 'Add New', 'tour-operator' ),
		'add_new_item'       => esc_html__( 'Add Accommodation', 'tour-operator' ),
		'edit_item'          => esc_html__( 'Edit Accommodation', 'tour-operator' ),
		'all_items'          => esc_html__( 'Accommodation', 'tour-operator' ),
		'view_item'          => esc_html__( 'View Accommodation', 'tour-operator' ),
		'search_items'       => esc_html__( 'Search Accommodation', 'tour-operator' ),
		'not_found'          => esc_html__( 'No accommodation defined', 'tour-operator' ),
		'not_found_in_trash' => esc_html__( 'No accommodation in trash', 'tour-operator' ),
		'parent_item_colon'  => '',
		'menu_name'          => esc_html__( 'Accommodation', 'tour-operator' ),
	),
	'public'              => true,
	'publicly_queryable'  => true,
	'show_ui'             => true,
	'show_in_menu'        => 'tour-operator',
	'menu_position'       => 30,
	'query_var'           => true,
	'rewrite'             => array(
		'slug'       => 'accommodation',
		'with_front' => false,
	),
	'exclude_from_search' => false,
	'capability_type'     => 'post',
	'has_archive'         => 'accommodation',
	'hierarchical'        => false,
	'show_in_rest'        => true,
	'supports'            => array(
		'title',
		'slug',
		'editor',
		'thumbnail',
		'excerpt',
		'custom-fields',
	),
);

return $post_type;
