<?php
/**
 * Module Template.
 *
 * @package   Lsx_Tour
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package Lsx_Tour
 * @author  LightSpeed
 */
class Lsx_Tour {

	/**
	 * The slug for this plugin
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'tour';

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object|Module_Template
	 */
	protected static $instance = null;
	
	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object|Module_Template
	 */
	public $search_fields = false;	

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function __construct() {
		$this->options = get_option('_lsx_lsx-settings',false);
		if(false !== $this->options && isset($this->options[$this->plugin_slug]) && !empty($this->options[$this->plugin_slug])){
			$this->options = $this->options[$this->plugin_slug];
		}
		else{
			$this->options = false;
		}
		
		// activate property post type
		add_action( 'init', array( $this, 'register_post_types' ) );		
		add_filter( 'cmb_meta_boxes', array( $this, 'metaboxes') );
		
		add_filter( 'to_entry_class', array( $this, 'entry_class') );
		
		add_filter( 'to_search_fields', array( $this, 'single_fields_indexing' ));

		add_action( 'to_framework_tour_tab_general_settings_bottom', array($this,'general_settings'), 10 , 1 );	
		
		add_filter( 'to_itinerary_class', array( $this, 'itinerary_class' ));
		add_filter( 'to_itinerary_needs_read_more', array( $this, 'itinerary_needs_read_more' ));
		
		$this->is_wetu_active = false;
		
		if(!class_exists('LSX_Currency')){
			add_filter('to_custom_field_query',array( $this, 'price_filter'),5,10);
		}
		add_filter('to_custom_field_query',array( $this, 'rating'),5,10);

		add_action('to_modal_meta',array($this, 'content_meta'));		
		
		include('class-itinerary.php');
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
	 * Register the landing pages post type.
	 *
	 *
	 * @return    null
	 */
	public function register_post_types() {
	
		$labels = array(
		    'name'               => _x( 'Tours', 'tour-operator' ),
		    'singular_name'      => _x( 'Tour', 'tour-operator' ),
		    'add_new'            => _x( 'Add New', 'tour-operator' ),
		    'add_new_item'       => _x( 'Add New Tour', 'tour-operator' ),
		    'edit_item'          => _x( 'Edit Tour', 'tour-operator' ),
		    'new_item'           => _x( 'New Tour', 'tour-operator' ),
		    'all_items'          => _x( 'All Tours', 'tour-operator' ),
		    'view_item'          => _x( 'View Tour', 'tour-operator' ),
		    'search_items'       => _x( 'Search Tours', 'tour-operator' ),
		    'not_found'          => _x( 'No tours found', 'tour-operator' ),
		    'not_found_in_trash' => _x( 'No tours found in Trash', 'tour-operator' ),
		    'parent_item_colon'  => '',
		    'menu_name'          => _x( 'Tours', 'tour-operator' )
		);

		$args = array(
            'menu_icon'          =>'dashicons-admin-site',
		    'labels'             => $labels,
		    'public'             => true,
		    'publicly_queryable' => true,
		    'show_ui'            => true,
		    'show_in_menu'       => 'tour-operator',
		    'query_var'          => true,
		    'rewrite'            => array( 'slug' => 'tour' ),
		    'capability_type'    => 'post',
		    'has_archive'        => 'tours',
		    'hierarchical'       => false,
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' )
		);

		register_post_type( 'tour', $args );		
	}	

	/**
	 * Remove the sharing from below the content on single accommodation.
	 */
	public static function remove_jetpack_sharing() {
		remove_filter( 'the_excerpt', 'sharing_display',19 );
		if ( class_exists( 'Jetpack_Likes' ) ) {
			remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		}
		remove_filter( 'the_content', 'sharing_display',19 );
		if ( class_exists( 'Jetpack_Likes' ) ) {
			remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		}
	}	
	
	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	public function metaboxes( array $meta_boxes ) {
	
		// Example of all available fields
		$fields[] = array( 'id' => 'featured',  'name' => _x( 'Featured', 'tour-operator' ), 'type' => 'checkbox', 'cols' => 12 );
		if(!class_exists('LSX_Banners')){
			$fields[] = array( 'id' => 'tagline',  'name' => 'Tagline', 'type' => 'text' );
		}
		$fields[] = array( 'id' => 'duration',  	'name' => _x( 'Duration', 'tour-operator' ), 'type' => 'text', 'cols' => 12 );
		$fields[] = array( 'id' => 'departs_from', 'name' => 'Departs From', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ),'allow_none'=>true, 'cols' => 12,'sortable'=>true,'repeatable'=>true );
		$fields[] = array( 'id' => 'ends_in', 'name' => 'Ends In', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ),'allow_none'=>true, 'cols' => 12,'sortable'=>true,'repeatable'=>true );
		$fields[] = array( 
					'id' => 'best_time_to_visit',
					'name' => _x( 'Best months to visit', 'tour-operator' ),
					'type' => 'select',
					'options' => array(
									'january' => 'January',
									'february' => 'February',
									'march' => 'March',
									'april' => 'April',
									'may' => 'May',
									'june' => 'June',
									'july' => 'July',
									'august' => 'August',
									'september' => 'September',
									'october' => 'October',
									'november' => 'November',
									'december' => 'December'
								),
					'multiple' => true,
					'cols' => 12
				);
		
