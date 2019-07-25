<?php
/**
 * Tour Operator - Continent taxonomy config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$taxonomy = array(
	'object_types'  => 'destination',
	'menu_position' => 15,
	'args'          => array(
		'hierarchical'        => true,
		'labels'              => array(
			'name'              => _x( 'Regions', 'taxonomy general name', 'tour-operator' ),
			'singular_name'     => _x( 'Region', 'taxonomy singular name', 'tour-operator' ),
			'search_items'      => __( 'Search Regions', 'tour-operator' ),
			'all_items'         => __( 'All Regions', 'tour-operator' ),
			'parent_item'       => __( 'Parent Region', 'tour-operator' ),
			'parent_item_colon' => __( 'Parent Region:', 'tour-operator' ),
			'edit_item'         => __( 'Edit Region', 'tour-operator' ),
			'update_item'       => __( 'Update Region', 'tour-operator' ),
			'add_new_item'      => __( 'Add New Region', 'tour-operator' ),
			'new_item_name'     => __( 'New Region Name', 'tour-operator' ),
			'menu_name'         => __( 'Region', 'tour-operator' ),
		),
		'show_ui'             => false,
		'show_in_quick_edit'  => true,
		'show_in_nav_menus'   => false,
		'public'              => true,
		'show_tagcloud'       => false,
		'exclude_from_search' => true,
		'show_admin_column'   => false,
		'query_var'           => true,
		'rewrite'             => array(
			'slug' => 'region',
		),
	),
);

return $taxonomy;
