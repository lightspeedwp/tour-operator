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
		add_filter( 'render_block', array( $this, 'maybe_hide_varitaion' ), 10, 3 );
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
	public function maybe_hide_varitaion( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/group',
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}
		if ( ! isset( $parsed_block['attrs']['className'] ) || '' === $parsed_block['attrs']['className'] || false === $parsed_block['attrs']['className'] ) {
			return $block_content;
		}

		$pattern = "/lsx(?:-[^-]+)+-wrapper/";
		preg_match( $pattern, $parsed_block['attrs']['className'], $matches );

		if ( empty( $matches ) ) {
			return $block_content;
		}
		
		if ( ! empty( $matches ) && isset( $matches[0] ) ) {
			// Save the first match to a variable
			$key = str_replace( [ 'lsx-', '-wrapper' ], '', $matches[0] );
		} else {
			return $block_content;
		}
		
		// Check to see if this is a taxonomy or a custom field.
		if ( taxonomy_exists( $key ) ) {
			$tax_args = array(
				'fields' => 'ids'
			);
			if ( empty( wp_get_post_terms( get_the_ID(), $key, $tax_args ) ) ) {
				$block_content = '';
			}
		} else {
			$key = str_replace( '-', '_', $key );
			$value = lsx_to_custom_field_query( $key, '', '', false );
			if ( empty( $value ) || '' === $value ) {
				$block_content = '';
			}
		}

		return $block_content;
	}
}
