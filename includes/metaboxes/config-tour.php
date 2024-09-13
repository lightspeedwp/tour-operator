<?php
/**
 * LSX Tour Operator - Accommodation Metabox config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$metabox = array(
	'title'  => esc_html__( 'LSX Tour Operator Plugin', 'tour-operator' ),
	'pages'  => 'tour',
	'fields' => array(),
);

$metabox['fields'][] = array(
	'id'   => 'featured',
	'name' => esc_html__( 'Featured', 'tour-operator' ),
	'type' => 'checkbox',
);

$metabox['fields'][] = array(
	'id'   => 'disable_single',
	'name' => esc_html__( 'Disable Single', 'tour-operator' ),
	'type' => 'checkbox',
);

$metabox['fields'][] = array(
	'id'   => 'tagline',
	'name' => esc_html__( 'Tagline', 'tour-operator' ),
	'type' => 'text',
);

$metabox['fields'][] = array(
	'id'   => 'duration',
	'name' => esc_html__( 'Duration', 'tour-operator' ),
	'type' => 'text',
);

$metabox['fields'][] = array(
	'id'         => 'departs_from',
	'name'       => esc_html__( 'Departs From', 'tour-operator' ),
	'type'       => 'pw_select',
	'use_ajax'   => false,
	'allow_none' => false,
	'sortable'   => false,
	'repeatable' => false,
	'options'  => array(
		'post_type_args' => 'destination',
	),
);

$metabox['fields'][] = array(
	'id'         => 'ends_in',
	'name'       => esc_html__( 'Ends In', 'tour-operator' ),
	'type'       => 'pw_select',
	'use_ajax'   => false,
	'allow_none' => false,
	'sortable'   => false,
	'repeatable' => false,
	'options'  => array(
		'post_type_args' => 'destination',
	),
);

$metabox['fields'][] = array(
	'id'       => 'best_time_to_visit',
	'name'     => esc_html__( 'Best months to visit', 'tour-operator' ),
	'type'     => 'multicheck',
	'multiple' => true,
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
);

if ( class_exists( 'LSX_TO_Team' ) ) {
	$metabox['fields'][] = array(
		'id'         => 'team_to_tour',
		'name'       => esc_html__( 'Tour Expert', 'tour-operator' ),
		'type'       => 'pw_select',
		'use_ajax'   => false,
		'allow_none' => false,
		'sortable'   => false,
		'repeatable' => false,
		'options'  => array(
			'post_type_args' => 'team',
		),
	);
}

$metabox['fields'][] = array(
	'id'      => 'group_size',
	'name'    => esc_html__( 'Group Size', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '50',
	),
);

$metabox['fields'][] = array(
	'id'      => 'hightlights',
	'name'    => esc_html__( 'Highlights', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'   => 'price_title',
	'name' => esc_html__( 'Price', 'tour-operator' ),
	'type' => 'title',
);

$metabox['fields'][] = array(
	'id'   => 'price',
	'name' => esc_html__( 'Price', 'tour-operator' ),
	'type' => 'text',
);

$metabox['fields'][] = array(
	'id'   => 'single_supplement',
	'name' => esc_html__( 'Single Supplement', 'tour-operator' ),
	'type' => 'text',
);

$metabox['fields'][] = array(
	'id'      => 'included',
	'name'    => esc_html__( 'Included', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'not_included',
	'name'    => esc_html__( 'Not Included', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'   => 'booking_validity_start',
	'name' => esc_html__( 'Booking Validity (start)', 'tour-operator' ),
	'type' => 'text_date_timestamp',
);

$metabox['fields'][] = array(
	'id'   => 'booking_validity_end',
	'name' => esc_html__( 'Booking Validity (end)', 'tour-operator' ),
	'type' => 'text_date_timestamp',
);

$metabox['fields'][] = array(
	'id'   => 'expire_post',
	'name' => esc_html__( 'Expire this tour automatically', 'tour-operator' ),
	'type' => 'checkbox',
);

if ( ! isset( tour_operator()->options['maps_disable'] ) && empty( tour_operator()->options['maps_disable'] ) ) {
	$metabox['fields'][] = array(
		'id'   => 'location_title',
		'name' => esc_html__( 'Location', 'tour-operator' ),
		'type' => 'title',
	);
	$metabox['fields'][] = array(
		'id'         => 'map_placeholder',
		'name'       => esc_html__( 'Map Placeholder', 'tour-operator' ),
		'type'       => 'file',
		'repeatable' => false,
		'show_size'  => false,
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
		   ),
	   ), 
	);
	$metabox['fields'][] = array(
		'id'        => 'itinerary_kml',
		'name'      => esc_html__( 'Itinerary KML File', 'tour-operator' ),
		'type'      => 'file',
		'repeatable' => false,
		'show_size'  => false,
	);
}

/*$metabox['fields'][] = array(
    'name'    => esc_html__( 'Gallery', 'tour-operator' ),
    'id'      => 'gallery',
    'type'    => 'file',
    // Optional:
    'options' => array(
        'url' => false, // Hide the text input for the url
    ),
    'text'    => array(
        'add_upload_file_text' => esc_html__( 'Add new image', 'tour-operator' )
    ),
    'query_args' => array(
         'type' => array(
             'image/gif',
             'image/jpeg',
             'image/png',
        ),
    ), 
);*/

