<?php
/**
 * Module Template.
 *
 * @package   Lsx_Envira_Intergration
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package Lsx_Vehicle
 * @author  LightSpeed
 */
class Lsx_Envira_Intergration {

	/**
	 * The slug for this plugin
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'envira';

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object|Module_Template
	 */
	protected static $instance = null;

	/**
	 * Holds the option screen prefix
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function __construct() {
		add_filter( 'cmb_meta_boxes', array( $this, 'register_metaboxes') );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object|Module_Template    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	
	/**
	 * Register the meta boxes we use to connect the Envira gallery to the other posts.
	 *
	 *
	 * @return    null
	 */
	
	function register_metaboxes( array $meta_boxes ) {
	
		$fields = array(
				array( 'id' => 'featured',  'name' => 'Featured', 'type' => 'checkbox' ),
				array( 'id' => 'tagline',  'name' => 'Tagline', 'type' => 'text' ),
				array( 'id' => 'code',  'name' => 'Code', 'type' => 'text' ),
				array( 'id' => 'gearbox',  'name' => 'Gearbox Type', 'type' => 'radio', 'options' => array( 'Automatic', 'Manual' ) ),
				array( 'id' => 'gears',  'name' => 'Gears', 'type' => 'radio', 'options' => array( '4', '5', '6', '7' ) ),
				array( 'id' => 'engine_type',  'name' => 'Engine Type', 'type' => 'radio', 'options' => array( 'Diesel', 'Petrol' ) ),
				array( 'id' => 'engine_size',  'name' => 'Engine Size', 'type' => 'text' ),
				array( 'id' => 'seating',  'name' => 'Seats', 'type' => 'text' ),
				array( 'id' => 'gallery', 'name' => 'Gallery', 'type' => 'image', 'repeatable' => true, 'show_size' => false ),
		);
		
		$meta_boxes[] = array(
				'title' => 'General',
				'pages' => 'vehicle',
				'fields' => $fields
		);		
		
		$connection_fields = array(
				
				array( 'id' => 'accommodation_to_envira', 'name' => 'Accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'accommodation','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
				array( 'id' => 'activity_to_envira', 'name' => 'Activities', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'activity','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
				array( 'id' => 'destination_to_envira', 'name' => 'Destinations', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
				array( 'id' => 'review_to_envira', 'name' => 'Reviews', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'reviews','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
				array( 'id' => 'special_to_envira', 'name' => 'Specials', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'special','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
				array( 'id' => 'team_to_envira', 'name' => 'Team', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'team','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
				array( 'id' => 'tour_to_envira', 'name' => 'Tours', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'tour','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
				array( 'id' => 'vehicle_to_envira', 'name' => 'Vehicles', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'vehicle','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true ),
		);
	
		$meta_boxes[] = array(
				'title' => 'Connections',
				'pages' => 'vehicle',
				'fields' => $connection_fields
		);
	
		return $meta_boxes;
	
	}	
	
}