<?php
/**
 * Backend actions for the Tour Operator Plugin
 *
 * @package   LSX_TO_Admin
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package LSX_TO_Admin
 * @author  LightSpeed
 */
class LSX_TO_Admin extends Tour_Operator {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->options = get_option('_lsx-to_settings',false);
		$this->set_vars();

		add_action('init',array($this,'init'));
		add_action( 'admin_menu', array($this,'register_menu_pages') );
		add_action( 'custom_menu_order', array($this,'reorder_menu_pages') );
		add_action( 'admin_head', array( $this, 'select_submenu_pages' ) );

		add_action( 'init', array( $this, 'global_taxonomies') );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ) );
		add_action( 'cmb_save_custom', array( $this, 'post_relations' ), 3 , 20 );

		add_filter( 'plugin_action_links_' . plugin_basename(LSX_TO_CORE), array($this,'add_action_links'));

		add_action( 'default_hidden_meta_boxes', array($this,'default_hidden_meta_boxes'), 10, 2 );
		add_filter('upload_mimes', array($this,'allow_svgimg_types'));
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function init() {
		if(is_admin()){
			$this->connections = $this->create_post_connections();
			$this->single_fields = apply_filters('lsx_to_search_fields',array());

			$this->taxonomies = apply_filters('lsx_to_taxonomies',$this->taxonomies);
			add_filter('lsx_to_taxonomy_widget_taxonomies', array( $this, 'widget_taxonomies' ),10,1 );

			if(!class_exists('LSX_Banners') && false !== $this->taxonomies){
				add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
				add_action( 'edit_term',   array( $this, 'save_meta' ), 10, 2 );
				foreach(array_keys($this->taxonomies) as $taxonomy){
					add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_thumbnail_form_field' ),3,1 );
					add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_tagline_form_field' ),3,1 );
				}
			}

			add_filter( 'type_url_form_media', array( $this, 'change_attachment_field_button' ), 20, 1 );
		}
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_admin_stylescripts( $hook ) {
		$screen = get_current_screen();

		if ( ! is_object( $screen ) ) {
			return;
		}

		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			$min = '';
		} else {
			$min = '.min';
		}

		// TO Pages: Add-ons, Help, Settings and Welcome
		// WP Terms: create/edit term
		if ( 0 !== strpos( $hook, 'tour-operator_page' ) && 'term.php' !== $hook ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script( 'tour-operator-admin-script', LSX_TO_URL . 'assets/js/admin' . $min . '.js', array( 'jquery' ), LSX_TO_VER, true );
		wp_enqueue_style( 'tour-operator-admin-style', LSX_TO_URL . 'assets/css/admin.css', array(), LSX_TO_VER );
		wp_style_add_data( 'tour-operator-admin-style', 'rtl', 'replace' );

	}

	/**
	 * Register a custom menu page.
	 */
	function register_menu_pages(){
		$icon_64 = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDIwIDIwO2ZpbGw6IzgyODc4YzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnIGlkPSJYTUxJRF8xMV8iPjxwYXRoIGlkPSJYTUxJRF8xOF8iIGQ9Ik0xMCwwQzQuNSwwLDAsNC41LDAsMTBzNC41LDEwLDEwLDEwczEwLTQuNSwxMC0xMFMxNS41LDAsMTAsMHogTTEwLDE4LjNjLTQuNiwwLTguMy0zLjctOC4zLTguM2MwLTQuNiwzLjctOC4zLDguMy04LjNjNC42LDAsOC4zLDMuNyw4LjMsOC4zQzE4LjMsMTQuNiwxNC42LDE4LjMsMTAsMTguM3oiLz48cGF0aCBpZD0iWE1MSURfMTlfIiBkPSJNMTAuOCw4LjlMMTAuOCw4LjlMMTAuOCw4LjljLTAuMS0wLjEtMC4yLTAuMS0wLjMtMC4yTDYuMSw2LjFsMi43LDQuNWMwLDAuMSwwLjEsMC4xLDAuMSwwLjJsMCwwbDAsMGMwLjIsMC4zLDAuNiwwLjYsMS4xLDAuNmMwLjgsMCwxLjQtMC42LDEuNC0xLjRDMTEuNCw5LjYsMTEuMiw5LjIsMTAuOCw4Ljl6IE0xMCwxMC43Yy0wLjQsMC0wLjctMC4zLTAuNy0wLjdjMC0wLjQsMC4zLTAuNywwLjctMC43czAuNywwLjMsMC43LDAuN0MxMC43LDEwLjQsMTAuNCwxMC43LDEwLDEwLjd6Ii8+PGcgaWQ9IlhNTElEXzE2XyI+PHJlY3QgaWQ9IlhNTElEXzhfIiB4PSI5LjciIHk9IjIuOSIgd2lkdGg9IjAuNiIgaGVpZ2h0PSIxLjMiLz48cmVjdCBpZD0iWE1MSURfN18iIHg9IjUuMSIgeT0iNC44IiB0cmFuc2Zvcm09Im1hdHJpeCgwLjcwNzEgLTAuNzA3MSAwLjcwNzEgMC43MDcxIC0yLjI1OTQgNS40MTg2KSIgd2lkdGg9IjAuNiIgaGVpZ2h0PSIxLjMiLz48cmVjdCBpZD0iWE1MSURfNl8iIHg9IjEzLjkiIHk9IjUuMSIgdHJhbnNmb3JtPSJtYXRyaXgoMC43MDcxIC0wLjcwNzEgMC43MDcxIDAuNzA3MSAwLjQxNjkgMTEuODc5NykiIHdpZHRoPSIxLjMiIGhlaWdodD0iMC42Ii8+PHJlY3QgaWQ9IlhNTElEXzVfIiB4PSIyLjkiIHk9IjkuNyIgd2lkdGg9IjEuMyIgaGVpZ2h0PSIwLjYiLz48cmVjdCBpZD0iWE1MSURfNF8iIHg9IjE1LjgiIHk9IjkuNyIgd2lkdGg9IjEuMyIgaGVpZ2h0PSIwLjYiLz48cmVjdCBpZD0iWE1MSURfM18iIHg9IjQuOCIgeT0iMTQuMyIgdHJhbnNmb3JtPSJtYXRyaXgoMC43MDcxIC0wLjcwNzEgMC43MDcxIDAuNzA3MSAtOC43MjE0IDguMDk1MikiIHdpZHRoPSIxLjMiIGhlaWdodD0iMC42Ii8+PHJlY3QgaWQ9IlhNTElEXzJfIiB4PSIxNC4yIiB5PSIxMy45IiB0cmFuc2Zvcm09Im1hdHJpeCgwLjcwNzEgLTAuNzA3MSAwLjcwNzEgMC43MDcxIC02LjA0NTEgMTQuNTU2MykiIHdpZHRoPSIwLjYiIGhlaWdodD0iMS4zIi8+PHJlY3QgaWQ9IlhNTElEXzFfIiB4PSI5LjciIHk9IjE1LjgiIHdpZHRoPSIwLjYiIGhlaWdodD0iMS4zIi8+PC9nPjxwYXRoIGlkPSJYTUxJRF80N18iIGQ9Ik0xMS4zLDkuNWMwLTAuMS0wLjEtMC4xLTAuMS0wLjJsMCwwbDAsMGMtMC4yLTAuMy0wLjYtMC42LTEuMS0wLjZjLTAuOCwwLTEuNCwwLjYtMS40LDEuNGMwLDAuNCwwLjIsMC44LDAuNSwxLjFsMCwwbDAsMGMwLjEsMC4xLDAuMiwwLjEsMC4zLDAuMmw0LjQsMi42TDExLjMsOS41eiBNMTAsMTAuN2MtMC40LDAtMC43LTAuMy0wLjctMC43YzAtMC40LDAuMy0wLjcsMC43LTAuN3MwLjcsMC4zLDAuNywwLjdDMTAuNywxMC40LDEwLjQsMTAuNywxMCwxMC43eiIvPjwvZz48L3N2Zz4=';

		add_menu_page(
			esc_html__( 'Dashboard', 'tour-operator' ),
			esc_html__( 'Tour Operator', 'tour-operator' ),
			'edit_posts',
			'tour-operator',
			array($this,'menu_dashboard'),
			$icon_64,
			6
		);

		foreach($this->post_types_singular as $type_key => $type_label){
			if ( in_array( $type_key , array( 'destination', 'tour', 'accommodation' ) ) ) {
				add_submenu_page('tour-operator', esc_html__('Add '.$type_label,'tour-operator'), esc_html__('Add '.$type_label,'tour-operator'), 'edit_posts', 'post-new.php?post_type='.$type_key);
			}
		}
		foreach($this->taxonomies_plural as $tax_key => $tax_label_plural){
			add_submenu_page('tour-operator', esc_html__($tax_label_plural,'tour-operator'), esc_html__($tax_label_plural,'tour-operator'), 'edit_posts', 'edit-tags.php?taxonomy='.$tax_key);
		}

		add_submenu_page('tour-operator', esc_html__('Help','tour-operator'), esc_html__('Help','tour-operator'), 'manage_options', 'to-help', array($this,'help_page'));
		add_submenu_page('tour-operator', esc_html__('Add-ons','tour-operator'), esc_html__('Add-ons','tour-operator'), 'manage_options', 'to-addons', array($this,'addons_page'));
	}

	/**
	 * Reorder custom menu pages.
	 *
	 * - [10] Destinations
	 * - [+1] Add Destination
	 * - [20] Tours
	 * - [+1] Add Tour
	 * - [22] Travel Styles
	 * - [30] Accommodation
	 * - [+1] Add Accommodation
	 * - [32] Accommodation Types
	 * - [33] Brands
	 * - [35] Facilities
	 * - [40] Team
	 * - [50] Activities
	 * - [60] Reviews
	 * - [70] Specials
	 * - [72] Special Types
	 * - [80] Vehicles
	 * - [90] Settings
	 * - [91] Help
	 * - [92] Add-ons
	 */
	function reorder_menu_pages() {
		global $submenu;
		$new_submenu = array();

		foreach ( $submenu as $page => $items ) {
			if ( 'tour-operator' === $page ) {
				foreach ( $items as $key => $item ) {
					$item_page = $item[2];

					// ***** All {post_type} *****

					$page = 'edit.php';

					if ( substr( $item_page, 0, strlen( $page ) ) === $page ) {
						$type_key = str_replace( 'edit.php?post_type=', '', $item_page );
						$type_obj = get_post_type_object( $type_key );

						if ( is_object( $type_obj ) ) {
							$menu_position = $type_obj->menu_position;

							if ( is_numeric( $menu_position ) ) {
								$new_submenu[ $menu_position ] = $item;
							}
						}

						continue;
					}

					// ***** Add {post_type} *****

					$page = 'post-new.php';

					if ( substr( $item_page, 0, strlen( $page ) ) === $page ) {
						$type_key = str_replace( 'post-new.php?post_type=', '', $item_page );
						$type_obj = get_post_type_object( $type_key );

						if ( is_object( $type_obj ) ) {
							$menu_position = $type_obj->menu_position + 1;

							if ( is_numeric( $menu_position ) ) {
								$new_submenu[ $menu_position ] = $item;
							}
						}

						continue;
					}

					// ***** Static pages *****

					$static_pages = array(
						90 => 'lsx-to-settings',
						91 => 'to-help',
						92 => 'to-addons',
					);

					$static_pages_found = false;

					foreach ( $static_pages as $menu_position => $page ) {
						if ( $page === $item_page ) {
							$new_submenu[ $menu_position ] = $item;
							$static_pages_found = true;
							break;
						}
					}

					if ( $static_pages_found ) {
						continue;
					}

					// ***** Taxonomies *****

					// @TODO - make $taxonomies_pages dynamic
					$taxonomies_pages = array(
						22  => 'edit-tags.php?taxonomy=travel-style',
						32  => 'edit-tags.php?taxonomy=accommodation-type',
						33  => 'edit-tags.php?taxonomy=accommodation-brand',
						35  => 'edit-tags.php?taxonomy=facility',
						72  => 'edit-tags.php?taxonomy=special-type',
						41  => 'edit-tags.php?taxonomy=role',
					);

					$taxonomies_pages_found = false;

					foreach ( $taxonomies_pages as $menu_position => $page ) {
						if ( $page === $item_page ) {
							$new_submenu[ $menu_position ] = $item;
							$taxonomies_pages_found = true;
							break;
						}
					}

					if ( $taxonomies_pages_found ) {
						continue;
					}

					// ***** With no menu order set (send to final positions) *****

					$new_submenu[ $key + 1000 ] = $item;
				}
			}
		}

		ksort( $new_submenu );
		$submenu[ 'tour-operator' ] = $new_submenu;
	}

	/**
	 * Keep TO main menu item active for all subitems
	 */
	function select_submenu_pages() {
		global $parent_file, $submenu_file;

		// @TODO - make $taxonomies_pages dynamic
		$taxonomies_pages = array(
			'edit-tags.php?taxonomy=travel-style',
			'edit-tags.php?taxonomy=accommodation-type',
			'edit-tags.php?taxonomy=accommodation-brand',
			'edit-tags.php?taxonomy=facility',
			'edit-tags.php?taxonomy=special-type',
			'edit-tags.php?taxonomy=role',
		);

		if ( in_array( $submenu_file, $taxonomies_pages ) ) {
			$parent_file = 'tour-operator';
		}
	}

	/**
	 * Display a custom menu page
	 */
	function menu_dashboard(){
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Dashboard', 'tour-operator' ); ?></h1>
		</div>
		<?php
	}

	/**
	 * Display the addons page
	 */
	function addons_page(){
		include(LSX_TO_PATH.'includes/settings/add-ons.php');
	}

	/**
	 * Display the help page
	 */
	function help_page(){
		include(LSX_TO_PATH.'includes/settings/help.php');
	}

	/**
	 * Display the licenses page
	 */
	function licenses_page(){
		include(LSX_TO_PATH.'includes/settings/licenses.php');
	}

	/**
	 * Register the global post types.
	 *
	 *
	 * @return    null
	 */
	public function global_taxonomies() {

		$labels = array(
			'name' => esc_html__( 'Travel Styles', 'tour-operator' ),
			'singular_name' => esc_html__( 'Travel Style', 'tour-operator' ),
			'search_items' =>  esc_html__( 'Search Travel Styles' , 'tour-operator' ),
			'all_items' => esc_html__( 'Travel Styles' , 'tour-operator' ),
			'parent_item' => esc_html__( 'Parent Travel Style' , 'tour-operator' ),
			'parent_item_colon' => esc_html__( 'Parent Travel Style:' , 'tour-operator' ),
			'edit_item' => esc_html__( 'Edit Travel Style' , 'tour-operator' ),
			'update_item' => esc_html__( 'Update Travel Style' , 'tour-operator' ),
			'add_new_item' => esc_html__( 'Add New Travel Style' , 'tour-operator' ),
			'new_item_name' => esc_html__( 'New Travel Style' , 'tour-operator' ),
			'menu_name' => esc_html__( 'Travel Styles' , 'tour-operator' ),
		);

		// Now register the taxonomy
		register_taxonomy('travel-style',array('accommodation','tour','destination','review','vehicle','special'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'public' => true,
			'exclude_from_search' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('travel-style'),
		));

		$labels = array(
			'name' => esc_html__( 'Brands', 'tour-operator' ),
			'singular_name' => esc_html__( 'Brand', 'tour-operator' ),
			'search_items' =>  esc_html__( 'Search Brands' , 'tour-operator' ),
			'all_items' => esc_html__( 'Brands' , 'tour-operator' ),
			'parent_item' => esc_html__( 'Parent Brand' , 'tour-operator' ),
			'parent_item_colon' => esc_html__( 'Parent Brand:' , 'tour-operator' ),
			'edit_item' => esc_html__( 'Edit Brand' , 'tour-operator' ),
			'update_item' => esc_html__( 'Update Brand' , 'tour-operator' ),
			'add_new_item' => esc_html__( 'Add New Brand' , 'tour-operator' ),
			'new_item_name' => esc_html__( 'New Brand' , 'tour-operator' ),
			'menu_name' => esc_html__( 'Brands' , 'tour-operator' ),
		);


		// Now register the taxonomy
		register_taxonomy('accommodation-brand',array('accommodation'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'public' => true,
			'exclude_from_search' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug'=>'brand'),
		));
	}

	/**
	 * Sets up the "post relations"
	 *
	 * @return    object
	 */
	public function post_relations($post_id, $field, $value) {

		if('group' === $field['type'] && isset($this->single_fields) && array_key_exists($field['id'], $this->single_fields)){

			$delete_counter = array();
			foreach($this->single_fields[$field['id']] as $fields_to_save){
				$delete_counter[$fields_to_save] = 0;
			}

			//Loop through each group in case of repeatable fields
			$relations = false;
			$previous_relations = false;

			foreach($value as $group){

				//loop through each of the fields in the group that need to be saved and grab their values.
				foreach($this->single_fields[$field['id']] as $fields_to_save){

					//Check if its an empty group
					if(isset($group[$fields_to_save]) && !empty($group[$fields_to_save])){;
						if($delete_counter[$fields_to_save]<1){
							//If this is a relation field, then we need to save the previous relations to remove any items if need be.
							if(in_array($fields_to_save,$this->connections)){
								$previous_relations[$fields_to_save] = get_post_meta($post_id,$fields_to_save,false);
							}
							delete_post_meta( $post_id, $fields_to_save );
							$delete_counter[$fields_to_save]++;
						}

						//Run through each group
						foreach($group[$fields_to_save] as $field_value){

							if(null !== $field_value){

								if(1 === $field_value){
									$field_value = true;
								}
								add_post_meta($post_id,$fields_to_save,$field_value);

								//If its a related connection the save that
								if(in_array($fields_to_save,$this->connections)){
									$relations[$fields_to_save][$field_value] = $field_value;
								}
							}
						}
					}
				}// end of the inner foreach

			}//end of the repeatable group foreach

			//If we have relations, loop through them and save the meta
			if(false!==$relations){
				foreach($relations as $relation_key => $relation_values){
					$temp_field = array('id'=>$relation_key);
					$this->save_related_post($post_id, $temp_field, $relation_values,$previous_relations[$relation_key]);
				}
			}

		}else{
			if(in_array($field['id'],$this->connections)){
				$this->save_related_post($post_id, $field, $value);
			}
		}
	}

	/**
	 * Save the reverse post relation.
	 *
	 *
	 * @return    null
	 */
	public function save_related_post($post_id, $field, $value,$previous_values=false) {
		$ids = explode('_to_',$field['id']);

		$relation = $ids[1].'_to_'.$ids[0];

		if(in_array($relation,$this->connections)){

			if(false===$previous_values){
				$previous_values = get_post_meta($post_id,$field['id'],false);
			}

			if(false !== $previous_values && !empty($previous_values)){
				foreach($previous_values as $tr){
					delete_post_meta( $tr, $relation, $post_id );
				}
			}

			if(is_array($value)){
				foreach($value as $v){
					if('' !== $v && null !== $v && false !== $v){
						add_post_meta($v,$relation,$post_id);
					}
				}
			}
		}
	}

	/**
	 * Adds in the "settings" link for the plugins.php page
	 */
	public function add_action_links ( $links ) {
		$mylinks = array(
			'<a href="' . admin_url( 'admin.php?page=lsx-to-settings' ) . '">'.esc_html__('Settings','tour-operator').'</a>',
			'<a href="https://www.lsdev.biz/documentation/tour-operator-plugin/" target="_blank">'.esc_html__('Documentation','tour-operator').'</a>',
			'<a href="https://www.lsdev.biz/contact-us/" target="_blank">'.esc_html__('Support','tour-operator').'</a>',
		);
		return array_merge( $links, $mylinks );
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function widget_taxonomies($taxonomies) {
		if(false !== $this->taxonomies){
			$taxonomies = array_merge($taxonomies,$this->taxonomies);
		}
		return $taxonomies;
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_thumbnail_form_field($term = false) {

		if(is_object($term)){
			$value = get_term_meta( $term->term_id, 'thumbnail', true );
			$image_preview = wp_get_attachment_image_src($value,'thumbnail');
			if(is_array($image_preview)){
				$image_preview = '<img src="'.$image_preview[0].'" width="'.$image_preview[1].'" height="'.$image_preview[2].'" class="alignnone size-thumbnail wp-image-'.$value.'" />';
			}
		}else{
			$image_preview = false;
			$value = false;
		}
		?>
		<tr class="form-field form-required term-thumbnail-wrap">
			<th scope="row"><label for="thumbnail"><?php esc_html_e('Featured Image','tour-operator');?></label></th>
			<td>
				<input class="input_image_id" type="hidden" name="thumbnail" value="<?php echo wp_kses_post($value); ?>">
				<div class="thumbnail-preview">
					<?php echo wp_kses_post($image_preview); ?>
				</div>
				<a style="<?php if('' !== $value && false !== $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e('Choose Image','tour-operator');?></a>
				<a style="<?php if('' === $value || false === $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-remove"><?php esc_html_e('Remove Image','tour-operator');?></a>
				<?php wp_nonce_field( 'lsx_to_save_term_thumbnail', 'lsx_to_term_thumbnail_nonce' ); ?>
			</td>
		</tr>
		<?php
	}
	/**
	 * Saves the Taxnomy term banner image
	 *
	 * @since 0.1.0
	 *
	 * @param  int     $term_id
	 * @param  string  $taxonomy
	 */
	public function save_meta( $term_id = 0, $taxonomy = '' ) {

		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['thumbnail'] ) || ! isset( $_POST['tagline'] ) ) {
			return;
		}

		if(check_admin_referer( 'lsx_to_save_term_thumbnail', 'lsx_to_term_thumbnail_nonce' )){
			if ( ! isset( $_POST['thumbnail'] ) ) {
				return;
			}
			$thumbnail_meta = sanitize_text_field(wp_unslash($_POST[ 'thumbnail' ]));
			$thumbnail_meta = ! empty( $thumbnail_meta ) ? $thumbnail_meta	: '';
			if ( empty( $thumbnail_meta ) ) {
				delete_term_meta( $term_id, 'thumbnail' );
			} else {
				update_term_meta( $term_id, 'thumbnail', $thumbnail_meta );
			}
		}

		if(check_admin_referer( 'lsx_to_save_term_tagline', 'lsx_to_term_tagline_nonce' )){
			if ( ! isset( $_POST['tagline'] ) ) {
				return;
			}
			$meta = sanitize_text_field(wp_unslash($_POST[ 'tagline' ]));
			$meta = ! empty( $meta ) ? $meta : '';
			if ( empty( $meta ) ) {
				delete_term_meta( $term_id, 'tagline' );
			} else {
				update_term_meta( $term_id, 'tagline', $meta );
			}
		}
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_tagline_form_field($term = false) {
		if(is_object($term)){
			$value = get_term_meta( $term->term_id, 'tagline', true );
		}else{
			$value = false;
		}
		?>
		<tr class="form-field form-required term-tagline-wrap">
			<th scope="row"><label for="tagline"><?php esc_html_e('Tagline','tour-operator');?></label></th>
			<td>
				<input name="tagline" id="tagline" type="text" value="<?php echo wp_kses_post($value); ?>" size="40" aria-required="true">
			</td>

			<?php wp_nonce_field( 'lsx_to_save_term_tagline', 'lsx_to_term_tagline_nonce' ); ?>
		</tr>
		<?php
	}

	/**
	 * Change the "Insert into Post" button text when media modal is used for feature images
	 */
	public function change_attachment_field_button( $html ) {
		if ( isset( $_GET['feature_image_text_button'] ) ) {
			$html = str_replace( 'value="Insert into Post"', sprintf( 'value="%s"', esc_html__( 'Select featured image', 'tour-operator' ) ), $html );
		}

		return $html;
	}

	/**
	 * Allow SVG files for upload
	 */
	public 	function allow_svgimg_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['kml'] = 'image/kml+xml';
		return $mimes;
	}

	/**
	 * Hide a few of the meta boxes by default
	 */
	public function default_hidden_meta_boxes( $hidden, $screen ) {

		$post_type = $screen->post_type;

		if ( in_array($post_type,$this->post_types) ) {
			$hidden = array(
				'authordiv',
				'revisionsdiv',
				'slugdiv',
				'sharing_meta'
			);
			return $hidden;
		}
		return $hidden;
	}
}
