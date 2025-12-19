<?php
/**
 * Review Card Pattern
 *
 * A card layout for displaying testimonials/reviews in query loops.
 * Includes quotation icon, excerpt, and author name (post title).
 *
 * Based on Figma design: Testimonial Card / 3 /
 * Design system node: 9754-127718
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      2.1.0
 * @version    2.1.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
	'title'         => __( 'Review Card', 'tour-operator' ),
	'description'   => __( 'A card layout for displaying testimonial reviews in query loops with quotation mark and author information.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'review', 'tour-operator' ),
		__( 'testimonial', 'tour-operator' ),
		__( 'card', 'tour-operator' ),
		__( 'quote', 'tour-operator' ),
		__( 'quotation', 'tour-operator' ),
	),
	'postTypes'     => array( 'wp_template' ),
	'blockTypes'    => array( 'core/post-template' ),
	'templateTypes' => array( 'archive', 'single', 'archive-review', 'single-tour', 'single-accommodation', 'single-destination' ),
	'viewportWidth' => 400,
	'content'       => '<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Review Card', 'tour-operator' ) . '","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/review-card"},"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"layout":{"type":"flex","flexWrap":"nowrap","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"},"ariaLabel":"' . esc_attr__( 'Review Card', 'tour-operator' ) . '"} -->
<div aria-label="' . esc_attr__( 'Review Card', 'tour-operator' ) . '" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"quotationIcon","fontSize":"large"} /-->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Quote', 'tour-operator' ) . '"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-excerpt {"textAlign":"center","showMoreOnNewLine":false,"excerptLength":40,"fontSize":"medium"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Author', 'tour-operator' ) . '"},"style":"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Author Details', 'tour-operator' ) . '"},"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","flexWrap":"nowrap","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:post-title {"textAlign":"center","level":3,"isLink":false,"fontSize":"large","fontFamily":"heading"} /-->

<!-- wp:paragraph {"align":"center","metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"reviewer_name"}}}},"fontSize":"medium","fontFamily":"heading"} -->
<p class="has-text-align-center has-heading-font-family has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
);
