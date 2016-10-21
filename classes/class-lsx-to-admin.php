<?php
/**
 * Backend actions for the LSX TO Plugin
 *
 * @package   TO_Admin
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package TO_Admin
 * @author  LightSpeed
 */
class TO_Admin extends Tour_Operator {

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

		add_action('init',array($this,'init'));
		add_action( 'admin_menu', array($this,'register_menu_pages') );

		add_action( 'init', array( $this, 'global_taxonomies') );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ) );
		add_action( 'cmb_save_custom', array( $this, 'post_relations' ), 3 , 20 );

		add_filter( 'plugin_action_links_' . plugin_basename(TO_CORE), array($this,'add_action_links'));

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
			$this->single_fields = apply_filters('to_search_fields',array());			
			
			$this->taxonomies = apply_filters('to_taxonomies',$this->taxonomies);
			add_filter('to_taxonomy_widget_taxonomies', array( $this, 'widget_taxonomies' ),10,1 );

			if(false !== $this->taxonomies){
				add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
				add_action( 'edit_term',   array( $this, 'save_meta' ), 10, 2 );
				foreach(array_keys($this->taxonomies) as $taxonomy){
					add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_thumbnail_form_field' ),3,1 );
					add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_tagline_form_field' ),3,1 );				
				}			
			}	
		}	
	}		

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_admin_stylescripts() {
		$screen = get_current_screen();
		if( !is_object( $screen ) ){
			return;
		}
		wp_enqueue_style( 'tour-operator-admin-style', TO_URL . '/assets/css/admin.css');
	}

	/**
	 * Register a custom menu page.
	 */
	function register_menu_pages(){
	    add_menu_page( 
	        __( 'Dashboard', 'tour-operator' ),
	        __( 'Tour Operator', 'tour-operator' ),
	        'edit_posts',
	        'tour-operator',
	        array($this,'menu_dashboard'),
	        null,
	        6
	    );

	    foreach($this->post_types_singular as $type_key => $type_label){
	    	add_submenu_page('tour-operator', esc_html__('Add '.$type_label,'tour-operator'), esc_html__('Add '.$type_label,'tour-operator'), 'edit_posts', 'post-new.php?post_type='.$type_key);
		}
	    foreach($this->taxonomies_plural as $tax_key => $tax_label_plural){
	    	add_submenu_page('tour-operator', esc_html__($tax_label_plural,'tour-operator'), esc_html__($tax_label_plural,'tour-operator'), 'edit_posts', 'edit-tags.php?taxonomy='.$tax_key);
		}

		add_submenu_page('tour-operator', esc_html__('Add-ons','tour-operator'), esc_html__('Add-ons','tour-operator'), 'manage_options', 'to-addons', array($this,'menu_licenses'));
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
	 * Display the licenses
	 */
	function menu_licenses(){
	    ?>
	    <div class="wrap">
	    	<h1><?php esc_html_e( 'Licenses', 'tour-operator' ); ?></h1> 
	    </div>
	    <?php
	}		

	/**
	 * Register the global post types.
	 *
	 *
	 * @return    null
	 */
	public function global_taxonomies() {
			
		$labels = array(
				'name' => _x( 'Travel Styles', 'tour-operator' ),
				'singular_name' => _x( 'Travel Style', 'tour-operator' ),
				'search_items' =>  __( 'Search Travel Styles' , 'tour-operator' ),
				'all_items' => __( 'Travel Styles' , 'tour-operator' ),
				'parent_item' => __( 'Parent Travel Style' , 'tour-operator' ),
				'parent_item_colon' => __( 'Parent Travel Style:' , 'tour-operator' ),
				'edit_item' => __( 'Edit Travel Style' , 'tour-operator' ),
				'update_item' => __( 'Update Travel Style' , 'tour-operator' ),
				'add_new_item' => __( 'Add New Travel Style' , 'tour-operator' ),
				'new_item_name' => __( 'New Travel Style' , 'tour-operator' ),
				'menu_name' => __( 'Travel Styles' , 'tour-operator' ),
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
				'name' => _x( 'Brands', 'tour-operator' ),
				'singular_name' => _x( 'Brand', 'tour-operator' ),
				'search_items' =>  __( 'Search Brands' , 'tour-operator' ),
				'all_items' => __( 'Brands' , 'tour-operator' ),
				'parent_item' => __( 'Parent Brand' , 'tour-operator' ),
				'parent_item_colon' => __( 'Parent Brand:' , 'tour-operator' ),
				'edit_item' => __( 'Edit Brand' , 'tour-operator' ),
				'update_item' => __( 'Update Brand' , 'tour-operator' ),
				'add_new_item' => __( 'Add New Brand' , 'tour-operator' ),
				'new_item_name' => __( 'New Brand' , 'tour-operator' ),
				'menu_name' => __( 'Brands' , 'tour-operator' ),
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

		$labels = array(
				'name' => _x( 'Location', 'tour-operator' ),
				'singular_name' => _x( 'Location', 'tour-operator' ),
				'search_items' =>  __( 'Search Locations' , 'tour-operator' ),
				'all_items' => __( 'Locations' , 'tour-operator' ),
				'parent_item' => __( 'Parent Location' , 'tour-operator' ),
				'parent_item_colon' => __( 'Parent Location:' , 'tour-operator' ),
				'edit_item' => __( 'Edit Location' , 'tour-operator' ),
				'update_item' => __( 'Update Location' , 'tour-operator' ),
				'add_new_item' => __( 'Add New Location' , 'tour-operator' ),
				'new_item_name' => __( 'New Location' , 'tour-operator' ),
				'menu_name' => __( 'Locations' , 'tour-operator' ),
		);
		// Now register the taxonomy
		register_taxonomy('location',array('accommodation'), array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'public' => true,
				'exclude_from_search' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array('slug'=>'location'),
		));			

	}

	/**
	 * Sets up the "post relations"
	 *
	 * @return    object|Module_Template    A single instance of this class.
	 */
	public function post_relations($post_id, $field, $value) {
		
		if('group' === $field['type'] && isset($this->single_fields) && array_key_exists($field['id'], $this->single_fields)){
				
			$delete_counter = array();
			foreach($this->single_fields[$field['id']] as $fields_to_save){
				$delete_counter[$fields_to_save] = 0;
			}
			
			//Loop through each group in case of repeatable fields
			$relations = $previous_relations = false;

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
			
								if(1 === $field_value){ $field_value = true; }
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
		 	'<a href="' . admin_url( 'options-general.php?page=lsx-lsx-settings' ) . '">'.__('Settings',$this->plugin_slug).'</a>',
		 	'<a href="https://www.lsdev.biz/documentation/tour-operator-plugin/" target="_blank">'.__('Documentation',$this->plugin_slug).'</a>',
		 	'<a href="https://feedmysupport.zendesk.com/home" target="_blank">'.__('Support',$this->plugin_slug).'</a>',
		 );
		return array_merge( $links, $mylinks );
	}	

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function widget_taxonomies($taxonomies) {
		if(false !== $this->taxonomies){ $taxonomies = array_merge($taxonomies,$this->taxonomies); }
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
				<input style="display:none;" name="thumbnail" id="thumbnail" type="text" value="<?php echo wp_kses_post($value); ?>" size="40" aria-required="true">
				<div class="thumbnail-preview">
					<?php echo wp_kses_post($image_preview); ?>
				</div>				

				<a style="<?php if('' !== $value && false !== $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e('Choose Image','tour-operator');?></a>				
				<a style="<?php if('' === $value || false === $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-remove"><?php esc_html_e('Remove Image','tour-operator');?></a>

				<?php wp_nonce_field( 'to_save_term_thumbnail', 'to_term_thumbnail_nonce' ); ?>
			</td>
		</tr>
		
		<script type="text/javascript">
			(function( $ ) {
				$( '.lsx-thumbnail-image-add' ).on( 'click', function() {
					tb_show('Choose a Featured Image', 'media-upload.php?type=image&TB_iframe=1');
					var image_thumbnail = '';
					window.send_to_editor = function( html ) 
					{
						var image_thumbnail = $( 'img',html ).html();
						$( '.thumbnail-preview' ).append(html);
						var imgClasses = $( 'img',html ).attr( 'class' );
						imgClasses = imgClasses.split('wp-image-');
						$( '#thumbnail' ).val(imgClasses[1]);
						tb_remove();
					}
					$( this ).hide();
					$( '.lsx-thumbnail-image-remove' ).show();
					
					return false;
				});

				$( '.lsx-thumbnail-image-remove' ).on( 'click', function() {
					$( '.thumbnail-preview' ).html('');
					$( '#thumbnail' ).val('');
					$( this ).hide();
					$( '.lsx-thumbnail-image-add' ).show();					
					return false;
				});	
			})(jQuery);
		</script>		
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

		if(check_admin_referer( 'to_save_term_thumbnail', 'to_term_thumbnail_nonce' )){
			$thumbnail_meta = ! empty( sanitize_text_field(wp_unslash($_POST[ 'thumbnail' ])) ) ? sanitize_text_field(wp_unslash($_POST[ 'thumbnail' ]))	: '';
			if ( empty( $thumbnail_meta ) ) {
				delete_term_meta( $term_id, 'thumbnail' );
			} else {
				update_term_meta( $term_id, 'thumbnail', $thumbnail_meta );
			}
		}
		
		if(check_admin_referer( 'to_save_term_tagline', 'to_term_tagline_nonce' )){
			$meta = ! empty( sanitize_text_field(wp_unslash($_POST[ 'tagline' ])) ) ? sanitize_text_field(wp_unslash($_POST[ 'tagline' ])) : '';
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

			<?php wp_nonce_field( 'to_save_term_tagline', 'to_term_tagline_nonce' ); ?>
		</tr>
		<?php
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