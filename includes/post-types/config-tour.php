<?php
/**
 * Tour Operator - Tour Post Type config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$post_type = array(
	'class'              => \lsx\legacy\Tour::get_instance(),
	'menu_icon'          => 'dashicons-admin-site',
	'labels'             => array(
		'name'               => esc_html__( 'Tours', 'tour-operator' ),
		'singular_name'      => esc_html__( 'Tour', 'tour-operator' ),
		'add_new'            => esc_html__( 'Add New', 'tour-operator' ),
		'add_new_item'       => esc_html__( 'Add Tour', 'tour-operator' ),
		'edit_item'          => esc_html__( 'Edit Tour', 'tour-operator' ),
		'new_item'           => esc_html__( 'New Tour', 'tour-operator' ),
		'all_items'          => esc_html__( 'Tours', 'tour-operator' ),
		'view_item'          => esc_html__( 'View Tour', 'tour-operator' ),
		'search_items'       => esc_html__( 'Search Tours', 'tour-operator' ),
		'not_found'          => esc_html__( 'No tours found', 'tour-operator' ),
		'not_found_in_trash' => esc_html__( 'No tours found in Trash', 'tour-operator' ),
		'parent_item_colon'  => '',
		'menu_name'          => esc_html__( 'Tours', 'tour-operator' ),
	),
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => 'tour-operator',
	'menu_position'      => 20,
	'query_var'          => true,
	'rewrite'            => array(
		'slug' => 'tour',
	),
	'capability_type'    => 'post',
	'has_archive'        => 'tours',
	'hierarchical'       => false,
	'supports'           => array(
		'title',
		'editor',
		'thumbnail',
		'excerpt',
		'custom-fields',
	),
);

return $post_type;
