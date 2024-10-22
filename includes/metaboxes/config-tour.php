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
	'id'   => 'disable_single',
	'name' => esc_html__( 'Disable Single', 'tour-operator' ),
	'type' => 'checkbox',
);

$metabox['fields'][] = array(
	'id'         => 'departs_from',
	'name'       => esc_html__( 'Departs From', 'tour-operator' ),
	'desc'       => esc_html__( 'Select the destination where the tour starts.', 'tour-operator' ),
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
	'desc'       => esc_html__( 'Select the destination where the tour ends.', 'tour-operator' ),
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
	'id'      => 'group_size',
	'name'    => esc_html__( 'Group Size', 'tour-operator' ),
	'desc'    => esc_html__( '', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '50',
	),
);

$metabox['fields'][] = array(
	'id'      => 'hightlights',
	'name'    => esc_html__( 'Highlights', 'tour-operator' ),
	'desc'    => esc_html__( '', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'included',
	'name'    => esc_html__( 'Included', 'tour-operator' ),
	'desc'    => esc_html__( 'List the items and services included with the tour (typically a paragraph or list).', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'not_included',
	'name'    => esc_html__( 'Not Included', 'tour-operator' ),
	'desc'    => esc_html__( 'List the items and services not included with the tour (typically a paragraph or list).', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'   => 'booking_validity_start',
	'name' => esc_html__( 'Booking Validity (start)', 'tour-operator' ),
	'desc'    => esc_html__( '', 'tour-operator' ),
	'type' => 'text_date_timestamp',
);

$metabox['fields'][] = array(
	'id'   => 'booking_validity_end',
	'name' => esc_html__( 'Booking Validity (end)', 'tour-operator' ),
	'desc'    => esc_html__( '', 'tour-operator' ),
	'type' => 'text_date_timestamp',
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
		'desc'       => esc_html__( '', 'tour-operator' ),
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
		'desc'      => esc_html__( '', 'tour-operator' ),
		'type'      => 'file',
		'repeatable' => false,
		'show_size'  => false,
	);
}

$metabox['fields'][] = array(
    'name' => esc_html__( 'Gallery', 'tour-operator' ),
	'desc' => esc_html__( 'Add images related to the tour to be displayed in the Tour gallery.', 'tour-operator' ),
    'id'   => 'gallery',
    'type' => 'file_list',
    'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
    'query_args' => array( 'type' => 'image' ), // Only images attachment
    'text' => array(
        'add_upload_files_text' => esc_html__( 'Add new image', 'tour-operator' ), // default: "Add or Upload Files"
    ),
);

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
	'name'       => esc_html__( 'Related Posts', 'tour-operator' ),
	'desc'       => esc_html__( 'Select blog posts about this tour.', 'tour-operator' ),
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
	'name'       => esc_html__( 'Related Accommodation', 'tour-operator' ),
	'desc'       => esc_html__( 'Attach other accommodations similar to this tour.', 'tour-operator' ),
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
	'name'       => esc_html__( 'Related Destinations', 'tour-operator' ),
	'desc'       => esc_html__( 'The Destinations (countries or regions) where this Tour takes place.', 'tour-operator' ),
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
