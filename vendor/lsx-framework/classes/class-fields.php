<?php
/**
 * CMB Field Patterns for LSX
 *
 * @package   LSX_Field_Patterns
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package LSX_Field_Patterns
 * @author  LightSpeed
 */
class LSX_Field_Pattern {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {

	}	

	/**
	 * Returns the fields needed for a videos, repeatable box.
	 */
	public static function price() {
		return apply_filters('lsx_price_field_pattern',array(
			array( 'id' => 'price',  'name' => 'Price', 'type' => 'text' )			
		));
	}	
	
	/**
	 * Returns the fields needed for a videos, repeatable box.
	 */
	public static function videos() {
		return array(
			array( 'id' => 'video_title',  'name' => __('Videos','lsx-tour-operators'), 'type' => 'title' ),
			array(
					'id' => 'videos',
					'name' => '',
					'single_name' => 'Video',
					'type' => 'group',
					'repeatable' => true,
					'sortable' => true,
					'fields' => array(
							array( 'id' => 'title',  'name' => 'Title', 'type' => 'text' ),
							array( 'id' => 'description', 'name' => 'Description', 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) ),
							array( 'id' => 'url',  'name' => 'Url', 'type' => 'text' ),
							array( 'id' => 'thumbnail', 'name' => 'Thumbnail', 'type' => 'image', 'repeatable' => false, 'show_size' => false ),
					),
					'desc' => ''
			)
		);	
	}
	
	/**
	 * Returns the field for the map
	 */
	public static function map() {
		return array(
				array( 'id' => 'location_title',  'name' => 'Location', 'type' => 'title', 'cols' => 12 ),
				array( 'id' => 'location', 'name' => 'Address', 'type' => 'gmap', 'cols' => 12 )
		);
	}	
}