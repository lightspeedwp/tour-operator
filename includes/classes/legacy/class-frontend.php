<?php

/**
 * Frontend actions for the LSX TO Plugin
 *
 * @package   Frontend
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 lightspeedwp
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package Frontend
 * @author  LightSpeed
 */
class Frontend extends Tour_Operator
{

	/**
	 * Holds the maps class
	 *
	 * @var      object
	 */
	public $maps = array();

	/**
	 * Breadcrumb text and URL properties
	 *
	 * @var string
	 */
	public string $home_text;
	public string $home_url;
	public string $destinations_text;
	public string $destinations_url;
	public string $tours_text;
	public string $tours_url;
	public string $accommodation_text;
	public string $accommodation_url;

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	public function __construct()
	{
		$this->options = get_option('lsx_to_settings', false);
		$this->set_vars();

		add_action('wp_enqueue_scripts', array($this, 'enqueue_stylescripts'), 1);
		add_filter('body_class', array($this, 'body_class'), 15, 1);

		if (! is_admin()) {
			add_filter('pre_get_posts', array($this, 'travel_style_post_types'), 10, 1);
		}

		$this->maps = new Maps();

		// Readmore
		remove_filter('term_description', 'wpautop');

		add_filter('wpseo_breadcrumb_links', array($this, 'wpseo_breadcrumb_links'), 200);
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_stylescripts()
	{
		$has_slick          = wp_script_is('slick', 'queue');
		$has_slick_lightbox = wp_script_is('slick-lightbox', 'queue');
		if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
			$prefix = 'src/js/';
			$suffix = '';
		} else {
			$prefix = 'build/';
			$suffix = '';
			// $suffix = '.min';
		}

		if (! $has_slick) {
			wp_enqueue_script('slick', LSX_TO_URL . 'assets/js/vendor/slick.min.js', array('jquery'), LSX_TO_VER, true);
		}

		if (! $has_slick_lightbox) {
			wp_enqueue_script('slick-lightbox', LSX_TO_URL . 'assets/js/vendor/slick-lightbox.min.js', array('jquery', 'slick'), LSX_TO_VER, true);
		}

		wp_enqueue_script('tour-operator-script', LSX_TO_URL . $prefix . 'custom' . $suffix . '.js', array('jquery', 'slick', 'slick-lightbox'/*, 'fixto'*/), LSX_TO_VER, true);

		if (! $has_slick) {
			wp_enqueue_style('slick', LSX_TO_URL . 'assets/css/vendor/slick.css', array(), LSX_TO_VER);
		}

		if (! $has_slick_lightbox) {
			wp_enqueue_style('slick-lightbox', LSX_TO_URL . 'assets/css/vendor/slick-lightbox.css', array('slick'), LSX_TO_VER);
		}

		if ( is_singular( 'destination' ) ) {
			wp_enqueue_style( 'wp-block-button' );
			wp_enqueue_style( 'wp-block-buttons' );
		}

		wp_enqueue_style('tour-operator-style', LSX_TO_URL . 'build/style.css', array(), LSX_TO_VER);
		wp_style_add_data('tour-operator-style', 'rtl', 'replace');
	}

	/**
	 * Set the main query to pull through only the top level destinations.
	 */
	public function travel_style_post_types($query)
	{
		if ($query->is_main_query() && $query->is_tax(array('travel-style'))) {
			$query->set('post_type', array('tour', 'accommodation'));
		}

		return $query;
	}

	/**
	 * Add a some classes so we can style.
	 */
	public function body_class($classes)
	{
		if (false !== $this->post_types && is_singular(array_keys($this->post_types))) {
			$classes[] = 'single-tour-operator';
		} elseif (false !== $this->post_types && is_post_type_archive(array_keys($this->post_types))) {
			$classes[] = 'archive-tour-operator';
		} elseif (false !== $this->taxonomies && is_tax(array_keys($this->taxonomies))) {
			$classes[] = 'archive-tour-operator';
		}

		return $classes;
	}

