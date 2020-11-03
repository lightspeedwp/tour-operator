<?php
/**
 * LSX Banners Main Class
 *
 * @package   LSX Banners
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeed
 */
class TO_Banners {

	/**
	 * Holds class instance
	 *
	 * @var      object|Lsx_Banners
	 */
	protected static $instance = null;

	/**
	 * Holds the name of the theme
	 *
	 * @var      string|Lsx_Banners
	 */
	public $theme = null;

	/**
	 * Holds a boolean weather or not to use placeholdit.
	 *
	 * @var      string|Lsx_Banners
	 */
	public $placeholder = false;

	/**
	 * Holds the current objects ID
	 *
	 * @var      string|Lsx_Banners
	 */
	public $post_id = false;

	/**
	 * Holds the current banner ID
	 *
	 * @var      string|Lsx_Banners
	 */
	public $banner_id = false;

	/**
	 * Runs on the body_class, to let you know if there is a banner or not.
	 *
	 * @var      string|Lsx_Banners
	 */
	public $has_banner = false;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->options = get_option( '_lsx_settings', false );
		if ( false === $this->options ) {
			$this->options = get_option( '_lsx_lsx-settings', false );
		}
		$this->set_vars();

		if ( ! class_exists( 'TO_Taxonomy_Admin' ) ) {
			require_once( TO_BANNERS_PATH . 'class-lsx-taxonomy-admin.php' );
		}

		if ( ! class_exists( 'TO_Placeholders' ) ) {
			require_once( TO_BANNERS_PATH . 'class-lsx-placeholders.php' );
			add_action( 'init', array( $this, 'init_placeholders' ), 100 );
		}
		require_once( TO_BANNERS_PATH . 'class-lsx-banners-admin.php' );
		if ( class_exists( 'TO_Banners_Admin' ) ) {
			$this->admin = new TO_Banners_Admin();
		}
		require_once( TO_BANNERS_PATH . 'class-lsx-banners-frontend.php' );
		if ( class_exists( 'TO_Banners_Frontend' ) ) {
			$this->frontend = new TO_Banners_Frontend();
		}

		require_once( TO_BANNERS_PATH . 'template-tags.php' );
	}

	/**
	 * Set the variables.
	 */
	public function set_vars() {
	}

	/**
	 * Set the placeholders
	 */
	public function init_placeholders() {
		$this->placeholders = new TO_Placeholders( $this->get_allowed_post_types() );
	}


	/**
	 * Retreives the allowed post types
	 *
	 * @return array
	 */
	public function get_allowed_post_types() {
		// Example of all available fields.
		$allowed_post_types = array( 'page', 'post' );
		if ( in_array( 'jetpack-portfolio', get_post_types() ) ) {
			$allowed_post_types[] = 'jetpack-portfolio';
		}
		return apply_filters( 'lsx_banner_allowed_post_types', $allowed_post_types );
	}

	/**
	 * Retreives the allowed taxonomies
	 *
	 * @return array
	 */
	public function get_allowed_taxonomies() {
		// Example of all available fields.
		$allowed_taxonomies = array( 'category' );
		return apply_filters( 'lsx_banner_allowed_taxonomies', $allowed_taxonomies );
	}

	/**
	 * Returns the defulat placeholder url
	 */
	public function default_placeholder( $url ) {
		$post_type = get_post_type();
		$default_id = false;
		if ( class_exists( 'Placeholders_Options' ) ) {
			$placeholders = Placeholders_Options::get_single( 'placeholders' );
			if ( false !== $placeholders && is_array( $placeholders ) && isset( $placeholders['image'] ) ) {
				foreach ( $placeholders['image'] as $placeholder ) {
					if ( isset( $placeholder['post_type'] ) && $post_type === $placeholder['post_type'] && isset( $placeholder['image'] ) ) {
						$url = $placeholder['image']['selection']['url'];
					}
				}
			}
		}
		return $url;
	}
}
