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
	 * Returns the fields needed for the settings.
	 *
	 * @return array
	 */
	public function get_settings_fields() {
		$settings = array();
		$settings = include( LSX_TO_PATH . 'includes/constants/settings-fields.php' );
		return $settings;
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

	/**
	 * Returns the array of settings to the UIX Class
	 */
	public function create_settings_page() {
		if ( is_admin() ) {
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'currency_settings' ), 11, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'map_settings' ), 12, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'fusion_table_settings' ), 13, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'map_placeholder_settings' ), 14, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'api_settings' ), 15, 1 );
			

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
	 * outputs the display settings for the map tab.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function currency_settings( $tab = 'maps' ) {
		if ( 'currency' === $tab ) {
			$settings = $this->get_settings_fields();
			echo wp_kses_post( $this->output_fields( $settings['currency'] ) );
		}
	}

	/**
	 * outputs the display settings for the map tab.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function map_settings( $tab = 'maps' ) {
		if ( 'maps' === $tab ) {
			$settings = $this->get_settings_fields();
			echo wp_kses_post( $this->output_fields( $settings['maps'] ) );
		}
	}

	/**
	 * Outputs the map marker upload field
	 */
	public function fusion_table_settings( $tab = 'general' ) {
		if ( 'fusion' === $tab ) {
			$settings = $this->get_settings_fields();		
			echo wp_kses_post( $this->output_fields( $settings['fusion'] ) );
		}
	}

	/**
	 * outputs the display settings for the map tab.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function map_placeholder_settings( $tab = 'general' ) {
		if ( 'placeholders' === $tab ) {
			$settings = $this->get_settings_fields();
			echo wp_kses_post( $this->output_fields( $settings['placeholder'] ) );
		}
	}

	/**
	 * Outputs the display settings for the map tab.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function api_settings( $tab = 'general' ) {
		if ( 'api' === $tab ) {
			$settings = $this->get_settings_fields();
			echo wp_kses_post( $this->output_fields( $settings['api'] ) );
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

	public function output_fields( $section = array() ) {
		$fields = array();
		if ( ! empty( $section ) ) {
			foreach ( $section as $field_id => $field ) {
				
				$field_html = '<tr class="form-field ' . sanitize_key( $field_id ) . '">';
				switch( $field['type'] ) {
					case 'checkbox':
						$field_html .= $this->checkbox_field( $field_id, $field );
					break;

					case 'image':
						$field_html .= $this->image_field( $field_id, $field );
					break;

					case 'select':
						$field_html .= $this->select_field( $field_id, $field );
					break;

					case 'text':
					case 'number':
						$field_html .= $this->checkbox_field( $field_id, $field );
					break;

					default;
				}
				$field_html .= '</tr>';
				$fields[] = $field_html;
			}
		}
		return implode( '', $fields ); 
	}

	/**
	 * Outputs the settings page Select Field.
	 *
	 * @param string $field_id
	 * @param array $args
	 * @return string
	 */
	public function select_field( $field_id, $args = array() ) {
		$defaults = array(
			'label'   => '',
			'desc'    => '',
			'default' => 0,
			'options' => array(),
		);
		$params = wp_parse_args( $args, $defaults );

		$field = array();

		$field[] = '<th scope="row"><label for="' . $field_id . '">' . $params['label'] . '</label></th>';
		$field[] = '<td>';
		$field[] = '<select type="' . $params['type'] . '" name="' . $field_id . '" />';
		foreach ( $params['options'] as $o_key => $o_val ) {
			$field[] = '<option val="' . $o_key . '">' . $o_val . '</option>';
		}
		$field[] = '</select>';
		if ( '' !== $params['desc'] ) {
			$field[] = '<br /><small>' . $params['desc'] . '</small>';
		}
		$field[] = '</td>';
		
		return implode( '', $field );
	}

	/**
	 * Outputs the settings page Checkbox.
	 *
	 * @param string $field_id
	 * @param array $args
	 * @return string
	 */
	public function checkbox_field( $field_id, $args = array() ) {
		$defaults = array(
			'label'   => '',
			'desc'    => '',
			'default' => 0,
		);
		$params = wp_parse_args( $args, $defaults );

		$field = array();

		$field[] = '<th scope="row"><label for="' . $field_id . '">' . $params['label'] . '</label></th>';
		$field[] = '<td>';
		$field[] = '<input type="' . $params['type'] . '" name="' . $field_id . '" />';
		if ( '' !== $params['desc'] ) {
			$field[] = '<br /><small>' . $params['desc'] . '</small>';
		}
		$field[] = '</td>';
		
		return implode( '', $field );
	}

	/**
	 * The image upload function.
	 *
	 * @param string $field_id
	 * @param array $args
	 * @return string
	 */
	public function image_field( $field_id, $args = array() ) {
		$defaults = array(
			'label'      => '',
			'desc'       => '',
			'default'    => 0,
			'preview_w'  => 48,
			'add_button' => esc_html__( 'Choose Image', 'tour-operator' ),
			'del_button' => esc_html__( 'Delete', 'tour-operator' ),
		);
		$params = wp_parse_args( $args, $defaults );

		$field = array();

		$field[] = '<th scope="row"><label for="' . $field_id . '">' . $params['label'] . '</label></th>';
		$field[] = '<td>';

		//hidden fields for the ID
		$field[] = '<input class="input_image_id" type="hidden" value="" name="' . $field_id . '_id" />';
		$field[] = '<input class="input_image" type="hidden" value="" name="' . $field_id . '" />';

		// Image Previews
		$field[] = '<div class="thumbnail-preview"><img src="" width="' . $params['preview_w'] . '" style="color:black;" /></div>';

		// Action Buttons
		$field[] = '<a style="" class="button-secondary lsx-thumbnail-image-add">' . $params['add_button'] . '</a>';
		$field[] = '<a style="display:none;" class="button-secondary lsx-thumbnail-image-delete">' . $params['del_button'] . '</a>';

		if ( '' !== $params['desc'] ) {
			$field[] = '<br /><small>' . $params['desc'] . '</small>';
		}
		$field[] = '</td>';
		
		return implode( '', $field );
	}


}
