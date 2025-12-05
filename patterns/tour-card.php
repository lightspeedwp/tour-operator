<?php
/**
 * Tour Card Pattern
 *
 * A card layout for displaying tours in grid/query loops.
 * Includes featured image, title, price, duration, and excerpt.
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      1.0.0
 * @version    2.1.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
	'title'         => __( 'Tour Card', 'tour-operator' ),
	'description'   => __( 'A card layout for displaying tours in grid/query loops with price and duration information.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'tour', 'tour-operator' ),
		__( 'card', 'tour-operator' ),
		__( 'grid', 'tour-operator' ),
		__( 'price', 'tour-operator' ),
		__( 'duration', 'tour-operator' ),
	),
	'postTypes'     => array( 'wp_template' ),
	'blockTypes'    => array( 'core/post-template'),
	'templateTypes' => array( 'archive', 'single', 'single-tour', 'archive-tour', 'single-accommodation' ),
	'viewportWidth' => 400,
	'content'       => '<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Tour Card', 'tour-operator' ) . '","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/tour-card"},"className":"overflow-hidden is-style-shadow-sm","style":{"spacing":{"blockGap":"var:preset|spacing|20"},"border":{"radius":"0.5rem"}},"layout":{"type":"constrained"},"ariaLabel":"' . esc_attr__( 'Tour Card', 'tour-operator' ) . '"} -->
<div aria-label="' . esc_attr__( 'Tour Card', 'tour-operator' ) . '" class="wp-block-group overflow-hidden is-style-shadow-sm" style="border-radius:0.5rem"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank"} /-->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Tour Title', 'tour-operator' ) . '"},"className":"center-vertically","style":{"dimensions":{"minHeight":"3.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group center-vertically" style="min-height:3.75rem"><!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"style":{"elements":{"link":{":hover":{"color":{"text":"var:preset|color|primary-700"}}}}},"fontSize":"large"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Tour Information', 'tour-operator' ) . '"},"className":"lsx-tour-info","style":{"spacing":{"padding":{"left":"var:preset|spacing|20","right":"var:preset|spacing|20","top":"0.63rem","bottom":"0.63rem"},"blockGap":"0"},"border":{"top":{"width":"1px"},"bottom":{"width":"1px"}}},"fontSize":"medium","layout":{"type":"constrained"},"ariaLabel":"' . esc_attr__( 'Tour details', 'tour-operator' ) . '"} -->
<div aria-label="' . esc_attr__( 'Tour details', 'tour-operator' ) . '" class="wp-block-group lsx-tour-info has-medium-font-size" style="border-top-width:1px;border-bottom-width:1px;padding-top:0.63rem;padding-right:var(--wp--preset--spacing--20);padding-bottom:0.63rem;padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Price Row', 'tour-operator' ) . '"},"className":"lsx-price-wrapper","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-price-wrapper"><!-- wp:group {"className":"lsx-info-label","style":{"spacing":{"blockGap":"0.3125rem"},"layout":{"selfStretch":"fixed","flexSize":"5rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-info-label"><!-- wp:lsx-tour-operator/icons {"iconName":"priceIcon"} /-->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"0.125rem","bottom":"0.125rem"}}}} -->
<p style="padding-top:0.125rem;padding-bottom:0.125rem">' . esc_html__( 'From:', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}},"__default":{"source":"core/pattern-overrides"}},"name":"' . esc_attr__( 'Price', 'tour-operator' ) . '"},"className":"lsx-info-value","style":{"spacing":{"padding":{"top":"0.125rem","bottom":"0.125rem"}}}} -->
<p class="lsx-info-value" style="padding-top:0.125rem;padding-bottom:0.125rem"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Duration Row', 'tour-operator' ) . '"},"className":"lsx-duration-wrapper","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-duration-wrapper"><!-- wp:group {"className":"lsx-info-label","style":{"spacing":{"blockGap":"0.3125rem"},"layout":{"selfStretch":"fixed","flexSize":"5rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group lsx-info-label"><!-- wp:lsx-tour-operator/icons {"iconName":"durationIcon"} /-->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"0.125rem","bottom":"0.125rem"}}}} -->
<p style="padding-top:0.125rem;padding-bottom:0.125rem">' . esc_html__( 'Duration:', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-info-value","style":{"spacing":{"padding":{"top":"0.125rem","bottom":"0.125rem"},"blockGap":"0.25rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group lsx-info-value" style="padding-top:0.125rem;padding-bottom:0.125rem"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"duration"}},"__default":{"source":"core/pattern-overrides"}},"name":"' . esc_attr__( 'Duration', 'tour-operator' ) . '"}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Days', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Tour Text Content', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":40,"fontSize":"medium","className":"line-clamp-4"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"name":"Permalink"},"style":{"border":{"radius":"0px"}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#permalink" style="border-radius:0px">' . esc_html__( 'View more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
);
