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
		$patterns = array(
			'lsx-tour-operator/itinerary-card' => require( LSX_TO_PATH . '/includes/patterns/itinerary-card.php' ),
		);

		foreach ( $patterns as $key => $function ) {
			register_block_pattern( $key, $function );
		}
	}
}
