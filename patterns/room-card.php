<?php
/**
 * Room Card Pattern
 *
 * A card layout for displaying accommodation units/rooms with
 * image, title, description, type, and price information.
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      1.0.0
 * @version    2.1.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
	'title'         => __( 'Room Card', 'tour-operator' ),
	'description'   => __( 'A horizontal card layout for accommodation units with image, description, and pricing.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'room', 'tour-operator' ),
	),
	'inserter'      => false,
	'content'       => '<!-- wp:columns {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":{"left":"0"}}}} -->
<div class="wp-block-columns" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Image', 'tour-operator' ) . '"},"className":"lsx-unit-image","style":{"layout":{"selfStretch":"fixed","flexSize":"275px"},"dimensions":{"minHeight":"275px"},"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-unit-image" style="min-height:275px"><!-- wp:image {"aspectRatio":"1","scale":"cover","sizeSlug":"medium","linkDestination":"none","className":"unit-image","style":{"border":{"radius":"0.5rem"},"layout":{"selfStretch":"fixed","flexSize":"275px"}}} -->
<figure class="wp-block-image size-medium has-custom-border unit-image"><img src="' . esc_url( LSX_TO_URL ) . 'assets/img/blocks/placeholder.png" alt="' . esc_attr__( 'Room image', 'tour-operator' ) . '" style="border-radius:0.5rem;aspect-ratio:1;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"className":"lsx-unit-content","style":{"spacing":{"padding":{"left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|40"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"default"}} -->
<div class="wp-block-group lsx-unit-content" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Room Heading', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"bottom":"var:preset|spacing|30"}},"border":{"bottom":{"width":"2px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="border-bottom-width:2px;padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:heading {"level":3,"className":"unit-title","fontSize":"large"} -->
<h3 class="wp-block-heading unit-title has-large-font-size">' . esc_html__( 'Room Title', 'tour-operator' ) . '</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"unit-description-wrapper","style":{"spacing":{"blockGap":"var:preset|spacing|30"},"layout":{"selfStretch":"fixed","flexSize":"60%"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group unit-description-wrapper"><!-- wp:paragraph {"className":"unit-description","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"medium"} -->
<p class="unit-description has-medium-font-size" style="margin-top:0">' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vehicula auctor nisl, ut suscipit purus consectetur dictum. Sed dapibus congue dolor sed iaculis. Fusce in molestie metus, vitae commodo nibh.', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Information', 'tour-operator' ) . '"},"className":"lsx-unit-info","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|40"},"border":{"radius":"0.5rem"},"layout":{"selfStretch":"fixed","flexSize":"40%"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-unit-info" style="border-radius:0.5rem;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:heading {"level":4,"fontSize":"large"} -->
<h4 class="wp-block-heading has-large-font-size">' . esc_html__( 'Information', 'tour-operator' ) . '</h4>
<!-- /wp:heading -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Info Items', 'tour-operator' ) . '"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'From Price Row', 'tour-operator' ) . '"},"className":"unit-price-wrapper","style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group unit-price-wrapper"><!-- wp:group {"style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:lsx-tour-operator/icons {"iconType":"outline","iconName":"priceIcon"} /-->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
<p class="has-medium-font-size" style="font-style:normal;font-weight:700">' . esc_html__( 'From:', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"name":"' . esc_attr__( 'Price Value', 'tour-operator' ) . '"},"className":"unit-price","fontSize":"medium"} -->
<p class="unit-price has-medium-font-size">' . esc_html__( 'Price', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Unit Type Row', 'tour-operator' ) . '"},"className":"unit-type-wrapper","style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group unit-type-wrapper"><!-- wp:group {"style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"accommodationTypeIcon"} /-->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"medium"} -->
<p class="has-medium-font-size" style="font-style:normal;font-weight:700">' . esc_html__( 'Unit Type:', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"name":"' . esc_attr__( 'Unit Type Value', 'tour-operator' ) . '"},"className":"unit-type","fontSize":"medium"} -->
<p class="unit-type has-medium-font-size">' . esc_html__( 'Unit type', 'tour-operator' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
);
