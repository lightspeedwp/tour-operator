<?php
/**
 * LSX Tour Operator - Destination Metabox config
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

$metabox = array(
	'title'  => esc_html__( 'LSX Tour Operator Plugin', 'tour-operator' ),
	'pages'  => 'destination',
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
	'id'   => 'travel_info_title',
	'name' => esc_html__( 'Travel Info', 'tour-operator' ),
	'type' => 'title',
);

$metabox['fields'][] = array(
	'id'      => 'electricity',
	'name'    => esc_html__( 'Electricity', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Enter details about the country\'s electrical system (e.g., voltage, plug types).', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'banking',
	'name'    => esc_html__( 'Banking', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Provide information about banking services and currency in the country.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'cuisine',
	'name'    => esc_html__( 'Cuisine', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Describe the typical cuisine or food experiences in the country.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'climate',
	'name'    => esc_html__( 'Climate', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Give an overview of the country\'s climate and weather patterns.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'transport',
	'name'    => esc_html__( 'Transport', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Provide information on transportation options available in the country.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'dress',
	'name'    => esc_html__( 'Dress', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Describe any local dress customs or recommended clothing for visitors.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'health',
	'name'    => esc_html__( 'Health', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Provide important health-related information for travellers (e.g., vaccinations, health services).', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'safety',
	'name'    => esc_html__( 'Safety', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Enter safety tips or advice for staying secure in the country.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'visa',
	'name'    => esc_html__( 'Visa', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Provide details on visa requirements for entering the country.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
	'id'      => 'additional_info',
	'name'    => esc_html__( 'General', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'desc'    => esc_html__( 'Add any other relevant general travel information about the country.', 'tour-operator' ),
	'options' => array(
		'editor_height' => '100',
	),
);

$metabox['fields'][] = array(
    'name' => esc_html__( 'Gallery', 'tour-operator' ),
    'id'   => 'gallery',
    'type' => 'file_list',
	'desc'    => esc_html__( 'Add images related to the country to be displayed in the Destination’s gallery.', 'tour-operator' ),
    'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
    'query_args' => array( 'type' => 'image' ), // Only images attachment
    'text' => array(
        'add_upload_files_text' => esc_html__( 'Add new image', 'tour-operator' ), // default: "Add or Upload Files"
    ),
);

if ( ! isset( tour_operator()->options['display']['maps_disable'] ) && empty( tour_operator()->options['display']['maps_disable'] ) ) {
	$metabox['fields'][] = array(
		'id'   => 'location_title',
		'name' => esc_html__( 'Location', 'tour-operator' ),
		'type' => 'title',
	);
	$metabox['fields'][] = array(
		'id'   => 'disable_auto_zoom',
		'name' => esc_html__( 'Disable Auto Zoom', 'tour-operator' ),
		'type' => 'checkbox',
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
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
		   ),
	   ), 
	);
}

$metabox['fields'][] = array(
	'id'         => 'post_to_destination',
	'name'       => esc_html__( 'Posts related with this destination', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'desc'       => esc_html__( 'Select related posts by typing the post name and choosing from the dropdown.', 'tour-operator' ),
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'post',
	),
);

$metabox['fields'][] = array(
	'id'         => 'accommodation_to_destination',
	'name'       => esc_html__( 'Accommodation related with this destination', 'tour-operator' ),
	'desc'       => esc_html__( 'Attach related accommodations by selecting the relevant accommodation from the dropdown.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'accommodation',
	),
);

$metabox['fields'][] = array(
	'id'         => 'tour_to_destination',
	'name'       => esc_html__( 'Tours related with this destination', 'tour-operator' ),
	'desc'       => esc_html__( 'Choose related tours by typing the tour name and selecting from the dropdown.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
	'options'  => array(
		'post_type_args' => 'tour',
	),
);

$metabox['fields'] = apply_filters( 'lsx_to_destination_custom_fields', $metabox['fields'] );

return $metabox;
