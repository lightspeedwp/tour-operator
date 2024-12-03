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
	'title'  => esc_html__( 'Details', 'tour-operator' ),
	'pages'  => 'tour',
	'fields' => array(),
);

$metabox['fields'][] = array(
	'id'         => 'departs_from',
	'name'       => esc_html__( 'Departs From', 'tour-operator' ),
	'desc'       => esc_html__( 'Select the destination where the tour starts.', 'tour-operator' ),
	'type'       => 'pw_select',
	'use_ajax'   => false,
	'allow_none' => true,
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
	'allow_none' => true,
	'sortable'   => false,
	'repeatable' => false,
	'options'  => array(
		'post_type_args' => 'destination',
	),
);

$metabox['fields'][] = array(
	'id'      => 'group_size',
	'name'    => esc_html__( 'Group Size', 'tour-operator' ),
	'desc'    => esc_html__( 'The range of group sizes for the tour (e.g., 2 - 20 people).', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '50',
	),
);

$metabox['fields'][] = array(
	'id'      => 'highlights',
	'name'    => esc_html__( 'Highlights', 'tour-operator' ),
	'desc'    => esc_html__( 'Key experiences or features of the tour.', 'tour-operator' ),
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
	'desc'    => esc_html__( 'The start date for when the tour can be booked.', 'tour-operator' ),
	'type' => 'text_date_timestamp',
);

$metabox['fields'][] = array(
	'id'   => 'booking_validity_end',
	'name' => esc_html__( 'Booking Validity (end)', 'tour-operator' ),
	'desc'    => esc_html__( 'The end date for when the tour can be booked.', 'tour-operator' ),
	'type' => 'text_date_timestamp',
);

$metabox['fields'][] = array(
	'id'   => 'expire_post',
	'name' => esc_html__( 'Expire this tour automatically', 'tour-operator' ),
	'desc' => esc_html__( 'This tour will expire automatically when the Booking Validity ends.', 'tour-operator' ),
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
		'desc'       => esc_html__( 'A placeholder image for the map if no address or GPS data is available.', 'tour-operator' ),
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
		'desc'      => esc_html__( 'A file containing GPS points for the tour route.', 'tour-operator' ),
		'type'      => 'file',
		'repeatable' => false,
		'show_size'  => false,
	);
}

$metabox['fields'][] = array(
	'id'   => 'media_title',
	'name' => esc_html__( 'Media', 'tour-operator' ),
	'type' => 'title',
);

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

$itinerary_fields[] = array(
	'id'   => 'title',
	'name' => esc_html__( 'Title', 'tour-operator' ),
	'desc' => esc_html__( 'Enter the title for the time frame (e.g., Day 1, Day 1-3).', 'tour-operator' ),
	'type' => 'text',
);

$itinerary_fields[] = array(
	'id'   => 'tagline',
	'name' => esc_html__( 'Tagline (Optional)', 'tour-operator' ),
	'desc' => esc_html__( 'Add an optional tagline for the itinerary entry (if left blank, it won’t display).', 'tour-operator' ),
	'type' => 'text',
);

