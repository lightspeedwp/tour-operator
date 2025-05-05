<?php
/**
 * Tour Operator - Accommodation-type taxonomy config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$taxonomy = array(
	'object_types'  => 'accommodation',
	'menu_position' => 32,
	'args'          => array(
		'hierarchical'        => true,
		'labels'              => array(
			'name'              => esc_html__( 'Accommodation Types', 'tour-operator' ),
			'singular_name'     => esc_html__( 'Accommodation Type', 'tour-operator' ),
			'search_items'      => esc_html__( 'Search Accommodation Types', 'tour-operator' ),
			'all_items'         => esc_html__( 'Accommodation Types', 'tour-operator' ),
			'parent_item'       => esc_html__( 'Parent Accommodation Type', 'tour-operator' ),
			'parent_item_colon' => esc_html__( 'Parent Accommodation Type:', 'tour-operator' ),
			'edit_item'         => esc_html__( 'Edit Accommodation Type', 'tour-operator' ),
			'update_item'       => esc_html__( 'Update Accommodation Type', 'tour-operator' ),
			'add_new_item'      => esc_html__( 'Add New Accommodation Type', 'tour-operator' ),
			'new_item_name'     => esc_html__( 'New Accommodation Type', 'tour-operator' ),
			'menu_name'         => esc_html__( 'Accommodation Types', 'tour-operator' ),
			'description'       => esc_html__( 'Select the type(s) of accommodation (e.g., hotel, resort).', 'tour-operator' ),
		),
		'show_ui'             => true,
		'public'              => true,
		'show_in_rest'        => true,
		'show_tagcloud'       => false,
		'exclude_from_search' => true,
		'show_admin_column'   => false,
		'query_var'           => true,
		'rewrite'             => array(
			'slug' => 'accommodation-type',
		),
	),
);

return $taxonomy;
