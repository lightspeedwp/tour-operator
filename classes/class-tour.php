<?php
/**
 * Tour Post Type Class
 *
 * @package   LSX_TO_PATHTour
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package LSX_TO_PATHTour
 * @author  LightSpeed
 */
class LSX_TO_PATHTour {

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
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object
	 */
	public $search_fields = false;

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
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function __construct() {
		$this->options = get_option('_to_settings',false);
		if(false !== $this->options && isset($this->options[$this->plugin_slug]) && !empty($this->options[$this->plugin_slug])){
			$this->options = $this->options[$this->plugin_slug];
		}
		else{
			$this->options = false;
		}
		
		// activate property post type
		add_action( 'init', array( $this, 'register_post_types' ) );		
		add_filter( 'cmb_meta_boxes', array( $this, 'metaboxes') );
		
		add_filter( 'lsx_to_entry_class', array( $this, 'entry_class') );
		
		add_filter( 'lsx_to_search_fields', array( $this, 'single_fields_indexing' ));

		add_action( 'lsx_to_framework_tour_tab_general_settings_bottom', array($this,'general_settings'), 10 , 1 );
		
		add_filter( 'lsx_to_itinerary_class', array( $this, 'itinerary_class' ));
		add_filter( 'lsx_to_itinerary_needs_read_more', array( $this, 'itinerary_needs_read_more' ));
		
		$this->is_wetu_active = false;
		
		if(!class_exists('LSX_Currency')){
			add_filter('lsx_to_custom_field_query',array( $this, 'price_filter'),5,10);
		}
		add_filter('lsx_to_custom_field_query',array( $this, 'rating'),5,10);

		add_action('lsx_to_modal_meta',array($this, 'content_meta'));
		
		include('class-itinerary.php');

		add_filter( 'lsx_to_page_navigation', array( $this, 'page_links') );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object    A single instance of this class.
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
		    'name'               => esc_html__( 'Tours', 'tour-operator' ),
		    'singular_name'      => esc_html__( 'Tour', 'tour-operator' ),
		    'add_new'            => esc_html__( 'Add New', 'tour-operator' ),
		    'add_new_item'       => esc_html__( 'Add New Tour', 'tour-operator' ),
		    'edit_item'          => esc_html__( 'Edit Tour', 'tour-operator' ),
		    'new_item'           => esc_html__( 'New Tour', 'tour-operator' ),
		    'all_items'          => esc_html__( 'Tours', 'tour-operator' ),
		    'view_item'          => esc_html__( 'View Tour', 'tour-operator' ),
		    'search_items'       => esc_html__( 'Search Tours', 'tour-operator' ),
		    'not_found'          => esc_html__( 'No tours found', 'tour-operator' ),
		    'not_found_in_trash' => esc_html__( 'No tours found in Trash', 'tour-operator' ),
		    'parent_item_colon'  => '',
		    'menu_name'          => esc_html__( 'Tours', 'tour-operator' )
		);

