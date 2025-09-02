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
	'title'  => esc_html__( 'Media', 'tour-operator' ),
	'pages'  => 'post',
	'fields' => array(),
);

$metabox['fields'][] = array(
	'name'    => __( 'Banner' , 'tour-operator' ),
	'id'      => 'banner_image',
	'type'    => 'file',
	// Optional:
	'options' => array(
		'url' => false, // Hide the text input for the url
	),
	'text'    => array(
		'add_upload_file_text' => __( 'Choose Image', 'tour-operator' ) // Change upload button text. Default: "Add or Upload File"
	),
	// query_args are passed to wp.media's library query.
	'query_args' => array(
		'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
		),
	),
	'preview_size' => 'large', // Image size to use when previewing in the admin.
);

$metabox['fields'][] = array(
    'name' => esc_html__( 'Gallery', 'tour-operator' ),
    'id'   => 'gallery',
    'type' => 'file_list',
	'desc'    => esc_html__( 'Add images for this post’s gallery.', 'tour-operator' ),
    'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
    'query_args' => array( 'type' => 'image' ), // Only images attachment
    'text' => array(
        'add_upload_files_text' => esc_html__( 'Add new image', 'tour-operator' ), // default: "Add or Upload Files"
    ),
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
