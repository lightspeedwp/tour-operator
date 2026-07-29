<?php
/**
 * Destination Card Pattern
 *
 * A card layout for displaying destinations in grid/query loops.
 * Includes featured image, title, excerpt, and a view button.
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      1.0.0
 * @version    2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
	'title'         => __( 'Destination Card', 'tour-operator' ),
	'description'   => __( 'A card layout for displaying destinations in grid/query loops.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'destination', 'tour-operator' ),
		__( 'card', 'tour-operator' ),
		__( 'grid', 'tour-operator' ),
		__( 'country', 'tour-operator' ),
		__( 'region', 'tour-operator' ),
		__( 'location', 'tour-operator' ),
	),
	'postTypes'     => array( 'wp_template' ),
	'blockTypes'    => array( 'core/post-template'),
	'viewportWidth' => 400,
	'content'       => '<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Destination Card', 'tour-operator' ) . '","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/destination-card"},"className":"overflow-hidden is-style-shadow-sm","style":{"spacing":{"blockGap":"var:preset|spacing|20"},"border":{"radius":"0.5rem"}},"layout":{"type":"default"},"ariaLabel":"' . esc_attr__( 'Destination Card', 'tour-operator' ) . '"} -->
<div aria-label="' . esc_attr__( 'Destination Card', 'tour-operator' ) . '" class="wp-block-group overflow-hidden is-style-shadow-sm" style="border-radius:0.5rem"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank"} /-->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Destination Title', 'tour-operator' ) . '"},"className":"center-vertically","style":{"dimensions":{"minHeight":"3.75rem"},"border":{"bottom":{"width":"1px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group center-vertically" style="border-bottom-width:1px;min-height:3.75rem"><!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"style":{"elements":{"link":{":hover":{"color":{"text":"var:preset|color|primary-700"}}}}},"fontSize":"large"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Destination Text Content', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","bottom":"var:preset|spacing|20","top":"var:preset|spacing|20"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":40,"fontSize":"medium","className":"line-clamp-4"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"name":"Permalink"},"style":{"border":{"radius":"0px"}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#permalink" style="border-radius:0px">' . esc_html__( 'View more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
);