		$args = array(
            'menu_icon'          =>'dashicons-admin-site',
		    'labels'             => $labels,
		    'public'             => true,
		    'publicly_queryable' => true,
		    'show_ui'            => true,
		    'show_in_menu'       => 'tour-operator',
			'menu_position'      => 20,
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
		$fields[] = array( 'id' => 'featured',  'name' => esc_html__( 'Featured', 'tour-operator' ), 'type' => 'checkbox', 'cols' => 12 );
		if(!class_exists('LSX_Banners')){
			$fields[] = array( 'id' => 'tagline',  'name' => esc_html__('Tagline','tour-operator'), 'type' => 'text' );
		}
		$fields[] = array( 'id' => 'duration',  	'name' => esc_html__( 'Duration', 'tour-operator' ), 'type' => 'text', 'cols' => 12 );
		$fields[] = array( 'id' => 'departs_from', 'name' => esc_html__('Departs From','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ),'allow_none'=>true, 'cols' => 12,'sortable'=>true,'repeatable'=>true );
		$fields[] = array( 'id' => 'ends_in', 'name' => esc_html__('Ends In','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ),'allow_none'=>true, 'cols' => 12,'sortable'=>true,'repeatable'=>true );
		$fields[] = array( 
					'id' => 'best_time_to_visit',
					'name' => esc_html__( 'Best months to visit', 'tour-operator' ),
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
			$fields[] = array( 'id' => 'team_to_tour', 'name' => esc_html__('Tour Expert','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'team','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'allow_none'=>true, 'cols' => 12);
		}
		$fields[] = array( 'id' => 'hightlights',  'name' => esc_html__('Hightlights','tour-operator'), 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'cols' => 12 );

		if(class_exists('Envira_Gallery')){
			if(!class_exists('LSX_TO_PATHGalleries')){
				$fields[] = array( 'id' => 'gallery_title',  'name' => esc_html__('Gallery','tour-operator'), 'type' => 'title' );
			}
			$fields[] = array( 'id' => 'envira_gallery', 'name' => esc_html__('Envira Gallery','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ) , 'allow_none' => true );
			if(class_exists('Envira_Videos')){
				$fields[] = array( 'id' => 'envira_video', 'name' => esc_html__('Envira Video Gallery','to-galleries'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ) , 'allow_none' => true );
			}			
		}

		$fields[] = array( 'id' => 'price_title',  'name' => esc_html__('Price','tour-operator'), 'type' => 'title', 'cols' => 12 );
		$fields[] = array( 'id' => 'price',  'name' => esc_html__('Price','tour-operator'), 'type' => 'text', 'cols' => 6 );
		$fields[] = array( 'id' => 'single_supplement',  'name' => esc_html__('Single Supplement','tour-operator'), 'type' => 'text', 'cols' => 12 );
		$fields[] = array( 'id' => 'included',  'name' => esc_html__('Included','tour-operator'), 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'cols' => 12 );
		$fields[] = array( 'id' => 'not_included',  'name' => esc_html__('Not Included','tour-operator'), 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'cols' => 12 );
		
		if(post_type_exists('special')){
			$fields[] = array( 'id' => 'special_to_tour', 'name' => esc_html__('Specials related with this tour','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'special','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'allow_none' => true , 'repeatable' => true, 'sortable' => true, 'cols' => 12 );
		}
		
		//Connections
		if(post_type_exists('review')){
			$fields[] = array( 'id' => 'review_title',  'name' => esc_html__('Reviews','tour-operator'), 'type' => 'title', 'cols' => 12);
			$fields[] = array( 'id' => 'review_to_tour', 'name' => esc_html__('Reviews related with this tour','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'review','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		
		//Itinerary Details
		$fields[] = array( 'id' => 'itinerary_title',  'name' => esc_html__('Itinerary','tour-operator'), 'type' => 'title' );
		$fields[] = array( 'id' => 'itinerary_kml', 'name' => esc_html__( 'Itinerary KML File', 'tour-operator' ), 'type' => 'file', 'show_size' => true, 'cols' => 12 );
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

		$fields = apply_filters('lsx_to_tour_custom_fields',$fields);
		
		$meta_boxes[] = array(
				'title' => esc_html__('Tour Operator Plugin','tour-operator'),
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
					<label for="description"><?php esc_html_e('Compress Itineraries','tour-operator');?></label>
				</th>
				<td>
					<input type="checkbox" {{#if shorten_itinerary}} checked="checked" {{/if}} name="shorten_itinerary" />
					<small><?php esc_html_e('If you have many Itinerary entries on your tours, then you may want to shorten the length of the page with a "read more" button.','tour-operator');?></small>
				</td>
			</tr>		
		<?php
	}	
	
	/**
	 * Sets up the "post relations"
	 *
	 * @since 1.0.0
	 *
	 * @return    object    A single instance of this class.
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
			if(function_exists('lsx_to_has_team_member') && to_has_team_member()){
				$classes[] = 'col-sm-9';
			}else{
				$classes[] = 'col-sm-12';
			}
		}
		return $classes;
	}
	
	/**
	 * returns the itinerary metabox fields
	 */
	public function itinerary_fields() {
		$fields = array();
		$fields[] = array( 'id' => 'title',  'name' => esc_html__('Title','tour-operator'), 'type' => 'text' );
		if(!class_exists('LSX_Banners')){
			$fields[] = array( 'id' => 'tagline',  'name' => esc_html__('Tagline','tour-operator'), 'type' => 'text' );
		}

		$fields[] = array( 'id' => 'description', 'name' => esc_html__('Description','tour-operator'), 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ) );
		$fields[] = array( 'id' => 'featured_image', 'name' => esc_html__('Featured Image','tour-operator'), 'type' => 'image', 'show_size' => false );
		if(post_type_exists('accommodation')){
			$fields[] = array( 'id' => 'accommodation_to_tour', 'name' => esc_html__('Accommodations related with this itinerary','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'accommodation','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		if(post_type_exists('activity')){
			$fields[] = array( 'id' => 'activity_to_tour', 'name' => esc_html__('Activities related with this itinerary','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'activity','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		if(post_type_exists('destination')){
			$fields[] = array( 'id' => 'destination_to_tour', 'name' => esc_html__('Destinations related with this itinerary','tour-operator'), 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => '-1', 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true,'allow_none'=>true, 'cols' => 12 );
		}
		if($this->is_wetu_active){
			$fields[] = array( 'id' => 'included', 'name' => esc_html__('Included','tour-operator'), 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) );
			$fields[] = array( 'id' => 'not_included', 'name' => esc_html__('Not Included','tour-operator'), 'type' => 'textarea', 'options' => array( 'editor_height' => '100' ) );
			$fields[] = array(
				'id' => 'drinks_basis',
				'name' => esc_html__('Drinks Basis','tour-operator'),
				'type' => 'select',
				'options' => array(
						'' => esc_html__('None','tour-operator'),
						esc_html__('No Drinks','tour-operator') => esc_html__('No Drinks','tour-operator'),
						esc_html__('Drinks (local brands)','tour-operator') => esc_html__('Drinks (local brands)','tour-operator'),
						esc_html__('Drinks (excl spirits)','tour-operator') => esc_html__('Drinks (excl spirits)','tour-operator'),
						esc_html__('All Drinks','tour-operator') => esc_html__('All Drinks','tour-operator'),
				)
			);
			$fields[] = array(
				'id' => 'meal_basis',
				'name' => esc_html__('Meal Basis','tour-operator'),
				'type' => 'select',
				'options' => array(
						'' => esc_html__('None','tour-operator'),
				esc_html__('Room Only','tour-operator') => esc_html__('Room Only','tour-operator'),
				esc_html__('Self Catering','tour-operator') => esc_html__('Self Catering','tour-operator'),
				esc_html__('Half Board','tour-operator') => esc_html__('Half Board','tour-operator'),
				esc_html__('Bed & Breakfast','tour-operator') => esc_html__('Bed & Breakfast','tour-operator'),
				esc_html__('Dinner, Bed and Breakfast','tour-operator') => esc_html__('Dinner, Bed and Breakfast','tour-operator'),
				esc_html__('Dinner, Bed, Breakfast and Lunch','tour-operator') => esc_html__('Dinner, Bed, Breakfast and Lunch','tour-operator'),
				esc_html__('Dinner, Bed, Breakfast, Lunch and Activites','tour-operator') => esc_html__('Dinner, Bed, Breakfast, Lunch and Activites','tour-operator'),
				esc_html__('Bed, All Meals, Most Drinks (local), Fees, Activites','tour-operator') => esc_html__('Bed, All Meals, Most Drinks (local), Fees, Activites','tour-operator'),
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
			$value = preg_replace("/[^0-9,.]/", "", $value);
			$value = ltrim($value, '.');
			$value = str_replace(',','',$value);
			$value = number_format((int) $value,2);
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
			if(false !== $rating_type && '' !== $rating_type && esc_html__('Unspecified','tour-operator') !== $rating_type){
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
			<div class="meta info"><?php to_price('<span class="price">'.esc_html__('from','tour-operator').' ','</span>'); to_duration('<span class="duration">','</span>'); ?></div>
			<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.esc_html__('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>
			<?php to_connected_destinations('<div class="meta destination">'.esc_html__('Destinations','tour-operator').': ','</div>'); ?>
			<?php if(function_exists('lsx_to_connected_activities')){ to_connected_activities('<div class="meta activities">'.esc_html__('Activities','tour-operator').': ','</div>');} ?>
		</div>
	<?php } }

	/**
	 * Adds our navigation links to the accommodation single post
	 *
	 * @param $page_links array
	 * @return $page_links array
	 */
	public function page_links($page_links){
		if(is_singular('tour')){
			$this->page_links = $page_links;
			$this->get_itinerary_link();
			$this->get_include_link();
			$this->get_map_link();

			$this->get_gallery_link();
			$this->get_videos_link();
			$page_links = $this->page_links;
		}
		return $page_links;
	}

	/**
	 * Tests for the Itinerary links and adds it to the $page_links variable
	 */
	public function get_itinerary_link()	{
		if(to_has_itinerary()) {
			$this->page_links['itinerary'] = esc_html__('Itinerary','tour-operator');
		}
	}

	/**
	 * Tests for the Included / Not Included Block $page_links variable
	 */
	public function get_include_link()	{
		$tour_included = to_included('','',false);
		$tour_not_included = to_not_included('','',false);
		if(null !== $tour_included || null !== $tour_not_included) {
			$this->page_links['included-excluded'] = esc_html__('Included / Not Included','tour-operator');
		}
	}

	/**
	 * Tests for the Google Map and returns a link for the section
	 */
	public function get_map_link(){
		if(function_exists('lsx_to_has_map') && to_has_map()){
			$this->page_links['accommodation-map'] = esc_html__('Map','tour-operator');
		}
	}

	/**
	 * Tests for the Gallery and returns a link for the section
	 */
	public function get_gallery_link(){
		$gallery_id = false;
		if(class_exists('Envira_Gallery')){
			$gallery_id = get_post_meta(get_the_ID(),'envira_to_tour',true);
		}
		if((false === $gallery_id || '' === $gallery_id) && class_exists('LSX_TO_PATHGalleries')) {
			$gallery_id = get_post_meta(get_the_ID(),'gallery',true);
		}
		if(false !== $gallery_id && '' !== $gallery_id){
			$this->page_links['gallery'] = esc_html__('Gallery','tour-operator');
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
		if((false === $videos_id || '' === $videos_id) && class_exists('LSX_TO_PATHVideos')) {
			$videos_id = get_post_meta(get_the_ID(),'videos',true);
		}
		if(false !== $videos_id && '' !== $videos_id){
			$this->page_links['videos'] = esc_html__('Videos','tour-operator');
		}
	}

}
$to_tour = LSX_TO_PATHTour::get_instance();