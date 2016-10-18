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
 * @package TO_Settings
 * @author  LightSpeed
 */
class TO_Settings extends TO_Tour_Operators {

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

		add_action( 'init', array( $this, 'create_settings_page'),100 );
		add_action( 'default_hidden_meta_boxes', array($this,'default_hidden_meta_boxes'), 10, 2 );
		add_filter('upload_mimes', array($this,'allow_svgimg_types'));	
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
	 * Returns the array of settings to the UIX Class
	 */
	public function create_settings_page(){
		if(is_admin()){
			if(!class_exists('\lsx\ui\uix')){
				include_once TO_PATH.'vendor/uix/uix.php';
			}
			$pages = $this->settings_page_array();
			$uix = \lsx\ui\uix::get_instance( 'lsx' );
			$uix->register_pages( $pages );

			foreach($this->post_types as $post_type => $label){
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'general_settings' ), 5 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'archive_settings_header' ), 10 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'archive_settings' ), 12 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'single_settings' ), 15 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_bottom', array( $this, 'settings_page_scripts' ), 100 );
			}			
		}
	}

	/**
	 * Returns the array of settings to the UIX Class
	 */
	public function settings_page_array(){
		// This array is for the Admin Pages. each element defines a page that is seen in the admin
	
		$tabs = array( // tabs array are for setting the tab / section templates
				// each array element is a tab with the key as the slug that will be the saved object property
				'general'		=> array(
						'page_title'        => '',
						'page_description'  => '',
						'menu_title'        => 'General',
						'template'          => TO_PATH.'includes/settings/general.php',
						'default'	 		=> true
				)
		);

		$posts_page = get_option('page_for_posts',false);
		if(false === $posts_page){
			$tabs['post'] = array(
				'page_title'        => 'Posts',
				'page_description'  => '',
				'menu_title'        => 'Posts',
				'template'          => TO_PATH.'includes/settings/post.php',
				'default'	 		=> false
			);
		}
	
		$additional_tabs = false;
		$additional_tabs = apply_filters('to_framework_settings_tabs',$additional_tabs);
		if(false !== $additional_tabs && is_array($additional_tabs) && !empty($additional_tabs)){
			$tabs = array_merge($tabs,$additional_tabs);
		}
	
		return array(
				'lsx-settings'  => array(                                                         // this is the settings array. The key is the page slug
						'page_title'  =>  'LSX Settings',                                                  // title of the page
						'menu_title'  =>  'LSX Settings',                                                  // title seen on the menu link
						'capability'  =>  'manage_options',                                              // required capability to access page
						'icon'        =>  'dashicons-book-alt',                                          // Icon or image to be used on admin menu
						'parent'      =>  'options-general.php',                                         // Position priority on admin menu)
						'save_button' =>  'Save Changes',                                                // If the page required saving settings, Set the text here.
						'tabs'        =>  $tabs,
						/*'help'	=> array(	// the wordpress contextual help is also included
								// key is the help slug
								'default-help' => array(
										'title'		=> 	esc_html__( 'Easy to add Help' , 'uix' ),
										'content'	=>	"Just add more items to this array with a unique slug/key."
								),
								'more-help' => array(
										'title'		=> 	esc_html__( 'Makes things Easy' , 'uix' ),
										'content'	=>	"the content can also be a file path to a template"
								)
						),*/
				),
		);
	}
	/**
	 * Adds in the settings neccesary for the archives
	 */
	public function general_settings($post_type=false){ 
		do_action('to_framework_'.$post_type.'_tab_general_settings_top',$post_type);
		?>
		<tr class="form-field-wrap">
			<th scope="row">
				<label for="currency"><?php esc_attr_e('General Enquiry','tour-operator'); ?></label>
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
								<option value="<?php echo wp_kses_post($form_id); ?>" {{#is enquiry value="<?php echo wp_kses_post($form_id); ?>"}} selected="selected"{{/is}}><?php echo wp_kses_post($form_data); ?></option>
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
				<label for="description"><?php esc_attr_e('Disable Modal','tour-operator'); ?></label>
			</th>
			<td>
				<input type="checkbox" {{#if disable_enquire_modal}} checked="checked" {{/if}} name="disable_enquire_modal" />
				<small><?php esc_attr_e('This disables the enquire modal, and instead redirects to the link you provide below.','tour-operator'); ?></small>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="title"><?php esc_attr_e('Enquire Link','tour-operator'); ?></label>
			</th>
			<td>
				<input type="text" {{#if enquire_link}} value="{{enquire_link}}" {{/if}} name="enquire_link" />
			</td>
		</tr>		
		<tr class="form-field">
			<th scope="row">
				<label for="description">Disable Archives</label>
			</th>
			<td>
				<input type="checkbox" {{#if disable_archives}} checked="checked" {{/if}} name="disable_archives" />
				<small>This disables the "post type archive", if you create your own custom loop it will still work.</small>
			</td>
		</tr>		
		<tr class="form-field">
			<th scope="row">
				<label for="description">Disable Singles</label>
			</th>
			<td>
				<input type="checkbox" {{#if disable_single}} checked="checked" {{/if}} name="disable_single" />
				<small>When disabled you will be redirected to the homepage when trying to access a single tour page.</small>
			</td>
		</tr>

		<?php	
			do_action('to_framework_'.$post_type.'_tab_general_settings_bottom',$post_type);	
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
	 * Adds in the settings neccesary for the archive heading
	 */
	public function archive_settings_header($post_type=false){ ?>
		{{#unless disable_archives}}
			<tr class="form-field">
				<th scope="row" colspan="2"><label><h3>Archive</h3></label></th>
			</tr>
		{{/unless}}
	<?php
	}

	/**
	 * Adds in the settings neccesary for the archives
	 */
	public function archive_settings($post_type=false){ ?>

		{{#unless disable_archives}}
			<?php do_action('to_framework_'.$post_type.'_tab_archive_settings_top',$post_type); ?>
			<tr class="form-field">
				<th scope="row">
					<label for="title"> Title</label>
				</th>
				<td>
					<input type="text" {{#if title}} value="{{title}}" {{/if}} name="title" />
				</td>
			</tr>			
			<tr class="form-field">
				<th scope="row">
					<label for="tagline"> Tagline</label>
				</th>
				<td>
					<input type="text" {{#if tagline}} value="{{tagline}}" {{/if}} name="tagline" />
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="description"> Description</label>
				</th>
				<td>
					<textarea class="description" name="description" rows="10">{{#if description}}{{{description}}}{{/if}}</textarea>
				</td>
			</tr>
			<?php do_action('to_framework_'.$post_type.'_tab_archive_settings_bottom',$post_type); ?>
		{{/unless}}
	<?php
	}

	/**
	 * Adds in the settings neccesary for the single
	 */
	public function single_settings($post_type=false){ ?>
		<?php 
		do_action('to_framework_'.$post_type.'_tab_single_settings_top',$post_type);
		if ( 'tour' == $post_type || 'accommodation' == $post_type || 'destination' == $post_type || 'activity' == $post_type ) : ?>
			<tr class="form-field">
				<th scope="row" colspan="2"><label><h3>Single</h3></label></th>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="section_title">Default Section Title</label>
				</th>
				<td>
					<input type="text" {{#if section_title}} value="{{section_title}}" {{/if}} name="section_title" />
				</td>
			</tr>
			<?php if ( 'tour' == $post_type ) : ?>
				<tr class="form-field">
					<th scope="row">
						<label for="related_section_title">"Related Tours" Section Title</label>
					</th>
					<td>
						<input type="text" {{#if related_section_title}} value="{{related_section_title}}" {{/if}} name="related_section_title" />
					</td>
				</tr>
			<?php endif ?>
			<?php if ( 'accommodation' == $post_type ) : ?>
				<tr class="form-field">
					<th scope="row">
						<label for="brands_section_title">"Accommodation Brands" Section Title</label>
					</th>
					<td>
						<input type="text" {{#if brands_section_title}} value="{{brands_section_title}}" {{/if}} name="brands_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="rooms_section_title">"Rooms" Section Title</label>
					</th>
					<td>
						<input type="text" {{#if rooms_section_title}} value="{{rooms_section_title}}" {{/if}} name="rooms_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="similar_section_title">"Similar Accommodations" Section Title</label>
					</th>
					<td>
						<input type="text" {{#if similar_section_title}} value="{{similar_section_title}}" {{/if}} name="similar_section_title" />
					</td>
				</tr>
			<?php endif ?>
			<?php if ( 'destination' == $post_type ) : ?>
				<tr class="form-field">
					<th scope="row">
						<label for="countries_section_title">"Countries" Section Title</label>
					</th>
					<td>
						<input type="text" {{#if countries_section_title}} value="{{countries_section_title}}" {{/if}} name="countries_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="regions_section_title">"Regions" Section Title</label>
					</th>
					<td>
						<input type="text" {{#if regions_section_title}} value="{{regions_section_title}}" {{/if}} name="regions_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="travel_styles_section_title">"Travel Styles" Section Title</label>
					</th>
					<td>
						<input type="text" {{#if travel_styles_section_title}} value="{{travel_styles_section_title}}" {{/if}} name="travel_styles_section_title" />
					</td>
				</tr>
			<?php endif ?>
		<?php endif ?>
	<?php do_action('to_framework_'.$post_type.'_tab_single_settings_bottom',$post_type);
	}

	/**
	 * Allows the settings pages to upload images
	 */
	public function settings_page_scripts(){ ?>
	{{#script src="<?php echo wp_kses_post(TO_PATH.'assets/js/tinymce/tinymce.min.js'); ?>"}}{{/script}}

	{{#script}}
		jQuery( function( $ ){
			$( '.lsx-thumbnail-image-add' ).on( 'click', function() {

				var slug = $(this).attr('data-slug');
				tb_show('Choose a Featured Image', 'media-upload.php?type=image&TB_iframe=1');
				var image_thumbnail = '';
				var thisObj = $(this);
				window.send_to_editor = function( html ) 
				{

					var image_thumbnail = $( 'img',html ).html();

					$( thisObj ).parent('td').find('.thumbnail-preview' ).append('<img width="150" height="150" src="'+$( 'img',html ).attr( 'src' )+'" />');
					$( thisObj ).parent('td').find('input[name="'+slug+'"]').val($( 'img',html ).attr( 'src' ));
					
					var imgClasses = $( 'img',html ).attr( 'class' );
					imgClasses = imgClasses.split('wp-image-');
					
					$( thisObj ).parent('td').find('input[name="'+slug+'_id"]').val(imgClasses[1]);
					$( thisObj ).hide();
					$( thisObj ).parent('td').find('.lsx-thumbnail-image-delete' ).show();
					tb_remove();
					$( this ).hide();
				}
				return false;
			});
			$( '.lsx-thumbnail-image-delete' ).on( 'click', function() {
				var slug = $(this).attr('data-slug');
				$( this ).parent('td').find('input[name="'+slug+'_id"]').val('');
				$( this ).parent('td').find('input[name="'+slug+'"]').val('');
				$( this ).parent('td').find('.thumbnail-preview' ).html('');
				$( this ).hide();
				$( this ).parent('td').find('.lsx-thumbnail-image-add' ).show();
			});

			if($( 'textarea.description' ).length){
				tinymce.init({
					selector:'textarea.description',
					plugins: [
					    'link hr anchor code',
					  ],
					menu: {},				
					toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright justify | link code',
				    setup: function (editor) {
				        editor.on('change', function () {
				            editor.save();
				        });
				    }
				});

				/*tinymce.get('textarea.description').on('click', function(e) {
				   ed.windowManager.alert('Hello world!');
				});	*/	
			}			
		});
	{{/script}}
	<?php
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