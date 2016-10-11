<?php
/**
 * Module Template.
 *
 * @package   Lsx_Team
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package Lsx_Tours
 * @author  LightSpeed
 */
class Lsx_Team {

	/**
	 * The slug for this plugin
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'team';

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object|Module_Template
	 */
	protected static $instance = null;

	/**
	 * Holds the option screen prefix
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function __construct() {
		$this->options = get_option('_to_lsx-settings',false);
		if(false !== $this->options && isset($this->options[$this->plugin_slug]) && !empty($this->options[$this->plugin_slug])){
			$this->options = $this->options[$this->plugin_slug];
		}
		else{
			$this->options = false;
		}
		
		// activate property post type
		add_action( 'init', array( $this, 'register_post_types' ) );		
		add_filter( 'cmb_meta_boxes', array( $this, 'register_metaboxes') );

		add_action( 'to_framework_team_tab_general_settings_bottom', array($this,'general_settings'), 10 , 1 );
		
		add_filter( 'to_entry_class', array( $this, 'entry_class') );
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
		    'name'               => _x( 'Team', 'tour-operator' ),
		    'singular_name'      => _x( 'Team Member', 'tour-operator' ),
		    'add_new'            => _x( 'Add New', 'tour-operator' ),
		    'add_new_item'       => _x( 'Add New Team Member', 'tour-operator' ),
		    'edit_item'          => _x( 'Edit', 'tour-operator' ),
		    'new_item'           => _x( 'New', 'tour-operator' ),
		    'all_items'          => _x( 'Team Members', 'tour-operator' ),
		    'view_item'          => _x( 'View', 'tour-operator' ),
		    'search_items'       => _x( 'Search the Team', 'tour-operator' ),
		    'not_found'          => _x( 'No team members found', 'tour-operator' ),
		    'not_found_in_trash' => _x( 'No team members found in Trash', 'tour-operator' ),
		    'parent_item_colon'  => '',
		    'menu_name'          => _x( 'Team', 'tour-operator' ),
			'featured_image'	=> _x( 'Profile Picture', 'tour-operator' ),
			'set_featured_image'	=> _x( 'Set Profile Picture', 'tour-operator' ),
			'remove_featured_image'	=> _x( 'Remove profile picture', 'tour-operator' ),
			'use_featured_image'	=> _x( 'Use as profile picture', 'tour-operator' ),								
		);

		$args = array(
            'menu_icon'          =>'dashicons-id-alt',
		    'labels'             => $labels,
		    'public'             => true,
		    'publicly_queryable' => true,
		    'show_ui'            => true,
		    'show_in_menu'       => true,
		    'query_var'          => true,
		    'rewrite'            => array('slug'=>'team'),
		    'capability_type'    => 'page',
		    'has_archive'        => 'team',
		    'hierarchical'       => false,
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' )
		);

		register_post_type( 'team', $args );	
		
	}
	
	
	function register_metaboxes( array $meta_boxes ) {
		
		$fields[] = array( 'id' => 'general_title',  'name' => 'General', 'type' => 'title' );
		$fields[] = array( 'id' => 'featured',  'name' => 'Featured', 'type' => 'checkbox' );
		if(!class_exists('TO_Banners')){
			$fields[] = array( 'id' => 'tagline',  'name' => 'Tagline', 'type' => 'text' );
		}
		$fields[] = array( 'id' => 'role', 'name' => 'Role', 'type' => 'text' );
		$fields[] = array( 'id' => 'contact_title',  'name' => 'Contact', 'type' => 'title' );
		$fields[] = array( 'id' => 'contact_email', 'name' => 'Email', 'type' => 'text' );
		$fields[] = array( 'id' => 'contact_number', 'name' => 'Number (international format)', 'type' => 'text' );
		$fields[] = array( 'id' => 'skype', 'name' => 'Skype', 'type' => 'text' );
		$fields[] = array( 'id' => 'social_title',  'name' => 'Social Profiles', 'type' => 'title' );
		$fields[] = array( 'id' => 'facebook', 'name' => 'Facebook', 'type' => 'text' );
		$fields[] = array( 'id' => 'twitter', 'name' => 'Twitter', 'type' => 'text' );
		$fields[] = array( 'id' => 'googleplus', 'name' => 'Google Plus', 'type' => 'text' );
		$fields[] = array( 'id' => 'linkedin', 'name' => 'LinkedIn', 'type' => 'text' );
		$fields[] = array( 'id' => 'pinterest', 'name' => 'Pinterest', 'type' => 'text' );
		$fields[] = array( 'id' => 'gallery_title',  'name' => 'Gallery', 'type' => 'title' );

		if(class_exists('Envira_Gallery')){ 
			$fields[] = array( 'id' => 'envira_to_team', 'name' => 'Gallery from  Envira Gallery plugin', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'envira','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true );
		}else{
			$fields[] = array( 'id' => 'gallery', 'name' => 'Gallery images', 'type' => 'image', 'repeatable' => true, 'show_size' => false );
		}
		
		if(class_exists('TO_Field_Pattern')){ $fields = array_merge($fields,TO_Field_Pattern::videos()); }		
	
		/*$fields[] = array( 'id' => 'accommodation_title',  'name' => 'Accommodation', 'type' => 'title' );
		$fields[] = array( 'id' => 'accommodation_to_team', 'name' => 'Accommodation', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'accommodation','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true );
		$fields[] = array( 'id' => 'activity_title',  'name' => 'Activities', 'type' => 'title' );
		$fields[] = array( 'id' => 'activity_to_team', 'name' => 'Activity', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'activity','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true );
		$fields[] = array( 'id' => 'destinations_title',  'name' => 'Destinations', 'type' => 'title' );
		$fields[] = array( 'id' => 'destination_to_team', 'name' => 'Destinations', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'destination','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true );
		$fields[] = array( 'id' => 'review_title',  'name' => 'Reviews', 'type' => 'title' );
		$fields[] = array( 'id' => 'review_to_team', 'name' => 'Reviews', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'review','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true );
		$fields[] = array( 'id' => 'specials_title',  'name' => 'Specials', 'type' => 'title' );
		$fields[] = array( 'id' => 'special_to_team', 'name' => 'Specials', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'special','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true );
		$fields[] = array( 'id' => 'tours_title',  'name' => 'Tours', 'type' => 'title' );
		$fields[] = array( 'id' => 'tour_to_team', 'name' => 'Tours', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'tour','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true );
		$fields[] = array( 'id' => 'vehicle_title',  'name' => 'Vehicles', 'type' => 'title' );
		$fields[] = array( 'id' => 'vehicle_to_team', 'name' => 'Vehicles', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'post_type' => 'vehicles','nopagin' => true,'posts_per_page' => 1000, 'orderby' => 'title', 'order' => 'ASC' ), 'repeatable' => true, 'sortable' => true, 'allow_none'=>true );*/
		
