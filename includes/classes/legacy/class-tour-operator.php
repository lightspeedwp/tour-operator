<?php
/**
 * @package   Tour_Operator
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeed
 **/

namespace lsx\legacy;

use stdClass;

// Setup the post connections.
class Tour_Operator {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 * @var      \lsx\Tour_Operator
	 */
	protected static $instance = null;

	/**
	 * Holds the array of options
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $options = false;

	/**
	 * Holds the LSX_TO_Framework class
	 *
	 * @since 1.0.0
	 * @var      object
	 */
	public $framework = false;

	/**
	 * Holds the array of post_types
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $base_post_types = array();

	/**
	 * Holds the array of post_types
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $post_types = array();

	/**
	 * Holds the array of post_types_singular
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $post_types_singular = array();

	/**
	 * Holds the array of taxonomies
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $base_taxonomies = array();

	/**
	 * Holds the array of taxonomies
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $taxonomies = array();
	/**
	 * Holds the array of taxonomies in Plural form.
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $taxonomies_plural = array();

	/**
	 * Holds the array of active post_types
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $active_post_types = array();

	/**
	 * Holds the array of connections from posts to posts
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $connections = null;
	/**
	 * Holds the array of single fields.
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $single_fields = null;

	/**
	 * Flags is out WETU Importer Plugin active.
	 *
	 * @since 1.0.0
	 * @var      array
	 */
	public $is_wetu_active = false;

	/**
	 * Holds an array of the post types you can assign Map Markers to.
	 *
	 * @since 1.1.5
	 *
	 * @var array
	 */
	public $map_post_type = array();

	/**
	 * Holds an array of the marker URLs
	 *
	 * @since 1.1.5
	 *
	 * @var object
	 */
	public $markers = false;

	/**
	 * Holds the Google API Key
	 *
	 * @var string
	 */
	public $google_api_key = false;

	/**
	 * Holds the textdomain slug.
	 *
	 * @var      array
	 */
	public $plugin_slug = 'tour-operator';

