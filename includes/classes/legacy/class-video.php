<?php
/**
 * Video
 *
 * @package   tour-operator
 * @author    LightSpeed
 * @license   GPL-3.0+
 * @link
 * @copyright 2019 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package Video
 * @author  LightSpeed
 */
class Video {

	/**
	 * Holds instances of the class
	 */
	protected static $instance;
	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'lsx_to_destination_custom_fields', array( $this, 'custom_fields' ) );
		add_filter( 'lsx_to_tour_custom_fields', array( $this, 'custom_fields' ) );
		add_filter( 'lsx_to_accommodation_custom_fields', array( $this, 'custom_fields' ) );
		add_filter( 'lsx_to_review_custom_fields', array( $this, 'custom_fields' ) );
		add_filter( 'lsx_to_activity_custom_fields', array( $this, 'custom_fields' ) );
		add_filter( 'lsx_to_special_custom_fields', array( $this, 'custom_fields' ) );
		add_filter( 'lsx_to_vehicle_custom_fields', array( $this, 'custom_fields' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Adds in the gallery fields to the Tour Operators Post Types.
	 */
	public function custom_fields( $fields ) {
		$key_ids    = array( 'gallery' );
		$new_fields = array();
		foreach ( $fields as $field ) {
			$new_fields[] = $field;
			if ( in_array( $field['id'], $key_ids ) ) {
				$new_fields[] = array(
					'id'          => 'videos',
					'name'        => __( 'Video Gallery', 'tour-operator' ),
					'desc'        => __( 'Link to videos about this item, including a title, URL, caption, and alt text.', 'tour-operator' ),
					'type'        => 'group',
					'repeatable'  => true,
					'sortable'    => true,
					'options'     => array(
						'group_title'       => __( 'Video {#}', 'tour-operator' ), // since version 1.1.4, {#} gets replaced by row number
						'add_button'        => __( 'Add Video', 'tour-operator' ),
						'remove_button'     => __( 'Remove Video', 'tour-operator' ),
						'sortable'          => false,
					),
					'fields'      => array(
						array(
							'id'   => 'title',
							'name' => __( 'Title', 'tour-operator' ),
							'desc' => __( 'The title of the video.', 'tour-operator' ),
							'type' => 'text',
						),
						array(
							'id'   => 'url',
							'name' => __( 'Url', 'tour-operator' ),
							'desc' => __( 'The URL link to the video.', 'tour-operator' ),
							'type' => 'text',
						),
						array(
							'id'   => 'description',
							'name' => __( 'Caption', 'tour-operator' ),
							'desc' => __( 'The caption displayed with the video on the frontend.', 'tour-operator' ),
							'type' => 'text',
						),
						array(
							'id'   => 'alt_text',
							'name' => __( 'Alt Text', 'tour-operator' ),
							'desc' => __( 'Alternative text for accessibility, describing the video for screen readers.', 'tour-operator' ),
							'type' => 'text',
						),
					),
				);
			}
		}
		return $new_fields;
	}
}