		$meta_boxes[] = array(
				'title' => 'LSX Tour Operators',
				'pages' => 'team',
				'fields' => $fields
		);		
		
		return $meta_boxes;
	
	}

	/**
	 * Adds the team specific options
	 */
	public function general_settings() {
		?>
			<?php
				$experts = get_posts(
					array(
						'post_type' => 'team',
						'posts_per_page' => -1,
						'orderby' => 'menu_order',
						'order' => 'ASC',
					)
				);
			?>
			<tr class="form-field">
				<th scope="row" colspan="2"><label><h3>Extra</h3></label></th>
			</tr>
			<tr class="form-field-wrap">
				<th scope="row">
					<label> Select your consultants</label>
				</th>
				<td>
					<?php foreach ( $experts as $expert ) : ?>
						<label for="expert-<?php echo esc_attr( $expert->ID ); ?>"><input type="checkbox" {{#if expert-<?php echo esc_attr( $expert->ID ); ?>}} checked="checked" {{/if}} name="expert-<?php echo esc_attr( $expert->ID ); ?>" id="expert-<?php echo esc_attr( $expert->ID ); ?>" value="<?php echo esc_attr( $expert->ID ); ?>" /> <?php echo esc_html( $expert->post_title ); ?></label><br>
					<?php endforeach ?>
				</td>
			</tr>	
		<?php
	}	
	
	/**
	 * A filter to set the content area to a small column on single
	 */
	public function entry_class( $classes ) {
		global $to_archive;
		if(1 !== $to_archive){$to_archive = false;}
		if(is_main_query() && is_singular($this->plugin_slug) && false === $to_archive){
			$classes[] = 'col-sm-9';
		}
		return $classes;
	}	
}
$to_team = Lsx_Team::get_instance();