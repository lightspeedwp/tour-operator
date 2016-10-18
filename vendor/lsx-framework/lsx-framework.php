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

		add_action('init',array($this,'filter_class_vars'),0);

		//A class for the settings pages
		include_once('classes/class-framework-admin.php');

		//A class for the frontend methods
		include_once('classes/class-framework-frontend.php');

		// A helper for the CMB Meta Fields
		include_once('classes/class-fields.php');

		//Placeholders for all of the post types.
		if(!class_exists('TO_Placeholders')){
			include_once('classes/class-placeholders.php');
			$this->placeholders = new TO_Placeholders($this->post_types);
		}	
		
		include_once('includes/lsx-post-type-widget.php');
		include_once('includes/lsx-taxonomy-widget.php');
		include_once('includes/lsx-cta-widget.php');
		add_action( 'widgets_init', array( $this, 'register_widget'));
		
		include_once('includes/template-tags.php');

		add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title') );
	}

	/**
	 * Allow plugins to add in their own vars
	 */
	public function filter_class_vars() {
		$this->post_types = apply_filters('to_framework_post_type_slugs',$this->post_types);
		$this->all_post_types = apply_filters('to_framework_post_type_slugs',$this->all_post_types);
		$this->taxonomies = apply_filters('to_framework_taxonomies',$this->taxonomies);

		if(is_admin()){
			$this->admin = new TO_Framework_Admin($this->post_types,$this->framework_path,$this->framework_url);	
		}else{
			$this->frontend = new TO_Framework_Frontend($this->all_post_types,$this->framework_path,$this->framework_url);	
		}
	}
	
	/**
	 * Register the TO_Widget
	 */
	public function register_widget() {
		register_widget( 'TO_Widget' );
		register_widget( 'TO_Taxonomy_Widget' );
		register_widget( 'TO_CTA_Widget' );
	}	
	
	/**
	 * Remove the "Archives:" from the post type archives.
	 *
	 * @param	$title
	 *
	 * @return	$title
	 */
	public function get_the_archive_title($title) {
		if(is_post_type_archive($this->post_types)){
			$title = post_type_archive_title( '', false );
		}
		if(is_tax($this->taxonomies)){
			$title = single_term_title( '', false );
		}
		return $title;
	}		
}