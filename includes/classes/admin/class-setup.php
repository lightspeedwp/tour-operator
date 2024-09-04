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
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
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

	public function register_meta_with_rest() {

		add_filter('acf/settings/remove_wp_meta_box', '__return_false');
	
		$fields = array(
			//Not needed
			'included'     => array(),
			'not_included' => array(),
	
			//Search.
			'duration'     => array(),
			'price'        => array(),
	
			//Post Connections.
		);
		$defaults = array(
			'default' => '',
			'single' => true,
			'type' => 'string',
		);
		foreach ( $fields as $key => $args ) {
			$args = wp_parse_args( $args, $defaults );
			register_meta(
				'post',
				$key,
				array(
					'show_in_rest' => true,
					'single'       => $args['single'],
					'type'         => $args['type'],
					'default'      => $args['default'],
				)
			);
		}
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

		$post_types = array(
			'tour',
			'accommodation',
			'destination',
		);

		foreach ( $post_types as $post_type ) {
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
				if ( 'post_select' === $field['type'] ) {
					$field['type'] = 'post_ajax_search';
				}

				$cmb->add_field( $field );
			}
		}
	
		/*$cmb->add_field( array(
			'id'         => 'departs_from',
			'name'       => esc_html__( 'Departs From', 'tour-operator' ),
			'type'       => 'post_ajax_search',
			'query_args'      => array(
				'post_type'      => 'destination',
				'nopagin'        => true,
				'posts_per_page' => '-1',
				'orderby'        => 'title',
				'order'          => 'ASC',
			),
		) );
	
		$cmb->add_field( array(
			'id'         => 'ends_in',
			'name'       => esc_html__( 'Ends In', 'tour-operator' ),
			'type'       => 'post_ajax_search',
			'query_args'      => array(
				'post_type'      => 'destination',
				'nopagin'        => true,
				'posts_per_page' => '-1',
				'orderby'        => 'title',
				'order'          => 'ASC',
			),
		) );
	
		$cmb->add_field( array(
			'id'       => 'best_time_to_visit',
			'name'     => esc_html__( 'Best months to visit', 'tour-operator' ),
			'type'     => 'multicheck',
			'options'  => array(
				'january'   => 'January',
				'february'  => 'February',
				'march'     => 'March',
				'april'     => 'April',
				'may'       => 'May',
				'june'      => 'June',
				'july'      => 'July',
				'august'    => 'August',
				'september' => 'September',
				'october'   => 'October',
				'november'  => 'November',
				'december'  => 'December',
			),
		));*/
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