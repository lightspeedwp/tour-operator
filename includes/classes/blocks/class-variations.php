<?php
namespace lsx\blocks;

/**
 * Registers our Custom Fields
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
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return  \lsx\blocks\Bindings
	 */
	public static function init() {

		// If the single instance hasn't been set, set it now.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
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
		}
	}
}