$itinerary_fields[] = array(
	'id'      => 'description',
	'name'    => esc_html__( 'Description', 'tour-operator' ),
	'desc'    => esc_html__( 'Provide a description of what happens during this time frame.', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$itinerary_fields[] = array(
	'id'        => 'featured_image',
	'name'      => esc_html__( 'Featured Image', 'tour-operator' ),
	'desc'      => esc_html__( 'Upload or select a featured image for the itinerary entry.', 'tour-operator' ),
	'type'      => 'file',
	'show_size' => false,
	'query_args' => array(
		'type' => array(
			'image/gif',
			'image/jpeg',
			'image/png',
	   ),
   ), 
);

$itinerary_fields = apply_filters( 'lsx_to_tours_itinerary_fields', $itinerary_fields );

if ( post_type_exists( 'accommodation' ) ) {
	$itinerary_fields[] = array(
		'id'         => 'accommodation_to_tour',
		'name'       => esc_html__( 'Related Accommodation', 'tour-operator' ),
		'desc'       => esc_html__( 'Select the accommodation associated with this Itinerary entry.', 'tour-operator' ),
		'type'       => 'pw_select',
		'use_ajax'   => false,
		'allow_none' => true,
		'sortable'   => false,
		'repeatable' => false,
		'options'  => array(
			'post_type_args' => 'accommodation',
		),
	);
}

if ( post_type_exists( 'destination' ) ) {
	$itinerary_fields[] = array(
		'id'         => 'destination_to_tour',
		'name'       => esc_html__( 'Related Destination', 'tour-operator' ),
		'desc'       => esc_html__( 'Choose the destination (region or country) associated with this Itinerary entry.', 'tour-operator' ),
		'type'       => 'pw_select',
		'use_ajax'   => false,
		'allow_none' => true,
		'sortable'   => false,
		'repeatable' => false,
		'options'  => array(
			'post_type_args' => 'destination',
		),
	);
}

$itinerary_fields[] = array(
	'id'      => 'included',
	'name'    => esc_html__( 'Included', 'tour-operator' ),
	'desc'    => esc_html__( 'Items or services provided during that part of the tour itinerary.', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$itinerary_fields[] = array(
	'id'      => 'excluded',
	'name'    => esc_html__( 'Excluded', 'tour-operator' ),
	'desc'    => esc_html__( 'Items or services not provided during that part of the tour itinerary.', 'tour-operator' ),
	'type'    => 'wysiwyg',
	'options' => array(
		'editor_height' => '100',
	),
);

$itinerary_fields[] = array(
	'id'      => 'drinks_basis',
	'name'    => esc_html__( 'Drinks Basis', 'tour-operator' ),
	'desc'    => esc_html__( 'Select the drinks basis for the itinerary (e.g., tea & coffee, all local drinks).', 'tour-operator' ),
	'type'    => 'select',
	'options' => array(
		'None'                => esc_html__( 'None', 'tour-operator' ),
		'TeaCoffee'           => esc_html__( 'Tea and Coffee Only', 'tour-operator' ),
		'DrinksSoft'          => esc_html__( 'Tea, Coffee and Soft Drinks Only', 'tour-operator' ),
		'DrinksLocalBrands'   => esc_html__( 'All Local Brands (Spirits, Wine and Beers)', 'tour-operator' ),
		'DrinksExclSpirits'   => esc_html__( 'All Local Brands (excl Spirits)', 'tour-operator' ),
		'DrinksExclChampagne' => esc_html__( 'All Drinks (excl Champagne)', 'tour-operator' ),
		'DrinksExclPremium'   => esc_html__( 'All Drinks (excl Premium Brands)', 'tour-operator' ),
		'AllDrinks'           => esc_html__( 'All Drinks', 'tour-operator' ),
	),
);
$itinerary_fields[] = array(
	'id'      => 'room_basis',
	'name'    => esc_html__( 'Room Basis', 'tour-operator' ),
	'desc'    => esc_html__( 'Choose the room basis for the itinerary (e.g., breakfast only, full board).', 'tour-operator' ),
	'type'    => 'select',
	'options' => array(
		'None'                                 => esc_html__( 'None', 'tour-operator' ),
		'BedAndBreakfast'                      => esc_html__( 'B&amp;B: Bed and Breakfast', 'tour-operator' ),
		'RoomOnly'                             => esc_html__( 'Room Only', 'tour-operator' ),
		'SelfCatering'                         => esc_html__( 'Self Catering', 'tour-operator' ),
		'Lunch'                                => esc_html__( 'Lunch', 'tour-operator' ),
		'Dinner'                               => esc_html__( 'Dinner', 'tour-operator' ),
		'LunchAndDinner'                       => esc_html__( 'Lunch and Dinner', 'tour-operator' ),
		'BedBreakfastAndLunch'                 => esc_html__( 'Bed, Breakfast and Lunch', 'tour-operator' ),
		'DinnerBedAndBreakfast'                => esc_html__( 'Dinner, Bed and Breakfast', 'tour-operator' ),
		'HalfBoard'                            => esc_html__( 'Half Board - Dinner, Bed and Breakfast', 'tour-operator' ),
		'DinnerBedBreakfastAndActivities'      => esc_html__( 'Half Board Plus - Dinner, Bed, Breakfast and Activities', 'tour-operator' ),
		'DinnerBedBreakfastAndLunch'           => esc_html__( 'Full Board - Dinner, Bed, Breakfast and Lunch', 'tour-operator' ),
		'DinnerBedBreakfastLunchAndActivities' => esc_html__( 'Full Board Plus -  Dinner, Bed, Breakfast, Lunch and Activities', 'tour-operator' ),
		'AllInclusiveBedAndAllMeals'           => esc_html__( 'All Inclusive - Bed and All Meals', 'tour-operator' ),
		'FullyInclusive'                       => esc_html__( 'Fully Inclusive - Bed, All Meals, Fees and Activities', 'tour-operator' ),
		'ExclusiveClubPremierBenefits'         => esc_html__( 'Premier - Executive Club / Premier Benefits', 'tour-operator' ),
	),
);

$metabox['fields'][] = array(
	'id'          => 'itinerary',
	'name'        => '',
	'single_name' => __( 'Day(s)', 'tour-operator' ),
	'type'        => 'group',
	'repeatable'  => true,
	'fields'      => $itinerary_fields,
	'desc'        => '',
    'options'     => array(
        'group_title'       => __( 'Itinerary {#}', 'tour-operator' ), // since version 1.1.4, {#} gets replaced by row number
        'add_button'        => __( 'Add Another', 'tour-operator' ),
        'remove_button'     => __( 'Remove', 'tour-operator' ),
        'sortable'          => false,
    ),
);

$metabox['fields'][] = array(
	'id'   => 'related_title',
	'name' => esc_html__( 'Related', 'tour-operator' ),
	'type' => 'title',
);

$metabox['fields'][] = array(
	'id'         => 'post_to_tour',
	'name'       => esc_html__( 'Related Posts', 'tour-operator' ),
	'desc'       => esc_html__( 'Select blog posts about this tour.', 'tour-operator' ),
	'type'       => 'pw_multiselect',
	'use_ajax'   => false,
	'repeatable' => false,
	'allow_none' => true,
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
	'allow_none' => true,
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
