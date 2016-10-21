<?php
/**
 * Properties.
 *
 * @package   TO_Accommodation
 * @author     LightSpeed Team
 * @license   GPL3
 * @link      
 * @copyright 2015  LightSpeed Team
 */


/**
 * Plugin class.
 * @package TO_Accommodation
 * @author   LightSpeed Team
 */
class TO_Accommodation {

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
	 * @var      object|TO_Accommodation
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
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 */
	private function __construct() {
		$this->is_wetu_active = false;
		$this->display_connected_tours = false;

		$this->options = get_option('_lsx_lsx-settings',false);
		if(false !== $this->options && isset($this->options[$this->plugin_slug]) && !empty($this->options[$this->plugin_slug])){
			$this->options = $this->options[$this->plugin_slug];
		}
		else{
			$this->options = false;
		}

		// activate property post type
		add_action( 'init', array( $this, 'activate_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies') );
		add_filter( 'cmb_meta_boxes', array( $this, 'metaboxes') );	

		add_action( 'to_framework_accommodation_tab_general_settings_bottom', array($this,'general_settings'), 10 , 1 );
		add_action( 'to_framework_accommodation_tab_single_settings_bottom', array($this,'single_settings'), 10 , 1 );
		
		add_filter( 'to_entry_class', array( $this, 'entry_class') );

		if(!class_exists('LSX_Currency')){
			add_filter('to_custom_field_query',array( $this, 'price_filter'),5,10);
		}

		add_filter('to_custom_field_query',array( $this, 'rating'),5,10);	
		
		include('class-units.php');

		add_action('to_map_meta','to_accommodation_meta');
		add_action('to_modal_meta','to_accommodation_meta');
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 0.0.1
	 *
	 * @return    object|TO_Accommodation    A single instance of this class.
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
				'name' 				=> __('Accommodation', 'tour-operator'),
				'singular_name' 	=> __('Accommodation', 'tour-operator'),
				'add_new' 			=> __('Add New', 'tour-operator'),
				'add_new_item' 		=> __('Add New Accommodation', 'tour-operator'),
				'edit_item' 		=> __('Edit Accommodation', 'tour-operator'),
				'all_items' 		=> __('All Accommodation', 'tour-operator'),
				'view_item' 		=> __('View Accommodation', 'tour-operator'),
				'search_items' 		=> __('Search Accommodation', 'tour-operator'),
				'not_found' 		=> __('No accommodation defined', 'tour-operator'),
				'not_found_in_trash'=> __('No accommodation in trash', 'tour-operator'),
				'parent_item_colon' => '',
				'menu_name' 		=> __('Accommodation', 'tour-operator')
			),
			'public' 				=>	true,
			'publicly_queryable'	=>	true,
			'show_ui' 				=>	true,
			'show_in_menu' 			=>	'tour-operator',
			'query_var' 			=>	true,
			'rewrite' 				=>	array('slug' => 'accommodation','with_front'=>false),		
			'exclude_from_search' 	=>	false,
			'capability_type' 		=>	'post',
			'has_archive' 			=>	'accommodation',
			'hierarchical' 			=>	false,
			'menu_position' 		=>	null,
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
				'name' => _x( 'Facilities', 'tour-operator' ),
				'singular_name' => _x( 'Facility', 'tour-operator' ),
				'search_items' =>  __( 'Search Facilities' , 'tour-operator' ),
				'all_items' => __( 'Facilities' , 'tour-operator' ),
				'parent_item' => __( 'Parent' , 'tour-operator' ),
				'parent_item_colon' => __( 'Parent:' , 'tour-operator' ),
				'edit_item' => __( 'Edit Facility' , 'tour-operator' ),
				'update_item' => __( 'Update Facility' , 'tour-operator' ),
				'add_new_item' => __( 'Add New Facility' , 'tour-operator' ),
				'new_item_name' => __( 'New Facility' , 'tour-operator' ),
				'menu_name' => __( 'Facilities' , 'tour-operator' ),
		);
		
		// Now register the taxonomy
		register_taxonomy('facility',$this->plugin_slug, array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'public' => true,
				'show_in_nav_menus' => false,
				'show_tagcloud' => false,
				'exclude_from_search' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => false,
		));
		
		$labels = array(
				'name' => _x( 'Accommodation Type', 'tour-operator' ),
				'singular_name' => _x( 'Accommodation Type', 'tour-operator' ),
				'search_items' =>  __( 'Search Accommodation Types' , 'tour-operator' ),
				'all_items' => __( 'Accommodation Types' , 'tour-operator' ),
				'parent_item' => __( 'Parent Accommodation Type' , 'tour-operator' ),
				'parent_item_colon' => __( 'Parent Accommodation Type:' , 'tour-operator' ),
				'edit_item' => __( 'Edit Accommodation Type' , 'tour-operator' ),
				'update_item' => __( 'Update Accommodation Type' , 'tour-operator' ),
				'add_new_item' => __( 'Add New Accommodation Type' , 'tour-operator' ),
				'new_item_name' => __( 'New Accommodation Type' , 'tour-operator' ),
				'menu_name' => __( 'Accommodation Types' , 'tour-operator' ),
		);
		
		// Now register the taxonomy
		register_taxonomy('accommodation-type',$this->plugin_slug, array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'public' => true,
				'show_in_nav_menus' => false,
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
		$fields[] = array( 'id' => 'featured',  'name' => 'Featured', 'type' => 'checkbox' );
		if(!class_exists('LSX_Banners')){
			$fields[] = array( 'id' => 'tagline',  'name' => 'Tagline', 'type' => 'text' );
		}

		if(class_exists('TO_Field_Pattern')){ $fields = array_merge($fields,TO_Field_Pattern::price()); }

		$fields[] = array( 
				'id' => 'price_type',
				'name' => __('Price Type','tour-operator'),
				'type' => 'select',
				'options' => array(
					'none' => 'Select a type',
					'per_person_per_night' => __('Per Person Per Night','tour-operator'),
					'per_person_sharing' => __('Per Person Sharing','tour-operator'),
					'per_person_sharing_per_night' => __('Per Person Sharing Per Night','tour-operator'),
					'total_percentage' => __('Percentage Off Your Price.','tour-operator')
				)
			);

		$fields[] = array( 'id' => 'included',  'name' => 'Included', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ) );
		$fields[] = array( 'id' => 'excluded',  'name' => 'Excluded', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ) );

		$fields[] = array( 'id' => 'team_to_accommodation', 'name' => 'Accommodation Expert', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'team','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'allow_none'=>true, 'cols' => 12 );	
		
		if(class_exists('TO_Maps') && false !== $this->options && isset($this->options['contact_details_disabled'])){
			$fields[] = array( 'id' => 'location_title',  'name' => 'Location', 'type' => 'title' );
			$fields[] = array( 'id' => 'location',  'name' => 'Address', 'type' => 'gmap' );
		}

		// Contact Fields
		if(false === $this->options || !isset($this->options['contact_details_disabled'])){
			$contact_fields = array(
					array( 'id' => 'contact_title',  'name' => 'Contact Details', 'type' => 'title' ),
					array( 'id' => 'name',  'name' => 'Name', 'type' => 'text' ),
					array( 'id' => 'email',  'name' => 'Email', 'type' => 'text' ),
					array( 'id' => 'phone',  'name' => 'Phone', 'type' => 'text' ),
					array( 'id' => 'website',  'name' => 'Website', 'type' => 'text' ),
					array( 'id' => 'location',  'name' => 'Address', 'type' => 'gmap' ),
			);	
			$fields = array_merge($fields,$contact_fields);
		}
		
		//Fast Facts
		$fast_facts_fields = array(
				array( 'id' => 'fast_facts_title',  'name' => 'Fast Facts', 'type' => 'title' ),
				array(
						'id' => 'rating_type',
						'name' => 'Rating Type',
						'type' => 'select',
						'options' => array(
								'Unspecified' => 'Unspecified',
								'TGCSA' => 'TGCSA',
								'Hotelstars Union' => 'Hotelstars Union'
						)
				),				
				array( 'id' => 'rating',  'name' => 'Rating', 'type' => 'radio', 'options' => array( '1', '2', '3', '4', '5' ), 'allow_none' => true ),
				array( 'id' => 'number_of_rooms',  'name' => 'Number of Rooms', 'type' => 'text' ),
				array( 'id' => 'checkin_time',  'name' => 'Check-in Time', 'type' => 'time' ),
				array( 'id' => 'checkout_time',  'name' => 'Check-out Time', 'type' => 'time' ),
				array( 'id' => 'minimum_child_age',  'name' => 'Minimum Child Age', 'type' => 'text' ),
				array( 
					'id' => 'spoken_languages',
					'name' => 'Spoken Languages',
					'type' => 'select',
					'multiple' => true,
					'options' => array( 
							'afrikaans' => 'Afrikaans',
							'chinese' => 'Chinese',
							'dutch' => 'Dutch',
							'english' => 'English',
							'flemish' => 'Flemish',
							'french' => 'French',
							'german' => 'German',
							'indian' => 'Indian',
							'italian' => 'Italian',
							'japanese' => 'Japanese',
							'portuguese' => 'Portuguese',
							'russian' => 'Russian',
							'spanish' => 'Spanish',
							'swahili' => 'Swahili',
							'xhosa' => 'Xhosa',
							'zulu' => 'Zulu'
					)
				),
				array(
						'id' => 'suggested_visitor_types',
						'name' => 'Friendly',
						'type' => 'select',
						'multiple' => true,
						'options' => array(
								'business' => 'Business',
								'children' => 'Children',
								'disability' => 'Disability',
								'leisure' => 'Leisure',
								'luxury' => 'Luxury',
								'pet' => 'Pet',
								'romance' => 'Romance',
								'vegetarian' => 'Vegetarian',
								'weddings' => 'Weddings'
						)
				),	                         				
				array( 
					'id' => 'special_interests',
					'name' => 'Special Interests',
					'type' => 'select',
					'multiple' => true,
					'options' => array(
						'adventure' => 'Adventure',
						'battlefields' => 'Battlefields',
						'beach_coastal' => 'Beach / Coastal',
						'big-5' => 'Big 5',
						'birding' => 'Birding',
						'cycling' => 'Cycling',
						'fishing' => 'Fishing',
						'flora' => 'Flora',
						'golf' => 'Golf',
						'gourmet' => 'Gourmet',
						'hiking' => 'Hiking',
						'history-and-culture' => 'History & Culture',
						'indigenous-culture-art' => 'Indigenous Culture / Art',
						'leisure' => 'Leisure',
						'nature-relaxation' => 'Nature Relaxation',
						'shopping' => 'Shopping',
						'sports' => 'Sports',
						'star-gazing' => 'Star Gazing',
						'watersports' => 'Watersports',
						'wildlife' => 'Wildlife',
						'wine' => 'Wine'
					)
				),
		);
		$fields = array_merge($fields,$fast_facts_fields);

		if(class_exists('Envira_Gallery')){
			if(!class_exists('TO_Galleries')){
				$fields[] = array( 'id' => 'gallery_title',  'name' => __('Gallery','tour-operator'), 'type' => 'title' );
			}			
			$fields[] = array( 'id' => 'envira_gallery', 'name' => __('Envira Gallery','to-galleries'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ) , 'allow_none' => true );
			if(class_exists('Envira_Videos')){
				$fields[] = array( 'id' => 'envira_video', 'name' => __('Envira Video Gallery','to-galleries'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ) , 'allow_none' => true );
			}			
		}		
		
		//Rooms
		$fields[] = array( 'id' => 'units_title',  'name' => __('Units','tour-operator'), 'type' => 'title' );
		$fields[] = array(
				'id' => 'units',
				'name' => '',
				'type' => 'group',
				'repeatable' => true,
				'sortable' => true,
				'fields' => array(
								array(
										'id' => 'type',
										'name' => 'Type',
										'type' => 'select',
										'options' => array(
												'chalet' => 'Chalet',
												'room' => 'Room',
												'spa' => 'Spa',
												'tent' => 'Tent',
												'villa' => 'Villa'
										)
								),						
								array( 'id' => 'title',  'name' => 'Title', 'type' => 'text' ),
								array( 'id' => 'description', 'name' => 'Description', 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) ),
								array( 'id' => 'price',  'name' => 'Price', 'type' => 'text' ),
								array( 'id' => 'gallery', 'name' => 'Gallery', 'type' => 'image', 'repeatable' => true, 'show_size' => false ),
							),
				'desc' => ''
		);
		
		//Connections
		$fields[] = array( 'id' => 'activity_title',  'name' => 'Activities', 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'activity_to_accommodation', 'name' => 'Activities related with this accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'activity','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true,  'allow_none'=>true, 'cols' => 12 );
		$fields[] = array( 'id' => 'destinations_title',  'name' => 'Destinations', 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'destination_to_accommodation', 'name' => 'Destinations related with this accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true,  'allow_none'=>true, 'cols' => 12 );
		$fields[] = array( 'id' => 'review_title',  'name' => 'Reviews', 'type' => 'title', 'cols' => 12);
		$fields[] = array( 'id' => 'review_to_accommodation', 'name' => 'Reviews related with this accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'review','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true,  'allow_none'=>true, 'cols' => 12 );
		$fields[] = array( 'id' => 'specials_title',  'name' => 'Specials', 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'special_to_accommodation', 'name' => 'Specials related with this accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'special','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'allow_none'=>true, 'cols' => 12 );
		$fields[] = array( 'id' => 'tours_title',  'name' => 'Tours', 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'tour_to_accommodation', 'name' => 'Tours related with this accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'tour','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true,  'allow_none'=>true, 'cols' => 12 );
		$fields[] = array( 'id' => 'vehicle_title',  'name' => 'Vehicles', 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'vehicle_to_accommodation', 'name' => 'Vehicles related with this accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'vehicle','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true,  'allow_none'=>true, 'cols' => 12 );
		
		//Allow the addons to add additional fields.
		$fields = apply_filters('to_accommodation_custom_fields',$fields);		
	
		//Register the actual metabox
		$meta_boxes[] = array(
				'title' => __('LSX Tour Operators','tour-operator'),
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
			if(function_exists('to_has_team_member') && to_has_team_member()){
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
			$value = number_format($value);
			global $tour_operator;
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
					$value .= '% '.__('Off','tour-operator');
					$before = str_replace('from', '', $before);
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
			if(false !== $rating_type && '' !== $rating_type && 'Unspecified' !== $rating_type){
				$rating_description = ' <small>('.$rating_type.')</small>';
			}
			$html = $before.implode('',$ratings_array).$rating_description.$after;

		}
		return $html;
	}	
}
$to_accommodation = TO_Accommodation::get_instance();