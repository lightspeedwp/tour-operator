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
	'pages'  => 'accommodation',
	'fields' => array(),
);

$metabox['fields'][] = array(
	'id'   => 'disable_single',
	'name' => esc_html__( 'Disable Single', 'tour-operator' ),
	'type' => 'checkbox',
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

if ( class_exists( 'LSX_TO_Team' ) ) {
	$metabox['fields'][] = array(
		'id'         => 'team_to_accommodation',
		'name'       => esc_html__( 'Accommodation Expert', 'tour-operator' ),
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

if ( ! isset( tour_operator()->options['display']['maps_disable'] ) && empty( tour_operator()->options['display']['maps_disable'] ) ) {
	$metabox['fields'][] = array(
		'id'   => 'location_title',
		'name' => esc_html__( 'Location', 'tour-operator' ),
		'type' => 'title',
	);
	$google_api_key = '';
	if ( isset( tour_operator()->options['googlemaps_key'] ) && ! empty( tour_operator()->options['googlemaps_key'] ) ) {
		$google_api_key = tour_operator()->options['googlemaps_key'];
	}
	$metabox['fields'][] = array(
		'id'             => 'location',
		'name'           => esc_html__( 'Address', 'tour-operator' ),
		'type'           => 'pw_map',
		'api_key' => $google_api_key,
	);
	$metabox['fields'][] = array(
		'id'         => 'map_placeholder',
		'name'       => esc_html__( 'Map Placeholder', 'tour-operator' ),
		'type'       => 'file',
		'repeatable' => false,
		'show_size'  => false,
		'preview_size' => 'thumbnail',
		'query_args' => array(
			 'type' => array(
				 'image/gif',
				 'image/jpeg',
				 'image/png',
			),
		),
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
	);
}

$metabox['fields'][] = array(
	'id'   => 'media_title',
	'name' => esc_html__( 'Media', 'tour-operator' ),
	'type' => 'title',
);

$metabox['fields'][] = array(
    'name' => esc_html__( 'Gallery', 'tour-operator' ),
	'desc' => esc_html__( 'Add images related to the accommodation to be displayed in the Accommodation\'s gallery.', 'tour-operator' ),
    'id'   => 'gallery',
    'type' => 'file_list',
    'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
    'query_args' => array( 'type' => 'image' ), // Only images attachment
    'text' => array(
        'add_upload_files_text' => esc_html__( 'Add new image', 'tour-operator' ), // default: "Add or Upload Files"
    ),
);

$metabox['fields'][] = array(
	'id'   => 'units_title',
	'name' => esc_html__( 'Units', 'tour-operator' ),
	'type' => 'title',
);
$metabox['fields'][] = array(
	'id'         => 'units',
	'name'       => '',
	'type'       => 'group',
	'repeatable' => true,
	'sortable'   => true,
	'desc'       => '',
    'options'     => array(
        'group_title'       => __( 'Unit {#}', 'tour-operator' ), // since version 1.1.4, {#} gets replaced by row number
        'add_button'        => __( 'Add Another', 'tour-operator' ),
        'remove_button'     => __( 'Remove', 'tour-operator' ),
        'sortable'          => false,
    ),
	'fields'     => array(
		array(
			'id'      => 'type',
			'name'    => esc_html__( 'Unit Type', 'tour-operator' ),
			'desc'    => esc_html__( 'Select the type of unit (e.g., room, suite) from the dropdown.', 'tour-operator' ),
			'type'    => 'select',
			'options' => \lsx\legacy\Accommodation::get_instance()->unit_types,
		),
		array(
			'id'   => 'title',
			'name' => esc_html__( 'Unit Title', 'tour-operator' ),
			'desc'    => esc_html__( 'Enter the name or title of the unit (e.g., Deluxe Room, Family Suite).', 'tour-operator' ),
			'type' => 'text',
		),
		array(
			'id'      => 'description',
			'name'    => esc_html__( 'Unit Description', 'tour-operator' ),
			'desc'    => esc_html__( 'Provide a brief description of the unit’s features and amenities.', 'tour-operator' ),
			'type'    => 'textarea',
			'options' => array(
				'editor_height' => '100',
			),
		),
		array(
			'id'   => 'price',
			'name' => esc_html__( 'Unit Price', 'tour-operator' ),
			'desc' => esc_html__( 'Enter the price of the unit.', 'tour-operator' ),
			'type' => 'text',
		),
		array(
			'name' => esc_html__( 'Unit Images', 'tour-operator' ),
			'desc'    => esc_html__( 'Showcase the unit by adding images.', 'tour-operator' ),
			'id'   => 'gallery',
			'type' => 'file_list',
			'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
			'query_args' => array( 'type' => 'image' ), // Only images attachment
			'text' => array(
				'add_upload_files_text' => esc_html__( 'Add new image', 'tour-operator' ), // default: "Add or Upload Files"
			),
		),
	),
);

$metabox['fields'][] = array(
	'id'   => 'related_title',
	'name' => esc_html__( 'Related', 'tour-operator' ),
	'type' => 'title',
);
$metabox['fields'][] = array(
	'id'         => 'post_to_accommodation',
	'name'       => esc_html__( 'Related Posts', 'tour-operator' ),
	'desc'       => esc_html__( 'Select blog posts about this Accommodation.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'post',
	),
);

$metabox['fields'][] = array(
	'id'         => 'destination_to_accommodation',
	'name'       => esc_html__( 'Related Destinations', 'tour-operator' ),
	'desc'       => esc_html__( 'The Destination (country or region) where this Accommodation is found.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'destination',
	),
);

$metabox['fields'][] = array(
	'id'         => 'tour_to_accommodation',
	'name'       => esc_html__( 'Related Tours', 'tour-operator' ),
	'desc'       => esc_html__( 'Choose tours that are linked to the accommodation.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'tour',
	),
);

$metabox['fields'] = apply_filters( 'lsx_to_accommodation_custom_fields', $metabox['fields'] );

return $metabox;
