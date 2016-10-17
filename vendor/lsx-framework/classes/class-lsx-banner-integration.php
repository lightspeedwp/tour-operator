<?php
/**
 * Module Template.
 *
 * @package   TO_Banner_Integration
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package TO_Banner_Integration
 * @author  LightSpeed
 */
class TO_Banner_Integration {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct($post_types=array(),$taxonomies=array()) {
		$this->post_types = $post_types;
		$this->taxonomies = $taxonomies;
		add_action( 'init', array( $this, 'init' ) );
		add_filter('to_banner_enable_placeholder', function( $bool ) { return true; });
		add_filter('to_banner_placeholder_url', array($this,'banner_placeholder_url'));

		add_filter('to_banner_enable_title', function( $bool ) { return true; });	
		add_filter('to_banner_enable_subtitle', function( $bool ) { return true; });
	}
	
	/**
	 * Init
	 */
	public function init() {
		if(class_exists('TO_Banners')){			
			add_filter( 'to_banner_allowed_post_types', array( $this, 'enable_banners'));
			add_filter( 'to_banner_allowed_taxonomies', array( $this, 'enable_taxonomy_banners'));
			add_action('to_banner_content',array( $this, 'banner_content'));	
			add_filter( 'to_banner_post_type_archive_url', array( $this, 'banner_archive_url'));
			add_action('to_banner_content',array( $this, 'posts_page_banner_tagline'));
			add_filter('to_banner_title', array($this,'banner_title'),100 );
		}
	}	
	
	/**
	 * Enables the lsx banners
	 *
	 * @return    null
	 */
	public function enable_banners($allowed_post_types) {
		$allowed_post_types = array_merge($allowed_post_types,$this->post_types);
		return $allowed_post_types;
	}
	
	/**
	 * Enables the lsx banners for taxonomies
	 *
	 * @return    null
	 */
	public function enable_taxonomy_banners($allowed_taxonomies) {
		$allowed_taxonomies = array_merge($allowed_taxonomies,$this->taxonomies);
		return $allowed_taxonomies;
	}
	
	/**
	 * A filter that outputs the description for the post_type and taxonomy archives.
	 */
	public function banner_archive_url($image=false) {
		global $tour_operator;
		if(is_post_type_archive($tour_operator->active_post_types) && isset($tour_operator->options[get_post_type()])){
			if(isset($tour_operator->options[get_post_type()]['banner']) && '' !== $tour_operator->options[get_post_type()]['banner']){
				$image = $tour_operator->options[get_post_type()]['banner'];
			}
		}
		return $image;
	}

	/**
	 *  Picks the placeholder from a specific post type setting, if its there
	 */
	public function banner_placeholder_url($image=false) {
		global $tour_operator;
		if(isset($tour_operator->options['general']) && isset($tour_operator->options['general']['banner_placeholder']) && '' !== $tour_operator->options['general']['banner_placeholder']){
				$image = $tour_operator->options['general']['banner_placeholder'];
		}			
		if(isset($tour_operator->options[get_post_type()]) && isset($tour_operator->options[get_post_type()]['banner_placeholder']) && '' !== $tour_operator->options[get_post_type()]['banner_placeholder']){
				$image = $tour_operator->options[get_post_type()]['banner_placeholder'];
		}
		return $image;
	}	
	
	/**
	 * A filter that outputs the description for the post_type and taxonomy archives.
	 */
	public function posts_page_banner_tagline(){
		global $tour_operator;
		if(is_home() && isset($tour_operator->options[get_post_type()]) && isset($tour_operator->options[get_post_type()]['tagline'])){
			$tagline = $tour_operator->options[get_post_type()]['tagline'];
			?>
			<p class="tagline"><?php echo $tagline; ?></p>
			<?php 
		}
	}
		
	/**
	 * A filter that outputs the title for the post_type_archives.
	 */
	public function banner_title($title) {
		global $tour_operator;
		if(is_post_type_archive() && isset($tour_operator->options[get_post_type()]) && isset($tour_operator->options[get_post_type()]['title']) && '' !== $tour_operator->options[get_post_type()]['title'] ){
			$title = '<h1 class="page-title">'.$tour_operator->options[get_post_type()]['title'].'</h1>';
		}
		return $title;
	}	
	
	/**
	 * Add homepage banner content
	 */
	public function banner_content(){
		if(is_front_page()){
			?>
			<div class="banner-content"><?php the_content(); ?></div>
			<?php 
		}
		if(is_singular('post')){
			?>
			<div class="banner-content"><?php to_post_meta(); ?></div>
			<?php 		
		}
	}
}
