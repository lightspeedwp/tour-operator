<?php

namespace lsx;

use lsx\admin\Admin;
use lsx\admin\Settings;
use lsx\admin\Setup;
use lsx\admin\Permalinks;
use lsx\admin\Post_Expiration;
use lsx\blocks\Bindings;
use lsx\blocks\Patterns;
use lsx\blocks\Query_Loop;
use lsx\blocks\Registration;
use lsx\blocks\Templates;
use lsx\integrations\facetwp\Post_Connections;

/**
 * Tour Operator Main Class
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
	 * @var     \lsx\Tour_Operator
	 */
	private static $instance;

	/**
	 * Holds request data
	 *
	 * @var     array
	 */
	public $request_data;

	/**
	 * Holds an array of current assets.
	 *
	 * @var     array
	 */
	public $assets;

	/**
	 * Holds the legacy object.
	 *
	 * @var     \lsx\legacy\Tour_Operator
	 */
	public $legacy;

	/**
	 * Holds an array of current classes.
	 *
	 * @var     array
	 */
	public $classes;

	/**
	 * Tour Operator constructor.
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
		require_once( LSX_TO_PATH . 'vendor/content-models/create-content-model.php' );

		$this->classes['permalinks']      = new Permalinks();
		$this->classes['taxonomies']      = Taxonomies::init();
		$this->classes['admin']           = new Admin();
		$this->classes['settings']        = Settings::init();
		$this->classes['setup']           = new Setup();
		$this->classes['bindings']        = Bindings::get_instance();
		$this->classes['registration']    = Registration::get_instance();
		$this->classes['patterns']        = Patterns::get_instance();
		$this->classes['templates']       = Templates::get_instance();
		$this->classes['query_loop']      = Query_Loop::get_instance();
		$this->classes['post_expiration'] = new Post_Expiration();

		// Files that wont load with the badly written spl_autoregister function.
		require_once LSX_TO_PATH . 'includes/classes/class-post-connections.php';
		$this->classes['post_connections'] = new Post_Connections();
	}
}
