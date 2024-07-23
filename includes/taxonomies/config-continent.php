<?php
/**
 * LSX Tour Operator - Continent taxonomy config
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
			'name'              => esc_html__( 'Continents', 'tour-operator' ),
			'singular_name'     => esc_html__( 'Continent', 'tour-operator' ),
			'search_items'      => esc_html__( 'Search Continents', 'tour-operator' ),
			'all_items'         => esc_html__( 'Continents', 'tour-operator' ),
			'parent_item'       => esc_html__( 'Parent', 'tour-operator' ),
			'parent_item_colon' => esc_html__( 'Parent:', 'tour-operator' ),
			'edit_item'         => esc_html__( 'Edit Continent', 'tour-operator' ),
			'update_item'       => esc_html__( 'Update Continent', 'tour-operator' ),
			'add_new_item'      => esc_html__( 'Add New Continent', 'tour-operator' ),
			'new_item_name'     => esc_html__( 'New Continent', 'tour-operator' ),
			'menu_name'         => esc_html__( 'Continents', 'tour-operator' ),
		),
		'show_ui'             => true,
		'show_in_quick_edit'  => true,
		'show_in_rest'        => true,
		'public'              => true,
		'show_tagcloud'       => false,
		'exclude_from_search' => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'             => array(
			'slug' => 'continent',
		),
	),
);

return $taxonomy;