$metabox['fields'][] = array(
    'name' => esc_html__( 'Gallery', 'tour-operator' ),
    'id'   => 'gallery',
    'type' => 'file_list',
    'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
    'query_args' => array( 'type' => 'image' ), // Only images attachment
    'text' => array(
        'add_upload_files_text' => esc_html__( 'Add new image', 'tour-operator' ), // default: "Add or Upload Files"
    ),
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
		'type'       => 'pw_multiselect',
		'use_ajax'   => false,
		'allow_none' => true,
		'options'  => array(
			'post_type_args' => 'envira',
		),
	);

	if ( class_exists( 'Envira_Videos' ) ) {
		$metabox['fields'][] = array(
			'id'         => 'envira_video',
			'name'       => esc_html__( 'Envira Video Gallery', 'to-galleries' ),
			'type'       => 'pw_multiselect',
			'use_ajax'   => false,
			'allow_none' => true,
			'options'  => array(
				'post_type_args' => 'envira',
			),
		);
	}
}

$metabox['fields'][] = array(
	'id'   => 'itinerary_title',
	'name' => esc_html__( 'Itinerary', 'tour-operator' ),
	'type' => 'title',
);

$metabox['fields'][] = array(
	'id'          => 'itinerary',
	'name'        => '',
	'single_name' => __( 'Day(s)', 'tour-operator' ),
	'type'        => 'group',
	'repeatable'  => true,
	'fields'      => lsx\legacy\Tour::get_instance()->itinerary_fields(),
	'desc'        => '',
    'options'     => array(
        'group_title'       => __( 'Itinerary {#}', 'tour-operator' ), // since version 1.1.4, {#} gets replaced by row number
        'add_button'        => __( 'Add Another', 'tour-operator' ),
        'remove_button'     => __( 'Remove', 'tour-operator' ),
        'sortable'          => false,
    ),
);

$metabox['fields'][] = array(
	'id'         => 'post_to_tour',
	'name'       => esc_html__( 'Posts related with this tour', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => false,
	'options'  => array(
		'post_type_args' => 'post',
	),
);

$metabox['fields'][] = array(
	'id'         => 'accommodation_to_tour',
	'name'       => esc_html__( 'Accommodation related with this tour', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => false,
	'options'  => array(
		'post_type_args' => 'accommodation',
	),
);

$metabox['fields'][] = array(
	'id'         => 'destination_to_tour',
	'name'       => esc_html__( 'Destinations related with this tour', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'destination',
	),
);

$metabox['fields'] = apply_filters( 'lsx_to_tour_custom_fields', $metabox['fields'] );

return $metabox;
