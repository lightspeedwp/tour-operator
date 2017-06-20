<?php
/**
 * Tour Operator - Destination Metabox config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$metabox = array(
	'title'  => esc_html__( 'LSX Tour Operators', 'tour-operator' ),
	'pages'  => 'destination',
	'fields' => array(),
);

$metabox['fields'][] = array(
	'id'   => 'featured',
	'name' => esc_html__( 'Featured', 'tour-operator' ),
	'type' => 'checkbox',
);

$metabox['fields'][] = array(
	'id'       => 'best_time_to_visit',
	'name'     => esc_html__( 'Best months to visit', 'tour-operator' ),
	'type'     => 'select',
	'options'  => array(
		'january'   => 'January',
		'february'  => 'February',
		'march'     => 'March',
		'april'     => 'April',
		'may'       => 'May',
		'june'      => 'June',
		'july'      => 'July',
		'august'    => 'August',
		'september' => 'September',
		'october'   => 'October',
		'november'  => 'November',
		'december'  => 'December',
	),
	'multiple' => true,
	'cols'     => 12,
);

if ( ! class_exists( 'LSX_Banners' ) ) {
	$metabox['fields'][] = array(
		'id'   => 'tagline',
		'name' => esc_html__( 'Tagline', 'tour-operator' ),
		'type' => 'text',
	);
}

$metabox['fields'][] = array(
	'id'   => 'travel_info_title',
	'name' => esc_html__( 'Travel Info', 'tour-operator' ),
	'type' => 'title',
);
$metabox['fields'][] = array(
	'id'      => 'electricity',
	'name'    => esc_html__( 'Electricity', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'banking',
	'name'    => esc_html__( 'Banking', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'cuisine',
	'name'    => esc_html__( 'Cuisine', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'climate',
	'name'    => esc_html__( 'Climate', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'transport',
	'name'    => esc_html__( 'Transport', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'dress',
	'name'    => esc_html__( 'Dress', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'health',
	'name'    => esc_html__( 'Health', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'safety',
	'name'    => esc_html__( 'Safety', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'visa',
	'name'    => esc_html__( 'Visa', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);
$metabox['fields'][] = array(
	'id'      => 'additional_info',
	'name'    => esc_html__( 'General', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array( 'editor_height' => '100' ),
	'cols'    => 12,
);

if ( class_exists( 'LSX_TO_Team' ) ) {
	$metabox['fields'][] = array(
		'id'         => 'team_to_destination',
		'name'       => esc_html__( 'Destination Expert', 'tour-operator' ),
		'type'       => 'post_select',
		'use_ajax'   => false,
		'query'      => array(
			'post_type'      => 'team',
			'nopagin'        => true,
			'posts_per_page' => 1000,
			'orderby'        => 'title',
			'order'          => 'ASC',
		),
		'allow_none' => true,
		'cols'       => 12,
		'allow_none' => true,
	);
}

$metabox['fields'][] = array(
	'id'   => 'gallery_title',
	'name' => esc_html__( 'Gallery', 'tour-operator' ),
	'type' => 'title',
);
$metabox['fields'][] = array(
	'id'         => 'gallery',
	'name'       => esc_html__( 'Gallery', 'tour-operator' ),
	'type'       => 'image',
	'repeatable' => true,
	'show_size'  => false,
);

if ( class_exists( 'Envira_Gallery' ) ) {
	$metabox['fields'][] = array(
		'id'   => 'envira_title',
		'name' => esc_html__( 'Envira Gallery', 'tour-operator' ),
		'type' => 'title',
	);
	$metabox['fields'][] = array(
		'id'         => 'envira_gallery',
		'name'       => esc_html__( 'Envira Gallery', 'to-galleries' ),
		'type'       => 'post_select',
		'use_ajax'   => false,
		'query'      => array(
			'post_type'      => 'envira',
			'nopagin'        => true,
			'posts_per_page' => '-1',
			'orderby'        => 'title',
			'order'          => 'ASC',
		),
		'allow_none' => true,
	);
	if ( class_exists( 'Envira_Videos' ) ) {
		$metabox['fields'][] = array(
			'id'         => 'envira_video',
			'name'       => esc_html__( 'Envira Video Gallery', 'to-galleries' ),
			'type'       => 'post_select',
			'use_ajax'   => false,
			'query'      => array(
				'post_type'      => 'envira',
				'nopagin'        => true,
				'posts_per_page' => '-1',
				'orderby'        => 'title',
				'order'          => 'ASC',
			),
			'allow_none' => true,
		);
	}
}


if ( class_exists( 'LSX_TO_Maps' ) ) {
	$metabox['fields'][] = array(
		'id'   => 'location_title',
		'name' => esc_html__( 'Location', 'tour-operator' ),
		'type' => 'title',
	);
	$metabox['fields'][] = array(
		'id'             => 'location',
		'name'           => esc_html__( 'Location', 'tour-operator' ),
		'type'           => 'gmap',
		'google_api_key' => $this->options['api']['googlemaps_key'],
	);
}

//Connections
$metabox['fields'][] = array(
	'id'   => 'accommodation_title',
	'name' => esc_html__( 'Accommodation', 'tour-operator' ),
	'type' => 'title',
	'cols' => 12,
);
$metabox['fields'][] = array(
	'id'         => 'accommodation_to_destination',
	'name'       => esc_html__( 'Accommodation related with this destination', 'tour-operator' ),
	'type'       => 'post_select',
	'use_ajax'   => false,
	'query'      => array(
		'post_type'      => 'accommodation',
		'nopagin'        => true,
		'posts_per_page' => '-1',
		'orderby'        => 'title',
		'order'          => 'ASC',
	),
	'repeatable' => true,
	'allow_none' => true,
	'cols'       => 12,
);
$metabox['fields'][] = array(
	'id'   => 'tours_title',
	'name' => esc_html__( 'Tours', 'tour-operator' ),
	'type' => 'title',
	'cols' => 12,
);
$metabox['fields'][] = array(
	'id'         => 'tour_to_destination',
	'name'       => esc_html__( 'Tours related with this destination', 'tour-operator' ),
	'type'       => 'post_select',
	'use_ajax'   => false,
	'query'      => array(
		'post_type'      => 'tour',
		'nopagin'        => true,
		'posts_per_page' => '-1',
		'orderby'        => 'title',
		'order'          => 'ASC',
	),
	'repeatable' => true,
	'allow_none' => true,
	'cols'       => 12,
);

//Allow the addons to add additional fields.
$metabox['fields'] = apply_filters( 'lsx_to_destination_custom_fields', $metabox['fields'] );


return $metabox;
