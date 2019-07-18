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
			self::$instance = new self;
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
					'id'   => 'video_title',
					'name' => __( 'Videos', 'tour-operator' ),
					'type' => 'title',
				);
				$new_fields[] = array(
					'id'          => 'videos',
					'name'        => '',
					'single_name' => __( 'Video', 'tour-operator' ),
					'type'        => 'group',
					'repeatable'  => true,
					'sortable'    => true,
					'fields'      => array(
						array(
							'id'   => 'title',
							'name' => __( 'Title', 'tour-operator' ),
							'type' => 'text',
						),
						array(
							'id'   => 'url',
							'name' => __( 'Url', 'tour-operator' ),
							'type' => 'text',
						),
						array(
							'id'   => 'description',
							'name' => __( 'Caption', 'tour-operator' ),
							'type' => 'text',
						),
						array(
							'id'   => 'alt_text',
							'name' => __( 'Alt Text', 'tour-operator' ),
							'type' => 'text',
						),
					),
					'desc'        => '',
				);
			}
		}
		return $new_fields;
	}
}