		if(post_type_exists('team')){
			$fields[] = array( 'id' => 'team_to_tour', 'name' => 'Tour Expert', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'team','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'allow_none'=>true, 'cols' => 12);
		}
		$fields[] = array( 'id' => 'hightlights',  'name' => 'Hightlights', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'cols' => 12 );

		if(class_exists('Envira_Gallery')){
			if(!class_exists('TO_Galleries')){
				$new_fields[] = array( 'id' => 'gallery_title',  'name' => __('Gallery','tour-operator'), 'type' => 'title' );
			}
			$fields[] = array( 'id' => 'envira_gallery', 'name' => __('Envira Gallery','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ) , 'allow_none' => true );
		}

		$fields[] = array( 'id' => 'price_title',  'name' => __('Price','tour-operator'), 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'price',  'name' => __('Price','tour-operator'), 'type' => 'text', 'cols' => 6 );
		$fields[] = array( 'id' => 'single_supplement',  'name' => __('Single Supplement','tour-operator'), 'type' => 'text', 'cols' => 12 );
		$fields[] = array( 'id' => 'included',  'name' => 'Included', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'cols' => 12 );
		$fields[] = array( 'id' => 'not_included',  'name' => 'Not Included', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'cols' => 12 );
		
		if(post_type_exists('special')){
			$fields[] = array( 'id' => 'special_to_tour', 'name' => 'Specials related with this tour', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'special','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'allow_none' => true , 'repeatable' => true, 'sortable' => true, 'cols' => 12 );
		}
		
		//Connections
		if(post_type_exists('review')){
			$fields[] = array( 'id' => 'review_title',  'name' => 'Reviews', 'type' => 'title', 'cols' => 12);
			$fields[] = array( 'id' => 'review_to_tour', 'name' => 'Reviews related with this tour', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'review','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		if(post_type_exists('vehicle')){
			$fields[] = array( 'id' => 'vehicle_title',  'name' => 'Vehicles', 'type' => 'title', 'cols' => 12 );
			$fields[] = array( 'id' => 'vehicle_to_tour', 'name' => 'Vehicles related with this tour', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'vehicle','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true, 'cols' => 12 );
		}
		
		//Itinerary Details
		$fields[] = array( 'id' => 'itinerary_title',  'name' => 'Itinerary', 'type' => 'title' );
		$fields[] = array( 'id' => 'itinerary_kml', 'name' => _x( 'Itinerary KML File', 'tour-operator' ), 'type' => 'file', 'show_size' => true, 'cols' => 12 );
		$fields[] = array(
				'id' => 'itinerary',
				'name' => '',
				'single_name' => 'Day(s)',
				'type' => 'group',
				'repeatable' => true,
				'sortable' => true,
				'fields' => $this->itinerary_fields(),
				'desc' => ''
		);		

		$fields = apply_filters('to_tour_custom_fields',$fields);
		
		$meta_boxes[] = array(
				'title' => __('LSX Tour Operators','tour-operator'),
				'pages' => 'tour',
				'fields' => $fields
		);	
	
		return $meta_boxes;
	
	}

	/**
	 * Adds the tour specific options
	 */
	public function general_settings() {
		?>
			<tr class="form-field">
				<th scope="row">
					<label for="description">Compress Itineraries</label>
				</th>
				<td>
					<input type="checkbox" {{#if shorten_itinerary}} checked="checked" {{/if}} name="shorten_itinerary" />
					<small>If you have many Itinerary entries on your tours, then you may want to shorten the length of the page with a "read more" button.</small>
				</td>
			</tr>		
		<?php
	}	
	
	/**
	 * Sets up the "post relations"
	 *
	 * @since 1.0.0
	 *
	 * @return    object|Module_Template    A single instance of this class.
	 */
	public function single_fields_indexing($search_fields) {
		$search_fields['itinerary'] = array('destination_to_tour','activity_to_tour','accommodation_to_tour');
		return $search_fields;
		
	}	
	
	/**
	 * A filter to set the content area to a small column on single
	 */
	public function entry_class( $classes ) {
		global $to_archive;
		if(1 !== $to_archive){$to_archive = false;}
		if(is_main_query() && is_singular($this->plugin_slug) && false === $to_archive){
			if(function_exists('to_has_team_member') && to_has_team_member()){
				$classes[] = 'col-sm-9';
			}else{
				$classes[] = 'col-sm-12';
			}
		}
		return $classes;
	}
	
	/**
	 * returns the room metabox fields
	 */
	public function room_fields() {
		
	}
	
	/**
	 * returns the itinerary metabox fields
	 */
	public function itinerary_fields() {
		$fields = array();
		$fields[] = array( 'id' => 'title',  'name' => 'Title', 'type' => 'text' );
		if(!class_exists('LSX_Banners')){
			$fields[] = array( 'id' => 'banner_subtitle',  'name' => 'Tagline', 'type' => 'text' );
		}

		$fields[] = array( 'id' => 'description', 'name' => 'Description', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ) );
		$fields[] = array( 'id' => 'featured_image', 'name' => 'Featured Image', 'type' => 'image', 'show_size' => false );
		if(post_type_exists('accommodation')){
			$fields[] = array( 'id' => 'accommodation_to_tour', 'name' => 'Accommodations related with this itinerary', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'accommodation','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		if(post_type_exists('activity')){
			$fields[] = array( 'id' => 'activity_to_tour', 'name' => 'Activities related with this itinerary', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'activity','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		if(post_type_exists('destination')){
			$fields[] = array( 'id' => 'destination_to_tour', 'name' => 'Destinations related with this itinerary', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		if($this->is_wetu_active){
			$fields[] = array( 'id' => 'included', 'name' => 'Included', 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) );
			$fields[] = array( 'id' => 'excluded', 'name' => 'Excluded', 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) );
			$fields[] = array(
					'id' => 'drinks_basis',
					'name' => 'Drinks Basis',
					'type' => 'select',
					'options' => array(
							'' => 'None',
							'No Drinks' => 'No Drinks',
							'Drinks (local brands)' => 'Drinks (local brands)',
							'Drinks (excl spirits)' => 'Drinks (excl spirits)',
							'All Drinks' => 'All Drinks',
					)
			);
			$fields[] = array(
					'id' => 'meal_basis',
					'name' => 'Meal Basis',
					'type' => 'select',
					'options' => array(
							'' => 'None',
							'Room Only' => 'Room Only',
							'Self Catering' => 'Self Catering',
							'Half Board' => 'Half Board',
							'Bed & Breakfast' => 'Bed & Breakfast',
							'Dinner, Bed and Breakfast' => 'Dinner, Bed and Breakfast',
							'Dinner, Bed, Breakfast and Lunch' => 'Dinner, Bed, Breakfast and Lunch',
							'Dinner, Bed, Breakfast, Lunch and Activites' => 'Dinner, Bed, Breakfast, Lunch and Activites',
							'Bed, All Meals, Most Drinks (local), Fees, Activites' => 'Bed, All Meals, Most Drinks (local), Fees, Activites',
					)
			);
		}
		
		return $fields;
	}
	
	/**
	 * returns the itinerary metabox fields
	 */
	public function itinerary_class($classes) {
		global $tour_itinerary;
		if(false !== $this->options && isset($this->options['shorten_itinerary'])){
			if($tour_itinerary->index > 3){
				$classes[] = 'hidden';
			}
		}
		return $classes;	
	}
	
	/**
	 * Outputs the read more button if needed
	 */
	public function itinerary_needs_read_more($return) {
		if(false !== $this->options && isset($this->options['shorten_itinerary'])){
			$return = true;
		}
		return $return;
	}	

	/**
	 * Adds in additional info for the price custom field
	 */
	public function price_filter($html='',$meta_key=false,$value=false,$before="",$after=""){
		if(get_post_type() === 'tour' && 'price' === $meta_key){
			$value = number_format((int) $value);
			global $tour_operator;
			$currency = '';
			if ( is_object( $tour_operator ) && isset( $tour_operator->options['general'] ) && is_array( $tour_operator->options['general'] ) ) {
				if ( isset( $tour_operator->options['general']['currency'] ) && ! empty( $tour_operator->options['general']['currency'] ) ) {
					$currency = $tour_operator->options['general']['currency'];
					$currency = '<span class="currency-icon '. mb_strtolower( $currency ) .'">'. $currency .'</span>';
				}
			}
			$value = $currency.$value;
			$html = $before.$value.$after;
	
		}
		return $html;
	}
	
	/**
	 * Filter and make the star ratings
	 */
	public function rating($html='',$meta_key=false,$value=false,$before="",$after=""){
		if(get_post_type() === 'tour' && 'rating' === $meta_key){
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

	/**
	 * Outputs the tour meta on the modal
	 */
	public function content_meta(){ 
		if('tour' === get_post_type()){
		?>
		<div class="tour-details">
			<div class="meta info"><?php to_price('<span class="price">from ','</span>'); to_duration('<span class="duration">','</span>'); ?></div>
			<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>
			<?php to_connected_destinations('<div class="meta destination">'.__('Destinations','tour-operator').': ','</div>'); ?>				
			<?php to_connected_activities('<div class="meta activities">'.__('Activites','tour-operator').': ','</div>'); ?>				
		</div>
	<?php } }	
	
}
$to_tour = Lsx_Tour::get_instance();