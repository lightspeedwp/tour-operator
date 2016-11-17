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
class TO_Settings extends Tour_Operator {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->options = get_option('_to_settings',false);	
		$this->set_vars();

		add_filter( 'to_framework_settings_tabs', array( $this, 'register_settings_tabs') );

		if(isset($_GET['welcome-page'])) {
			$display_page = !empty(sanitize_text_field(wp_unslash($_GET['welcome-page']))) ? sanitize_text_field(wp_unslash($_GET['welcome-page'])) : '';
		}
			
		if ( ! empty( $display_page ) ) {
			add_action( 'admin_menu', array( $this, 'create_welcome_page' ) );
		} else {
			add_action( 'init', array( $this, 'create_settings_page'),100 );
		}
	}	

	/**
	 * Returns the array of settings to the UIX Class
	 */
	public function create_settings_page(){
		if(is_admin()){
			if(!class_exists('\to\ui\uix')){
				include_once TO_PATH.'vendor/uix/uix.php';
			}
			$pages = $this->settings_page_array();
			$uix = \to\ui\uix::get_instance( 'to' );
			$uix->register_pages( $pages );

			foreach($this->post_types as $post_type => $label){
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'general_settings' ), 5 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'archive_settings_header' ), 10 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'archive_settings' ), 12 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_content_top', array( $this, 'single_settings' ), 15 , 1 );
				add_action( 'to_framework_'.$post_type.'_tab_bottom', array( $this, 'settings_page_scripts' ), 100 );
			}

			
			add_action('to_framework_dashboard_tab_content',array($this,'dashboard_tab_content'));
			add_action('to_framework_display_tab_content',array($this,'display_tab_content'),10,1);

			add_action( 'to_framework_api_tab_bottom', array( $this, 'settings_page_scripts' ), 100 );
			add_action( 'to_framework_display_tab_bottom', array( $this, 'settings_page_scripts' ), 100 );
		}
	}

	/**
	 * Add the welcome page
	 */
	public function create_welcome_page() {
	    add_submenu_page( 'tour-operator', esc_html__( 'Settings', 'tour-operator' ), esc_html__( 'Settings', 'tour-operator' ), 'manage_options', 'to-settings', array( $this, 'welcome_page' ) );
	}

	/**
	 * Display the welcome page
	 */
	public function welcome_page() {
	    include( TO_PATH . 'includes/settings/welcome.php' );
	}

	/**
	 * Returns the array of settings to the UIX Class in the lsx framework
	 */	
	public function register_settings_tabs($tabs){
		// This array is for the Admin Pages. each element defines a page that is seen in the admin
		
		$post_types = apply_filters('to_post_types',$this->post_types);
		
		if(false !== $post_types && !empty($post_types)){
			foreach($post_types as $index => $title){

				$disabled = false;
				if(!in_array($index,$this->active_post_types)){
					$disabled = true;
				}

				$tabs[$index] = array(
					'page_title'        => $title,
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
	 * Returns the array of settings to the UIX Class
	 */
	public function settings_page_array(){
		// This array is for the Admin Pages. each element defines a page that is seen in the admin
	
		$tabs = array( // tabs array are for setting the tab / section templates
				// each array element is a tab with the key as the slug that will be the saved object property
				'general'		=> array(
						'page_title'        => '',
						'page_description'  => '',
						'menu_title'        => esc_html__('General','tour-operator'),
						'template'          => TO_PATH.'includes/settings/general.php',
						'default'	 		=> true
				)
		);
		$tabs['display'] = array(
			'page_title'        => '',
			'page_description'  => '',
			'menu_title'        => esc_html__('Display','tour-operator'),
			'template'          => TO_PATH.'includes/settings/display.php',
			'default'	 		=> false
		);	

		if(in_array('LSX_Banners',get_declared_classes())){
			$tabs['api'] = array(
				'page_title'        => '',
				'page_description'  => '',
				'menu_title'        => esc_html__('API','tour-operator'),
				'template'          => TO_PATH.'includes/settings/api.php',
				'default'	 		=> false
			);	
		}

		$posts_page = get_option('page_for_posts',false);
		if(false === $posts_page){
			$tabs['post'] = array(
				'page_title'        => esc_html__('Posts','tour-operator'),
				'page_description'  => '',
				'menu_title'        => esc_html__('Posts','tour-operator'),
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
				'settings'  => array(                                                         // this is the settings array. The key is the page slug
						'page_title'  =>  esc_html__('Tour Operator Settings','tour-operator'),                                                  // title of the page
						'menu_title'  =>  esc_html__('Settings','tour-operator'),                                                  // title seen on the menu link
						'capability'  =>  'manage_options',                                              // required capability to access page
						'icon'        =>  'dashicons-book-alt',                                      // Icon or image to be used on admin menu
						'parent'      =>  'tour-operator',                                         // Position priority on admin menu)
						'save_button' =>  esc_html__('Save Changes','tour-operator'),                                                // If the page required saving settings, Set the text here.
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
	 * outputs the display tabs settings
	 */
	public function display_tab_content($subtab='basic') { 

		if('basic'===$subtab){
			if(class_exists('LSX_Banners') && class_exists('Envira_Gallery')){
			?>
			<tr class="form-field">
				<th scope="row">
					<label for="description"><?php esc_html_e('Display galleries in the banner','tour-operator'); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if enable_galleries_in_banner}} checked="checked" {{/if}} name="enable_galleries_in_banner" />
					<small><?php esc_html_e('Move the gallery on a page into the banner.','tour-operator'); ?></small>
				</td>
			</tr>	

			<?php $this->modal_setting(); ?>	
		<?php }
		}
		if('advanced'===$subtab){
		?>
			<tr class="form-field">
				<th scope="row">
					<label for="description"><?php esc_html_e('Disable CSS','tour-operator'); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if disable_css}} checked="checked" {{/if}} name="disable_css" />
					<small><?php esc_html_e('Disable the CSS if you want to include your own.','tour-operator'); ?></small>
				</td>
			</tr>	
			<tr class="form-field">
				<th scope="row">
					<label for="description"><?php esc_html_e('Disable Javascript','tour-operator'); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if disable_js}} checked="checked" {{/if}} name="disable_js" />
					<small><?php esc_html_e('Only disable the JS if you are debugging an error.','tour-operator'); ?></small>
				</td>
			</tr>				
		<?php
		}
	}	

	/**
	 * outputs the dashboard tabs settings
	 */
	public function dashboard_tab_content() {
		?>
		<?php if(!class_exists('LSX_Currencies')) { ?>
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
	public function settings_page_scripts(){ 
	/*{{#script src="<?php echo wp_kses_post(TO_PATH.'assets/js/tinymce/tinymce.min.js'); ?>"}}{{/script}}*/
	?>
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

			<?php /*if($( 'textarea.description' ).length){
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
			/*}*/ ?>

			$( '.ui-tab-nav a' ).on( 'click', function(event) {
				event.preventDefault();

				$('.ui-tab-nav a.active').removeClass('active');
				$(this).addClass('active');

				$('.ui-tab.active').removeClass('active');
				$($(this).attr('href')).addClass('active');
			});			
		});
	{{/script}}
	<?php
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
}