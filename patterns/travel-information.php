<?php
/**
 * Travel Information Pattern
 *
 * A grid section displaying various travel information categories
 * such as banking, climate, cuisine, electricity, dress, health,
 * safety, transport, and visa information for destinations.
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      1.0.0
 * @version    2.1.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

/**
 * Travel Information Cards Configuration
 *
 * Define all travel information cards in a single array.
 * Each card requires: slug, title, and meta_key.
 * Optional: wrapper_class, align (defaults to 'full').
 */
$travel_info_cards = array(
	array(
		'slug'          => 'general',
		'title'         => __( 'General', 'tour-operator' ),
		'meta_key'      => 'additional_info',
		'wrapper_class' => 'lsx-general-wrapper',
	),
	array(
		'slug'          => 'banking',
		'title'         => __( 'Banking', 'tour-operator' ),
		'meta_key'      => 'banking',
		'wrapper_class' => 'lsx-banking-wrapper',
	),
	array(
		'slug'          => 'climate',
		'title'         => __( 'Climate', 'tour-operator' ),
		'meta_key'      => 'climate',
		'wrapper_class' => 'lsx-climate-wrapper',
	),
	array(
		'slug'          => 'cuisine',
		'title'         => __( 'Cuisine', 'tour-operator' ),
		'meta_key'      => 'cuisine',
		'wrapper_class' => 'lsx-cuisine-wrapper',
	),
	array(
		'slug'          => 'electricity',
		'title'         => __( 'Electricity', 'tour-operator' ),
		'meta_key'      => 'electricity',
		'wrapper_class' => 'lsx-electricity-wrapper',
	),
	array(
		'slug'          => 'dress',
		'title'         => __( 'Dress', 'tour-operator' ),
		'meta_key'      => 'dress',
		'wrapper_class' => 'lsx-dress-wrapper',
	),
	array(
		'slug'          => 'health',
		'title'         => __( 'Health', 'tour-operator' ),
		'meta_key'      => 'health',
		'wrapper_class' => 'lsx-health-wrapper',
	),
	array(
		'slug'          => 'safety',
		'title'         => __( 'Safety', 'tour-operator' ),
		'meta_key'      => 'safety',
		'wrapper_class' => 'lsx-safety-wrapper',
	),
	array(
		'slug'          => 'transport',
		'title'         => __( 'Transport', 'tour-operator' ),
		'meta_key'      => 'transport',
		'wrapper_class' => 'lsx-transport-wrapper',
	),
	array(
		'slug'          => 'visa',
		'title'         => __( 'Visa', 'tour-operator' ),
		'meta_key'      => 'visa',
		'wrapper_class' => 'lsx-visa-wrapper',
	),
);

/**
 * Generate card markup for a single travel information card
 *
 * @param array $card Card configuration array.
 * @return string Card HTML markup.
 */
function lsx_to_generate_travel_info_card( $card ) {
	$slug          = $card['slug'];
	$title         = $card['title'];
	$meta_key      = $card['meta_key'];
	$wrapper_class = isset( $card['wrapper_class'] ) ? $card['wrapper_class'] : 'lsx-' . $slug . '-wrapper';

	// Build outer group opening comment.
	$markup = '<!-- wp:group {"metadata":{"name":"' . esc_attr( $title ) . '"},"className":"' . esc_attr( $wrapper_class ) . ' additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->' . "\n";

	// Opening div with proper classes.
	$markup .= '<div class="wp-block-group ' . esc_attr( $wrapper_class ) . ' additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem">';

	// Content wrapper group opening comment.
	$markup .= '<!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->' . "\n";

	// Content div.
	$markup .= '<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)">';

	// Title group.
	$markup .= '<!-- wp:group {"layout":{"type":"constrained"}} -->' . "\n";
	$markup .= '<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->' . "\n";
	$markup .= '<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-' . esc_attr( $slug ) . '">' . esc_html( $title ) . '</h4>' . "\n";
	$markup .= '<!-- /wp:heading --></div>' . "\n";
	$markup .= '<!-- /wp:group -->' . "\n\n";

	// Description with binding.
	$markup .= '<!-- wp:group {"className":"content","layout":{"type":"constrained"}} -->' . "\n";
	$markup .= '<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"' . esc_attr( $meta_key ) . '"}}}},"fontSize":"medium"} -->' . "\n";
	$markup .= '<p class="has-medium-font-size"></p>' . "\n";
	$markup .= '<!-- /wp:paragraph --></div>' . "\n";
	$markup .= '<!-- /wp:group --></div>' . "\n";
	$markup .= '<!-- /wp:group -->' . "\n\n";

	// Read more button.
	$markup .= '<!-- wp:buttons -->' . "\n";
	$markup .= '<div class="wp-block-buttons">';

	$markup .= '<!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->' . "\n";
	$markup .= '<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-' . esc_attr( $slug ) . '" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>' . "\n";
	$markup .= '<!-- /wp:button --></div>' . "\n";
	$markup .= '<!-- /wp:buttons --></div>' . "\n";
	$markup .= '<!-- /wp:group -->' . "\n\n";

	return $markup;
}// Generate all card markups.
$cards_markup = '';
foreach ( $travel_info_cards as $card ) {
	$cards_markup .= lsx_to_generate_travel_info_card( $card );
}

return array(
	'title'         => __( 'Travel Information', 'tour-operator' ),
	'description'   => __( 'Display travel information such as banking, climate, cuisine, and visa details for a destination.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'travel', 'tour-operator' ),
		__( 'information', 'tour-operator' ),
		__( 'banking', 'tour-operator' ),
		__( 'climate', 'tour-operator' ),
		__( 'visa', 'tour-operator' ),
		__( 'destination', 'tour-operator' ),
	),
	'postTypes'     => array( 'wp_template' ),
	'content'       => '<!-- wp:group {"tagName":"section","metadata":{"name":"' . esc_attr__( 'Travel Information', 'tour-operator' ) . '","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/travel-information"},"align":"wide","className":"lsx-travel-information-wrapper lsx-to-slider","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignwide lsx-travel-information-wrapper lsx-to-slider" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|small","left":"0","right":"0"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Travel Information', 'tour-operator' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","className":"travel-information is-style-section-9","layout":{"type":"grid"},"ariaLabel":"' . esc_attr__( 'Travel information categories', 'tour-operator' ) . '"} -->
<div class="wp-block-group alignwide travel-information is-style-section-9" aria-label="' . esc_attr__( 'Travel information categories', 'tour-operator' ) . '">' . $cards_markup . '</div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->',
);
