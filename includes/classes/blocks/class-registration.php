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

		add_filter( 'pre_render_block', array( $this, 'pre_render_featured_block' ), 10, 2 );
	}

	/**
	 * Registers our variations block assets
	 *
	 * @return void
	 */
	public function enqueue_block_variations_script() {
		// Make sure the script is only enqueued in the block editor.
		if ( is_admin() && function_exists( 'register_block_type' ) ) {
			wp_enqueue_script(
				'lsx-to-block-variations',  // Handle for the script.
				LSX_TO_URL . 'assets/js/blocks/variations.js', // Path to your JavaScript file.
				array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),  // Dependencies.
				filemtime( LSX_TO_PATH . 'assets/js/blocks/variations.js' ), // Versioning with file modification time.
				true  // Enqueue in the footer.
			);

			wp_enqueue_script(
				'lsx-to-query-loops',  // Handle for the script.
				LSX_TO_URL . 'assets/js/blocks/query-loops.js', // Path to your JavaScript file.
				array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),  // Dependencies.
				filemtime( LSX_TO_PATH . 'assets/js/blocks/query-loops.js' ), // Versioning with file modification time.
				true  // Enqueue in the footer.
			);

			// Enqueue linked-cover.js
			wp_enqueue_script(
				'lsx-linked-cover',
				LSX_TO_URL . 'assets/js/blocks/linked-cover.js',
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-data', 'wp-hooks' ),
				filemtime( LSX_TO_PATH . 'assets/js/blocks/linked-cover.js' )
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

	/**
	 * A function to detect variation, and alter the query args.
	 * 
	 * Following the https://developer.wordpress.org/news/2022/12/building-a-book-review-grid-with-a-query-loop-block-variation/
	 *
	 * @param string|null   $pre_render   The pre-rendered content. Default null.
	 * @param array         $parsed_block The block being rendered.
	 * @param WP_Block|null $parent_block If this is a nested block, a reference to the parent block.
	 */
	public function pre_render_featured_block( $pre_render, $parsed_block ) {
		// Determine if this is the custom block variation.
		if ( isset( $parsed_block['attrs']['namespace'] ) && 'lsx/lsx-featured-posts' === $parsed_block['attrs']['namespace'] ) {
			add_filter(
				'query_loop_block_query_vars',
				function( $query, $block ) use ( $parsed_block ) {
	
					// Add rating meta key/value pair if queried.
					if ( 'lsx/lsx-featured-posts' === $parsed_block['attrs']['namespace'] ) {	
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
					}
					return $query;
				},
				10,
				2
			);
		}
		return $pre_render;
	}

}
