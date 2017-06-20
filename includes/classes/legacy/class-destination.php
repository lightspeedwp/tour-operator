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
	 * Holds the $page_links array while its being built on the single
	 * accommodation page.
	 *
	 * @since 0.0.1
	 * @var      array
	 */
	public $page_links = false;

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function __construct() {
		$this->options = get_option( '_lsx-to_settings', false );

		if ( ! is_admin() ) {
			add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		}
		add_filter( 'lsx_to_entry_class', array( $this, 'entry_class' ) );

		add_action( 'lsx_to_map_meta', array( $this, 'content_meta' ) );
		add_action( 'lsx_to_modal_meta', array( $this, 'content_meta' ) );

		add_action( 'lsx_to_framework_destination_tab_general_settings_bottom', array(
			$this,
			'general_settings',
		), 10, 1 );

		add_filter( 'lsx_to_page_navigation', array( $this, 'page_links' ) );

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
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Set the main query to pull through only the top level destinations.
	 *
	 * @param $query object
	 *
	 * @return object
	 */
	function pre_get_posts( $query ) {
		if ( $query->is_main_query() && $query->is_post_type_archive( $this->slug ) ) {
			$query->set( 'post_parent', '0' );
			$query->set( 'posts_per_page', '-1' );
			$query->set( 'nopagin', true );
			$query->set( 'orderby', 'title' );
		}

		return $query;
	}

	/**
	 * A filter to set the content area to a small column on single
	 *
	 * @param $classes array
	 *
	 * @return array
	 */
	public function entry_class( $classes ) {
		global $lsx_to_archive;
		if ( 1 !== $lsx_to_archive ) {
			$lsx_to_archive = false;
		}
		if ( is_main_query() && is_singular( $this->slug ) && false === $lsx_to_archive ) {
			if ( lsx_to_has_enquiry_contact() ) {
				$classes[] = 'col-sm-9';
			} else {
				$classes[] = 'col-sm-12';
			}
		}

		return $classes;
	}

	/**
	 * Displays the destination specific settings
	 *
	 * @param $post_type string
	 * @param $tab       string
	 *
	 * @return null
	 */
	public function general_settings() {
		?>
        <tr class="form-field -wrap">
            <th scope="row">
                <label for="description"><?php esc_html_e( 'Display the map in the banner', 'tour-operator' ); ?></label>
            </th>
            <td>
                <input type="checkbox" {{#if enable_banner_map}}
                       checked="checked" {{/if}} name="enable_banner_map" />
            </td>
        </tr>
		<?php
	}

	/**
	 * Outputs the destination meta
	 */
	public function content_meta() {
		if ( 'destination' === get_post_type() ) {
			?>
            <div class="destination-details meta taxonomies">
				<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">' . esc_html__( 'Travel Style', 'tour-operator' ) . ': ', ', ', '</div>' ); ?>
				<?php if ( function_exists( 'lsx_to_connected_activities' ) ) {
					lsx_to_connected_activities( '<div class="meta activities">' . esc_html__( 'Activities', 'tour-operator' ) . ': ', '</div>' );
				} ?>
            </div>
		<?php }
	}

	/**
	 * Adds our navigation links to the accommodation single post
	 *
	 * @param $page_links array
	 *
	 * @return $page_links array
	 */
	public function page_links( $page_links ) {
		$this->page_links = $page_links;
		if ( is_singular( 'destination' ) ) {
			$this->get_travel_info_link();
			$this->get_region_link();
			$this->get_related_tours_link();
			if ( ! lsx_to_item_has_children( get_the_ID(), 'destination' ) ) {
				$this->get_related_accommodation_link();
				$this->get_related_activities_link();
			}
			$this->get_map_link();
			$this->get_gallery_link();
			$this->get_videos_link();

		} elseif ( is_post_type_archive( 'destination' ) ) {
			$this->get_region_links();
		}
		$page_links = $this->page_links;

		return $page_links;
	}

	/**
	 * Adds the Travel Information to the $page_links variable
	 */
	public function get_travel_info_link() {
		$electricity = get_post_meta( get_the_ID(), 'electricity', true );
		$banking     = get_post_meta( get_the_ID(), 'banking', true );
		$cuisine     = get_post_meta( get_the_ID(), 'cuisine', true );
		$climate     = get_post_meta( get_the_ID(), 'climate', true );
		$transport   = get_post_meta( get_the_ID(), 'transport', true );
		$dress       = get_post_meta( get_the_ID(), 'dress', true );

		if ( ! empty( $electricity ) || ! empty( $banking ) || ! empty( $cuisine ) || ! empty( $climate ) || ! empty( $transport ) || ! empty( $dress ) ) {
			$this->page_links['travel-info'] = esc_html__( 'Travel Information', 'tour-operator' );
		}
	}

	/**
	 * Adds the Region to the $page_links variable
	 */
	public function get_region_link() {
		if ( lsx_to_item_has_children( get_the_ID(), 'destination' ) ) {
			$this->page_links['regions'] = esc_html__( 'Regions', 'tour-operator' );
		}
	}

	/**
	 * Tests Regions adds them to the $page_links variable
	 */
	public function get_region_links() {
		$tour_operator = tour_operator();
		if ( have_posts() ) :
			if ( ! isset( $tour_operator->search )
			     || empty( $tour_operator->search )
			     || false === $tour_operator->search->options
			     || ! isset( $tour_operator->search->options['destination']['enable_search'] )
			) :

				while ( have_posts() ) :
					the_post();
					$slug                      = sanitize_title( the_title( '', '', false ) );
					$this->page_links[ $slug ] = the_title( '', '', false );
				endwhile;
			endif;
			wp_reset_query();
		endif;
	}

	/**
	 * Tests for the Google Map and returns a link for the section
	 */
	public function get_map_link() {
		if ( function_exists( 'lsx_to_has_map' ) && lsx_to_has_map() ) {
			$this->page_links['destination-map'] = esc_html__( 'Map', 'tour-operator' );
		}
	}

	/**
	 * Tests for the Gallery and returns a link for the section
	 */
	public function get_gallery_link() {
		if ( function_exists( 'lsx_to_gallery' ) ) {
			$gallery_ids    = get_post_meta( get_the_ID(), 'gallery', false );
			$envira_gallery = get_post_meta( get_the_ID(), 'envira_gallery', true );

			if ( ( false !== $gallery_ids && '' !== $gallery_ids && is_array( $gallery_ids ) && ! empty( $gallery_ids ) )
			     || ( false !== $envira_gallery && '' !== $envira_gallery )
			) {
				$this->page_links['gallery'] = esc_html__( 'Gallery', 'tour-operator' );

				return;
			}
		} elseif ( class_exists( 'envira_gallery' ) ) {
			$envira_gallery = get_post_meta( get_the_ID(), 'envira_gallery', true );
			if ( false !== $envira_gallery && '' !== $envira_gallery && false === lsx_to_enable_envira_banner() ) {
				$this->page_links['gallery'] = esc_html__( 'Gallery', 'tour-operator' );

				return;
			}
		}
	}

	/**
	 * Tests for the Videos and returns a link for the section
	 */
	public function get_videos_link() {
		$videos_id = false;
		if ( class_exists( 'Envira_Videos' ) ) {
			$videos_id = get_post_meta( get_the_ID(), 'envira_video', true );
		}
		if ( ( false === $videos_id || '' === $videos_id ) && class_exists( 'LSX_TO_Videos' ) ) {
			$videos_id = get_post_meta( get_the_ID(), 'videos', true );
		}
		if ( false !== $videos_id && '' !== $videos_id ) {
			$this->page_links['videos'] = esc_html__( 'Videos', 'tour-operator' );
		}
	}

	/**
	 * Tests for the Related Tours and returns a link for the section
	 */
	public function get_related_tours_link() {
		$connected_tours = get_post_meta( get_the_ID(), 'tour_to_destination', false );
		if ( post_type_exists( 'tour' ) && is_array( $connected_tours ) && ! empty( $connected_tours ) ) {
			$this->page_links['tours'] = esc_html__( 'Tours', 'tour-operator' );
		}
	}

	/**
	 * Tests for the Related Accommodation and returns a link for the section
	 */
	public function get_related_accommodation_link() {
		$connected_accommodation = get_post_meta( get_the_ID(), 'accommodation_to_destination', false );
		if ( post_type_exists( 'accommodation' ) && is_array( $connected_accommodation ) && ! empty( $connected_accommodation ) ) {
			$this->page_links['accommodation'] = esc_html__( 'Accommodation', 'tour-operator' );
		}
	}

	/**
	 * Tests for the Related Activities and returns a link for the section
	 */
	public function get_related_activities_link() {
		$connected_activities = get_post_meta( get_the_ID(), 'activity_to_destination', false );
		if ( post_type_exists( 'activity' ) && is_array( $connected_activities ) && ! empty( $connected_activities ) ) {
			$this->page_links['activity'] = esc_html__( 'Activities', 'tour-operator' );
		}
	}

	/**
	 * Only return the upper lever countries
	 */
	public function filter_countries( $countries = array() ) {
		global $wpdb;
		if ( ! empty( $countries ) ) {
			$new_items           = array();
			$formatted_countries = implode( ',', $countries );

			$results = $wpdb->get_results( "SELECT ID,post_parent FROM {$wpdb->posts} WHERE ID IN ({$formatted_countries})" );

			if ( ! empty( $results ) ) {
				foreach ( $results as $result ) {
					if ( 0 === $result->post_parent || '0' === $result->post_parent ) {
						$new_items[] = $result->ID;
					}
				}
				$countries = $new_items;
			}
		}

		return $countries;
	}

}
