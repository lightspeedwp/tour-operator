<?php
/**
 * LSX Tour Operator - Travel-style taxonomy config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$taxonomy = array(
	'object_types'  => array(
		'accommodation',
		'tour',
		'destination',
		'review',
		'vehicle',
		'special',
	),
	'menu_position' => 22,
	'args'          => array(
		'hierarchical'        => true,
		'labels'              => array(
			'name'              => esc_html__( 'Travel Styles', 'tour-operator' ),
			'singular_name'     => esc_html__( 'Travel Style', 'tour-operator' ),
			'search_items'      => esc_html__( 'Search Travel Styles', 'tour-operator' ),
			'all_items'         => esc_html__( 'Travel Styles', 'tour-operator' ),
			'parent_item'       => esc_html__( 'Parent Travel Style', 'tour-operator' ),
			'parent_item_colon' => esc_html__( 'Parent Travel Style:', 'tour-operator' ),
			'edit_item'         => esc_html__( 'Edit Travel Style', 'tour-operator' ),
			'update_item'       => esc_html__( 'Update Travel Style', 'tour-operator' ),
			'add_new_item'      => esc_html__( 'Add New Travel Style', 'tour-operator' ),
			'new_item_name'     => esc_html__( 'New Travel Style', 'tour-operator' ),
			'menu_name'         => esc_html__( 'Travel Styles', 'tour-operator' ),
		),
		'show_ui'             => true,
		'public'              => true,
		'show_tagcloud'       => false,
		'exclude_from_search' => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'             => array(
			'slug' => 'travel-style',
		),
	),
);

return $taxonomy;
