<?php
/**
 * Backend actions for the LSX TO Plugin
 *
 * @package   \lsx\admin
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2019 LightSpeedDevelopment
 */

namespace lsx\admin;

/**
 * Main plugin class.
 *
 * @package lsx
 * @author  LightSpeed
 */
class Settings {

	/**
	 * Holds instance of the class
	 *
	 * @since   1.1.0
	 * @var     \lsx\admin\Admin
	 */
	private static $instance;

	/**
	 * Holds the tour operators options
	 *
	 * @since   1.1.0
	 * @var     array
	 */
	public $options;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->options = tour_operator()->options;

		if ( isset( $_GET['welcome-page'] ) ) {
			$display_page = sanitize_text_field( $_GET['welcome-page'] );
			$display_page = ! empty( $display_page ) ? $display_page : '';
		}

		if ( ! empty( $display_page ) ) {
			add_action( 'admin_menu', array( $this, 'create_welcome_page' ) );
		} else {
			add_action( 'init', array( $this, 'create_settings_page' ), 100 );
		}

		// Incase the API tab is being loaded via another plugin, we add all the API hooks to the LSX ones.
		add_action( 'lsx_framework_api_tab_content', array( $this, 'lsx_to_framework_api_patch' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.1.0
	 * @return  Tour_Operator  A single instance
	 */
	public static function init() {

		// If the single instance hasn't been set, set it now.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Returns the array of settings to the UIX Class
	 */
	public function create_settings_page() {
		if ( is_admin() ) {
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'map_display_settings' ), 12, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_placeholder', array( $this, 'map_placeholder_settings' ), 12, 1 );
			

			if ( ! empty( tour_operator()->legacy->post_types ) ) {
				foreach ( tour_operator()->legacy->post_types as $post_type => $label ) {
					if ( isset( tour_operator()->legacy->options[ $post_type ]['googlemaps_marker'] ) && '' !== tour_operator()->legacy->options[ $post_type ]['googlemaps_marker'] ) {
						tour_operator()->legacy->markers->post_types[ $post_type ] = tour_operator()->legacy->options[ $post_type ]['googlemaps_marker'];
					} else {
						tour_operator()->legacy->markers->post_types[ $post_type ] = LSX_TO_URL . 'assets/img/markers/' . $post_type . '-marker.png';
					}
					add_action( 'lsx_to_framework_' . $post_type . '_tab_content', array( $this, 'post_type_map_settings' ), 10, 2 );
				}
			}
		}
	}

	/**
	 * Add the welcome page
	 */
	public function create_welcome_page() {
		add_submenu_page( 'tour-operator', esc_html__( 'Settings', 'tour-operator' ), esc_html__( 'Settings', 'tour-operator' ), 'manage_options', 'lsx-to-settings', array( $this, 'welcome_page' ) );
	}

	/**
	 * Display the welcome page
	 */
	public function welcome_page() {
		include( LSX_TO_PATH . 'includes/partials/welcome.php' );
	}

	/**
	 * Returns the array of settings to the UIX Class
	 */
	public function settings_page_array() {
		// This array is for the Admin Pages. each element defines a page that is seen in the admin

		$tabs = array( // tabs array are for setting the tab / section templates
			// each array element is a tab with the key as the slug that will be the saved object property
			'general'       => array(
				'menu_title'        => esc_html__( 'General', 'tour-operator' ),
				'template'          => LSX_TO_PATH . 'includes/partials/general.php',
				'default'           => true,
			),
			'destination'       => array(
				'menu_title'        => esc_html__( 'Destinations', 'tour-operator' ),
				'template'          => 'post_type',
				'default'           => false,
			),
			'tour'       => array(
				'menu_title'        => esc_html__( 'Tours', 'tour-operator' ),
				'template'          => 'post_type',
				'default'           => false,
			),
			'accommodation'       => array(
				'menu_title'        => esc_html__( 'Accommodation', 'tour-operator' ),
				'template'          => 'post_type',
				'default'           => false,
			),
		);

		$additional_tabs = false;
		$additional_tabs = apply_filters( 'lsx_to_framework_settings_tabs', $additional_tabs );

		if ( false !== $additional_tabs && is_array( $additional_tabs ) && ! empty( $additional_tabs ) ) {
			$tabs = array_merge( $tabs, $additional_tabs );
		}

		return array(
			'settings'  => array(                                                         // this is the settings array. The key is the page slug
				'page_title'  => esc_html__( 'LSX Tour Operator Settings', 'tour-operator' ),                                                  // title of the page
				'menu_title'  => esc_html__( 'Settings', 'tour-operator' ),                                                  // title seen on the menu link
				'capability'  => 'manage_options',                                              // required capability to access page
				'icon'        => 'dashicons-book-alt',                                      // Icon or image to be used on admin menu
				'parent'      => 'tour-operator',                                         // Position priority on admin menu)
				'save_button' => esc_html__( 'Save Changes', 'tour-operator' ),                                                // If the page required saving settings, Set the text here.
				'tabs'        => $tabs,
			),
		);
	}

	public function lsx_to_framework_api_patch( $tab = 'settings' ) {
		do_action( 'lsx_to_framework_api_tab_content', $tab );
	}

	/**
	 * outputs the display settings for the map tab.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function map_display_settings( $tab = 'general' ) {
		if ( 'general' === $tab ) {
			$this->map_settings_title();
			$this->disable_maps_checkbox();
			$this->map_marker_field();
			$this->cluster_marker_field();
			$this->start_end_marker_fields();
			$this->fusion_tables_fields();
		}
	}

	/**
	 * outputs the display settings for the map tab.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function map_placeholder_settings( $tab = 'placeholder' ) {
		if ( 'general' === $tab ) {
			$this->enable_map_placeholder_checkbox();
			$this->map_placeholder_field();
		}
	}

	/**
	 * Outputs the post type map settings.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function post_type_map_settings( $post_type = '', $tab = 'general' ) {
		if ( 'placeholders' === $tab ) {
			$this->map_marker_field();
			$this->map_placeholder_field();
		}
	}

	/**
	 * Outputs the map placeholder field header
	 */
	public function map_settings_title() {
		?>
		<tr class="form-field">
			<th scope="row" colspan="2">
				<label>
					<h3><?php esc_html_e( 'Map Settings', 'tour-operator' ); ?></h3>
				</label>
			</th>
		</tr>
		<?php
	}

	/**
	 * Outputs the map placeholder field
	 */
	public function disable_maps_checkbox() {
		?>
		<tr class="form-field">
			<th scope="row">
				<label for="maps_disabled"><?php esc_html_e( 'Disable Maps', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input type="checkbox" checked="checked" name="maps_disabled" /> 
				<small><?php esc_html_e( 'This will disable maps on all post types.', 'tour-operator' ); ?></small>
			</td>
		</tr>	
		<?php
	}

	/**
	 * Outputs the map placeholder field
	 */
	public function enable_map_placeholder_checkbox() {
		?>
        	
		<tr class="form-field">
			<th scope="row">
				<label for="map_placeholder_enabled"><?php esc_html_e( 'Enable Map Placeholder', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input type="checkbox" checked="checked" name="map_placeholder_enabled" /> 
				<small><?php esc_html_e( 'Enable a placeholder users will click to load the map.', 'tour-operator' ); ?></small>
			</td>
		</tr>	
		<?php
	}

	/**
	 * Outputs the map placeholder field
	 */
	public function map_placeholder_field() {
		?>
		<tr class="form-field map-placeholder">
			<th scope="row">
				<label for="banner"> <?php esc_html_e( 'Upload a map placeholder', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input class="input_image_id" type="hidden" value="" name="map_placeholder" />
				<input class="input_image" type="hidden" value="" name="map_placeholder" />
				<div class="thumbnail-preview">
					<img src="" width="480" style="color:black;" />
				</div>
				<a style="" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'tour-operator' ); ?></a>
				<a style="display:none;" class="button-secondary lsx-thumbnail-image-delete"><?php esc_html_e( 'Delete', 'tour-operator' ); ?></a>
			</td>
		</tr>
		<?php
	}

	/**
	 * outputs the map marker upload field
	 */
	public function map_marker_field() {
		?>
		<tr class="form-field default-marker-wrap">
			<th scope="row">
				<label for="banner"> <?php esc_html_e( 'Choose a default marker', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input class="input_image_id" type="hidden" value=""  name="googlemaps_marker_id" />
				<input class="input_image" type="hidden" value="" name="googlemaps_marker" />
				<div class="thumbnail-preview">
					<img src="" width="48" style="color:black;" />
				</div>
				<a style="" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'tour-operator' ); ?></a>
				<a style="display:none;" class="button-secondary lsx-thumbnail-image-delete"><?php esc_html_e( 'Delete', 'tour-operator' ); ?></a>
			</td>
		</tr>
		<?php
	}

	/**
	 * outputs the cluster marker upload field
	 */
	public function cluster_marker_field() {
		?>
		<tr class="form-field default-cluster-small-wrap">
			<th scope="row">
				<label for="banner"> <?php esc_html_e( 'Choose a cluster marker', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input class="input_image_id" type="hidden" value="" name="gmap_cluster_small_id" />
				<input class="input_image" type="hidden" value="" name="gmap_cluster_small" />
				<div class="thumbnail-preview">
					<img src="" width="48" style="color:black;" />
				</div>
				<a style="" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'tour-operator' ); ?></a>
				<a style="display:none;" class="button-secondary lsx-thumbnail-image-delete"><?php esc_html_e( 'Delete', 'tour-operator' ); ?></a>
			</td>
		</tr>
		<?php
	}

	/**
	 * outputs the start/end marker upload field
	 */
	public function start_end_marker_fields() {
		?>
		<tr class="form-field default-cluster-small-wrap">
			<th scope="row">
				<label for="banner"> <?php esc_html_e( 'Choose a start marker', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input class="input_image_id" type="hidden" value=""  name="gmap_marker_start_id" />
				<input class="input_image" type="hidden"  value="" name="gmap_marker_start" />
				<div class="thumbnail-preview">
					<img src="" width="48" style="color:black;" />
				</div>
				<a style="" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'tour-operator' ); ?></a>
				<a style="display:none;" class="button-secondary lsx-thumbnail-image-delete"><?php esc_html_e( 'Delete', 'tour-operator' ); ?></a>
			</td>
		</tr>
		<tr class="form-field default-cluster-small-wrap">
			<th scope="row">
				<label for="banner"> <?php esc_html_e( 'Choose a end marker', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input class="input_image_id" type="hidden" value=""  name="gmap_marker_end_id" />
				<input class="input_image" type="hidden" value=""  name="gmap_marker_end" />
				<div class="thumbnail-preview">
					<img src="" width="48" style="color:black;" />
				</div>
				<a style="" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'tour-operator' ); ?></a>
				<a style="display:none;" class="button-secondary lsx-thumbnail-image-delete"><?php esc_html_e( 'Delete', 'tour-operator' ); ?></a>
			</td>
		</tr>
		<?php
	}

	/**
	 * Outputs the map marker upload field
	 */
	public function fusion_tables_fields() {
		?>
		<tr class="form-field">
			<th scope="row" colspan="2">
				<label>
					<h3><?php esc_html_e( 'Fusion Tables Settings', 'tour-operator' ); ?></h3>
				</label>
			</th>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="fusion_tables_enabled"><?php esc_html_e( 'Enable Fusion Tables', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input type="checkbox" checked="checked" name="fusion_tables_enabled" />
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="title"><?php esc_html_e( 'Border Width', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input type="text" maxlength="2" value="" name="fusion_tables_width_border" />
				<br>
				<small>Default value: 2</small>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="title"><?php esc_html_e( 'Border Colour', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input type="text" maxlength="7" value="" name="fusion_tables_colour_border" />
				<br>
				<small>Default value: #000000</small>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="title"><?php esc_html_e( 'Background Colour', 'tour-operator' ); ?></label>
			</th>
			<td>
				<input type="text" maxlength="7" value="" name="fusion_tables_colour_background" />
				<br>
				<small>Default value: #000000</small>
			</td>
		</tr>
		<?php
	}
}
