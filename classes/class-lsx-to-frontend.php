<?php
/**
 * Frontend actions for the LSX TO Plugin
 *
 * @package   LSX_TO_Frontend
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package LSX_TO_Frontend
 * @author  LightSpeed
 */
class LSX_TO_Frontend extends LSX_Tour_Operators {

	/**
	 * This holds the class OBJ of LSX_Template_Redirects
	 */
	public $redirects = false;	

	/**
	 * Enable Modals
	 *
	 * @since 1.0.0
	 *
	 * @var      boolean|LSX_TO_Frontend
	 */
	public $enable_modals = false;

	/**
	 * Holds the modal ids for output in the footer
	 *
	 * @since 1.0.0
	 *
	 * @var      array|LSX_TO_Frontend
	 */
	public $modal_ids = array();

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->options = get_option('_lsx_lsx-settings',false);	
		$this->set_vars();

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylescripts' ) );	
		add_action( 'wp_head', array( $this,'wp_head') , 10 );
		add_filter( 'body_class', array( $this, 'body_class') );
		add_action('lsx_header_after',array( $this, 'header_after'));

		if(!is_admin()){
			add_filter( 'pre_get_posts', array( $this,'taxonomy_pre_get_posts') , 10, 1 );
			add_action( 'pre_get_posts', array( $this,'team_pre_get_posts') , 10, 1 );
		}	

		add_filter( 'lsx_connected_list_item', array( $this,'add_modal_attributes') , 10, 3 );
		add_action( 'wp_footer', array( $this,'output_modals') , 10 );		

		if(!class_exists('LSX_Template_Redirects')){
			require_once( LSX_TOUR_OPERATORS_PATH . 'classes/class-template-redirects.php' );
		}
		$this->redirects = new LSX_Template_Redirects(LSX_TOUR_OPERATORS_PATH,array_keys($this->post_types),array_keys($this->taxonomies));
	}	

	/**
	 * Initate some boolean flags
	 */
	public function wp_head() {
		if(is_singular($this->active_post_types)
			&& false !== $this->options
			&& isset($this->options[get_post_type()]['enable_modals'])
			&& 'on' === $this->options[get_post_type()]['enable_modals']){
				$this->enable_modals = true;				
		}

		if(is_post_type_archive($this->active_post_types)){
			add_action('lsx_content_wrap_before','lsx_tour_operator_archive_header',100);
			add_action('lsx_content_wrap_before','lsx_tour_operator_archive_description',100);
			add_filter('lsx_tour_operator_archive_description',array($this,'get_post_type_archive_description'),1,3);
		}

		if(false !== $this->taxonomies && is_tax(array_keys($this->taxonomies))){
			add_action('lsx_content_wrap_before','lsx_tour_operator_archive_header',100);
			add_action('lsx_content_wrap_before','lsx_tour_operator_archive_description',100);
		}
		
		if(is_singular($this->active_post_types)){
			add_action('lsx_content_wrap_before','lsx_tour_operator_single_header',100);
		}
		
		if(class_exists('Lsx_Banners')){
			remove_action('lsx_content_top', 'lsx_breadcrumbs',100);
			add_action('lsx_banner_container_top', 'lsx_breadcrumbs');
		}		
	}

	/**
	 * This runs on the lsx_header_after action
	 */
	public function header_after() {
		if(class_exists('Lsx_Banners') && lsx_has_banner()){
			remove_action('lsx_content_wrap_before','lsx_tour_operator_archive_header',100);
			remove_action('lsx_content_wrap_before','lsx_tour_operator_single_header',100);
			add_action('lsx_banner_content','lsx_tour_operator_banner_content');
			add_filter('lsx_tour_operator_tagline',array($this,'get_tagline'),1,3);
		}
	}		

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function add_modal_attributes($html,$post_id,$link) {
		if(true === $this->enable_modals && true === $link){
			$html = '<a data-toggle="modal" data-target="#lsx-modal-'.$post_id.'" href="#">'.get_the_title($post_id).'</a>';
			if(!in_array($post_id,$this->modal_ids)){
				$this->modal_ids[] = $post_id;
			}
		}	
		return $html;
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function output_modals() {
		global $lsx_archive,$post;
		if(true === $this->enable_modals && !empty($this->modal_ids)){
			$temp = $lsx_archive;
			$lsx_archive = 1;
			foreach($this->modal_ids as $post_id){
			$post = get_post($post_id);
			?>	
				<div class="lsx-modal modal fade" id="lsx-modal-<?php echo $post_id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo get_the_title($post_id); ?>">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-body">
				      	<button type="button" class="close" data-dismiss="modal" aria-label="<?php _e('Close','lsx-tour-operators'); ?>"><span aria-hidden="true">×</span></button>
				        <?php lsx_tour_operator_content( 'content', 'modal' ); ?>
				      </div>
				    </div>
				  </div>
				</div>
			<?php
			}
			$lsx_archive = $temp;
			wp_reset_postdata();
		}
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_stylescripts() {
		wp_enqueue_script( 'lsx-tour-operators-script', LSX_TOUR_OPERATORS_URL . 'assets/js/custom.min.js', array( 'jquery' ) , false, true );
		wp_enqueue_style( 'lsx-tour-operators-style', LSX_TOUR_OPERATORS_URL . 'assets/css/style.css');
		if(defined('WP_SHARING_PLUGIN_URL')){
			wp_enqueue_style( 'sharing', WP_SHARING_PLUGIN_URL.'sharing.css', false, JETPACK__VERSION );
		}
	}

	/**
	 * Set the main query to pull through only the top level destinations.
	 */
	public function taxonomy_pre_get_posts($query) {
		if($query->is_main_query() && $query->is_tax(array('travel-style'))){
			$query->set('post_type',array('tour','accommodation'));
		}	
		return $query;
	}
	
	/**
	 * Set the Team Archive to infinite posts per page
	 */
	public function team_pre_get_posts($query) {
		if($query->is_main_query() && $query->is_post_type_archive(array('team'))){
			$query->set('posts_per_page',-1);
		}	
		return $query;
	}

	/**
	 * Add a some classes so we can style.
	 */
	public function body_class( $classes ) {	
		global $post;
		if(false !== $this->post_types && is_singular(array_keys($this->post_types))){
			$classes[] = 'single-tour-operator';
		}
		elseif(false !== $this->post_types && is_post_type_archive(array_keys($this->post_types))){
			$classes[] = 'archive-tour-operator';
		}
		elseif(false !== $this->taxonomies && is_tax(array_keys($this->taxonomies))){
			$classes[] = 'archive-tour-operator';
		}
		elseif(is_search()){
			$classes[] = 'archive-tour-operator';
		}
		return $classes;
	}	
}