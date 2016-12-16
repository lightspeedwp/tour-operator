<?php
/**
 * CMB Field Patterns for the Tour Operator Plugin
 *
 * @package   LSX_TO_Field_Pattern
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package LSX_TO_Field_Pattern
 * @author  LightSpeed
 */
class LSX_TO_Field_Pattern {

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
		return apply_filters('lsx_to_price_field_pattern',array(
			array( 'id' => 'price',  'name' => 'Price', 'type' => 'text' )			
		));
	}	
	
	/**
	 * Returns the fields needed for a videos, repeatable box.
	 */
	public static function videos() {
		return array(
			array( 'id' => 'video_title',  'name' => esc_html__('Videos','tour-operator'), 'type' => 'title' ),
			array(
					'id' => 'videos',
					'name' => '',
					'single_name' => esc_html__('Video','tour-operator'),
					'type' => 'group',
					'repeatable' => true,
					'sortable' => true,
					'fields' => array(
							array( 'id' => 'title',  'name' => esc_html__('Title','tour-operator'), 'type' => 'text' ),
							array( 'id' => 'description', 'name' => esc_html__('Description','tour-operator'), 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) ),
							array( 'id' => 'url',  'name' => esc_html__('Url','tour-operator'), 'type' => 'text' ),
							array( 'id' => 'thumbnail', 'name' => esc_html__('Thumbnail','tour-operator'), 'type' => 'image', 'repeatable' => false, 'show_size' => false ),
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
				array( 'id' => 'location_title',  'name' => esc_html__('Location','tour-operator'), 'type' => 'title', 'cols' => 12 ),
				array( 'id' => 'location', 'name' => esc_html__('Address','tour-operator'), 'type' => 'gmap', 'cols' => 12 )
		);
	}	
}