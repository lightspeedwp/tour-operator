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
	public $post_types = [
		'tour',
		'accommodation',
		'destination',
	];

	public $image_sizes = [
		'lsx-to-card-list' => [
			'title'  => 'TO Card (list)',
			'ratio'  => '1:1',
			'width'  => 300,
			'height' => 300,
			'crop'   => true
		],
		'lsx-to-card-grid' => [
			'title'  => 'TO Card (grid)',
			'ratio'  => '3:2',
			'width'  => 400,
			'height' => 250,
			'crop'   => true
		],
		'lsx-to-gallery' => [
			'title'  => 'TO Gallery',
			'ratio'  => '3:2',
			'width'  => 900,
			'height' => 600,
			'crop'   => true
		],
		'lsx-to-banner' => [
			'title'  => 'TO Banner',
			'ratio'  => '5:2',
			'width'  => 1440,
			'height' => 600,
			'crop'   => true
		]
	];

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'init', array( $this, 'register_meta_with_rest' ) );
		add_action( 'init', array( $this, 'register_image_sizes' ) );
		add_filter( 'image_size_names_choose', array( $this, 'editor_image_sizes' ), 10, 1 );
		add_action( 'cmb2_admin_init', array( $this, 'register_cmb2_fields' ) );

		// Allow extra tags and attributes to wp_kses_post().
		add_filter(
			'wp_kses_allowed_html',
			array(
				$this,
				'wp_kses_allowed_html',
			),
			10,
			2
		);
		// Allow extra protocols to wp_kses_post().
		add_filter(
			'kses_allowed_protocols',
			array(
				$this,
				'kses_allowed_protocols',
			)
		);
		// Allow extra style attributes to wp_kses_post().
		add_filter( 'safe_style_css', array( $this, 'safe_style_css' ) );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.0.1
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'tour-operator', false, basename( LSX_TO_PATH ) . '/languages' );
	}

	/**
	 * Register our sticky posts and disable_single meta fields with rest.
	 *
	 * @return void
	 */
	public function register_meta_with_rest() {
		add_filter('acf/settings/remove_wp_meta_box', '__return_false');
		
		register_meta(
			'post',
			'featured',
			array(
				'type'         => 'boolean',
				'single'       => true,
				'show_in_rest' => true
			)
		);

		register_meta(
			'post',
			'disable_single',
			array(
				'type'         => 'boolean',
				'single'       => true,
				'show_in_rest' => true
			)
		);
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
		$cmb = [];
		foreach ( $this->post_types as $post_type ) {
			$fields = $this->get_custom_fields( $post_type );

			$metabox_counter = 1;
			$cmb[ $metabox_counter ] = new_cmb2_box( array(
				'id'            => 'lsx_to_metabox_' . $post_type . '_' . $metabox_counter,
				'title'         => $fields['title'],
				'object_types'  => array( $post_type ), // Post type
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
			) );

			foreach ( $fields['fields'] as $field ) {

				if ( 'title' === $field['type'] ) {
					$metabox_counter++;
					$cmb[ $metabox_counter ] = new_cmb2_box( array(
						'id'            => 'lsx_to_metabox_' . $post_type . '_' . $metabox_counter,
						'title'         => $field['name'],
						'object_types'  => array( $post_type ), // Post type
						'context'       => 'normal',
						'priority'      => 'high',
						'show_names'    => true,
					) );
					continue;
				}

				/**
				 * Fixes for the extensions
				 */
				if ( 'post_select' === $field['type'] || 'post_ajax_search' === $field['type'] ) {
					$field['type'] = 'pw_multiselect';
				}

				$cmb[ $metabox_counter ]->add_field( $field );
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

	/**
	 * Allow extra tags and attributes to wp_kses_post()
	 */
	public function wp_kses_allowed_html( $allowedtags, $context ) {
		if ( ! isset( $allowedtags['i'] ) ) {
			$allowedtags['i'] = array();
		}
		$allowedtags['i']['aria-hidden']    = true;

		if ( ! isset( $allowedtags['span'] ) ) {
			$allowedtags['span'] = array();
		}

		$allowedtags['span']['aria-hidden'] = true;

		if ( ! isset( $allowedtags['button'] ) ) {
			$allowedtags['button'] = array();
		}

		$allowedtags['button']['aria-label']   = true;
		$allowedtags['button']['data-dismiss'] = true;

		if ( ! isset( $allowedtags['li'] ) ) {
			$allowedtags['li'] = array();
		}

		$allowedtags['li']['data-target']   = true;
		$allowedtags['li']['data-slide-to'] = true;

		if ( ! isset( $allowedtags['a'] ) ) {
			$allowedtags['a'] = array();
		}

		
		$allowedtags['a']['target']             = true;
		$allowedtags['a']['data-toggle']             = true;
		$allowedtags['a']['data-target']             = true;
		$allowedtags['a']['data-slide']              = true;
		$allowedtags['a']['data-collapsed']          = true;
		$allowedtags['a']['data-envira-caption']     = true;
		$allowedtags['a']['data-envira-retina']      = true;
		$allowedtags['a']['data-thumbnail']          = true;
		$allowedtags['a']['data-mobile-thumbnail']   = true;
		$allowedtags['a']['data-envirabox-type']     = true;
		$allowedtags['a']['data-video-width']        = true;
		$allowedtags['a']['data-video-height']       = true;
		$allowedtags['a']['data-video-aspect-ratio'] = true;

		if ( ! isset( $allowedtags['h2'] ) ) {
			$allowedtags['h2'] = array();
		}

		$allowedtags['h2']['data-target'] = true;
		$allowedtags['h2']['data-toggle'] = true;

		if ( ! isset( $allowedtags['div'] ) ) {
			$allowedtags['div'] = array();
		}

		$allowedtags['div']['aria-labelledby']                      = true;
		$allowedtags['div']['data-interval']                        = true;
		$allowedtags['div']['data-icon']                            = true;
		$allowedtags['div']['data-id']                              = true;
		$allowedtags['div']['data-class']                           = true;
		$allowedtags['div']['data-long']                            = true;
		$allowedtags['div']['data-lat']                             = true;
		$allowedtags['div']['data-zoom']                            = true;
		$allowedtags['div']['data-link']                            = true;
		$allowedtags['div']['data-thumbnail']                       = true;
		$allowedtags['div']['data-title']                           = true;
		$allowedtags['div']['data-type']                            = true;
		$allowedtags['div']['data-cluster-small']                   = true;
		$allowedtags['div']['data-cluster-medium']                  = true;
		$allowedtags['div']['data-cluster-large']                   = true;
		$allowedtags['div']['data-fusion-tables']                   = true;
		$allowedtags['div']['data-fusion-tables-colour-border']     = true;
		$allowedtags['div']['data-fusion-tables-width-border']      = true;
		$allowedtags['div']['data-fusion-tables-colour-background'] = true;
		$allowedtags['div']['itemscope']                            = true;
		$allowedtags['div']['itemtype']                             = true;
		$allowedtags['div']['data-row-height']                      = true;
		$allowedtags['div']['data-justified-margins']               = true;
		$allowedtags['div']['data-slick']                           = true;

		//Envirta Gallery tags
		//
		$allowedtags['div']['data-envira-id']                       = true;
		$allowedtags['div']['data-gallery-config']                  = true;
		$allowedtags['div']['data-gallery-images']                  = true;
		$allowedtags['div']['data-gallery-theme']                   = true;
		$allowedtags['div']['data-envira-columns']                  = true;

		if ( ! isset( $allowedtags['img'] ) ) {
			$allowedtags['img'] = array();
		}

		$allowedtags['img']['data-envira-index']      = true;
		$allowedtags['img']['data-envira-caption']    = true;
		$allowedtags['img']['data-envira-gallery-id'] = true;
		$allowedtags['img']['data-envira-item-id']    = true;
		$allowedtags['img']['data-envira-src']        = true;
		$allowedtags['img']['data-envira-srcset']     = true;

		if ( ! isset( $allowedtags['input'] ) ) {
			$allowedtags['input'] = array();
		}

		$allowedtags['input']['type']    = true;
		$allowedtags['input']['id']      = true;
		$allowedtags['input']['name']    = true;
		$allowedtags['input']['value']   = true;
		$allowedtags['input']['size']    = true;
		$allowedtags['input']['checked'] = true;
		$allowedtags['input']['onclick'] = true;
		$allowedtags['input']['class'] = true;
		$allowedtags['input']['placeholder'] = true;
		$allowedtags['input']['autocomplete'] = true;

		if ( ! isset( $allowedtags['select'] ) ) {
			$allowedtags['select'] = array();
		}

		$allowedtags['select']['name']     = true;
		$allowedtags['select']['id']       = true;
		$allowedtags['select']['disabled'] = true;
		$allowedtags['select']['onchange'] = true;

		if ( ! isset( $allowedtags['option'] ) ) {
			$allowedtags['option'] = array();
		}

		$allowedtags['option']['value']    = true;
		$allowedtags['option']['selected'] = true;

		if ( ! isset( $allowedtags['iframe'] ) ) {
			$allowedtags['iframe'] = array();
		}

		$allowedtags['iframe']['src']             = true;
		$allowedtags['iframe']['width']           = true;
		$allowedtags['iframe']['height']          = true;
		$allowedtags['iframe']['frameborder']     = true;
		$allowedtags['iframe']['allowfullscreen'] = true;
		$allowedtags['iframe']['style']           = true;

		if ( ! isset( $allowedtags['noscript'] ) ) {
			$allowedtags['noscript'] = array();
		}

		return $allowedtags;
	}

	/**
	 * Allow extra protocols to wp_kses_post()
	 */
	public function kses_allowed_protocols( $allowedprotocols ) {
		$allowedprotocols[] = 'tel';

		return $allowedprotocols;
	}

	/**
	 * Allow extra style attributes to wp_kses_post()
	 */
	public function safe_style_css( $allowedstyles ) {
		$allowedstyles[] = 'display';
		$allowedstyles[] = 'background-image';

		return $allowedstyles;
	}

	/**
	 * Register the image sizes with WordPress
	 *
	 * @return void
	 */
	public function register_image_sizes() {
		foreach ( $this->image_sizes as $key => $params ) {
			add_image_size( $key, $params['width'], $params['height'], $params['crop'] );
		}
	}

	/**
	 * The array of image sizes from WordPress
	 *
	 * @param array $sizes
	 * @return array
	 */
	public function editor_image_sizes( $sizes ) {
		$new_sizes = [];
		foreach ( $this->image_sizes as $key => $params ) {
			$new_sizes[ $key ] = $params['title'];
		}
		return array_merge( $sizes, $new_sizes );
	}
}