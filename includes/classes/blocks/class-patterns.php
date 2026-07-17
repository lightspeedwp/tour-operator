<?php
/**
 * Patterns Registration
 *
 * Handles the registration of block patterns and pattern categories
 * for the Tour Operator plugin.
 *
 * @package    Tour_Operator
 * @subpackage Blocks
 * @since      1.0.0
 * @version    2.1.0
 */

namespace lsx\blocks;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Patterns
 *
 * Registers block patterns and pattern categories for the Tour Operator plugin.
 *
 * @since 1.0.0
 */
class Patterns {

	/**
	 * Holds the slug of the main pattern category.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $category = 'lsx-tour-operator';

	/**
	 * Pattern categories to register.
	 *
	 * @since 2.1.0
	 * @var array
	 */
	private $categories = array();

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->categories = array(
			'lsx-tour-operator'    => __( 'Tour Operator', 'tour-operator' ),
		);

		// Register our categories.
		add_filter( 'block_categories_all', array( $this, 'register_block_category' ), 10, 1 );
		add_action( 'init', array( $this, 'register_block_pattern_categories' ) );

		// Register our block patterns.
		add_action( 'init', array( $this, 'register_block_patterns' ), 10 );
	}

	/**
	 * Registers the block category for the editor.
	 *
	 * @since 1.0.0
	 *
	 * @param array $categories Existing categories.
	 * @return array Modified categories array.
	 */
	public function register_block_category( $categories ) {
		$categories[] = array(
			'slug'  => $this->category,
			'title' => __( 'Tour Operator', 'tour-operator' ),
		);
		return $categories;
	}

	/**
	 * Registers all pattern categories.
	 *
	 * @since 2.1.0
	 *
	 * @return void
	 */
	public function register_block_pattern_categories() {
		foreach ( $this->categories as $slug => $label ) {
			register_block_pattern_category(
				$slug,
				array( 'label' => $label )
			);
		}
	}

	/**
	 * Registers block patterns from the patterns directory.
	 *
	 * Loads patterns from the root /patterns/ directory.
	 *
	 * @since 1.0.0
	 * @since 2.1.0 Updated to load from root /patterns/ directory.
	 *
	 * @return void
	 */
	public function register_block_patterns() {
		$directory = LSX_TO_PATH . 'patterns/';

		if ( ! is_dir( $directory ) ) {
			return;
		}

		foreach ( glob( $directory . '*.php' ) as $file ) {
			// Extract the filename without the directory path and extension.
			$filename = basename( $file, '.php' );

			// Use the filename to create the key.
			$key = 'lsx-tour-operator/' . $filename;

			// Check if pattern is already registered.
			if ( \WP_Block_Patterns_Registry::get_instance()->is_registered( $key ) ) {
				continue;
			}

			// Require the file and register the pattern.
			register_block_pattern( $key, require $file );
		}
	}
}
