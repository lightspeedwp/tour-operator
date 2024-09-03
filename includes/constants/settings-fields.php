<?php
$settings_fields = array(
	'currency' => array(
		'currency' => array(
			'label'   => esc_html__( 'Currency', 'tour-operator' ),
			'type'    => 'select',
			'default' => 'ZAR',
			'options' => array(
				'USD' => esc_html__( 'USD (united states dollar)', 'tour-operator' ),
				'GBP' => esc_html__( 'GBP (british pound)', 'tour-operator' ),
				'ZAR' => esc_html__( 'ZAR (south african rand)', 'tour-operator' ),
				'NAD' => esc_html__( 'NAD (namibian dollar)', 'tour-operator' ),
				'CAD' => esc_html__( 'CAD (canadian dollar)', 'tour-operator' ),
				'EUR' => esc_html__( 'EUR (euro)', 'tour-operator' ),
				'HKD' => esc_html__( 'HKD (hong kong dollar)', 'tour-operator' ),
				'SGD' => esc_html__( 'SGD (singapore dollar)', 'tour-operator' ),
				'NZD' => esc_html__( 'NZD (new zealand dollar)', 'tour-operator' ),
				'AUD' => esc_html__( 'AUD (australian dollar)', 'tour-operator' ),
			),
		),
	),
	'maps' => array(
		'maps_disabled' => array(
			'label'   => esc_html__( 'Disable Maps', 'tour-operator' ),
			'desc'    => esc_html__( 'This will disable maps on all post types.', 'tour-operator' ),
			'type'    => 'checkbox',
			'default' => 0,
		),
		'googlemaps_marker_id' => array(
			'label'     => esc_html__( 'Choose a default marker', 'tour-operator' ),
			'type'      => 'image',
			'default'   => 0,
			'preview_w' => 48,
		),
		'gmap_cluster_small_id' => array(
			'label'     => esc_html__( 'Choose a cluster marker', 'tour-operator' ),
			'type'      => 'image',
			'default'   => 0,
			'preview_w' => 48,
		),
		'gmap_marker_start_id' => array(
			'label'     => esc_html__( 'Choose a start marker', 'tour-operator' ),
			'type'      => 'image',
			'default'   => 0,
			'preview_w' => 48,
		),
		'gmap_marker_end_id' => array(
			'label'     => esc_html__( 'Choose a end marker', 'tour-operator' ),
			'type'      => 'image',
			'default'   => 0,
			'preview_w' => 48,
		),
	),
	'placeholder' => array(
		'map_placeholder_enabled' => array(
			'label'   => esc_html__( 'Enable Map Placeholder', 'tour-operator' ),
			'desc'    => esc_html__( 'Enable a placeholder users will click to load the map.', 'tour-operator' ),
			'type'    => 'checkbox',
			'default' => 0,
		),
		'map_placeholder' => array(
			'label'     => esc_html__( 'Upload a map placeholder', 'tour-operator' ),
			'type'      => 'image',
			'default'   => 0,
			'preview_w' => 480,
		),
	),
	'fusion' => array(
		'fusion_tables_enabled' => array(
			'label'   => esc_html__( 'Enable Fusion Tables', 'tour-operator' ),
			'type'    => 'checkbox',
			'default' => 0,
		),
		'fusion_tables_width_border' => array(
			'label'   => esc_html__( 'Border Width', 'tour-operator' ),
			'desc'    => esc_html__( 'Default value: 2', 'tour-operator' ),
			'type'    => 'number',
			'default' => 2,
		),
		'fusion_tables_colour_border' => array(
			'label'   => esc_html__( 'Border Colour', 'tour-operator' ),
			'desc'    => esc_html__( 'Default value: #000000', 'tour-operator' ),
			'type'    => 'text',
			'default' => '#000000',
		),
		'fusion_tables_colour_background' => array(
			'label'   => esc_html__( 'Background Colour', 'tour-operator' ),
			'desc'    => esc_html__( 'Default value: #000000', 'tour-operator' ),
			'type'    => 'text',
			'default' => '#000000',
		),
	),
	'api' => array(
		'googlemaps_key' => array(
			'label'   => esc_html__( 'Google Maps API', 'tour-operator' ),
			'type'    => 'text',
		)
	),
	'post_types' => array(

	)
);

return $settings_fields;