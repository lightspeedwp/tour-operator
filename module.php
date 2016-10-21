<?php
/**
 * @package   TO_Tour_Operators
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeed
 *
 **/
if(!function_exists('cmb_init')){
	if ( is_file( TO_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php' ) ) {
		require_once( TO_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php' );
	}
}

require_once( TO_PATH . 'includes/template-tags.php' );
require_once( TO_PATH . 'includes/post-expirator.php' );
require_once( TO_PATH . 'includes/post-order.php' );
require_once( TO_PATH . 'includes/customizer.php' );
require_once( TO_PATH . 'includes/layout.php' );
require_once( TO_PATH . 'includes/widgets/post-type-widget.php');
require_once( TO_PATH . 'includes/widgets/taxonomy-widget.php');
require_once( TO_PATH . 'includes/widgets/cta-widget.php');
require_once( TO_PATH . 'classes/class-fields.php');

// Setup the post connections
class TO_Tour_Operators {
	
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
	 * Holds the TO_Framework class
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
	public $plugin_slug = 'tour-operator';	
	
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
		add_action( 'init', array( $this, 'require_post_type_classes' ) , 1 );
		//Allow extra tags and attributes to wp_kses_post()
		add_filter( 'wp_kses_allowed_html', array( $this, 'wp_kses_allowed_html' ), 10, 2 );
		//Allow extra protocols to wp_kses_post()
		add_filter( 'kses_allowed_protocols', array( $this, 'kses_allowed_protocols' ) );
		//Allow extra style attributes to wp_kses_post()
		add_filter( 'safe_style_css', array( $this, 'safe_style_css' ) );
		

		
		require_once( TO_PATH . 'classes/class-lsx-to-admin.php' );
		if(class_exists('TO_Admin')){
			$this->admin = new TO_Admin();
		}

		require_once( TO_PATH . 'classes/class-lsx-to-settings.php' );
		if(class_exists('TO_Settings')){
			$this->settings = new TO_Settings();
		}

		require_once( TO_PATH . 'classes/class-lsx-to-frontend.php' );
		if(class_exists('TO_Frontend')){
			$this->frontend = new TO_Frontend();
			add_action( 'to_content', array( $this->frontend->redirects, 'content_part' ), 10 , 2 );
		}

		if(!class_exists('TO_Placeholders')){
			include_once('classes/class-placeholders.php');
			$this->placeholders = new TO_Placeholders(array_keys($this->post_types));
		}		

		add_action( 'widgets_init', array( $this, 'register_widget'));

		//These need to run after the plugins have all been read.
		include_once('classes/class-lsx-banner-integration.php');
		$this->lsx_banners = new TO_LSX_Banner_Integration(array_keys($this->post_types),array_keys($this->taxonomies));

		//Integrations
		$this->to_search_integration();
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
		load_plugin_textdomain( 'tour-operator', FALSE, basename( TO_PATH ) . '/languages');
	}

	/**
	 * Sets the variables for the class
	 */
	public function set_vars(){
		// This is the array of enabled post types.
		$this->post_types = array(
				'destination'	=> esc_html__('Destinations','tour-operator'),
				'accommodation'	=> esc_html__('Accommodation','tour-operator'),
				'tour'			=> esc_html__('Tours','tour-operator'),
		);	
		$this->post_types_singular = array(
				'destination'	=> esc_html__('Destination','tour-operator'),
				'accommodation'	=> esc_html__('Accommodation','tour-operator'),
				'tour'			=> esc_html__('Tour','tour-operator'),
		);		
		$this->post_types = apply_filters('to_post_types',$this->post_types);
		$this->active_post_types = array_keys($this->post_types);

		$this->taxonomies = array(
				'travel-style'			=> __('Travel Style',$this->plugin_slug),
				'accommodation-brand'			=> __('Brand',$this->plugin_slug),
				'accommodation-type'	=> __('Accommodation Type',$this->plugin_slug),
				'facility'	=> __('Facility',$this->plugin_slug),
				'location'	=> __('Location',$this->plugin_slug)
		);
		$this->taxonomies_plural = array(
				'travel-style'			=> __('Travel Styles',$this->plugin_slug),
				'accommodation-brand'			=> __('Brands',$this->plugin_slug),
				'accommodation-type'	=> __('Accommodation Types',$this->plugin_slug),
				'facility'	=> __('Facilities',$this->plugin_slug),
				'location'	=> __('Locations',$this->plugin_slug)
		);				
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
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.0.1
	 */
	public function get_active_post_types() {
		return $this->active_post_types;
	}

	/**
	 * Requires the post type classes
	 *
	 * @since 0.0.1
	 */
	public function require_post_type_classes() {
		foreach($this->post_types as $post_type => $label){
			require_once( TO_PATH . 'classes/class-'.$post_type.'.php' );
		}
		$this->connections = $this->create_post_connections();	
		$this->single_fields = apply_filters('to_search_fields',array());
	}

	/**
	 * Generates the post_connections used in the metabox fields
	 */
	public function create_post_connections() {
		$connections = array();
		$post_types = apply_filters('to_post_types',$this->post_types);
		foreach($post_types as $key_a => $values_a){
			foreach($this->post_types as $key_b => $values_b){
				// Make sure we dont try connect a post type to itself.
				if($key_a !== $key_b){
					$connections[] = $key_a.'_to_'.$key_b;
				}
			}
		}
		return $connections;
	}		

	/**
	 * Include the post type for the search integration
	 */
	public function to_search_integration(){
		add_filter( 'to_search_post_types', array( $this, 'post_types_filter') );
		add_filter( 'to_search_taxonomies', array( $this, 'taxonomies_filter') );	
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
	 * Returns the post types for use in the addons.
	 */
	public function get_taxonomies(){
		return $this->taxonomies;
	}

	/**
	 * Returns the post types for use in the addons.
	 */
	public function get_post_types(){
		return $this->post_types;
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
			$tagline_value = get_post_meta(get_the_ID(),'banner_subtitle',true);
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

	/**
	 * Allow extra tags and attributes to wp_kses_post()
	 */
	public function wp_kses_allowed_html( $allowedtags, $context ) {
		// Tags exist, only adding new attributes

		$allowedtags['i']['aria-hidden'] = true;
		$allowedtags['span']['aria-hidden'] = true;

		$allowedtags['button']['aria-label'] = true;
		$allowedtags['button']['data-dismiss'] = true;

		$allowedtags['li']['data-target'] = true;
		$allowedtags['li']['data-slide-to'] = true;

		$allowedtags['a']['data-toggle'] = true;
		$allowedtags['a']['data-target'] = true;
		$allowedtags['a']['data-slide'] = true;
		$allowedtags['a']['data-collapsed'] = true;

		$allowedtags['div']['aria-labelledby'] = true;
		$allowedtags['div']['data-interval'] = true;
		$allowedtags['div']['data-icon'] = true;
		$allowedtags['div']['data-id'] = true;
		$allowedtags['div']['data-class'] = true;
		$allowedtags['div']['data-long'] = true;
		$allowedtags['div']['data-lat'] = true;
		$allowedtags['div']['data-zoom'] = true;
		$allowedtags['div']['data-link'] = true;
		$allowedtags['div']['data-thumbnail'] = true;
		$allowedtags['div']['data-title'] = true;
		$allowedtags['div']['data-type'] = true;
		$allowedtags['div']['data-cluster-small'] = true;
		$allowedtags['div']['data-cluster-medium'] = true;
		$allowedtags['div']['data-cluster-large'] = true;

		// New tags

		$allowedtags['input'] = array();
		$allowedtags['input']['type'] = true;
		$allowedtags['input']['id'] = true;
		$allowedtags['input']['name'] = true;
		$allowedtags['input']['value'] = true;
		$allowedtags['input']['size'] = true;
		$allowedtags['input']['checked'] = true;
		$allowedtags['input']['onclick'] = true;

		$allowedtags['select'] = array();
		$allowedtags['select']['name'] = true;
		$allowedtags['select']['id'] = true;
		$allowedtags['select']['disabled'] = true;
		$allowedtags['select']['onchange'] = true;

		$allowedtags['option'] = array();
		$allowedtags['option']['value'] = true;
		$allowedtags['option']['selected'] = true;

		$allowedtags['iframe'] = array();
		$allowedtags['iframe']['src'] = true;
		$allowedtags['iframe']['width'] = true;
		$allowedtags['iframe']['height'] = true;
		$allowedtags['iframe']['frameborder'] = true;
		$allowedtags['iframe']['allowfullscreen'] = true;
		$allowedtags['iframe']['style'] = true;

		return $allowedtags;
	}

	/**
	 * Allow extra protocols to wp_kses_post()
	 */
	public function kses_allowed_protocols( $allowedprotocols ) {
		$allowedprotocols[] = 'tel';
		return $allowedprotocols;
	}

	/**
	 * Allow extra style attributes to wp_kses_post()
	 */
	public function safe_style_css( $allowedstyles ) {
		$allowedstyles[] = 'display';
		return $allowedstyles;
	}

	/**
	 * checks which plugin is active, and grabs those forms.
	 */
	public function show_default_form() {
		if(class_exists('Caldera_Forms_Forms') || class_exists('GFForms') || class_exists('Ninja_Forms')) {
			return true;
		}else{
			return false;
		}		
	}

	/**
	 * checks which plugin is active, and grabs those forms.
	 */
	public function get_activated_forms() {
		$all_forms = false;
		if(class_exists('Ninja_Forms')){
			$all_forms = $this->get_ninja_forms();
		}elseif(class_exists('GFForms')){
			$all_forms = $this->get_gravity_forms();
		}elseif(class_exists('Caldera_Forms_Forms')) {
			$all_forms = $this->get_caldera_forms();
		}
		return $all_forms;
	}

	/**
	 * gets the currenct ninja forms
	 */
	public function get_ninja_forms() {
		global $wpdb;
		$results = $wpdb->get_results("SELECT id,title FROM {$wpdb->prefix}nf3_forms");
		$forms = false;
		if(!empty($results)){
			foreach($results as $form){
				$forms[$form->id] = $form->title;
			}
		}
		return $forms;
	}
	/**
	 * gets the currenct gravity forms
	 */
	public function get_gravity_forms() {
		global $wpdb;
		$results = RGFormsModel::get_forms( null, 'title' );
		$forms = false;
		if(!empty($results)){
			foreach($results as $form){
				$forms[$form->id] = $form->title;
			}
		}
		return $forms;
	}
	/**
	 * gets the currenct caldera forms
	 */
	public function get_caldera_forms() {
		global $wpdb;
		$results = Caldera_Forms_Forms::get_forms(true);
		$forms = false;
		if(!empty($results)){
			foreach($results as $form => $form_data){
				$forms[$form] = $form_data['name'];
			}
		}
		return $forms;
	}	

}
$tour_operator = TO_Tour_Operators::get_instance();

/**
 * Returns an array of the tour taxonomies.
 *
 * @param	$term_id
 */
function to_get_taxonomies() {
	global $tour_operator;
	if(false !== $tour_operator){
		return $tour_operator->get_taxonomies();
	}
}

/**
 * Returns an array of the tour post types.
 *
 * @param	$term_id
 */
function to_get_post_types() {
	global $tour_operator;
	if(false !== $tour_operator){
		return $tour_operator->get_post_types();
	}
}