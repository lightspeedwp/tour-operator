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
		}

		add_action( 'admin_menu', array( $this, 'create_settings_page' ), 100 );
		add_action( 'admin_init', array( $this, 'save_settings' ), 1 );
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

		//tour_operator()->legacy->get_post_types();

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
		add_options_page( esc_html__( 'Settings', 'tour-operator' ), esc_html__( 'Tour Operator', 'tour-operator' ), 'manage_options', 'lsx-to-settings', array( $this, 'settings_page' ) );

		if ( is_admin() ) {

			//Settings Page
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'hidden_settings' ), 10, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'currency_settings' ), 11, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'map_settings' ), 12, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'fusion_table_settings' ), 13, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'map_placeholder_settings' ), 14, 1 );
			add_action( 'lsx_to_framework_dashboard_tab_content', array( $this, 'api_settings' ), 15, 1 );

			//Post type pages
			add_action( 'lsx_to_framework_post_type_tab_content', array( $this, 'post_type_map_settings' ), 10, 2 );
			

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
		add_submenu_page( 'tour-operator', esc_html__( 'Welcome', 'tour-operator' ), esc_html__( 'Welcome', 'tour-operator' ), 'manage_options', 'lsx-to-settings', array( $this, 'welcome_page' ) );
	}

	/**
	 * Display the welcome page
	 */
	public function welcome_page() {
		include( LSX_TO_PATH . 'includes/partials/welcome.php' );
	}

	/**
	 * Generate the settings page.
	 *
	 * @return void
	 */
	public function settings_page() {
		include( LSX_TO_PATH . 'includes/partials/settings.php' );
	}

	/**
	 * outputs the display settings for the map tab.
	 *
	 * @param $tab string
	 * @return null
	 */
	public function hidden_settings( $tab = 'hidden' ) {
		if ( 'hidden' === $tab ) {
			wp_nonce_field( 'lsx_to_settings_save', 'lsx_to_nonce' );
		}
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
	public function post_type_map_settings( $tab, $post_type ) {
		$settings = $this->get_settings_fields();
		if ( 'placeholder' === $tab ) {
			echo wp_kses_post( $this->output_fields( $settings['post_types'][ $tab ], $post_type ) );
		}
		if ( 'template' === $tab ) {
			echo wp_kses_post( $this->output_fields( $settings['post_types'][ $tab ], $post_type ) );
		}
	}

	public function output_fields( $section = array(), $post_type = '' ) {
		$fields = array();
		if ( ! empty( $section ) ) {
			foreach ( $section as $field_id => $field ) {
				
				$field_html = '<tr class="form-field ' . sanitize_key( $field_id ) . '">';
				switch( $field['type'] ) {
					case 'checkbox':
						$field_html .= $this->checkbox_field( $field_id, $field, $post_type );
					break;

					case 'image':
						$field_html .= $this->image_field( $field_id, $field, $post_type );
					break;

					case 'select':
						$field_html .= $this->select_field( $field_id, $field, $post_type );
					break;

					case 'text':
					case 'number':
						$field_html .= $this->text_field( $field_id, $field, $post_type );
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
	public function select_field( $field_id, $args = array(), $post_type = '' ) {
		$defaults = array(
			'label'   => '',
			'desc'    => '',
			'default' => 0,
			'options' => array(),
		);
		$params = wp_parse_args( $args, $defaults );

		$field = array();

		// If this is a generated type.
		if ( '' !== $post_type ) {
			$field_id = $post_type . '_' . $field_id;
		}

		$field[] = '<th scope="row"><label for="' . $field_id . '">' . $params['label'] . '</label></th>';
		$field[] = '<td>';
		$field[] = '<select type="' . $params['type'] . '" name="' . $field_id . '" />';

		$selected = $this->get_value( $field_id, $params );

		foreach ( $params['options'] as $o_key => $o_val ) {
			$select_param = '';
			if ( $o_key === $selected ) {
				$select_param = 'selected="selected"';
			}
			$field[] = '<option ' . $select_param . ' value="' . $o_key . '">' . $o_val . '</option>';
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
	public function checkbox_field( $field_id, $args = array(), $post_type = '' ) {
		$defaults = array(
			'label'   => '',
			'desc'    => '',
			'default' => 0,
		);
		$params = wp_parse_args( $args, $defaults );

		$field = array();

		// If this is a generated type.
		if ( '' !== $post_type ) {
			$field_id = $post_type . '_' . $field_id;
		}

		$field[] = '<th scope="row"><label for="' . $field_id . '">' . $params['label'] . '</label></th>';
		$field[] = '<td>';

		$checked       = $this->get_value( $field_id, $params );
		$checked_param = '';
		if ( 1 === (int) $checked ) {
			$checked_param = 'checked="checked"';
		}

		$field[] = '<input ' . $checked_param . ' value="1" type="' . $params['type'] . '" name="' . $field_id . '" />';
		if ( '' !== $params['desc'] ) {
			$field[] = '<small>' . $params['desc'] . '</small>';
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
	public function text_field( $field_id, $args = array(), $post_type = '' ) {
		$defaults = array(
			'label'   => '',
			'desc'    => '',
			'default' => 0,
		);
		$params = wp_parse_args( $args, $defaults );

		$field = array();

		// If this is a generated type.
		if ( '' !== $post_type ) {
			$field_id = $post_type . '_' . $field_id;
		}

		$field[] = '<th scope="row"><label for="' . $field_id . '">' . $params['label'] . '</label></th>';
		$field[] = '<td>';

		$value = $this->get_value( $field_id, $params );

		$field[] = '<input value="' . $value . '" type="' . $params['type'] . '" name="' . $field_id . '" />';
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
	public function image_field( $field_id, $args = array(), $post_type = '' ) {
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

		// If this is a generated type.
		if ( '' !== $post_type ) {
			$field_id = $post_type . '_' . $field_id;
		}

		$field[] = '<th scope="row"><label for="' . $field_id . '">' . $params['label'] . '</label></th>';
		$field[] = '<td>';

		// Get the stored image
		$image_id = (int) $this->get_value( $field_id, $params );
		$image    = array( '' );
		$prev_css = 'display:none;';
		if ( 0 !== $image_id && '' !== $image_id ) {
			$image = wp_get_attachment_image_src( $image_id, 'medium' );
			$prev_css = '';
		}

		//hidden fields for the ID
		$field[] = '<input class="input_image" type="hidden" value="' . $image_id . '" name="' . $field_id . '" />';

		// Image Previews
		$field[] = '<div class="thumbnail-preview" style="' . $prev_css . '"><img src="' . $image[0] . '" width="' . $params['preview_w'] . '" style="color:black;" /></div>';

		// Action Buttons
		$add_css = '';
		$del_css = 'display:none;';
		if ( 0 !== $image_id && '' !== $image_id ) {
			$add_css = 'display:none;';
			$del_css = '';
		}

		$field[] = '<a style="' . $add_css . '" class="button-secondary lsx-thumbnail-image-add">' . $params['add_button'] . '</a>';
		$field[] = '<a style="' . $del_css . '" class="button-secondary lsx-thumbnail-image-delete">' . $params['del_button'] . '</a>';

		if ( '' !== $params['desc'] ) {
			$field[] = '<br /><small>' . $params['desc'] . '</small>';
		}
		$field[] = '</td>';
		
		return implode( '', $field );
	}

	/**
	 * Save the TO options.
	 *
	 * @return void
	 */
	public function save_settings() {
		if ( ! isset( $_GET['page'] ) ) {
			return;
		}

		$page = sanitize_key( $_GET['page'] );
		if ( 'lsx-to-settings' !== $page ) {
			return;
		}

		if ( ! isset( $_POST['lsx_to_nonce'] ) ) {
			return;
		}

		$nonce = sanitize_key( $_POST['lsx_to_nonce'] );
		if ( false === wp_verify_nonce( $nonce, 'lsx_to_settings_save' ) ) {
			return;
		}
		
		$settings_fields = $this->get_settings_fields();
		$settings_values = array();
		foreach ( $settings_fields as $section => $fields ) {
			if ( 'post_types' !== $section ) {
				foreach ( $fields as $key => $field ) {
					$save = '';
					if ( isset( $_POST[ $key ] ) ) {
						$save = $_POST[ $key ];
					} else if ( isset( $field['default'] ) ) {
						$save = $field['default'];
					}
	
					$settings_values[ $key ] = $save;
				}
			}
		}

		$settings_pages = tour_operator()->legacy->get_post_types();
		//Run through each post type
		foreach ( $settings_pages as $tab_index => $tab ) {

			//Loop through each of the post type sections
			foreach ( $settings_fields['post_types'] as $section => $fields ) {
				
				//Loop through each of the fields in the section.
				foreach ( $fields as $key => $field ) {
					$save = '';
					if ( isset( $_POST[ $tab_index . '_' . $key ] ) ) {
						$save = $_POST[ $tab_index . '_' . $key ];
					} else if ( isset( $field['default'] ) ) {
						$save = $field['default'];
					}
	
					$settings_values[ $tab_index . '_' . $key ] = $save;
				}
			}
		}

		if ( ! empty( $settings_values ) ) {
			update_option( 'lsx_to_settings', $settings_values );

			wp_safe_redirect( $_POST[ '_wp_http_referer' ] );
			exit;
		}
	}

	/**
	 * Get the value from the saved settings, or sets to the default.
	 *
	 * @param [type] $field_id
	 * @param [type] $params
	 * @return void
	 */
	public function get_value( $field_id, $params ) {
		$value = '';
		if ( isset( $params['default'] ) ) {
			$value = $params['default'];
		}
		if ( isset( $this->options[ $field_id ] ) ) {
			$value = $this->options[ $field_id ];
		}
		return $value;
	}
}
