<?php
namespace lsx\blocks;

/**
 * The creation of the block variants and the code to control the display.
 *
 * @package lsx
 * @author  LightSpeed
 */
class Registration {
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_variations_script' ), 10 );
		add_filter( 'query_loop_block_query_vars', array( $this, 'query_args_filter' ), 10, 2 );
	}

	/**
	 * Registers our variations block assets
	 *
	 * @return void
	 */
	public function enqueue_block_variations_script() {

		$scripts = [
			'general'       => '',
			'tour'          => '',
			'accommodation' => '',
			'destination'   => '',
			'query-loops'   => '',
		];

		// Make sure the script is only enqueued in the block editor.
		if ( is_admin() && function_exists( 'register_block_type' ) ) {
			
			foreach ( $scripts as $slug => $restrictions ) {
				wp_enqueue_script(
					'lsx-to-block-' . $slug . '-variations',  // Handle for the script.
					LSX_TO_URL . 'assets/js/blocks/' . $slug . '.js', // Path to your JavaScript file.
					array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),  // Dependencies.
					filemtime( LSX_TO_PATH . 'assets/js/blocks/' . $slug . '.js' ), // Versioning with file modification time.
					true  // Enqueue in the footer.
				);
			}

			// Enqueue linked-cover.js
			wp_enqueue_script(
				'lsx-to-linked-cover',
				LSX_TO_URL . 'assets/js/blocks/linked-cover.js',
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-data', 'wp-hooks' ),
				filemtime( LSX_TO_PATH . 'assets/js/blocks/linked-cover.js' )
			);

			// Enqueue linked-cover.js
			wp_enqueue_script(
				'lsx-to-slider-query',
				LSX_TO_URL . 'assets/js/blocks/slider-query.js',
				array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ),
				filemtime( LSX_TO_PATH . 'assets/js/blocks/slider-query.js' )
			);

			if ( array_key_exists( get_post_type(), tour_operator()->get_post_types() ) ) {
				wp_enqueue_script(
					'lsx-to-slotfills',  // Handle for the script.
					LSX_TO_URL . 'assets/js/blocks/slotfills.js', // Path to your JavaScript file.
					array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),  // Dependencies.
					filemtime( LSX_TO_PATH . 'assets/js/blocks/slotfills.js' ), // Versioning with file modification time.
					true  // Enqueue in the footer.
				);
			}
		}
	}

	public function query_args_filter( $query, $block ) {
		$block = $block->parsed_block;

		// Determine if this is the custom block variation.
		if ( ! isset( $block['attrs']['className'] )  ) {
			return $query;
		}
		
		$pattern = "/(lsx|facts)-(.*?)-query/";
		preg_match( $pattern, $block['attrs']['className'], $matches );

		if ( ! empty( $matches ) && isset( $matches[0] ) ) {
			// Save the first match to a variable
			$key = str_replace( [ 'facts-', 'lsx-', '-query' ], '', $matches[0] );
		} else {
			return $query;
		}

		switch ( $key ) {
			case 'regions':
				// We only restric this on the destination post type, in case the block is used on a landing page.
				if ( 'destination' === get_post_type() ) {
					$query['post_parent__in'] = [ get_the_ID() ];
				}
			break;

			case 'related-regions':
				// We only restric this on the destination post type, in case the block is used on a landing page.
				$parent = wp_get_post_parent_id();
				if ( 'destination' === get_post_type() ) {
					$query['post_parent'] = $parent;
					$query['post__not_in'] = [ get_the_ID() ];
				}
			break;

			case 'featured-accommodation':
			case 'featured-tours':
			case 'featured-destinations':
				$query['meta_query'] = array(
					'relation' => 'OR',
					array(
						'key' => 'featured',
						'value' => true,
						'compare' => '=',
					),
				);

			break;

			default:
			break;
		}
		do_action( 'qm/debug', $key );
		do_action( 'qm/debug', $query );

		// Add rating meta key/value pair if queried.
		/*if ( 'lsx/lsx-featured-posts' === $parsed_block['attrs']['namespace'] ) {	
			unset( $query['post__not_in'] );
			unset( $query['offset'] );
			$query['nopaging'] = false;
			
			// if its sticky posts, only include those.
			if ( 'post' === $query['post_type'] ) {
				$sticky_posts = get_option( 'sticky_posts', array() );
				if ( ! is_array( $sticky_posts ) ) {
					$sticky_posts = array( $sticky_posts );
				}
				$query['post__in'] = $sticky_posts;
				$query['ignore_sticky_posts'] = 1;
			} else {
				//Use the "featured" custom field.
				$query['meta_query'] = array(
					array(
						'key'     => 'featured',
						'compare' => 'EXISTS',
					)
				);
			}
		}*/
		return $query;
	}
}