	/**
	 * Initialize breadcrumb properties.
	 *
	 * @since 2.1.2
	 */
	private function init_breadcrumb_properties() {
		if ( $this->breadcrumb_props_initialized ) {
			return;
		}

		$this->home_text           = esc_attr__('Home', 'tour-operator');
		$this->home_url            = home_url();
		$this->destinations_text   = esc_attr__('Destinations', 'tour-operator');
		$this->destinations_url    = get_post_type_archive_link('destination');
		$this->tours_text          = esc_attr__('Tours', 'tour-operator');
		$this->tours_url           = get_post_type_archive_link('tour');
		$this->accommodation_text  = esc_attr__('Accommodation', 'tour-operator');
		$this->accommodation_url   = get_post_type_archive_link('accommodation');

		$this->breadcrumb_props_initialized = true;
	}

	/**
	 * Add continent item to the breadcrumb.
	 */
	public function wpseo_breadcrumb_links($crumbs)
	{
		// Initialize breadcrumb properties when needed
		$this->init_breadcrumb_properties();

		if ( is_tax( [ 'continent', 'accommodation-brand', 'travel-style', 'accommodation-type' ] ) ) {
			$crumbs = $this->taxonomy_breadcrumb_links($crumbs);
		}

		// Post type archives
		if ( is_post_type_archive( [ 'destination', 'accommodation', 'tour' ] ) ) {
			$crumbs = $this->archive_breadcrumbs_links( $crumbs, get_post_type());
		}

		// Single Items
		if (is_singular('destination')) {
			$crumbs = $this->destination_breadcrumb_links($crumbs);
		}
		if (is_singular('accommodation')) {
			$crumbs = $this->accommodation_breadcrumb_links($crumbs);
		}
		if (is_singular('tour')) {
			$crumbs = $this->tour_breadcrumb_links($crumbs);
		}

		return $crumbs;
	}

	public function archive_breadcrumbs_links( $crumbs, $post_type ) {
		$post_type_object = get_post_type_object( $post_type );
		if ( ! is_post_type_archive( $post_type ) || ! $post_type_object ) {
			return $crumbs;
		}

		switch ( $post_type ) {
			case 'destination':
				$text = $this->destinations_text;
				$url  = $this->destinations_url;
				break;
			case 'tour':
				$text = $this->tours_text;
				$url  = $this->tours_url;
				break;
			case 'accommodation':
				$text = $this->accommodation_text;
				$url  = $this->accommodation_url;
				break;
			default:
				$text = esc_attr( $post_type_object->labels->name );
				$url  = get_post_type_archive_link( $post_type );
				break;
		}

		$new_crumbs = array(
			array(
				'text' => $this->home_text,
				'url'  => $this->home_url,
			),
			array(
				'text' => $text,
				'url'  => $url,
			),
		);

		return $new_crumbs;
	}

