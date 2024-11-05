<?php
namespace lsx\blocks;


class Patterns {

	/**
	 * Holds the slug of the projects pattern category.
	 *
	 * @var string
	 */
	private $pattern_category = 'lsx-tour-operator';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		//Register our pattern category
		add_action( 'init', array( $this, 'register_block_category' ) );

		// Register our block patterns
		add_action( 'init', array( $this, 'register_block_patterns' ), 10 );
	}

	/**
	 * Registers the projects pattern category
	 *
	 * @return void
	 */
	public function register_block_category() {
		register_block_pattern_category(
			$this->pattern_category,
			array( 'label' => __( 'LSX Tour Operator', 'lsx-tour-operator' ) )
		);
	}  

	/**
	 * Registers our block patterns with the 
	 *
	 * @return void
	 */
	public function register_block_patterns() {
		$directory = LSX_TO_PATH . '/includes/patterns/';
		
		foreach ( glob( $directory . '*.php') as $file ) {
			// Extract the filename without the directory path and extension
			$filename = basename( $file, '.php' );
			
			// Use the filename to create the key
			$key = 'lsx-tour-operator/' . $filename;
		
			// Require the file and add it to the patterns array
			register_block_pattern( $key, require $file );
		}

		/*$patterns = array(
			'lsx-tour-operator/itinerary-list' => require( LSX_TO_PATH . '/includes/patterns/itinerary-list.php' ),
			'lsx-tour-operator/destination-card' => require( LSX_TO_PATH . '/includes/patterns/destination-card.php' ),
			'lsx-tour-operator/room-card' => require( LSX_TO_PATH . '/includes/patterns/room-card.php' ),
		);

		foreach ( $patterns as $key => $function ) {
			register_block_pattern( $key, $function );
		}*/
	}
}
