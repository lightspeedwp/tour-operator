<?php
/**
 * @package   LSX_Tour_Operators
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeed
 *
 **/
if(!function_exists('cmb_init')){
	if ( is_file( LSX_TOUR_OPERATORS_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php' ) ) {
		require_once( LSX_TOUR_OPERATORS_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php' );
	}
}

require_once( LSX_TOUR_OPERATORS_PATH . 'includes/template-tags.php' );
require_once( LSX_TOUR_OPERATORS_PATH . 'includes/post-expirator.php' );
require_once( LSX_TOUR_OPERATORS_PATH . 'includes/post-order.php' );
require_once( LSX_TOUR_OPERATORS_PATH . 'includes/customizer.php' );

// Setup the post connections
class LSX_Tour_Operators {
	
	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object|Module_Template
	 */
	protected static $instance = null;	
	
	/**
	 * Holds the array of options
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $options = false;	
	
	/**
	 * Holds the LSX_Framework class
	 *
	 * @since 1.0.0
	 *
	 * @var      object
	 */
	public $framework = false;	
	
	/**
	 * Holds the array of post_types
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $post_types = array();	
	
	/**
	 * Holds the array of taxonomies
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $taxonomies = array();	
	
	/**
	 * Holds the array of active post_types
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $active_post_types = array();
	
	/**
	 * Holds the array of connections from posts to posts
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $connections = null;	
	
	/**
	 * is out WETU Importer Plugin active
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $is_wetu_active = false;

	/**
	 * Holds the textdomain slug
	 *
	 * @since 1.0.0
	 *
	 * @var      array()
	 */
	public $plugin_slug = 'lsx-tour-operators';	
	
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function __construct() {
		
		//Set the options
		$this->options = get_option('_lsx_lsx-settings',false);	
		$this->set_vars();

		//Add our action to init to set up our vars first.	
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		if(!class_exists('LSX_Framework')){
			require_once( LSX_TOUR_OPERATORS_PATH . 'vendor/lsx-framework/lsx-framework.php' );
		}
		$this->framework = new LSX_Framework(LSX_TOUR_OPERATORS_PATH,$this->post_types,$this->active_post_types,array_keys($this->taxonomies));
		
		require_once( LSX_TOUR_OPERATORS_PATH . 'classes/class-lsx-to-admin.php' );
		if(class_exists('LSX_TO_Admin')){
			$this->admin = new LSX_TO_Admin();
		}
		require_once( LSX_TOUR_OPERATORS_PATH . 'classes/class-lsx-to-frontend.php' );
		if(class_exists('LSX_TO_Frontend')){
			$this->frontend = new LSX_TO_Frontend();
		}

		//Integrations
		$this->lsx_search_integration();
		
		add_action( 'lsx_tour_operator_content', array( $this->frontend->redirects, 'content_part' ), 10 , 2 );
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
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.0.1
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'lsx-tour-operators', FALSE, basename( LSX_TOUR_OPERATORS_PATH ) . '/languages');
	}

	/**
	 * Sets the variables for the class
	 */
	public function set_vars(){
		// This is the array of enabled post types.
		$this->active_post_types = $this->get_active_post_types();
		$this->post_types = array(
				//'activity'		=> 'Activites',
				'accommodation'	=> 'Accommodation',
				'destination'	=> 'Destinations',
				//'review'		=> 'Reviews',
				//'special'		=> 'Specials',
				'team'			=> 'Team',
				'tour'			=> 'Tours',
				//'vehicle'		=> 'Vehicles'
		);	
		$this->taxonomies = array(
				'travel-style'			=> __('Travel Style',$this->plugin_slug),
				'accommodation-brand'			=> __('Brand',$this->plugin_slug),
				'accommodation-type'	=> __('Accommodation Type',$this->plugin_slug),
				//'special-type'	=> __('Special Type',$this->plugin_slug),
				'facility'	=> __('Facility',$this->plugin_slug),
				'location'	=> __('Location',$this->plugin_slug)
		);		
	}		
	
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.0.1
	 */
	public function get_active_post_types() {
		$active_post_types = array();

		//print_r(); die();
		if(false !== $this->options && isset($this->options['general']['post_types']) && is_array($this->options['general']['post_types']) && !empty($this->options['general']['post_types'])){

			$active_post_types = array_keys($this->options['general']['post_types']);
		} 
		return $active_post_types;
	}

	/**
	 * Include the post type for the search integration
	 */
	public function lsx_search_integration(){
		add_filter( 'lsx_search_post_types', array( $this, 'post_types_filter') );
		add_filter( 'lsx_search_taxonomies', array( $this, 'taxonomies_filter') );	
	}	

	/**
	 * Adds our post types to an array via a filter
	 */
	public function post_types_filter($post_types){
		if(is_array($post_types)){
			$post_types = array_merge($post_types,$this->post_types);
		}else{
			$post_types = $this->post_types;
		}
		return $post_types;
	}

	/**
	 * Adds our taxonomies to an array via a filter
	 */
	public function taxonomies_filter($taxonomies){
		if(is_array($taxonomies)){
			$taxonomies = array_merge($taxonomies,$this->taxonomies);
		}else{
			$taxonomies = $this->taxonomies;
		}
		return $taxonomies;
	}		

	/**
	 * A filter that outputs the tagline for the current page.
	 */
	public function get_tagline($tagline=false,$before='',$after='') {

		if(is_post_type_archive($this->active_post_types) && isset($this->options[get_post_type()]) && isset($this->options[get_post_type()]['tagline'])){
			$tagline = $this->options[get_post_type()]['tagline'];
		}	
		if(is_singular($this->active_post_types)){
			$tagline_value = get_post_meta(get_the_ID(),'tagline',true);
			if(false !== $tagline_value){
				$tagline = $tagline_value;
			}
		}
		if(is_tax(array_keys($this->taxonomies))){
			$taxonomy_tagline = get_term_meta(get_queried_object_id(), 'tagline', true);
			if(false !== $taxonomy_tagline && '' !== $taxonomy_tagline){
				$tagline = $taxonomy_tagline;
			}
		}		
		if(false !== $tagline && '' !== $tagline){
			$tagline = $before.$tagline.$after;
		}
		return $tagline;
	}
	
	/**
	 * A filter that outputs the description for the post_type archives.
	 */
	public function get_post_type_archive_description($description=false,$before='',$after='') {	
		if(is_post_type_archive($this->active_post_types) && isset($this->options[get_post_type()]) && isset($this->options[get_post_type()]['description']) && '' !== $this->options[get_post_type()]['description'] ){
			$description = $this->options[get_post_type()]['description'];
			$description = $this->apply_filters_the_content($description);
			$description = $before.$description.$after;
		}
		return $description;
	}

	/**
	 * Return any content with "read more" button and filtered by the_content
	 */
	public function apply_filters_the_content( $content = '', $more_link_text = 'Read More', $link = '' ) {
		$output = '';

		if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
			$content = explode( $matches[0], $content, 2 );
			
			if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) )
				$more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
		} else {
			$content = array( $content );
		}
		
		$output .= $content[0];

		if ( count( $content ) > 1 ) {
			if ( empty( $link ) ) {
				$output .= "<a class=\"btn btn-default more-link\" data-collapsed=\"true\" href=\"#more-000\">{$more_link_text}</a>" . $content[1];
			} else {
				$output .= "<a class=\"btn btn-default more-link\" href=\"{$link}\">{$more_link_text}</a>";
			}
		}

		$output = apply_filters( 'the_content', $output );
		return $output;
	}

}
$lsx_tour_operators = LSX_Tour_Operators::get_instance();