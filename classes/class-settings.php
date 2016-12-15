<?php
/**
 * Backend actions for the LSX TO Plugin
 *
 * @package   LSX_TO_PATHAdmin
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package LSX_TO_PATHSettings
 * @author  LightSpeed
 */
class LSX_TO_PATHSettings extends Tour_Operator {

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
				include_once LSX_TO_PATHPATH.'vendor/uix/uix.php';
			}
			$pages = $this->settings_page_array();
			$uix = \to\ui\uix::get_instance( 'to' );
			$uix->register_pages( $pages );

			foreach($this->post_types as $post_type => $label){
				add_action( 'to_framework_'.$post_type.'_tab_content', array( $this, 'general_settings' ), 5 , 2 );
				add_action( 'to_framework_'.$post_type.'_tab_content', array( $this, 'archive_settings' ), 12 , 2 );
				add_action( 'to_framework_'.$post_type.'_tab_content', array( $this, 'single_settings' ), 15 , 2 );
			}
			
			add_action('to_framework_dashboard_tab_content',array($this,'dashboard_tab_content'),10,1);
			add_action('to_framework_display_tab_content',array($this,'display_tab_content'),10,1);
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
	    include( LSX_TO_PATHPATH . 'includes/settings/welcome.php' );
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
					'page_title'        => '',
					'page_description'  => '',
					'menu_title'        => $title,
					'template'          => apply_filters('to_settings_path',LSX_TO_PATHPATH,$index).'includes/settings/'.$index.'.php',
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
						'template'          => LSX_TO_PATHPATH.'includes/settings/general.php',
						'default'	 		=> true
				)
		);
		$tabs['display'] = array(
			'page_title'        => '',
			'page_description'  => '',
			'menu_title'        => esc_html__('Display','tour-operator'),
			'template'          => LSX_TO_PATHPATH.'includes/settings/display.php',
			'default'	 		=> false
		);	

		//if(in_array('LSX_Banners',get_declared_classes())){
			$tabs['api'] = array(
				'page_title'        => '',
				'page_description'  => '',
				'menu_title'        => esc_html__('API','tour-operator'),
				'template'          => LSX_TO_PATHPATH.'includes/settings/api.php',
				'default'	 		=> false
			);	
		//}

		$posts_page = get_option('page_for_posts',false);
		if(false === $posts_page){
			$tabs['post'] = array(
				'page_title'        => esc_html__('Posts','tour-operator'),
				'page_description'  => '',
				'menu_title'        => esc_html__('Posts','tour-operator'),
				'template'          => LSX_TO_PATHPATH.'includes/settings/post.php',
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
	 *
	 * @param $tab string
	 * @return null
	 */
	public function dashboard_tab_content($tab='general') {
		if('general' !== $tab){ return false;}
		?>
		<?php if(!class_exists('LSX_Currencies')) { ?>
			<tr class="form-field-wrap">
				<th scope="row">
					<label for="currency"> <?php esc_html_e('Currency','tour-operator'); ?></label>
				</th>
				<td>
					<select value="{{currency}}" name="currency">
						<option value="USD" {{#is currency value=""}}selected="selected"{{/is}} {{#is currency value="USD"}} selected="selected"{{/is}}><?php esc_html_e('USD (united states dollar)','tour-operator'); ?></option>
						<option value="GBP" {{#is currency value="GBP"}} selected="selected"{{/is}}><?php esc_html_e('GBP (british pound)','tour-operator'); ?></option>
						<option value="ZAR" {{#is currency value="ZAR"}} selected="selected"{{/is}}><?php esc_html_e('ZAR (south african rand)','tour-operator'); ?></option>
						<option value="NAD" {{#is currency value="NAD"}} selected="selected"{{/is}}><?php esc_html_e('NAD (namibian dollar)','tour-operator'); ?></option>
						<option value="CAD" {{#is currency value="CAD"}} selected="selected"{{/is}}><?php esc_html_e('CAD (canadian dollar)','tour-operator'); ?></option>
						<option value="EUR" {{#is currency value="EUR"}} selected="selected"{{/is}}><?php esc_html_e('EUR (euro)','tour-operator'); ?></option>
						<option value="HKD" {{#is currency value="HKD"}} selected="selected"{{/is}}><?php esc_html_e('HKD (hong kong dollar)','tour-operator'); ?></option>
						<option value="SGD" {{#is currency value="SGD"}} selected="selected"{{/is}}><?php esc_html_e('SGD (singapore dollar)','tour-operator'); ?></option>
						<option value="NZD" {{#is currency value="NZD"}} selected="selected"{{/is}}><?php esc_html_e('NZD (new zealand dollar)','tour-operator'); ?></option>
						<option value="AUD" {{#is currency value="AUD"}} selected="selected"{{/is}}><?php esc_html_e('AUD (australian dollar)','tour-operator'); ?></option>
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
								<option value="" {{#is enquiry value=""}}selected="selected"{{/is}}><?php esc_html_e('Select a form','tour-operator'); ?></option>
								<?php
								foreach($forms as $form_id => $form_data){ ?>
									<option value="<?php echo esc_attr( $form_id ); ?>" {{#is enquiry value="<?php echo esc_attr( $form_id ); ?>"}} selected="selected"{{/is}}><?php echo esc_html( $form_data ); ?></option>
								<?php
								}
							}else{ ?>
								<option value="" {{#is enquiry value=""}}selected="selected"{{/is}}><?php esc_html_e('You have no form available','tour-operator'); ?></option>
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
	 * Adds in the settings necessary for the archives
	 *
	 * @param $post_type string
	 * @param $tab string
	 * @return null
	 */
	public function general_settings($post_type=false,$tab=false){
		if('general' !== $tab){ return false; }

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
							<option value="" {{#is enquiry value=""}}selected="selected"{{/is}}><?php esc_html_e('Select a form','tour-operator'); ?></option>
							<?php
							foreach($forms as $form_id => $form_data){ ?>
								<option value="<?php echo wp_kses_post($form_id); ?>" {{#is enquiry value="<?php echo wp_kses_post($form_id); ?>"}} selected="selected"{{/is}}><?php echo wp_kses_post($form_data); ?></option>
								<?php
							}
						}else{ ?>
							<option value="" {{#is enquiry value=""}}selected="selected"{{/is}}><?php esc_html_e('You have no form available','tour-operator'); ?></option>
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
				<label for="description"><?php esc_attr_e('Disable Enquire Modal','tour-operator'); ?></label>
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

		<?php	
			do_action('to_framework_'.$post_type.'_tab_general_settings_bottom',$post_type);	
	}

	/**
	 * Adds in the settings necessary for the archives
	 *
	 * @param $post_type string
	 * @param $tab string
	 * @return null
	 */
	public function archive_settings($post_type=false,$tab=false){
		if('archives' !== $tab){ return false; }
		?>

		<tr class="form-field">
			<th scope="row">
				<label for="description"><?php esc_html_e('Disable Archives','tour-operator'); ?></label>
			</th>
			<td>
				<input type="checkbox" {{#if disable_archives}} checked="checked" {{/if}} name="disable_archives" />
				<small><?php esc_html_e('This disables the "post type archive", if you create your own custom loop it will still work.','tour-operator'); ?></small>
			</td>
		</tr>
		<?php do_action('to_framework_'.$post_type.'_tab_archive_settings_top',$post_type); ?>
		<tr class="form-field">
			<th scope="row">
				<label for="title"> <?php esc_html_e('Title','tour-operator'); ?></label>
			</th>
			<td>
				<input type="text" {{#if title}} value="{{title}}" {{/if}} name="title" />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="tagline"> <?php esc_html_e('Tagline','tour-operator'); ?></label>
			</th>
			<td>
				<input type="text" {{#if tagline}} value="{{tagline}}" {{/if}} name="tagline" />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="description"> <?php esc_html_e('Description','tour-operator'); ?></label>
			</th>
			<td>
				<textarea class="description" name="description" rows="10">{{#if description}}{{{description}}}{{/if}}</textarea>
			</td>
		</tr>
		<?php do_action('to_framework_'.$post_type.'_tab_archive_settings_bottom',$post_type); ?>

	<?php
	}

	/**
	 * Adds in the settings necessary for the single
	 *
	 * @param $post_type string
	 * @param $tab string
	 * @return null
	 */
	public function single_settings($post_type=false,$tab=false){
		if('single' !== $tab){ return false; }

		?>
		<tr class="form-field">
			<th scope="row">
				<label for="description"><?php esc_html_e('Disable Singles','tour-operator'); ?></label>
			</th>
			<td>
				<input type="checkbox" {{#if disable_single}} checked="checked" {{/if}} name="disable_single" />
				<small><?php esc_html_e('When disabled you will be redirected to the homepage when trying to access a single tour page.','tour-operator'); ?></small>
			</td>
		</tr>
		<?php
		do_action('to_framework_'.$post_type.'_tab_single_settings_top',$post_type);
		if ( 'tour' == $post_type || 'accommodation' == $post_type || 'destination' == $post_type || 'activity' == $post_type ) : ?>
			<tr class="form-field">
				<th scope="row">
					<label for="section_title"><?php esc_html_e('Default Section Title','tour-operator'); ?></label>
				</th>
				<td>
					<input type="text" {{#if section_title}} value="{{section_title}}" {{/if}} name="section_title" />
				</td>
			</tr>
			<?php if ( 'tour' == $post_type ) : ?>
				<tr class="form-field">
					<th scope="row">
						<label for="related_section_title"><?php esc_html_e('"Related Tours" Section Title','tour-operator'); ?></label>
					</th>
					<td>
						<input type="text" {{#if related_section_title}} value="{{related_section_title}}" {{/if}} name="related_section_title" />
					</td>
				</tr>
			<?php endif ?>
			<?php if ( 'accommodation' == $post_type ) : ?>
				<tr class="form-field">
					<th scope="row">
						<label for="brands_section_title"><?php esc_html_e('"Accommodation Brands" Section Title','tour-operator'); ?></label>
					</th>
					<td>
						<input type="text" {{#if brands_section_title}} value="{{brands_section_title}}" {{/if}} name="brands_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="rooms_section_title"><?php esc_html_e('"Rooms" Section Title','tour-operator'); ?></label>
					</th>
					<td>
						<input type="text" {{#if rooms_section_title}} value="{{rooms_section_title}}" {{/if}} name="rooms_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="similar_section_title"><?php esc_html_e('"Similar Accommodations" Section Title','tour-operator'); ?></label>
					</th>
					<td>
						<input type="text" {{#if similar_section_title}} value="{{similar_section_title}}" {{/if}} name="similar_section_title" />
					</td>
				</tr>
			<?php endif ?>
			<?php if ( 'destination' == $post_type ) : ?>
				<tr class="form-field">
					<th scope="row">
						<label for="countries_section_title"><?php esc_html_e('"Countries" Section Title','tour-operator'); ?></label>
					</th>
					<td>
						<input type="text" {{#if countries_section_title}} value="{{countries_section_title}}" {{/if}} name="countries_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="regions_section_title"><?php esc_html_e('"Regions" Section Title','tour-operator'); ?></label>
					</th>
					<td>
						<input type="text" {{#if regions_section_title}} value="{{regions_section_title}}" {{/if}} name="regions_section_title" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="travel_styles_section_title"><?php esc_html_e('"Travel Styles" Section Title','tour-operator'); ?></label>
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