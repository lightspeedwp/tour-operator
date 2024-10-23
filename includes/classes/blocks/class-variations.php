<?php
namespace lsx\blocks;

/**
 * The creation of the block variants and the code to control the display.
 *
 * @package lsx
 * @author  LightSpeed
 */
class Variations {
	/**
	 * Holds instance of the class
	 *
	 * @since   1.1.0
	 * @var     \lsx\blocks\Variations
	 */
	private static $instance;

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

			if ( array_key_exists( get_post_type(), tour_operator()->get_post_types() ) ) {
				wp_enqueue_script(
					'lsx-to-slotfills',  // Handle for the script.
					LSX_TO_URL . 'assets/js/blocks/sticky-slotfill.js', // Path to your JavaScript file.
					array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),  // Dependencies.
					filemtime( LSX_TO_PATH . 'assets/js/blocks/sticky-slotfill.js' ), // Versioning with file modification time.
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

		$allowed_classes = array(
			'lsx-price-wrapper' => 'price',
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}
		if ( ! isset( $parsed_block['attrs']['className'] ) || '' === $parsed_block['attrs']['className'] || false === $parsed_block['attrs']['className'] ) {
			return $block_content;
		}

		if ( ! array_key_exists( $parsed_block['attrs']['className'], $allowed_classes ) ) {
			return $block_content;
		}

		$value = lsx_to_custom_field_query( 'price', '', '', false );
		if ( empty( $value ) || '' === $value ) {
			$block_content = '';
		}
		return $block_content;
	}
}
