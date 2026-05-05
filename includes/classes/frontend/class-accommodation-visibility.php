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
 * Handles visibility control for tour, accommodation, and destination posts
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
	 * Supported post types
	 *
	 * @since 2.1.0
	 * @var array
	 */
	private $post_types = [ 'tour', 'accommodation', 'destination' ];

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_meta_field' ] );
		add_action( 'pre_get_posts', [ $this, 'exclude_hidden_from_queries' ] );
		add_filter( 'query_loop_block_query_vars', [ $this, 'filter_query_block_args' ], 10, 1 );
		add_filter( 'lsx_to_connected_list_item', [ $this, 'filter_hidden_modal_links' ], 10, 3 );
		add_filter( 'excerpt_more', [ $this, 'remove_view_more_for_hidden' ], 10, 1 );
	}

	/**
	 * Register the meta field for visibility control
	 *
	 * @return void
	 */
	public function register_meta_field() {
		foreach ( $this->post_types as $post_type ) {
			register_post_meta(
				$post_type,
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
	}

	/**
	 * Exclude hidden posts from queries
	 *
	 * @param \WP_Query $query The WP_Query instance
	 * @return void
	 */
	public function exclude_hidden_from_queries( $query ) {
		// Only modify main query
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		// Check if this is a query for our supported post types
		$post_type = $query->get( 'post_type' );
		if ( ! $this->is_supported_query( $query, $post_type ) ) {
			return;
		}

		// Add meta query to exclude hidden posts
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
	 * Filter Query Block query arguments to exclude hidden posts
	 *
	 * @param array $query_args The query arguments
	 * @return array Modified query arguments
	 */
	public function filter_query_block_args( $query_args ) {
		// Check if this query is for our supported post types
		$post_type = isset( $query_args['post_type'] ) ? $query_args['post_type'] : '';
		
		// Skip if not one of our post types
		if ( empty( $post_type ) ) {
			return $query_args;
		}

		// Check if post_type matches our supported types
		$is_supported = false;
		if ( is_array( $post_type ) ) {
			foreach ( $this->post_types as $supported_type ) {
				if ( in_array( $supported_type, $post_type, true ) ) {
					$is_supported = true;
					break;
				}
			}
		} elseif ( in_array( $post_type, $this->post_types, true ) ) {
			$is_supported = true;
		}

		if ( ! $is_supported ) {
			return $query_args;
		}

		// Add meta query to exclude hidden posts
		$meta_query = isset( $query_args['meta_query'] ) ? $query_args['meta_query'] : [];
		
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

		$query_args['meta_query'] = $meta_query;

		return $query_args;
	}

	/**
	 * Check if the query is for supported post types
	 *
	 * @param \WP_Query $query The WP_Query instance
	 * @param string|array $post_type The post type from the query
	 * @return bool
	 */
	private function is_supported_query( $query, $post_type ) {
		// Check if post_type matches our supported types
		if ( in_array( $post_type, $this->post_types, true ) ) {
			return true;
		}

		// Check for taxonomy archives
		if ( $query->is_tax( 'accommodation-type' ) || $query->is_tax( 'accommodation-brand' ) || $query->is_tax( 'travel-style' ) ) {
			return true;
		}

		// Check for search queries
		if ( $query->is_search() ) {
			$search_post_types = $query->get( 'post_type' );
			
			// If post_type is not set, search includes all post types
			if ( empty( $search_post_types ) ) {
				return true;
			}

			// Check if any of our post types are in the search
			if ( is_array( $search_post_types ) ) {
				foreach ( $this->post_types as $supported_type ) {
					if ( in_array( $supported_type, $search_post_types, true ) ) {
						return true;
					}
				}
			} elseif ( in_array( $search_post_types, $this->post_types, true ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a post is hidden
	 *
	 * @param int $post_id The post ID to check
	 * @return bool True if hidden, false otherwise
	 */
	public static function is_post_hidden( $post_id ) {
		$post_type = get_post_type( $post_id );
		$supported_types = [ 'tour', 'accommodation', 'destination' ];
		
		if ( ! in_array( $post_type, $supported_types, true ) ) {
			return false;
		}

		$is_hidden = get_post_meta( $post_id, self::META_KEY, true );
		return ! empty( $is_hidden );
	}

	/**
	 * Filter modal links to prevent modals for hidden posts
	 *
	 * @param string $html The HTML output for the connected list item
	 * @param int    $post_id The post ID
	 * @param bool   $has_single Whether the post has a single page
	 * @return string Modified HTML
	 */
	public function filter_hidden_modal_links( $html, $post_id, $has_single ) {
		// Only process if this is one of our supported post types
		$post_type = get_post_type( $post_id );
		if ( ! in_array( $post_type, $this->post_types, true ) ) {
			return $html;
		}

		// If post is hidden, return just the title without a link
		if ( self::is_post_hidden( $post_id ) ) {
			return get_the_title( $post_id );
		}

		return $html;
	}

	/**
	 * Remove "View More" text from excerpts of hidden posts
	 *
	 * @param string $more_string The excerpt more string
	 * @return string Modified more string
	 */
	public function remove_view_more_for_hidden( $more_string ) {
		global $post;

		// Only process our supported post types
		if ( ! $post || ! in_array( get_post_type( $post ), $this->post_types, true ) ) {
			return $more_string;
		}

		// If post is hidden, return empty string (no "View More" link)
		if ( self::is_post_hidden( $post->ID ) ) {
			return '';
		}

		return $more_string;
	}
}