	/**
	 * Holds the Schema Class
	 *
	 * @var \lsx\legacy\Schema();
	 */
	public $schema = false;

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'disable_deprecated' ), 0 );
		add_action( 'plugins_loaded', array( $this, 'trigger_schema' ), 10 );

		// Set the options.
		$this->options = get_option( 'lsx_to_settings', array() );
		$this->set_vars();

		// Make TO last plugin to load.
		add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );

		// Add our action to init to set up our vars first.
		add_action( 'init', array( $this, 'require_post_type_classes' ), 1 );

		// init admin object.
		$this->admin = new Admin();
		// init frontend object.
		$this->frontend = new Frontend();

		// init placeholders.
		$this->placeholders = new Placeholders( array_keys( $this->post_types ) );

		add_action(
			'admin_init',
			array(
				$this,
				'register_activation_hook_check',
			)
		);
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function trigger_schema() {
		// Initiates the Schema.
		$this->schema = Schema::get_instance();
	}

	/**
	 * On plugin activation
	 *
	 * @since 1.0.0
	 */
	public static function register_activation_hook() {
		self::compatible_version_check_on_activation();
		// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! is_network_admin() && ! isset( $_GET['activate-multi'] ) ) {
			set_transient( '_tour_operators_flush_rewrite_rules', 1, 30 );
		}
		// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! is_network_admin() && ! isset( $_GET['activate-multi'] ) ) {
			set_transient( '_tour_operators_welcome_redirect', 1, 30 );
		}
	}

	/**
	 * On plugin activation (check)
	 *
	 * @since 1.0.0
	 */
	public function register_activation_hook_check() {
		if ( ! get_transient( '_tour_operators_flush_rewrite_rules' ) && ! get_transient( '_tour_operators_welcome_redirect' ) ) {
			return;
		}

		if ( get_transient( '_tour_operators_flush_rewrite_rules' ) ) {
			delete_transient( '_tour_operators_flush_rewrite_rules' );
			flush_rewrite_rules();
		}

		if ( get_transient( '_tour_operators_welcome_redirect' ) ) {
			delete_transient( '_tour_operators_welcome_redirect' );
			wp_safe_redirect( 'admin.php?page=lsx-to-settings&welcome-page=1' );
			exit();
		}
	}

	/**
	 * Disables any deprecated plugins.
	 *
	 * @return void
	 */
	public function disable_deprecated() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( defined( 'LSX_TO_MAPS_CORE' ) && is_plugin_active( plugin_basename( LSX_TO_MAPS_CORE ) ) ) {
			deactivate_plugins( plugin_basename( LSX_TO_MAPS_CORE ) );
		}
		if ( defined( 'LSX_TO_VIDEOS_CORE' ) && is_plugin_active( plugin_basename( LSX_TO_VIDEOS_CORE ) ) ) {
			deactivate_plugins( plugin_basename( LSX_TO_VIDEOS_CORE ) );
		}
	}



	/**
	 * Sets the variables for the class
	 */
	public function set_vars() {
		$this->post_types          = array(
			'destination'   => esc_html__( 'Destinations', 'tour-operator' ),
			'accommodation' => esc_html__( 'Accommodation', 'tour-operator' ),
			'tour'          => esc_html__( 'Tours', 'tour-operator' ),
		);

		$this->post_types_singular = array(
			'destination'   => esc_html__( 'Destination', 'tour-operator' ),
			'accommodation' => esc_html__( 'Accommodation', 'tour-operator' ),
			'tour'          => esc_html__( 'Tour', 'tour-operator' ),
		);

		$this->base_post_types     = $this->post_types;
		$this->post_types          = apply_filters( 'lsx_to_post_types', $this->post_types );
		$this->post_types_singular = apply_filters( 'lsx_to_post_types_singular', $this->post_types_singular );
		$this->active_post_types   = array_keys( $this->post_types );

		$this->taxonomies        = array(
			'travel-style'        => __( 'Travel Style', 'tour-operator' ),
			'accommodation-brand' => __( 'Brand', 'tour-operator' ),
			'accommodation-type'  => __( 'Accommodation Type', 'tour-operator' ),
			'facility'            => __( 'Facility', 'tour-operator' ),
			'continent'           => __( 'Continent', 'tour-operator' ),
			'region'              => __( 'Region', 'tour-operator' ),
		);

		$this->taxonomies_plural = array(
			'travel-style'        => __( 'Travel Styles', 'tour-operator' ),
			'accommodation-brand' => __( 'Brands', 'tour-operator' ),
			'accommodation-type'  => __( 'Accommodation Types', 'tour-operator' ),
			'facility'            => __( 'Facilities', 'tour-operator' ),
			'continent'           => __( 'Continents', 'tour-operator' ),
			'region'              => __( 'Regions', 'tour-operator' ),
		);

		$this->base_taxonomies   = $this->taxonomies;
		$this->taxonomies        = apply_filters( 'lsx_to_framework_taxonomies', $this->taxonomies );
		$this->taxonomies_plural = apply_filters( 'lsx_to_framework_taxonomies_plural', $this->taxonomies_plural );

		$this->set_map_vars();
	}

	/**
	 * Set the map related variables.
	 *
	 * @return void
	 */
	public function set_map_vars() {
		return;
		$this->map_post_types = array( 'accommodation', 'activity', 'destination' );
		$this->markers        = new \stdClass();

		if ( ( false !== $this->options && isset( $this->options['googlemaps_key'] ) ) || defined( 'GOOGLEMAPS_API_KEY' ) ) {
			if ( ! defined( 'GOOGLEMAPS_API_KEY' ) ) {
				$this->google_api_key = $this->options['googlemaps_key'];
			} else {
				$this->google_api_key = GOOGLEMAPS_API_KEY;
			}
		} else {
			$this->google_api_key = false;
		}

		if ( isset( $this->options['googlemaps_marker'] ) && '' !== $this->options['googlemaps_marker'] ) {
			$this->markers->default_marker = $this->options['googlemaps_marker'];
		} else {
			$this->markers->default_marker = LSX_TO_URL . 'assets/img/markers/gmaps-mark.svg';
		}

		if ( isset( $this->options['gmap_cluster_small'] ) && '' !== $this->options['gmap_cluster_small'] ) {
			$this->markers->cluster_small = $this->options['gmap_cluster_small'];
		} else {
			$this->markers->cluster_small = LSX_TO_URL . 'assets/img/markers/m1.png';
		}

		if ( isset( $this->options['gmap_cluster_medium'] ) && '' !== $this->options['gmap_cluster_medium'] ) {
			$this->markers->cluster_medium = $this->options['gmap_cluster_medium'];
		} else {
			$this->markers->cluster_medium = LSX_TO_URL . 'assets/img/markers/m2.png';
		}

		if ( isset( $this->options['gmap_cluster_large'] ) && '' !== $this->options['gmap_cluster_large'] ) {
			$this->markers->cluster_large = $this->options['gmap_cluster_large'];
		} else {
			$this->markers->cluster_large = LSX_TO_URL . 'assets/img/markers/m3.png';
		}

		if ( isset( $this->options['gmap_marker_start'] ) && '' !== $this->options['gmap_marker_start'] ) {
			$this->markers->start = $this->options['gmap_marker_start'];
		} else {
			$this->markers->start = LSX_TO_URL . 'assets/img/markers/start-marker.png';
		}

		if ( isset( $this->options['gmap_marker_end'] ) && '' !== $this->options['gmap_marker_end'] ) {
			$this->markers->end = $this->options['gmap_marker_end'];
		} else {
			$this->markers->end = LSX_TO_URL . 'assets/img/markers/end-marker.png';
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.0.1
	 */
	public function get_active_post_types() {
		return $this->active_post_types;
	}

	/**
	 * Requires the post type classes
	 *
	 * @since 0.0.1
	 */
	public function require_post_type_classes() {
		foreach ( $this->post_types as $post_type => $label ) {
			if ( class_exists( "lsx\\legacy\\{$post_type}" ) ) {
				$this->$post_type = call_user_func_array( array( "lsx\\legacy\\{$post_type}", 'get_instance' ), array() );
			}
		}

		$this->connections   = $this->create_post_connections();
		$this->single_fields = apply_filters( 'lsx_to_search_fields', array() );
	}

	/**
	 * Generates the post_connections used in the metabox fields
	 */
	public function create_post_connections() {
		$connections = array();
		$post_types  = apply_filters( 'lsx_to_post_types', $this->post_types );

		foreach ( $post_types as $key_a => $values_a ) {
			foreach ( $this->post_types as $key_b => $values_b ) {
				// Make sure we dont try connect a post type to itself.
				if ( $key_a !== $key_b ) {
					$connections[] = $key_a . '_to_' . $key_b;
				}
			}
		}

		return $connections;
	}

	/**
	 * Adds our post types to an array via a filter.
	 *
	 * @param array $post_types List of posttypes being used.
	 *
	 * @return array Altered list of post types with added items.
	 */
	public function post_types_filter( $post_types ) {
		if ( is_array( $post_types ) ) {
			$post_types = array_merge( $post_types, $this->post_types );
		} else {
			$post_types = $this->post_types;
		}

		return $post_types;
	}

	/**
	 * Returns the post types for use in the addons.
	 *
	 * @return array List of taxonomies.
	 */
	public function get_taxonomies() {
		return apply_filters( 'lsx_to_framework_taxonomies', $this->taxonomies );
	}

	/**
	 * Returns the post types for use in the addons.
	 *
	 * @return array List of post types.
	 */
	public function get_post_types() {
		return $this->post_types;
	}

	/**
	 * Adds our taxonomies to an array via a filter
	 *
	 * @param array $taxonomies List of taxonomies to add to.
	 *
	 * @return array List of altered taxonomies.
	 */
	public function taxonomies_filter( $taxonomies ) {
		if ( is_array( $taxonomies ) ) {
			$taxonomies = array_merge( $taxonomies, $this->taxonomies );
		} else {
			$taxonomies = $this->taxonomies;
		}

		return $taxonomies;
	}

	/**
	 * Make TO last plugin to load.
	 */
	public function activated_plugin() {
		$plugins = get_option( 'active_plugins' );

		if ( false != $plugins ) {
			$search = preg_grep( '/.*\/tour-operator\.php/', $plugins );
			$key    = array_search( $search, $plugins );

			if ( is_array( $search ) && count( $search ) ) {
				foreach ( $search as $key => $path ) {
					array_splice( $plugins, $key, 1 );
					array_push( $plugins, $path );
					update_option( 'active_plugins', $plugins );
				}
			}
		}
	}
}
