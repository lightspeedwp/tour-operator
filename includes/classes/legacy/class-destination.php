<?php
/**
 * Destination Class
 *
 * @package   Destination
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package Destination
 * @author  LightSpeed
 */
class Destination {

	/**
	 * The slug for this plugin
	 *
	 * @since 1.0.0
	 * @var      string
	 */
	protected $slug = 'destination';

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Holds the option screen prefix
	 *
	 * @since 1.0.0
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function __construct() {
		$this->options = get_option( '_lsx-to_settings', false );

		add_action( 'lsx_to_map_meta', array( $this, 'content_meta' ) );
		add_action( 'lsx_to_modal_meta', array( $this, 'content_meta' ) );
		add_filter( 'lsx_to_parents_only', array( $this, 'filter_countries' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Outputs the destination meta
	 */
	public function content_meta() {
		if ( 'destination' === get_post_type() ) { ?>
			<?php
				$meta_class = 'lsx-to-meta-data lsx-to-meta-data-';

				the_terms( get_the_ID(), 'travel-style', '<span class="' . $meta_class . 'style"><span class="lsx-to-meta-data-key">' . esc_html__( 'Travel Style', 'tour-operator' ) . ':</span> ', ', ', '</span>' );

				if ( function_exists( 'lsx_to_connected_activities' ) ) {
					lsx_to_connected_activities( '<span class="' . $meta_class . 'activities"><span class="lsx-to-meta-data-key">' . esc_html__( 'Activities', 'tour-operator' ) . ':</span> ', '</span>' );
				}
			?>
		<?php 
        }
	}

	/**
	 * Only return the upper lever countries
	 */
	public function filter_countries( $countries = array() ) {
		if ( ! empty( $countries ) ) {
			$new_items = array();
			foreach ( $countries as $country ) {
				$temp_parent = wp_get_post_parent_id( $country );
				if ( 0 === $temp_parent || '0' === $temp_parent ) {
					$new_items[] = $country;
				}
			}
			$countries = array_reverse( $new_items );
		}
		return $countries;
	}
}
