<?php
/**
 * Tour Operator - Facility taxonomy config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$taxonomy = array(
	'object_types'  => 'accommodation',
	'menu_position' => 35,
	'args'          => array(
		'hierarchical'        => true,
		'labels'              => array(
			'name'              => esc_html__( 'Facilities', 'tour-operator' ),
			'singular_name'     => esc_html__( 'Facility', 'tour-operator' ),
			'search_items'      => esc_html__( 'Search Facilities', 'tour-operator' ),
			'all_items'         => esc_html__( 'Facilities', 'tour-operator' ),
			'parent_item'       => esc_html__( 'Parent', 'tour-operator' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'tour-operator' ),
			'edit_item'         => esc_html__( 'Edit Facility', 'tour-operator' ),
			'update_item'       => esc_html__( 'Update Facility', 'tour-operator' ),
			'add_new_item'      => esc_html__( 'Add New Facility', 'tour-operator' ),
			'new_item_name'     => esc_html__( 'New Facility', 'tour-operator' ),
			'menu_name'         => esc_html__( 'Facilities', 'tour-operator' ),
		),
		'show_ui'             => true,
		'public'              => true,
		'show_tagcloud'       => false,
		'exclude_from_search' => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'             => array(
			'slug' => 'facility',
		),
	),
);

return $taxonomy;
