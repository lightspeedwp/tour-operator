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
class TO_Admin extends TO_Tour_Operators {

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
		add_action( 'init', array( $this, 'require_post_type_classes' ) , 1 );
		add_action( 'init', array( $this, 'global_taxonomies') );
		add_filter( 'to_framework_settings_tabs', array( $this, 'settings_page_array') );

		add_action('to_framework_dashboard_tab_content',array($this,'dashboard_tab_content'));

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ) );
		add_action( 'cmb_save_custom', array( $this, 'post_relations' ), 3 , 20 );

		add_filter( 'plugin_action_links_' . plugin_basename(TO_CORE), array($this,'add_action_links'));		
	}	

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->taxonomies = apply_filters('to_taxonomy_admin_taxonomies',$this->taxonomies);
		add_filter('to_taxonomy_widget_taxonomies', array( $this, 'widget_taxonomies' ),10,1 );

		if(false !== $this->taxonomies){
			add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
			add_action( 'edit_term',   array( $this, 'save_meta' ), 10, 2 );
			foreach($this->taxonomies as $taxonomy){
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_thumbnail_form_field' ),3,1 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_tagline_form_field' ),3,1 );				
			}			
		}		
	}		

	/**
	 * outputs the dashboard tabs settings
	 */
	public function dashboard_tab_content() {
		?>
		<?php $this->modal_setting(); ?>

		<?php if(!class_exists('LSX_Currency')) { ?>
			<tr class="form-field-wrap">
				<th scope="row">
					<label for="currency"> Currency</label>
				</th>
				<td>
					<select value="{{currency}}" name="currency">
						<option value="USD" {{#is currency value=""}}selected="selected"{{/is}} {{#is currency value="USD"}} selected="selected"{{/is}}>USD (united states dollar)</option>
						<option value="GBP" {{#is currency value="GBP"}} selected="selected"{{/is}}>GBP (british pound)</option>
						<option value="ZAR" {{#is currency value="ZAR"}} selected="selected"{{/is}}>ZAR (south african rand)</option>
						<option value="NAD" {{#is currency value="NAD"}} selected="selected"{{/is}}>NAD (namibian dollar)</option>
						<option value="CAD" {{#is currency value="CAD"}} selected="selected"{{/is}}>CAD (canadian dollar)</option>
						<option value="EUR" {{#is currency value="EUR"}} selected="selected"{{/is}}>EUR (euro)</option>
						<option value="HKD" {{#is currency value="HKD"}} selected="selected"{{/is}}>HKD (hong kong dollar)</option>
						<option value="SGD" {{#is currency value="SGD"}} selected="selected"{{/is}}>SGD (singapore dollar)</option>
						<option value="NZD" {{#is currency value="NZD"}} selected="selected"{{/is}}>NZD (new zealand dollar)</option>
						<option value="AUD" {{#is currency value="AUD"}} selected="selected"{{/is}}>AUD (australian dollar)</option>
					</select>
				</td>
			</tr>
		<?php } ?>

			<tr class="form-field-wrap">
				<th scope="row">
					<label for="currency"><?php esc_html_e('General Enquiry','tour-operator'); ?></label>
				</th>
				<?php
					if(true === $this->show_default_form()){
						$forms = $this->get_activated_forms(); ?>
						<td>
							<select value="{{enquiry}}" name="enquiry">
							<?php
							if(false !== $forms && '' !== $forms){ ?>
								<option value="" {{#is enquiry value=""}}selected="selected"{{/is}}>Select a form</option>
								<?php
								foreach($forms as $form_id => $form_data){ ?>
									<option value="<?php echo esc_attr( $form_id ); ?>" {{#is enquiry value="<?php echo esc_attr( $form_id ); ?>"}} selected="selected"{{/is}}><?php echo esc_html( $form_data ); ?></option>
								<?php
								}
							}else{ ?>
								<option value="" {{#is enquiry value=""}}selected="selected"{{/is}}>You have no form available</option>
							<?php } ?>
							</select>
						</td>
					<?php }else{ ?>
						<td>
							<textarea class="description enquiry" name="enquiry" rows="10">{{#if enquiry}}{{{enquiry}}}{{/if}}</textarea>
						</td>
					<?php
					}
				?>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="description"><?php esc_html_e('Disable Enquire Modal','tour-operator'); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if disable_enquire_modal}} checked="checked" {{/if}} name="disable_enquire_modal" />
					<small><?php esc_html_e('This disables the enquire modal, and instead redirects to the link you provide below.','tour-operator'); ?></small>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="title"><?php esc_html_e('Enquire Link','tour-operator'); ?></label>
				</th>
				<td>
					<input type="text" {{#if enquire_link}} value="{{enquire_link}}" {{/if}} name="enquire_link" />
				</td>
			</tr>							
		<?php  
	}

	/**
	 * outputs the dashboard tabs settings
	 */
	public function single_settings() { 
		$this->modal_setting();
	}		

	/**
	 * outputs the modal setting field
	 */
	public function modal_setting() { ?>
		<tr class="form-field">
			<th scope="row">
				<label for="description"><?php esc_html_e('Enable Connected Modals','tour-operator'); ?></label>
			</th>
			<td>
				<input type="checkbox" {{#if enable_modals}} checked="checked" {{/if}} name="enable_modals" />
				<small><?php esc_html_e('Any connected item showing on a single will display a preview in a modal.','tour-operator'); ?></small>
			</td>
		</tr>
	<?php
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
	 * Returns the array of settings to the UIX Class in the lsx framework
	 */	
	public function settings_page_array($tabs){
		// This array is for the Admin Pages. each element defines a page that is seen in the admin
		
		$post_types = apply_filters('to_post_types',$this->post_types);
		
		if(false !== $post_types && !empty($post_types)){
			foreach($post_types as $index => $title){

				$disabled = false;
				if(!in_array($index,$this->active_post_types)){
					$disabled = true;
				}

				$tabs[$index] = array(
					'page_title'        => 'General',
					'page_description'  => '',
					'menu_title'        => $title,
					'template'          => apply_filters('to_settings_path',TO_PATH,$index).'includes/settings/'.$index.'.php',
					'default'	 		=> false,
					'disabled'			=> $disabled
				);
			}
			ksort($tabs);
		}
		return $tabs;
	}	

	/**
	 * Requires the post type classes
	 *
	 * @since 0.0.1
	 */
	public function require_post_type_classes() {
		foreach($this->post_types as $post_type => $label){
			require_once( TO_PATH . 'classes/class-'.$post_type.'.php' );	
			add_action('to_framework_'.$post_type.'_tab_single_settings_bottom', array($this,'single_settings'),40);
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
	 * Sets up the "post relations"
	 *
	 * @return    object|Module_Template    A single instance of this class.
	 */
	public function post_relations($post_id, $field, $value) {
		
		if('group' === $field['type'] && array_key_exists($field['id'], $this->single_fields)){
				
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
			<th scope="row"><label for="thumbnail"><?php _e('Featured Image','tour-operator');?></label></th>
			<td>
				<input style="display:none;" name="thumbnail" id="thumbnail" type="text" value="<?php echo $value; ?>" size="40" aria-required="true">
				<div class="thumbnail-preview">
					<?php echo $image_preview; ?>
				</div>				

				<a style="<?php if('' !== $value && false !== $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-add"><?php _e('Choose Image','tour-operator');?></a>				
				<a style="<?php if('' === $value || false === $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-remove"><?php _e('Remove Image','tour-operator');?></a>
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
		$thumbnail_meta = ! empty( $_POST[ 'thumbnail' ] ) ? $_POST[ 'thumbnail' ]	: '';
		if ( empty( $thumbnail_meta ) ) {
			delete_term_meta( $term_id, 'thumbnail' );
		} else {
			update_term_meta( $term_id, 'thumbnail', $thumbnail_meta );
		}
		
		$meta = ! empty( $_POST[ 'tagline' ] ) ? $_POST[ 'tagline' ] : '';
		if ( empty( $meta ) ) {
			delete_term_meta( $term_id, 'tagline' );
		} else {
			update_term_meta( $term_id, 'tagline', $meta );
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
			<th scope="row"><label for="tagline"><?php _e('Tagline','tour-operator');?></label></th>
			<td>
				<input name="tagline" id="tagline" type="text" value="<?php echo $value; ?>" size="40" aria-required="true">
			</td>
		</tr>
		<?php
	}					
}