<?php
namespace lsx\blocks;


class Patterns {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

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
	private function __construct() {
		//Register our pattern category
		add_action( 'init', array( $this, 'register_block_category' ) );

		// Register our block patterns
		add_action( 'init', array( $this, 'register_block_patterns' ), 10 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return  \lsx\blocks\Patterns
	 */
	public static function init() {

		// If the single instance hasn't been set, set it now.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
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
			'lsx-tour-operator/itinerary-card' => $this->itinerary_pattern( 'card' ),
		);

		foreach ( $patterns as $key => $function ) {
			register_block_pattern( $key, $function );
		}
	}

	/**
	 * Itinerary Pattern
	 *
	 * @return void
	 */
	public function itinerary_pattern( $style = 'card' ) {
		return array(
			'title'       => __( 'Itinerary (list)', 'lsx-projects' ),
			'description' => '',
			'categories'  => array( $this->pattern_category ),
			//'postTypes'  => array( 'tour' ),
			'blockTypes'  => array( 'core/group' ),
			'content'     => '
				<!-- wp:columns {"align":"wide"} -->
				<div class="wp-block-columns alignwide"><!-- wp:column {"width":"20%"} -->
				<div class="wp-block-column" style="flex-basis:20%"><!-- wp:image {"id":2981,"sizeSlug":"full","linkDestination":"none","className":"itinerary-image"} -->
				<figure class="wp-block-image size-full itinerary-image"><img src="https://beta.local/wp-content/uploads/2024/09/R0I3460.jpg" alt="" class="wp-image-2981" title=""/></figure>
				<!-- /wp:image --></div>
				<!-- /wp:column -->

				<!-- wp:column {"width":"80%"} -->
				<div class="wp-block-column" style="flex-basis:80%"><!-- wp:group {"layout":{"type":"constrained"}} -->
				<div class="wp-block-group"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"bottom":"10px"}},"border":{"bottom":{"color":"var:preset|color|primary","width":"2px"},"top":[],"right":[],"left":[]}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group alignwide" style="border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;padding-bottom:10px"><!-- wp:heading {"level":3,"align":"wide","className":"itinerary-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary"} -->
				<h3 class="wp-block-heading alignwide itinerary-title has-primary-color has-text-color has-link-color">Day 1 (itinerary day)</h3>
				<!-- /wp:heading --></div>
				<!-- /wp:group -->

				<!-- wp:columns {"align":"wide"} -->
				<div class="wp-block-columns alignwide"><!-- wp:column {"width":"66.66%"} -->
				<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:paragraph {"className":"itinerary-description","style":{"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary"} -->
				<p class="itinerary-description has-septenary-color has-text-color has-link-color"><strong>Itinerary Description</strong></p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:column -->

				<!-- wp:column {"width":"33.33%"} -->
				<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:group {"style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
				<div class="wp-block-group has-base-background-color has-background" style="border-radius:8px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="wp-block-group"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|senary"}}}},"textColor":"senary"} -->
				<p class="has-senary-color has-text-color has-link-color"><strong>Icon</strong></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p><strong>Location</strong>:</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"className":"itinerary-location","style":{"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary"} -->
				<p class="itinerary-location has-septenary-color has-text-color has-link-color"><strong>Location</strong></p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="wp-block-group"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|senary"}}}},"textColor":"senary"} -->
				<p class="has-senary-color has-text-color has-link-color"><strong>Icon</strong></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p><strong>Accommodation</strong>:</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"className":"itinerary-accommodation","style":{"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary"} -->
				<p class="itinerary-accommodation has-septenary-color has-text-color has-link-color"><strong>Accommodation </strong></p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="wp-block-group"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|senary"}}}},"textColor":"senary"} -->
				<p class="has-senary-color has-text-color has-link-color"><strong>Icon</strong></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p><strong>Type</strong>:</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"className":"itinerary-type","style":{"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary"} -->
				<p class="itinerary-type has-septenary-color has-text-color has-link-color"><strong>Accommodation Type </strong></p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="wp-block-group"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|senary"}}}},"textColor":"senary"} -->
				<p class="has-senary-color has-text-color has-link-color"><strong>Icon</strong></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p><strong>Drinks Basis</strong>:</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"className":"itinerary-drinks","style":{"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary"} -->
				<p class="itinerary-drinks has-septenary-color has-text-color has-link-color"><strong>Drinks Basis </strong></p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="wp-block-group"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|senary"}}}},"textColor":"senary"} -->
				<p class="has-senary-color has-text-color has-link-color"><strong>Icon</strong></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p><strong>Room Basis</strong>:</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"className":"itinerary-room","style":{"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary"} -->
				<p class="itinerary-room has-septenary-color has-text-color has-link-color"><strong>Room Basis </strong></p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:group --></div>
				<!-- /wp:group --></div>
				<!-- /wp:column --></div>
				<!-- /wp:columns --></div>
				<!-- /wp:group --></div>
				<!-- /wp:column --></div>
				<!-- /wp:columns -->
			',
		);
	}
}
