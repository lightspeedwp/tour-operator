<?php
/**
 * LSX Tour Operator - Pages Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

namespace lsx\admin;

/**
 * Registers our Custom Fields
 *
 * @package lsx
 * @author  LightSpeed
 */
class Setup {

	/**
	 * Holds instance of the class
	 *
	 * @since   1.1.0
	 * @var     \lsx\admin\Setup
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
	 * Holds the array of core post types
	 *
	 * @since   1.1.0
	 * @var     array
	 */
	public $post_types;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->post_types = array(
			'tour',
			'accommodation',
			'destination',
		);
		add_action( 'init', array( $this, 'register_meta_with_rest' ) );
		add_action( 'cmb2_admin_init', array( $this, 'register_cmb2_fields' ) );
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
	 * TODO: Remove this function when sure we dont need to register our rest fields.
	 *
	 * @return void
	 */
	public function register_meta_with_rest() {

		add_filter('acf/settings/remove_wp_meta_box', '__return_false');
		/*
		foreach ( $this->post_types as $post_type ) {
			$fields = $this->get_custom_fields( $post_type );

			foreach ( $fields['fields'] as $key => $field ) {

				if ( 'title' === $field['type'] ) {
					continue;
				}

				$args = array(
					'show_in_rest' => true,
					'single'       => true,
				);

				switch ( $field['type'] ) {
					case 'text':
					case 'post_ajax_search':
					case 'multicheck':
					case 'wysiwyg':
					case 'text_date_timestamp':
					case 'file':
					case 'select':
					case 'radio':
						$args['type'] = 'string';	
					break;

					case 'number':
					case 'image':
						$args['type'] = 'number';
					break;

					case 'checkbox':
						$args['type'] = 'boolean';	
					break;

					case 'group':
						$args['type']   = 'string';
						$args['single'] = false;
					break;

					case 'gmap':
						$args['type']   = 'string';
					break;	

					default:
						$args['type']   = 'string';
					break;
				}

				if ( isset( $field['desc'] ) && ! empty( $field['desc'] ) ) {
					$args['description'] = $field['desc'];
				}

				if ( isset( $field['default'] ) && ! empty( $field['default'] ) ) {
					$args['default'] = $field['default'];
				}
	
				$registered = register_meta(
					'post',
					$field['id'],
					$args
				);
			}
		}
		*/
	}

	/**
	 * Registers the CMB2 custom fields
	 *
	 * @return void
	 */
	public function register_cmb2_fields() {
		/**
		 * Initiate the metabox
		 */
		foreach ( $this->post_types as $post_type ) {
			$fields = $this->get_custom_fields( $post_type );

			$cmb = new_cmb2_box( array(
				'id'            => 'lsx_to_metabox_' . $post_type,
				'title'         => $fields['title'],
				'object_types'  => array( $post_type ), // Post type
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
			) );

			foreach ( $fields['fields'] as $field ) {

				/**
				 * Fixes for the extensions
				 */
				if ( 'post_select' === $field['type'] || 'post_ajax_search' === $field['type'] ) {
					$field['type'] = 'pw_multiselect';
				}

				$cmb->add_field( $field );
			}
		}
	}

	/**
	 * Gets the field files.
	 *
	 * @param string $type
	 * @return array
	 */
	public function get_custom_fields( $type = '' ) {
		$fields = array();
		if ( '' !== $type ) {
			$fields = include( LSX_TO_PATH . 'includes/metaboxes/config-' . $type . '.php' );
		}
		return $fields;
	}
}