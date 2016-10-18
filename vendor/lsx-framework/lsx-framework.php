<?php
/**
 * @package   LSX Framework
 * @author     LightSpeed Team
 * @license   GPL3
 * @link      
 * @copyright 2015  LightSpeed Team
 *
 * @wordpress-plugin
 * Plugin Name: LSX Framework
 * Plugin URI:  https://github.com/lightspeeddevelopment/lsx-framework/
 * Description: LSX Modules manager
 * Version:     0.2
 * Author:      LightSpeed Team
 * Author URI:  https://www.lsdev.biz/
 * Text Domain: lsx
 * License:     GPL3
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

class TO_Framework {
	
	/**
	 * Holds class instance
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * The root path of the plugin this is being used in.
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $plugin_path = null;	
	
	/**
	 * The root path of the framework
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $framework_path = null;	
	
	/**
	 * The root url of the framework
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $framework_url = null;	
	
	/**
	 * Holds the array of post_types
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $post_types = null;	

	/**
	 * Holds an array of all post types for the settings tabs
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $all_post_types = null;	
	
	/**
	 * Holds the array of options
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $options = null;	
	
	/**
	 * Holds the array of taxonomies
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $taxonomies = null;	
	
	
	/**
	 * Hold the TO_Maps Instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object
	 */
	public $maps = null;	
	
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 */
	public function __construct($plugin_path=false,$all_post_types=false,$post_types=false,$taxonomies=false) {
		$this->plugin_path = $plugin_path;
		$this->post_types = apply_filters('to_framework_post_type_slugs',$post_types);
		$this->all_post_types = apply_filters('to_framework_post_type_slugs',array_keys($all_post_types));
		$this->taxonomies = apply_filters('to_framework_taxonomies',$taxonomies);
		$this->framework_path = plugin_dir_path( __FILE__ );
		$this->framework_url = plugin_dir_url( __FILE__ );
		
		$options = get_option('_lsx_lsx-settings',false);
		if(false !== $options){
			$this->options = $options;
		}
		else{
			$this->options = false;
		}

		//A class for the settings pages
		include_once('classes/class-framework-admin.php');

		//A class for the frontend methods
		include_once('classes/class-framework-frontend.php');

		// A helper for the CMB Meta Fields
		include_once('classes/class-fields.php');		
	}
			
}