<?php

namespace lsx;

use lsx\admin\Admin;
use lsx\admin\Pages;
use lsx\admin\Settings;
use lsx\admin\Setup;
use lsx\blocks\Bindings;
use lsx\blocks\Patterns;
use lsx\blocks\Registration;
use lsx\blocks\Templates;

/**
 * LSX Tour Operator Main Class
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */
class Tour_Operator {

	/**
	 * Holds instance of the class
	 *
	 * @since   1.1.0
	 * @var     \lsx\Tour_Operator
	 */
	private static $instance;

	/**
	 * Holds request data
	 *
	 * @since   1.1.0
	 * @var     array
	 */
	public $request_data;

	/**
	 * Holds the main admin page suffix
	 *
	 * @since   1.1.0
	 * @var     \lsx\admin\Admin
	 */
	public $admin;

	/**
	 * Holds the main settings object
	 *
	 * @since   1.1.0
	 * @var     \lsx\admin\Settings
	 */
	public $settings;

	/**
	 * Holds the main setup object
	 *
	 * @since   1.1.0
	 * @var     \lsx\admin\Setup
	 */
	public $setup;

	/**
	 * Holds the Pages instance.
	 *
	 * @since   1.1.0
	 * @var     \lsx\admin\Pages
	 */
	public $pages;

	/**
	 * Holds the Taxonomies instance.
	 *
	 * @since   1.1.0
	 * @var     \lsx\Taxonomies
	 */
	public $taxonomies;

	/**
	 * Holds an array of current assets.
	 *
	 * @since   1.1.0
	 * @var     array
	 */
	public $assets;
	/**
	 * Holds the legacy object.
	 *
	 * @since   1.1.0
	 * @var     \lsx\legacy\Tour_Operator
	 */
	public $legacy;

	/**
	 * LSX Tour Operator constructor.
	 */
	public function __construct() {
		// init legacy.
		$this->legacy = legacy\Tour_Operator::get_instance();
		// Setup plugin.
		add_action( 'init', array( $this, 'setup' ), 9 );
	}

	/**
	 * Magic helper to call from legacy.
	 *
	 * @param string $tag  Tag to call.
	 * @param array  $args Callable arguments.
	 *
	 * @return mixed Legacy callback return.
	 */
	public function __call( $tag, $args ) {
		if ( is_callable( array( $this->legacy, $tag ) ) ) {
			return call_user_func_array( array( $this->legacy, $tag ), $args );
		}

		return null;
	}

	/**
	 * Magic helper to get from legacy.
	 *
	 * @param string $tag Tag to get.
	 *
	 * @return mixed Legacy callback return.
	 */
	public function __get( $tag ) {
		return $this->legacy->{$tag};
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
	 * Set request vars
	 *
	 * @param array $request_data Array of request variables.
	 *
	 * @since 1.1.0
	 */
	public function set_request_data( $request_data ) {
		$this->request_data = $request_data;
	}

	/**
	 * Enqueue a set of styles and scripts.
	 *
	 * @since  1.1.0
	 *
	 * @param string $type The type of asset.
	 * @param array  $set  Array of assets to be enqueued.
	 */
	public function set_assets( $type, $set ) {
		if ( 'callback' === $type ) {
			call_user_func( $set );
		} else {
			$enqueue_type = 'wp_enqueue_' . $type;
			foreach ( $set as $key => $item ) {
				if ( is_int( $key ) ) {
					$enqueue_type( $item );
					continue;
				}
				$args = $this->build_asset_args( $item );
				$enqueue_type( $key, $args['src'], $args['deps'], $args['ver'], $args['in_footer'] );
			}
		}
	}


	/**
	 * Checks the asset type
	 *
	 * @since  1.1.0
	 *
	 * @param array|string $asset Asset structure, slug or path to build.
	 *
	 * @return array Params for enqueuing the asset
	 */
	private function build_asset_args( $asset ) {
		// Setup default args for array type includes.
		$args = array(
			'src'       => $asset,
			'deps'      => array(),
			'ver'       => false,
			'in_footer' => false,
			'media'     => false,
		);
		if ( is_array( $asset ) ) {
			$args = array_merge( $args, $asset );
		}

		return $args;
	}

	/**
	 * Setup hooks and text load domain
	 *
	 * @since 1.1.0
	 * @uses  "init" action
	 */
	public function setup() {
		load_plugin_textdomain( 'tour-operator', false, LSX_TO_CORE . '/languages' );
		$this->pages      = Pages::init();
		$this->taxonomies = Taxonomies::init();
		$this->admin      = new Admin();
		$this->settings   = Settings::init();
		$this->setup      = new Setup();
		$this->bindings   = new Bindings();
		$this->registration = new Registration();
		$this->patterns   = new Patterns();
		$this->templates   = new Templates();
	}
}
