<?php
/**
 * Frontend actions for the framework
 *
 * @package   TO_Framework_Frontend
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package TO_Framework_Frontend
 * @author  LightSpeed
 */
class TO_Framework_Frontend {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct($post_types=false,$framework_path=false,$framework_url=false) {

		$this->post_types = $post_types;
		$this->framework_path = $framework_path;
		$this->framework_url = $framework_url;
		$options = get_option('_to_lsx-settings',false);	
		if(false !== $options){
			$this->options = $options;
		}
		else{
			$this->options = false;
		}	

		//General
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylescripts' ) );

		//Redirects
		add_action( 'template_redirect', array( $this, 'redirect_singles') );
		add_action( 'template_redirect', array( $this, 'redirect_archive') );

		//LSX
		add_action( 'to_content_before', array( $this, 'remove_jetpack_share' ));
		add_action( 'to_content_wrap_before', array( $this, 'remove_jetpack_share' ));

		//Jetpack
		add_filter( 'sharing_show', array( $this, 'show_jetpack_sharing_filter'),2,100 );	

		// Readmore
		add_filter( 'the_content', array( $this, 'modify_read_more_link') );
		remove_filter( 'term_description','wpautop' );
		add_filter( 'term_description', array( $this, 'modify_term_description') );			
	}

	/**
	 * Redirect the single links to the homepage if the single is set to be disabled.
	 *
	 * @param	$template
	 *
	 * @return	$template
	 */
	public function redirect_singles() {
		$queried_post_type = get_query_var('post_type');
		if(is_singular() && false !== $this->options && isset($this->options[$queried_post_type]) && isset($this->options[$queried_post_type]['disable_single'])){
			if ( is_singular($queried_post_type)) {
				wp_redirect( home_url(), 301 );
				exit;
			}
		}
	}
	
	/**
	 * Redirect the archive links to the homepage if the disable archive is set to be disabled.
	 *
	 * @param	$template
	 *
	 * @return	$template
	 */
	public function redirect_archive() {
		$queried_post_type = get_query_var('post_type');
		if(is_post_type_archive() && false !== $this->options && isset($this->options[$queried_post_type]) && isset($this->options[$queried_post_type]['disable_archives'])){
			if ( is_post_type_archive($queried_post_type) ) {
				wp_redirect( home_url(), 301 );
				exit;
			}
		}
	}

	public function remove_jetpack_share() {
		
		if(in_array(get_post_type(),$this->post_types)){
			remove_filter( 'the_content', 'sharing_display',19 );
			remove_filter( 'the_excerpt', 'sharing_display',19 );
			if ( class_exists( 'Jetpack_Likes' ) ) {
				remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
			}
		}
	}
	
	public function show_jetpack_sharing_filter($show, $post) {
		if(in_array($post->post_type,$this->post_types)){
			$show = true;
		}
		return $show;
	}

	/**
	 * Register and enqueue javascript file for the frontend.
	 *
	 * @return    null
	 */
	public function enqueue_stylescripts() {
		if(!is_admin()){
			wp_enqueue_script( 'lsx-framework-js', $this->framework_url . 'assets/js/lsx-framework.js', array( 'jquery' ) , false, true );
		}
	}		

	/**
	 * Modify the read more link
	 *
	 * @package 	lsx-framework
	 * @subpackage 	read-more
	 * @category 	post-types
	 *
	 * @param 		string $content
	 * @return   	string $content
	 */
	public function modify_read_more_link($content) {
		$content = str_replace('<span id="more-'.get_the_ID().'"></span>','<a class="btn btn-default more-link" data-collapsed="true" href="' . get_permalink() . '">'.__('Read More','lsx-framework').'</a>',$content);
		return $content;
	}

	/**
	 * Modify term_description to use the_content filter
	 * 
	 * @package 	lsx-framework
	 * @subpackage 	read-more
	 * @category 	taxonomies
	 *
	 * @param 		string $content
	 * @return   	string $content
	 */
	public function modify_term_description( $content ) {
		$more_link_text = 'Read More';
		$output = '';

		if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
			$content = explode( $matches[0], $content, 2 );
			
			if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) )
				$more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
		} else {
			$content = array( $content );
		}

		$teaser = $content[0];
		$output .= $teaser;

		if ( count( $content ) > 1 ) {
			$output .= "<a class=\"btn btn-default more-link\" data-collapsed=\"true\" href=\"#more-000\">{$more_link_text}</a>" . $content[1];
		}

		$output = apply_filters( 'the_content', $output );
		return $output;
	}			
}