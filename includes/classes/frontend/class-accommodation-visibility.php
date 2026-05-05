<?php
/**
 * Tour Operator - Accommodation Visibility Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-3.0+
 */

namespace lsx\frontend;

/**
 * Class Accommodation_Visibility
 *
 * Handles visibility control for accommodation posts
 *
 * @since 2.1.0
 * @package lsx\frontend
 */
class Accommodation_Visibility {

	/**
	 * Meta key for storing visibility status
	 *
	 * @since 2.1.0
	 * @var string
	 */
	const META_KEY = '_lsx_to_hide_accommodation';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_meta_field' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_assets' ] );
		add_action( 'pre_get_posts', [ $this, 'exclude_hidden_from_queries' ] );
		add_filter( 'lsx_to_connected_list_item', [ $this, 'filter_hidden_accommodation_modal_links' ], 10, 3 );
		add_filter( 'excerpt_more', [ $this, 'remove_view_more_for_hidden_accommodation' ], 10, 1 );
	}

	/**
	 * Register the meta field for visibility control
	 *
	 * @return void
	 */
	public function register_meta_field() {
		register_post_meta(
			'accommodation',
			self::META_KEY,
			[
				'type'         => 'boolean',
				'single'       => true,
				'show_in_rest' => true,
				'default'      => false,
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}

	/**
	 * Enqueue editor scripts and styles
	 *
	 * @return void
	 */
	public function enqueue_editor_assets() {
		global $post;

		// Only load on accommodation post type
		if ( ! $post || 'accommodation' !== get_post_type( $post ) ) {
			return;
		}

		wp_enqueue_script(
			'lsx-to-accommodation-visibility',
			LSX_TO_URL . 'build/accommodation-visibility.js',
			[ 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ],
			LSX_TO_VER,
			true
		);

		wp_localize_script(
			'lsx-to-accommodation-visibility',
			'lsxAccommodationVisibility',
			[
				'metaKey' => self::META_KEY,
			]
		);
	}

	/**
	 * Exclude hidden accommodation from queries
	 *
	 * @param \WP_Query $query The WP_Query instance
	 * @return void
	 */
	public function exclude_hidden_from_queries( $query ) {
		// Only modify main query or queries for accommodation post type
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		// Check if this is a query for accommodation posts
		$post_type = $query->get( 'post_type' );
		if ( 'accommodation' !== $post_type && ! $this->is_accommodation_query( $query ) ) {
			return;
		}

		// Add meta query to exclude hidden accommodation
		$meta_query = $query->get( 'meta_query' ) ?: [];
		
		$meta_query[] = [
			'relation' => 'OR',
			[
				'key'     => self::META_KEY,
				'compare' => 'NOT EXISTS',
			],
			[
				'key'     => self::META_KEY,
				'value'   => '1',
				'compare' => '!=',
			],
		];

		$query->set( 'meta_query', $meta_query );
	}

	/**
	 * Check if the query is for accommodation
	 *
	 * @param \WP_Query $query The WP_Query instance
	 * @return bool
	 */
	private function is_accommodation_query( $query ) {
		// Check for accommodation type taxonomy archive
		if ( $query->is_tax( 'accommodation-type' ) || $query->is_tax( 'accommodation-brand' ) ) {
			return true;
		}

		// Check for search queries that might include accommodation
		if ( $query->is_search() ) {
			$post_types = $query->get( 'post_type' );
			
			// If post_type is not set, search includes all post types (including accommodation)
			if ( empty( $post_types ) ) {
				return true;
			}

			// Check if accommodation is in the post_type array
			if ( is_array( $post_types ) && in_array( 'accommodation', $post_types, true ) ) {
				return true;
			}

			// Check if post_type is exactly 'accommodation'
			if ( 'accommodation' === $post_types ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if an accommodation post is hidden
	 *
	 * @param int $post_id The post ID to check
	 * @return bool True if hidden, false otherwise
	 */
	public static function is_accommodation_hidden( $post_id ) {
		if ( 'accommodation' !== get_post_type( $post_id ) ) {
			return false;
		}

		$is_hidden = get_post_meta( $post_id, self::META_KEY, true );
		return ! empty( $is_hidden );
	}

	/**
	 * Filter accommodation modal links to prevent modals for hidden accommodation
	 *
	 * @param string $html The HTML output for the connected list item
	 * @param int    $post_id The post ID
	 * @param bool   $has_single Whether the post has a single page
	 * @return string Modified HTML
	 */
	public function filter_hidden_accommodation_modal_links( $html, $post_id, $has_single ) {
		// Only process if this is an accommodation post
		if ( 'accommodation' !== get_post_type( $post_id ) ) {
			return $html;
		}

		// If accommodation is hidden, return just the title without a link
		if ( self::is_accommodation_hidden( $post_id ) ) {
			return get_the_title( $post_id );
		}

		return $html;
	}

	/**
	 * Remove "View More" text from excerpts of hidden accommodation
	 *
	 * @param string $more_string The excerpt more string
	 * @return string Modified more string
	 */
	public function remove_view_more_for_hidden_accommodation( $more_string ) {
		global $post;

		// Only process accommodation posts
		if ( ! $post || 'accommodation' !== get_post_type( $post ) ) {
			return $more_string;
		}

		// If accommodation is hidden, return empty string (no "View More" link)
		if ( self::is_accommodation_hidden( $post->ID ) ) {
			return '';
		}

		return $more_string;
	}
}
