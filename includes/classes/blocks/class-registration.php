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
		add_action( 'init', array( $this, 'register_block_json_files' ), 10 );
	}

	/**
	 * Register the block json files.
	 *
	 * @return void
	 */
	public function register_block_json_files() {
		$directory = LSX_TO_PATH . 'includes/blocks/';

		foreach ( glob( $directory . '*', GLOB_ONLYDIR ) as $key ) {
			$key  = basename( $key );
			$block_folder = $directory . $key;
			$build_folder = $block_folder . '/build';

			if ( is_dir( $build_folder ) ) {
				$js_file = $build_folder . '/index.js';
				$block_json_path = $build_folder;
				$js_url = LSX_TO_URL . 'includes/blocks/' . $key . '/build/index.js';
			} else {
				$js_file = $block_folder . '/index.js';
				$block_json_path = $block_folder;
				$js_url = LSX_TO_URL . 'includes/blocks/' . $key . '/index.js';
			}

			if ( file_exists( $js_file ) ) {
				wp_register_script(
					'lsx-to-block-' . $key,
					$js_url,
					array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'lsx-to-block-general-variations' ),
					filemtime( $js_file ),
					[ 'in_footer' => true ]
				);
			}

			// Registers block using the metadata loaded from block.json.
			register_block_type( $block_json_path );
		}
	}

	/**
	 * Registers our variations block assets
	 *
	 * @return void
	 */
	public function enqueue_block_variations_script() {
		$scripts = [
			'general'       => array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
		];

		$additional_scripts = [
			'linked-cover' => array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-data', 'wp-hooks' ),
			'slider-query' => array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-compose' ),
		];

		// Make sure the script is only enqueued in the block editor.
		if ( is_admin() && function_exists( 'register_block_type' ) ) {

			foreach ( $scripts as $slug => $restrictions ) {
				wp_enqueue_script(
					'lsx-to-block-' . $slug . '-variations',  // Handle for the script.
					LSX_TO_URL . 'assets/js/blocks/' . $slug . '.js', // Path to your JavaScript file.
					array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),  // Dependencies.
					filemtime( LSX_TO_PATH . 'assets/js/blocks/' . $slug . '.js' ), // Versioning with file modification time.
					[ 'in_footer' => true ]
				);
				if ( 'general' === $slug ) {
					$param_array = array(
						'homeUrl'   => trailingslashit( home_url() ),
						'assetsUrl' => LSX_TO_URL . 'assets/img/'
					);
					$param_array = apply_filters( 'lsx_to_editor_params', $param_array );
					wp_localize_script( 'lsx-to-block-' . $slug . '-variations', 'lsxToEditor', $param_array );
				}
			}

			foreach ( $additional_scripts as $slug => $dependancies ) {
				wp_enqueue_script(
					'lsx-to-' . $slug,
					LSX_TO_URL . 'assets/js/blocks/' . $slug . '.js',
					$dependancies,
					filemtime( LSX_TO_PATH . 'assets/js/blocks/' . $slug . '.js' ),
					[ 'in_footer' => true ]
				);
			}

			if ( array_key_exists( get_post_type(), tour_operator()->get_post_types() ) ) {
				wp_enqueue_script(
					'lsx-to-slotfills',  // Handle for the script.
					LSX_TO_URL . 'assets/js/blocks/slotfills.js', // Path to your JavaScript file.
					array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),  // Dependencies.
					filemtime( LSX_TO_PATH . 'assets/js/blocks/slotfills.js' ), // Versioning with file modification time.
					[ 'in_footer' => true ]
				);
			}
		}
	}
}
