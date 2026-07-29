<?php
/**
 * Accommodation Card Pattern
 *
 * A card layout for displaying accommodation in grid/query loops.
 * Includes featured image, title, price, type, room count, and excerpt.
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
	'title'         => __( 'Accommodation Card', 'tour-operator' ),
	'description'   => __( 'A card layout for displaying accommodation in grid/query loops with price and room information.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'accommodation', 'tour-operator' ),
		__( 'card', 'tour-operator' ),
		__( 'grid', 'tour-operator' ),
		__( 'hotel', 'tour-operator' ),
		__( 'lodge', 'tour-operator' ),
		__( 'rooms', 'tour-operator' ),
	),
	'postTypes'     => array( 'wp_template' ),
	'blockTypes'    => array( 'core/post-template'),
	'viewportWidth' => 400,
	'content'       => '<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Accommodation Card', 'tour-operator' ) . '","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/accommodation-card"},"className":"overflow-hidden is-style-shadow-sm","style":{"spacing":{"blockGap":"var:preset|spacing|20"},"border":{"radius":"0.5rem"}},"layout":{"type":"default"},"ariaLabel":"' . esc_attr__( 'Accommodation Card', 'tour-operator' ) . '"} -->
<div aria-label="' . esc_attr__( 'Accommodation Card', 'tour-operator' ) . '" class="wp-block-group overflow-hidden is-style-shadow-sm" style="border-radius:0.5rem"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank"} /-->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Accommodation Title', 'tour-operator' ) . '"},"className":"center-vertically","style":{"dimensions":{"minHeight":"3.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group center-vertically" style="min-height:3.75rem"><!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"style":{"elements":{"link":{":hover":{"color":{"text":"var:preset|color|primary-700"}}}}},"fontSize":"large"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Accommodation Information', 'tour-operator' ) . '"},"className":"lsx-accommodation-info","style":{"spacing":{"padding":{"left":"var:preset|spacing|20","right":"var:preset|spacing|20","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"},"blockGap":"0"},"border":{"top":{"width":"1px"},"bottom":{"width":"1px"}}},"fontSize":"medium","layout":{"type":"default"},"ariaLabel":"' . esc_attr__( 'Accommodation details', 'tour-operator' ) . '"} -->
<div aria-label="' . esc_attr__( 'Accommodation details', 'tour-operator' ) . '" class="wp-block-group lsx-accommodation-info has-medium-font-size" style="border-top-width:1px;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Price Row', 'tour-operator' ) . '"},"className":"lsx-price-wrapper","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-price-wrapper"><!-- wp:group {"className":"lsx-info-label","style":{"spacing":{"blockGap":"var:preset|spacing|10"},"layout":{"selfStretch":"fixed"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-info-label"><!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} /-->

<!-- wp:paragraph -->
<p>' . esc_html__( 'From:', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}},"__default":{"source":"core/pattern-overrides"}},"name":"' . esc_attr__( 'Price', 'tour-operator' ) . '"},"className":"lsx-info-value","style":{"spacing":{"padding":{"top":"0.125rem","bottom":"0.125rem"}}}} -->
<p class="lsx-info-value" style="padding-top:0.125rem;padding-bottom:0.125rem"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Type Row', 'tour-operator' ) . '"},"className":"lsx-accommodation-type-wrapper","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-accommodation-type-wrapper"><!-- wp:group {"className":"lsx-info-label","style":{"spacing":{"blockGap":"var:preset|spacing|10"},"layout":{"selfStretch":"fixed"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-info-label"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"accommodationTypeIcon"} /-->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Type:', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-info-value","style":{"spacing":{"padding":{"top":"0.125rem","bottom":"0.125rem"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group lsx-info-value"><!-- wp:post-terms {"term":"accommodation-type","className":"is-style-default","style":{"elements":{"link":{":hover":{"color":{"text":"var:preset|color|primary-700"}}}}},"fontSize":"medium"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Rooms Row', 'tour-operator' ) . '"},"className":"lsx-number-of-rooms-wrapper","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-number-of-rooms-wrapper"><!-- wp:group {"className":"lsx-info-label","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-info-label"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"roomBasisIcon"} /-->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Rooms:', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"number_of_rooms"}},"__default":{"source":"core/pattern-overrides"}},"name":"' . esc_attr__( 'Number of Rooms', 'tour-operator' ) . '"},"className":"lsx-info-value","style":{"spacing":{"padding":{"top":"0.125rem","bottom":"0.125rem"}}}} -->
<p class="lsx-info-value" style="padding-top:0.125rem;padding-bottom:0.125rem"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Accommodation Text Content', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":40,"fontSize":"medium", "className":"line-clamp-4"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"name":"Permalink"},"style":{"border":{"radius":"0px"}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#permalink" style="border-radius:0px">' . esc_html__( 'View more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
);
