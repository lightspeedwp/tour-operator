<?php
/**
 * @package   LSX_TO_Template_Redirects
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeed
 *
 **/

class LSX_TO_Template_Redirects {

	/**
	 * Plugin Path
	 */
	public $plugin_path = false;

	/**
	 * Post Types
	 */
	public $post_types = false;	

	/**
	 * Taxonomies
	 */
	public $taxonomies = false;		

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @param array $post_types an array of the post types to redirect.
	 * @param array $taxonomies an array of the taxonomies to redirect.
	 */
	public function __construct($plugin_path=false,$post_types=false,$taxonomies=false) {
		if(false !== $plugin_path){
			$this->plugin_path = $plugin_path;

			add_filter( 'lsx_to_widget_path', array( $this, 'widget_path'), 10, 2 );
			add_filter( 'lsx_to_content_path', array( $this, 'content_path'), 10, 3 );

			if(false !== $post_types){
				$this->post_types = $post_types;
				add_filter( 'template_include', array( $this, 'post_type_archive_template_include'), 99 );
				add_filter( 'template_include', array( $this, 'post_type_single_template_include'), 99 );				
				add_filter( 'template_include', array( $this, 'search_template_include'), 99 );				
			}
			if(false !== $taxonomies){
				$this->taxonomies = $taxonomies;
				add_filter( 'template_include', array( $this, 'taxonomy_template_include'), 99 );				
			}
		}			
	}

	/**
	 * Redirect wordpress to the archive template located in the plugin
	 *
	 * @param	$template
	 * @return	$template
	 */
	public function post_type_archive_template_include( $template ) {
		
		if ( is_main_query() && is_post_type_archive($this->post_types)) {
			$current_post_type = get_post_type();
			if ( '' == locate_template( array( 'archive-'.$current_post_type.'.php' ) )	&& file_exists( $this->plugin_path.'templates/archive-'.$current_post_type.'.php' )) {
				$template = $this->plugin_path.'templates/archive-'.$current_post_type.'.php';
			}
		}
		return $template;
	}
	
	/**
	 * Redirect wordpress to the single template located in the plugin
	 *
	 * @param	$template
	 *
	 * @return	$template
	 */
	public function post_type_single_template_include($template) {
		if ( is_main_query() && is_singular($this->post_types) ) {
			$current_post_type = get_post_type();
			
			if ( '' == locate_template( array( 'single-'.$current_post_type.'.php' ) )	&& file_exists( $this->plugin_path.'templates/single-'.$current_post_type.'.php') ) {
					$template = $this->plugin_path.'templates/single-'.$current_post_type.'.php';
			}
		}
		return $template;
	}
	
	/**
	 * Redirect wordpress to the taxonomy located in the plugin
	 *
	 * @param	$template
	 *
	 * @return	$template
	 */
	public function taxonomy_template_include($template) {

		if ( is_main_query() && is_tax($this->taxonomies) ) {
			$current_taxonomy = get_query_var('taxonomy');
	
			if ( '' == locate_template( array( 'taxonomy-'.$current_taxonomy.'.php' ) ) && file_exists( $this->plugin_path.'templates/taxonomy-'.$current_taxonomy.'.php') ) {
				$template = $this->plugin_path.'templates/taxonomy-'.$current_taxonomy.'.php';
			}
		}
		return $template;
	}

	/**
	 * Redirect wordpress to the search template located in the plugin
	 *
	 * @param	$template
	 *
	 * @return	$template
	 */
	public function search_template_include( $template ) {
		
		if ( is_main_query() && is_search() ) {
			if ( file_exists( $this->plugin_path.'templates/search.php' )) {
				$template = $this->plugin_path.'templates/search.php';
			}
		}
		return $template;
	}

	/**
	 * Redirect wordpress to the single template located in the plugin
	 *
	 * @param	$template
	 *
	 * @return	$template
	 */
	public function content_part($slug, $name = null) {
		$template = array();
		$name = (string) $name;
		if ( '' !== $name ){
			$template = "{$slug}-{$name}.php";
		}else{
			$template = "{$slug}.php";
		}

		if ( '' == locate_template( array( $template ) ) && file_exists( $this->plugin_path.'templates/'.$template) ) {
			$template = $this->plugin_path.'templates/'.$template;
		}elseif(file_exists( get_stylesheet_directory().'/'.$template)){
			$template = get_stylesheet_directory().'/'.$template;
		}else{
			$template = false;
		}
		
		if(false !== $template){
			load_template( $template, false );
		}
	}

	/**
	 * Redirect wordpress to the single template located in the plugin
	 *
	 * @param	$path
	 * @param	$post_type
	 *
	 * @return	$path
	 */
	public function widget_path($path,$slug) {
		if((false !== $this->post_types && in_array($slug,$this->post_types))
		 || (false !== $this->taxonomies && in_array($slug,$this->taxonomies)) || 'post' === $slug){
			$path = $this->plugin_path;
		}
		return $path;
	}

	/**
	 * Redirect wordpress to the single template located in the plugin
	 *
	 * @param	$path
	 * @param	$post_type
	 *
	 * @return	$path
	 */
	public function content_path($path,$slug,$part) {
		if(false !== $this->post_types
			&& 'content' === $slug
			&& in_array(get_post_type(),$this->post_types)){

			$path = $this->plugin_path.'templates/';
		}
		return $path;
	}		
}