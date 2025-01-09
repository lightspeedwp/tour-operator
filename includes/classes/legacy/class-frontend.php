<?php
/**
 * Frontend actions for the LSX TO Plugin
 *
 * @package   Frontend
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package Frontend
 * @author  LightSpeed
 */
class Frontend extends Tour_Operator {

	/**
	 * Enable Modals
	 *
	 * @since 1.0.0
	 * @var      boolean|Frontend
	 */
	public $enable_modals = false;

	/**
	 * Holds the modal ids for output in the footer
	 *
	 * @since 1.0.0
	 * @var      array|Frontend
	 */
	public $modal_ids = array();

	/**
	 * Holds the maps class
	 * @var      object
	 */
	public $maps = array();

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	public function __construct() {
		$this->options = get_option( '_lsx-to_settings', false );
		$this->set_vars();

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylescripts' ), 1 );
		add_filter( 'body_class', array( $this, 'body_class' ), 15, 1 );

		if ( ! is_admin() ) {
			add_filter( 'pre_get_posts', array( $this, 'travel_style_post_types' ), 10, 1 );
		}

		$this->maps = new Maps();

		add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ), 100 );

		// Readmore
		remove_filter( 'term_description', 'wpautop' );

		add_filter( 'wpseo_breadcrumb_links', array( $this, 'wpseo_breadcrumb_links' ), 20 );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_stylescripts() {
		$has_slick = wp_script_is( 'slick', 'queue' );
		$has_slick_lightbox = wp_script_is( 'slick-lightbox', 'queue' );
		//if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			$prefix = 'src/';
			$suffix = '';
		/*} else {
			$prefix = '';
			$suffix = '.min';
		}*/

		if ( ! $has_slick ) {
			wp_enqueue_script( 'slick', LSX_TO_URL . 'assets/js/vendor/slick.min.js', array( 'jquery' ), LSX_TO_VER, true );
		}

		if ( ! $has_slick_lightbox ) {
			wp_enqueue_script( 'slick-lightbox', LSX_TO_URL . 'assets/js/vendor/slick-lightbox.min.js', array( 'jquery', 'slick' ), LSX_TO_VER, true );
		}

		wp_enqueue_script( 'tour-operator-script', LSX_TO_URL . 'assets/js/' . $prefix . 'custom' . $suffix . '.js', array( 'jquery', 'slick', 'slick-lightbox'/*, 'fixto'*/ ), LSX_TO_VER, true );

		if ( ! $has_slick ) {
			wp_enqueue_style( 'slick', LSX_TO_URL . 'assets/css/vendor/slick.css', array(), LSX_TO_VER );
		}

		if ( ! $has_slick_lightbox ) {
			wp_enqueue_style( 'slick-lightbox', LSX_TO_URL . 'assets/css/vendor/slick-lightbox.css', array( 'slick' ), LSX_TO_VER );
		}

		wp_enqueue_style( 'tour-operator-style', LSX_TO_URL . 'assets/css/style.css', array(), LSX_TO_VER );
		wp_style_add_data( 'tour-operator-style', 'rtl', 'replace' );

	}

	/**
	 * Set the main query to pull through only the top level destinations.
	 */
	public function travel_style_post_types( $query ) {
		if ( $query->is_main_query() && $query->is_tax( array( 'travel-style' ) ) ) {
			$query->set( 'post_type', array( 'tour', 'accommodation' ) );
		}

		return $query;
	}

	/**
	 * Add a some classes so we can style.
	 */
	public function body_class( $classes ) {
		if ( false !== $this->post_types && is_singular( array_keys( $this->post_types ) ) ) {
			$classes[] = 'single-tour-operator';
		} elseif ( false !== $this->post_types && is_post_type_archive( array_keys( $this->post_types ) ) ) {
			$classes[] = 'archive-tour-operator';
		} elseif ( false !== $this->taxonomies && is_tax( array_keys( $this->taxonomies ) ) ) {
			$classes[] = 'archive-tour-operator';
		}

		return $classes;
	}

	/**
	 * Remove the "Archives:" from the post type archives.
	 *
	 * @param    $title
	 *
	 * @return    $title
	 */
	public function get_the_archive_title( $title ) {
		if ( is_post_type_archive( array_keys( $this->post_types ) ) ) {
			$title = post_type_archive_title( '', false );
		}

		if ( is_tax( array_keys( $this->taxonomies ) ) ) {
			$title = single_term_title( '', false );
		}

		return $title;
	}

	/**
	 * Add continent item to the breadcrumb.
	 */
	public function wpseo_breadcrumb_links( $crumbs ) {
		if ( is_tax( 'continent' ) ) {
			$crumbs = $this->continent_breadcrumb_links( $crumbs );
		}

		if ( is_singular( 'destination' ) ) {
			$crumbs = $this->destination_breadcrumb_links( $crumbs );
		}

		if ( is_singular( 'accommodation' ) ) {
			$crumbs = $this->accommodation_breadcrumb_links( $crumbs );
		}

		if ( is_singular( 'tour' ) ) {
			$crumbs = $this->tour_breadcrumb_links( $crumbs );
		}

		return $crumbs;
	}

	/**
	 * The Breadcrumbs Links for the continents.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function continent_breadcrumb_links( $crumbs ) {
		$destination_breadcrumb = array(
			'text' => esc_html__( 'Destinations', 'tour-operator' ),
			'url'  => get_post_type_archive_link( 'destination' ),
		);

		array_splice( $crumbs, 1, 0, array( $destination_breadcrumb ) );
		return $crumbs;
	}

	/**
	 * The Breadcrumbs Links for the Destinations.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function destination_breadcrumb_links( $crumbs ) {
		global $post;
		$continents = wp_get_post_terms( $post->ID, 'continent' );
		if ( empty( $continents ) || ! is_array( $continents ) ) {
			global $post;

			if ( ! empty( $post->post_parent ) ) {
				$continents = wp_get_post_terms( $post->post_parent, 'continent' );
			}
		}

		if ( ! empty( $continents ) && is_array( $continents ) ) {
			foreach ( $continents as $key => $continent ) {
				$continent_breadcrumb = array(
					'text' => $continent->name,
					'url'  => get_term_link( $continent ),
				);

				array_splice( $crumbs, 2, 0, array( $continent_breadcrumb ) );
				break;
			}
		}
		return $crumbs;
	}

	/**
	 * The Breadcrumbs Links for the Tours and Accommodation.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function accommodation_breadcrumb_links( $crumbs ) {
		$new_crumbs = array(
			array(
				'text' => esc_attr__( 'Home', 'tour-operator' ),
				'url'  => home_url(),
			),
			array(
				'text' => esc_attr__( 'Accommodation', 'tour-operator' ),
				'url'  => get_post_type_archive_link( 'accommodation' ),
			),
		);
		
		// Get the primary travel style
		$primary      = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_accommodation-type', true );
		$primary_term = get_term( $primary, 'accommodation-type' );

		if ( ! is_wp_error( $primary_term ) && null !== $primary_term ) {
			$new_crumbs[] = array(
				'text' => $primary_term->name,
				'url'  => get_term_link( $primary_term, 'accommodation-type' ),
			);
		} else {
			$counter = 0;
			$terms = wp_get_object_terms( get_the_ID(), 'accommodation-type' );
			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( 0 < $counter ) {
						continue;
					}

					$new_crumbs[] = array(
						'text' => $term->name,
						'url'  => get_term_link( $term ),
					);
					$counter++;
				}
			}
		}
		
		$new_crumbs[] = array(
			'text' => get_the_title(),
			'url'  => get_permalink(),
		);
		$crumbs = $new_crumbs;
		return $crumbs;
	}

	/**
	 * The Breadcrumbs Links for the Tours and Accommodation.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function tour_breadcrumb_links( $crumbs ) {
		$new_crumbs = array(
			array(
				'text' => esc_attr__( 'Home', 'tour-operator' ),
				'url'  => home_url(),
			),
			array(
				'text' => esc_attr__( 'Tours', 'tour-operator' ),
				'url'  => get_post_type_archive_link( 'tour' ),
			),
		);

		// Get the primary travel style
		$primary      = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_travel-style', true );
		$primary_term = get_term( $primary, 'travel-style' );

		if ( ! is_wp_error( $primary_term ) && null !== $primary_term ) {
			$new_crumbs[] = array(
				'text' => $primary_term->name,
				'url'  => get_term_link( $primary_term, 'travel-style' ),
			);
		} else {
			$counter = 0;
			$terms = wp_get_object_terms( get_the_ID(), 'travel-style' );
			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( 0 < $counter ) {
						continue;
					}

					$new_crumbs[] = array(
						'text' => $term->name,
						'url'  => get_term_link( $term ),
					);
					$counter++;
				}
			}
		}
		
		$new_crumbs[] = array(
			'text' => get_the_title(),
			'url'  => get_permalink(),
		);
		$crumbs = $new_crumbs;

		return $crumbs;
	}
}
