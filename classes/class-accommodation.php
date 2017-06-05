<?php
/**
 * Accommodation Class, this registers the post type and adds certain filters for layout.
 *
 * @package   LSX_TO_Accommodation
 * @author     LightSpeed Team
 * @license   GPL3
 * @link      
 * @copyright 2015  LightSpeed Team
 */


/**
 * Plugin class.
 * @package LSX_TO_Accommodation
 * @author   LightSpeed Team
 */
class LSX_TO_Accommodation {

	/**
	 * The slug for this plugin
	 *
	 * @since 0.0.1
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'accommodation';

	/**
	 * Holds class isntance
	 *
	 * @since 0.0.1
	 *
	 * @var      object|LSX_TO_Accommodation
	 */
	protected static $instance = null;

	/**
	 * If Wetu is active
	 *
	 * @since 0.0.1
	 *
	 * @var      boolean
	 */
	public $is_wetu_active = false;

	/**
	 * Holds and array of the Unit types available (slug => key)
	 *
	 * @since 0.0.1
	 *
	 * @var      array
	 */
	public $unit_types = false;

	/**
	 * Holds the $page_links array while its being built on the single accommodation page.
	 *
	 * @since 0.0.1
	 *
	 * @var      array
	 */
	public $page_links = false;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 */
	private function __construct() {
		$this->is_wetu_active = false;
		$this->display_connected_tours = false;

		$this->options = get_option('_lsx-to_settings',false);

		$this->unit_types = array(
			'chalet' => esc_html__('Chalet','tour-operator'),
			'room' => esc_html__('Room','tour-operator'),
			'spa' => esc_html__('Spa','tour-operator'),
			'tent' => esc_html__('Tent','tour-operator'),
			'villa' => esc_html__('Villa','tour-operator')
		);

		// activate property post type
		add_action( 'init', array( $this, 'activate_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies') );
		add_filter( 'cmb_meta_boxes', array( $this, 'metaboxes') );	

		add_action( 'lsx_to_framework_accommodation_tab_general_settings_bottom', array($this,'general_settings'), 10 , 1 );
		add_action( 'lsx_to_framework_accommodation_tab_single_settings_bottom', array($this,'single_settings'), 10 , 1 );
		
		add_filter( 'lsx_to_entry_class', array( $this, 'entry_class') );

		if(!class_exists('LSX_Currency')){
			add_filter('lsx_to_custom_field_query',array( $this, 'price_filter'),5,10);
		}

		add_filter('lsx_to_custom_field_query',array( $this, 'rating'),5,10);
		
		include('class-units.php');

		add_action('lsx_to_map_meta','lsx_to_accommodation_meta');
		add_action('lsx_to_modal_meta','lsx_to_accommodation_meta');

		add_filter( 'lsx_to_page_navigation', array( $this, 'page_links') );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 0.0.1
	 *
	 * @return    object|LSX_TO_Accommodation    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	/**
	 * Register the properties post types.
	 *
	 *
	 * @return    null
	 */
	public function activate_post_types() {
		
		// define the properties post type
		$args = array(
			'labels' 				=> array(
				'name' 				=> esc_html__('Accommodation', 'tour-operator'),
				'singular_name' 	=> esc_html__('Accommodation', 'tour-operator'),
				'add_new' 			=> esc_html__('Add New', 'tour-operator'),
				'add_new_item' 		=> esc_html__('Add New Accommodation', 'tour-operator'),
				'edit_item' 		=> esc_html__('Edit Accommodation', 'tour-operator'),
				'all_items' 		=> esc_html__('Accommodation', 'tour-operator'),
				'view_item' 		=> esc_html__('View Accommodation', 'tour-operator'),
				'search_items' 		=> esc_html__('Search Accommodation', 'tour-operator'),
				'not_found' 		=> esc_html__('No accommodation defined', 'tour-operator'),
				'not_found_in_trash'=> esc_html__('No accommodation in trash', 'tour-operator'),
				'parent_item_colon' => '',
				'menu_name' 		=> esc_html__('Accommodation', 'tour-operator')
			),
			'public' 				=>	true,
			'publicly_queryable'	=>	true,
			'show_ui' 				=>	true,
			'show_in_menu' 			=>	'tour-operator',
			'menu_position' 		=>	30,
			'query_var' 			=>	true,
			'rewrite' 				=>	array('slug' => 'accommodation','with_front'=>false),		
			'exclude_from_search' 	=>	false,
			'capability_type' 		=>	'post',
			'has_archive' 			=>	'accommodation',
			'hierarchical' 			=>	false,
			'menu_icon'				=>	"dashicons-admin-multisite",
			'supports' 				=> array(
				'title',
				'slug',
				'editor',
				'thumbnail',
				'excerpt',
				'custom-fields'
			),
		);
		
		// register post type
		register_post_type('accommodation', $args);
	}
	
	
	/**
	 * Register the global post types.
	 *
	 *
	 * @return    null
	 */
	public function register_taxonomies() {
		$labels = array(
				'name' => esc_html__( 'Facilities', 'tour-operator' ),
				'singular_name' => esc_html__( 'Facility', 'tour-operator' ),
				'search_items' =>  esc_html__( 'Search Facilities' , 'tour-operator' ),
				'all_items' => esc_html__( 'Facilities' , 'tour-operator' ),
				'parent_item' => esc_html__( 'Parent' , 'tour-operator' ),
				'parent_item_colon' => esc_html__( 'Parent:' , 'tour-operator' ),
				'edit_item' => esc_html__( 'Edit Facility' , 'tour-operator' ),
				'update_item' => esc_html__( 'Update Facility' , 'tour-operator' ),
				'add_new_item' => esc_html__( 'Add New Facility' , 'tour-operator' ),
				'new_item_name' => esc_html__( 'New Facility' , 'tour-operator' ),
				'menu_name' => esc_html__( 'Facilities' , 'tour-operator' ),
		);
		
		// Now register the taxonomy
		register_taxonomy('facility',$this->plugin_slug, array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'public' => true,
				'show_tagcloud' => false,
				'exclude_from_search' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => false,
		));
		
		$labels = array(
				'name' => esc_html__( 'Accommodation Type', 'tour-operator' ),
				'singular_name' => esc_html__( 'Accommodation Type', 'tour-operator' ),
				'search_items' =>  esc_html__( 'Search Accommodation Types' , 'tour-operator' ),
				'all_items' => esc_html__( 'Accommodation Types' , 'tour-operator' ),
				'parent_item' => esc_html__( 'Parent Accommodation Type' , 'tour-operator' ),
				'parent_item_colon' => esc_html__( 'Parent Accommodation Type:' , 'tour-operator' ),
				'edit_item' => esc_html__( 'Edit Accommodation Type' , 'tour-operator' ),
				'update_item' => esc_html__( 'Update Accommodation Type' , 'tour-operator' ),
				'add_new_item' => esc_html__( 'Add New Accommodation Type' , 'tour-operator' ),
				'new_item_name' => esc_html__( 'New Accommodation Type' , 'tour-operator' ),
				'menu_name' => esc_html__( 'Accommodation Types' , 'tour-operator' ),
		);
		
		// Now register the taxonomy
		register_taxonomy('accommodation-type',$this->plugin_slug, array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'public' => true,
				'show_tagcloud' => false,
				'exclude_from_search' => true,
				'show_admin_column' => false,
				'query_var' => true,
				'rewrite' => array('accommodation-type'),
		));		
		

	}	
	
	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	
	function metaboxes( array $meta_boxes ) {		
		
		// Info Panel
		$fields[] = array( 'id' => 'featured',  'name' => esc_html__('Featured','tour-operator'), 'type' => 'checkbox' );
		if(!class_exists('LSX_Banners')){
			$fields[] = array( 'id' => 'tagline',  'name' => esc_html__('Tagline','tour-operator'), 'type' => 'text' );
		}

		if(class_exists('LSX_TO_Field_Pattern')){
			$fields = array_merge($fields,LSX_TO_Field_Pattern::price());
		}

		$fields[] = array( 
			'id' => 'price_type',
			'name' => esc_html__('Price Type','tour-operator'),
			'type' => 'select',
			'options' => array(
				'none' => 'Select a type',
				'per_person_per_night' => esc_html__('Per Person Per Night','tour-operator'),
				'per_person_sharing' => esc_html__('Per Person Sharing','tour-operator'),
				'per_person_sharing_per_night' => esc_html__('Per Person Sharing Per Night','tour-operator'),
				'total_percentage' => esc_html__('Percentage Off Your Price.','tour-operator')
			)
		);

		$fields[] = array( 'id' => 'included',  'name' => esc_html__('Included','tour-operator'), 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ) );
		$fields[] = array( 'id' => 'not_included',  'name' => esc_html__('Not Included','tour-operator'), 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ) );

		$fields[] = array( 'id' => 'team_to_accommodation', 'name' => esc_html__('Accommodation Expert','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'team','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'allow_none'=>true, 'cols' => 12 );
		
		if(class_exists('LSX_TO_Maps')){
			$fields[] = array( 'id' => 'location_title',  'name' => esc_html__('Location','tour-operator'), 'type' => 'title' );
			$fields[] = array( 'id' => 'location',  'name' => esc_html__('Address','tour-operator'), 'type' => 'gmap', 'google_api_key' => $this->options['api']['googlemaps_key'] );
		}
		
		//Fast Facts
		$fast_facts_fields = array(
				array( 'id' => 'fast_facts_title',  'name' => esc_html__('Fast Facts','tour-operator'), 'type' => 'title' ),
				array(
						'id' => 'rating_type',
						'name' => esc_html__('Rating Type','tour-operator'),
						'type' => 'select',
						'options' => array(
								'Unspecified' => esc_html__('Unspecified','tour-operator'),
								'TGCSA' => esc_html__('TGCSA','tour-operator'),
								'Hotelstars Union' => esc_html__('Hotelstars Union','tour-operator')
						)
				),				
				array( 'id' => 'rating',  'name' => esc_html__('Rating','tour-operator'), 'type' => 'radio', 'options' => array( '1', '2', '3', '4', '5' ), 'allow_none' => true ),
				array( 'id' => 'number_of_rooms',  'name' => esc_html__('Number of Rooms','tour-operator'), 'type' => 'text' ),
				array( 'id' => 'checkin_time',  'name' => esc_html__('Check-in Time','tour-operator'), 'type' => 'time' ),
				array( 'id' => 'checkout_time',  'name' => esc_html__('Check-out Time','tour-operator'), 'type' => 'time' ),
				array( 'id' => 'minimum_child_age',  'name' => esc_html__('Minimum Child Age','tour-operator'), 'type' => 'text' ),
				array( 
					'id' => 'spoken_languages',
					'name' => esc_html__('Spoken Languages','tour-operator'),
					'type' => 'select',
					'multiple' => true,
					'options' => array( 
							'afrikaans' => esc_html__('Afrikaans','tour-operator'),
							'chinese' => esc_html__('Chinese','tour-operator'),
							'dutch' => esc_html__('Dutch','tour-operator'),
							'english' => esc_html__('English','tour-operator'),
							'flemish' => esc_html__('Flemish','tour-operator'),
							'french' => esc_html__('French','tour-operator'),
							'german' => esc_html__('German','tour-operator'),
							'indian' => esc_html__('Indian','tour-operator'),
							'italian' => esc_html__('Italian','tour-operator'),
							'japanese' => esc_html__('Japanese','tour-operator'),
							'portuguese' => esc_html__('Portuguese','tour-operator'),
							'russian' => esc_html__('Russian','tour-operator'),
							'spanish' => esc_html__('Spanish','tour-operator'),
							'swahili' => esc_html__('Swahili','tour-operator'),
							'xhosa' => esc_html__('Xhosa','tour-operator'),
							'zulu' => esc_html__('Zulu','tour-operator')
					)
				),
				array(
						'id' => 'suggested_visitor_types',
						'name' => esc_html__('Friendly','tour-operator'),
						'type' => 'select',
						'multiple' => true,
						'options' => array(
								'business' => esc_html__('Business','tour-operator'),
								'children' => esc_html__('Children','tour-operator'),
								'disability' => esc_html__('Disability','tour-operator'),
								'leisure' => esc_html__('Leisure','tour-operator'),
								'luxury' => esc_html__('Luxury','tour-operator'),
								'pet' => esc_html__('Pet','tour-operator'),
								'romance' => esc_html__('Romance','tour-operator'),
								'vegetarian' => esc_html__('Vegetarian','tour-operator'),
								'weddings' => esc_html__('Weddings','tour-operator')
						)
				),	                         				
				array( 
					'id' => 'special_interests',
					'name' => esc_html__('Special Interests','tour-operator'),
					'type' => 'select',
					'multiple' => true,
					'options' => array(
						'adventure' => esc_html__('Adventure','tour-operator'),
						'battlefields' => esc_html__('Battlefields','tour-operator'),
						'beach_coastal' => esc_html__('Beach / Coastal','tour-operator'),
						'big-5' => esc_html__('Big 5','tour-operator'),
						'birding' => esc_html__('Birding','tour-operator'),
						'cycling' => esc_html__('Cycling','tour-operator'),
						'fishing' => esc_html__('Fishing','tour-operator'),
						'flora' => esc_html__('Flora','tour-operator'),
						'golf' => esc_html__('Golf','tour-operator'),
						'gourmet' => esc_html__('Gourmet','tour-operator'),
						'hiking' => esc_html__('Hiking','tour-operator'),
						'history-and-culture' => esc_html__('History & Culture','tour-operator'),
						'indigenous-culture-art' => esc_html__('Indigenous Culture / Art','tour-operator'),
						'leisure' => esc_html__('Leisure','tour-operator'),
						'nature-relaxation' => esc_html__('Nature Relaxation','tour-operator'),
						'shopping' => esc_html__('Shopping','tour-operator'),
						'sports' => esc_html__('Sports','tour-operator'),
						'star-gazing' => esc_html__('Star Gazing','tour-operator'),
						'watersports' => esc_html__('Watersports','tour-operator'),
						'wildlife' => esc_html__('Wildlife','tour-operator'),
						'wine' => esc_html__('Wine','tour-operator')
					)
				),
		);
		$fields = array_merge($fields,$fast_facts_fields);

		$fields[] = array( 'id' => 'gallery_title',  'name' => esc_html__('Gallery','tour-operator'), 'type' => 'title' );
		$fields[] = array( 'id' => 'gallery', 'name' => esc_html__('Gallery','tour-operator'), 'type' => 'image', 'repeatable' => true, 'show_size' => false );
		if(class_exists('Envira_Gallery')){
			$fields[] = array( 'id' => 'envira_title',  'name' => esc_html__('Envira Gallery','tour-operator'), 'type' => 'title' );
			$fields[] = array( 'id' => 'envira_gallery', 'name' => esc_html__('Envira Gallery','to-galleries'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ) , 'allow_none' => true );
			if(class_exists('Envira_Videos')){
				$fields[] = array( 'id' => 'envira_video', 'name' => esc_html__('Envira Video Gallery','to-galleries'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ) , 'allow_none' => true );
			}			
		}		
		
		//Rooms
		$fields[] = array( 'id' => 'units_title',  'name' => esc_html__('Units','tour-operator'), 'type' => 'title' );
		$fields[] = array(
				'id' => 'units',
				'name' => '',
				'type' => 'group',
				'repeatable' => true,
				'sortable' => true,
				'fields' => array(
								array(
										'id' => 'type',
										'name' => esc_html__('Type','tour-operator'),
										'type' => 'select',
										'options' => $this->unit_types
								),						
								array( 'id' => 'title',  'name' => esc_html__('Title','tour-operator'), 'type' => 'text' ),
								array( 'id' => 'description', 'name' => esc_html__('Description','tour-operator'), 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) ),
								array( 'id' => 'price',  'name' => esc_html__('Price','tour-operator'), 'type' => 'text' ),
								array( 'id' => 'gallery', 'name' => esc_html__('Gallery','tour-operator'), 'type' => 'image', 'repeatable' => true, 'show_size' => false ),
							),
				'desc' => ''
		);
		
		//Connections
		$fields[] = array( 'id' => 'destinations_title',  'name' => esc_html__('Destinations','tour-operator'), 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'destination_to_accommodation', 'name' => esc_html__('Destinations related with this accommodation','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true,  'allow_none'=>true, 'cols' => 12 );
		$fields[] = array( 'id' => 'tours_title',  'name' => esc_html__('Tours','tour-operator'), 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'tour_to_accommodation', 'name' => esc_html__('Tours related with this accommodation','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'tour','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true,  'allow_none'=>true, 'cols' => 12 );
		
		//Allow the addons to add additional fields.
		$fields = apply_filters('lsx_to_accommodation_custom_fields',$fields);
	
		//Register the actual metabox
		$meta_boxes[] = array(
				'title' => esc_html__('Tour Operator Plugin','tour-operator'),
				'pages' => 'accommodation',
				'fields' => $fields
		);		
		
		return $meta_boxes;
	
	}

	/**
	 * Adds the accommodation specific options
	 */
	public function general_settings() {
		?>
			<tr class="form-field">
				<th scope="row">
					<label for="contact_details_disabled"><?php esc_html_e('Disable "Contact Details" panel','tour-operator'); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if contact_details_disabled}} checked="checked" {{/if}} name="contact_details_disabled" />
				</td>
			</tr>	
		<?php
	}

	/**
	 * Adds the accommodation single specific options
	 */
	public function single_settings() {
		?>
			<tr class="form-field">
				<th scope="row">
					<label for="display_connected_tours"><?php esc_html_e('Display Connected Tours','tour-operator'); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if display_connected_tours}} checked="checked" {{/if}} name="display_connected_tours" />
					<small><?php esc_html_e('This will replace the related accommodation with the connected tours instead.','tour-operator'); ?>
				</td>
			</tr>	
		<?php
	}	

	/**
	 * Returns thedisplay connected tours boolean
	 */
	public function display_connected_tours() {
		return $this->display_connected_tours;
	}
	
	/**
	 * A filter to set the content area to a small column on single
	 */
	function entry_class( $classes ) {
		global $post;
		if(is_main_query() && is_singular($this->plugin_slug)){
			if ( lsx_to_has_enquiry_contact() ) {
				$classes[] = 'col-sm-9';
			}else{
				$classes[] = 'col-sm-12';
			}
		}
		return $classes;
	}

	/**
	 * Adds in additional info for the price custom field
	 */
	public function price_filter($html='',$meta_key=false,$value=false,$before="",$after=""){
		if(get_post_type() === 'accommodation' && 'price' === $meta_key){
			$price_type = get_post_meta(get_the_ID(),'price_type',true);
			$value = preg_replace("/[^0-9,.]/", "", $value);
			$value = ltrim($value, '.');
			$value = str_replace(',','',$value);
			$value = number_format((int) $value,2);
			$tour_operator = tour_operator();
			$currency = '';
			if ( is_object( $tour_operator ) && isset( $tour_operator->options['general'] ) && is_array( $tour_operator->options['general'] ) ) {
				if ( isset( $tour_operator->options['general']['currency'] ) && ! empty( $tour_operator->options['general']['currency'] ) ) {
					$currency = $tour_operator->options['general']['currency'];
					$currency = '<span class="currency-icon '. mb_strtolower( $currency ) .'">'. $currency .'</span>';
				}
			}
			switch($price_type){

				case 'per_person_per_night':
				case 'per_person_sharing':
				case 'per_person_sharing_per_night':
					$value = $currency.$value.' '.ucwords(str_replace('_',' ',$price_type));
				break;

				case 'total_percentage':
					$value .= '% '.esc_html__('Off','tour-operator');
					$before = str_replace(esc_html__('From price','tour-operator'), '', $before);
				break;

				case 'none':
				default:
					$value = $currency.$value;
				break;
			}
			$html = $before.$value.$after;

		}
		return $html;
	}

	/**
	 * Filter and make the star ratings
	 */
	public function rating($html='',$meta_key=false,$value=false,$before="",$after=""){
		if(get_post_type() === 'accommodation' && 'rating' === $meta_key){
			$ratings_array = false;
			$counter = 5;
			while($counter > 0){
				if($value >= 0){
					$ratings_array[] = '<i class="fa fa-star"></i>';
				}else{
					$ratings_array[] = '<i class="fa fa-star-o"></i>';
				}
				$counter--;
				$value--;
			}
			$rating_type = get_post_meta(get_the_ID(),'rating_type',true);
			$rating_description = '';
			if(false !== $rating_type && '' !== $rating_type && esc_html__('Unspecified','tour-operator') !== $rating_type){
				$rating_description = ' <small>('.$rating_type.')</small>';
			}
			$html = $before.implode('',$ratings_array).$rating_description.$after;

		}
		return $html;
	}

	/**
	 * Adds our navigation links to the accommodation single post
	 *
	 * @param $page_links array
	 * @return $page_links array
	 */
	public function page_links($page_links){
		if(is_singular('accommodation')){
			$this->page_links = $page_links;
			$this->get_unit_page_links();
			$this->get_facility_link();
			$this->get_map_link();
			$this->get_gallery_link();
			$this->get_videos_link();
			$this->get_related_tours_link();
			$page_links = $this->page_links;
		}
		return $page_links;
	}

	/**
	 * Tests for the Unit links and adds them to the $page_links variable
	 */
	public function get_unit_page_links()	{
		$links = false;
		if(lsx_to_accommodation_has_rooms()) {
			$return = false;
			foreach($this->unit_types as $type_key => $type_label){
				if(lsx_to_accommodation_check_type($type_key)){
					$this->page_links[$type_key.'s'] = esc_html__(lsx_to_get_post_type_section_title('accommodation', $type_key.'s', $type_label.'s'),'tour-operator');
				}
			}
		}
	}

	/**
	 * Tests for the Facilities and returns a link for the section
	 */
	public function get_facility_link(){
		$facilities = wp_get_object_terms(get_the_ID(),'facility');
		if ( ! empty( $facilities ) && ! is_wp_error( $facilities ) ) {
			$this->page_links['facilities'] = esc_html__('Facilities','tour-operator');
		}
	}

	/**
	 * Tests for the Google Map and returns a link for the section
	 */
	public function get_map_link(){
		if(function_exists('lsx_to_has_map') && lsx_to_has_map()){
			$this->page_links['accommodation-map'] = esc_html__('Map','tour-operator');
		}
	}

	/**
	 * Tests for the Gallery and returns a link for the section
	 */
	public function get_gallery_link(){
		if(function_exists('lsx_to_gallery')) {
			$gallery_ids = get_post_meta(get_the_ID(),'gallery',false);
			$envira_gallery = get_post_meta(get_the_ID(),'envira_gallery',true);

			if((false !== $gallery_ids && '' !== $gallery_ids && is_array($gallery_ids) && !empty($gallery_ids))
			 || (false !== $envira_gallery && '' !== $envira_gallery)){
			 	$this->page_links['gallery'] = esc_html__('Gallery','tour-operator');
			 	return;
			}
		}elseif(class_exists('envira_gallery')) {
			$envira_gallery = get_post_meta(get_the_ID(),'envira_gallery',true);
			if(false !== $envira_gallery && '' !== $envira_gallery && false === lsx_to_enable_envira_banner()){
				$this->page_links['gallery'] = esc_html__('Gallery','tour-operator');
			 	return;
			}
		}
	}

	/**
	 * Tests for the Videos and returns a link for the section
	 */
	public function get_videos_link(){
		$videos_id = false;
		if(class_exists('Envira_Videos')){
			$videos_id = get_post_meta(get_the_ID(),'envira_video',true);
		}
		if((false === $videos_id || '' === $videos_id) && class_exists('LSX_TO_Videos')) {
			$videos_id = get_post_meta(get_the_ID(),'videos',true);
		}
		if(false !== $videos_id && '' !== $videos_id){
			$this->page_links['videos'] = esc_html__('Videos','tour-operator');
		}
	}

	/**
	 * Tests for the Related Tours and returns a link for the section
	 */
	public function get_related_tours_link(){
		$connected_tours = get_post_meta(get_the_ID(),'tour_to_accommodation',false);
		if(post_type_exists('tour') && is_array($connected_tours) && !empty($connected_tours) ) {
			$this->page_links['related-items'] = esc_html__('Tours','tour-operator');
		}
	}
}
$lsx_to_accommodation = LSX_TO_Accommodation::get_instance();