	/**
	 * The Breadcrumbs Links for the continents.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function taxonomy_breadcrumb_links($crumbs)
	{
		$taxonomy   = get_queried_object()->taxonomy;
		$new_crumbs	= array();
		switch ( $taxonomy ) {
			case 'continent':
				$new_crumbs = array(
					'text' => $this->destinations_text,
					'url'  => $this->destinations_url,
				);
				break;
			case 'accommodation-brand':
				$new_crumbs = array(
					'text' => $this->accommodation_text,
					'url'  => $this->accommodation_url,
				);
				break;
			case 'travel-style':
				$new_crumbs = array(
					'text' => $this->tours_text,
					'url'  => $this->tours_url,
				);
				break;
			case 'accommodation-type':
				$new_crumbs = array(
					'text' => $this->accommodation_text,
					'url'  => $this->accommodation_url,
				);
				break;
		}
		if ( ! empty( $new_crumbs ) ) {
			array_splice($crumbs, 1, 0, array( $new_crumbs ));
		}
		
		return $crumbs;
	}

	/**
	 * The Breadcrumbs Links for the Destinations.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function destination_breadcrumb_links($crumbs)
	{

		$new_crumbs = array(
			array(
				'text' => $this->home_text,
				'url'  => $this->home_url,
			),
			array(
				'text' => $this->destinations_text,
				'url'  => $this->destinations_url,
			),
		);

		global $post;
		$continents = wp_get_post_terms($post->ID, 'continent');
		if (empty($continents) || ! is_array($continents)) {
			global $post;

			if (! empty($post->post_parent)) {
				$continents = wp_get_post_terms($post->post_parent, 'continent');
			}
		}

		if (! empty($continents) && is_array($continents)) {
			foreach ($continents as $key => $continent) {
				$continent_breadcrumb = array(
					'text' => $continent->name,
					'url'  => get_term_link($continent),
				);

				array_splice($new_crumbs, 2, 0, array($continent_breadcrumb));
				break;
			}
		}

		if ( has_post_parent() ) {
			$parent = get_post_parent();
			$parent_breadcrumb = array(
				'text' => $parent->post_title,
				'url'  => get_permalink( $parent->ID ),
			);

			array_splice($new_crumbs, 3, 0, array($parent_breadcrumb));
		}

		$new_crumbs[] = array(
			'text' => get_the_title(),
			'url'  => get_permalink(),
		);

		return $new_crumbs;
	}

	/**
	 * The Breadcrumbs Links for the Tours and Accommodation.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function accommodation_breadcrumb_links($crumbs)
	{
		$new_crumbs = array(
			array(
				'text' => $this->home_text,
				'url'  => $this->home_url,
			),
			array(
				'text' => $this->accommodation_text,
				'url'  => $this->accommodation_url,
			),
		);

		// Get the primary travel style
		$primary      = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_accommodation-type', true);
		$primary_term = get_term($primary, 'accommodation-type');

		if (! is_wp_error($primary_term) && null !== $primary_term) {
			$new_crumbs[] = array(
				'text' => $primary_term->name,
				'url'  => get_term_link($primary_term, 'accommodation-type'),
			);
		} else {
			$counter = 0;
			$terms   = wp_get_object_terms(get_the_ID(), 'accommodation-type');
			if (! is_wp_error($terms) && ! empty($terms)) {
				foreach ($terms as $term) {
					if (0 < $counter) {
						continue;
					}

					$new_crumbs[] = array(
						'text' => $term->name,
						'url'  => get_term_link($term),
					);
					++$counter;
				}
			}
		}

		$new_crumbs[] = array(
			'text' => get_the_title(),
			'url'  => get_permalink(),
		);
		$crumbs       = $new_crumbs;
		return $crumbs;
	}

	/**
	 * The Breadcrumbs Links for the Tours and Accommodation.
	 *
	 * @param array $crumbs
	 * @return array
	 */
	public function tour_breadcrumb_links($crumbs)
	{
		$new_crumbs = array(
			array(
				'text' => $this->home_text,
				'url'  => $this->home_url,
			),
			array(
				'text' => $this->tours_text,
				'url'  => $this->tours_url,
			),
		);

		// Get the primary travel style
		$primary      = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_travel-style', true);
		$primary_term = get_term($primary, 'travel-style');

		if (! is_wp_error($primary_term) && null !== $primary_term) {
			$new_crumbs[] = array(
				'text' => $primary_term->name,
				'url'  => get_term_link($primary_term, 'travel-style'),
			);
		} else {
			$counter = 0;
			$terms   = wp_get_object_terms( get_the_ID(), 'travel-style');

			if (! is_wp_error($terms) && ! empty($terms)) {
				foreach ($terms as $term) {
					if (0 < $counter) {
						continue;
					}

					$new_crumbs[] = array(
						'text' => $term->name,
						'url'  => get_term_link($term),
					);
					++$counter;
				}
			}
		}

		$new_crumbs[] = array(
			'text' => get_the_title(),
			'url'  => get_permalink(),
		);
		$crumbs       = $new_crumbs;

		return $crumbs;
	}
}
