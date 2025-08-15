<?php
/**
 * Tour Operator - Post Metabox config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2025 LightSpeedDevelopment
 */

$metabox = array(
	'title'  => esc_html__( 'Details', 'tour-operator' ),
	'pages'  => 'post',
	'fields' => array(),
);

$metabox['fields'][] = array(
	'id'   => 'related_title',
	'name' => esc_html__( 'Related', 'tour-operator' ),
	'type' => 'title',
);

$metabox['fields'][] = array(
	'id'         => 'accommodation_to_post',
	'name'       => esc_html__( 'Related Accommodation', 'tour-operator' ),
	'desc'       => esc_html__( 'Select accommodation related to this post.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'accommodation',
	),
);

$metabox['fields'][] = array(
	'id'         => 'destination_to_post',
	'name'       => esc_html__( 'Related Destinations', 'tour-operator' ),
	'desc'       => esc_html__( 'The Destination (country or region) where this post is found.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'destination',
	),
);

$metabox['fields'][] = array(
	'id'         => 'tour_to_post',
	'name'       => esc_html__( 'Related Tours', 'tour-operator' ),
	'desc'       => esc_html__( 'Choose tours that are linked to the post.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'tour',
	),
);

$metabox['fields'] = apply_filters( 'lsx_to_post_custom_fields', $metabox['fields'] );

return $metabox;
