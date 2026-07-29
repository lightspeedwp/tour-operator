<?php
/**
 * Itinerary List Pattern
 *
 * A list display layout for tour itineraries showing day-by-day details
 * including location, accommodation, type, drinks basis, and room basis.
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
	'title'         => __( 'Itinerary Item', 'tour-operator' ),
	'description'   => __( 'A single itinerary day item with image, description, and accommodation details.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'itinerary', 'tour-operator' ),
	),
	'inserter'      => false,
	'content'       => '<!-- wp:columns {"align":"full","style":{"spacing":{"blockGap":{"left":"0"}}}} -->
<div class="wp-block-columns alignfull"><!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Image', 'tour-operator' ) . '"},"className":"itinerary-image","style":{"layout":{"selfStretch":"fixed","flexSize":"300px"},"dimensions":{"minHeight":"300px"},"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group itinerary-image" style="min-height:300px"><!-- wp:image {"aspectRatio":"1","scale":"cover","sizeSlug":"medium","linkDestination":"none","className":"itinerary-image","style":{"border":{"radius":"8px"},"layout":{"selfStretch":"fixed","flexSize":"300px"}}} -->
<figure class="wp-block-image size-medium has-custom-border itinerary-image"><img src="' . esc_url( LSX_TO_URL ) . 'assets/img/blocks/placeholder.png" alt="' . esc_attr__( 'Itinerary day image', 'tour-operator' ) . '" style="border-radius:8px;aspect-ratio:1;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"className":"lsx-itinerary-content","style":{"spacing":{"padding":{"left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|40"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"default"}} -->
<div class="wp-block-group lsx-itinerary-content" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Day Heading', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"bottom":"var:preset|spacing|30"}},"border":{"bottom":{"width":"2px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="border-bottom-width:2px;padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:heading {"level":3,"className":"itinerary-title","fontSize":"large"} -->
<h3 class="wp-block-heading itinerary-title has-large-font-size">' . esc_html__( 'Day 1 - 3', 'tour-operator' ) . '</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"itinerary-description-wrapper","style":{"spacing":{"blockGap":"var:preset|spacing|30"},"layout":{"selfStretch":"fixed","flexSize":"60%"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group itinerary-description-wrapper"><!-- wp:paragraph {"className":"itinerary-description","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"medium"} -->
<p class="itinerary-description has-medium-font-size" style="margin-top:0">' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vehicula auctor nisl, ut suscipit purus consectetur dictum. Sed dapibus congue dolor sed iaculis. Fusce in molestie metus, vitae commodo nibh.', 'tour-operator' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:read-more {"className":"is-style-default"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Information', 'tour-operator' ) . '"},"className":"lsx-itinerary-info","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|30"},"border":{"radius":"0.5rem"},"layout":{"selfStretch":"fixed","flexSize":"40%"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-itinerary-info has-base-background-color has-background" style="border-radius:0.5rem;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)">


<!-- wp:group {"metadata":{"name":"Location Row"},"className":"itin-location-wrapper","style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group itin-location-wrapper"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"destinationIcon"} /-->
<!-- wp:paragraph {"metadata":{"name":"Location Value"},"className":"itinerary-location","fontSize":"medium","prefix":"Location:","prefixBold":true} -->
<p class="itinerary-location has-medium-font-size">Card Link</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->


<!-- wp:group {"metadata":{"name":"Accommodation Row"},"className":"itin-accommodation-wrapper","style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group itin-accommodation-wrapper"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"accommodationIcon"} /-->
<!-- wp:paragraph {"metadata":{"name":"Accommodation Value"},"className":"itinerary-accommodation","fontSize":"medium","prefix":"Accommodation:","prefixBold":true} -->
<p class="itinerary-accommodation has-medium-font-size">Card Link</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->


<!-- wp:group {"metadata":{"name":"Type Row"},"className":"itin-type-wrapper","style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group itin-type-wrapper"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"accommodationTypeIcon"} /-->
<!-- wp:paragraph {"metadata":{"name":"Type Value"},"className":"itinerary-type","fontSize":"medium","prefix":"Type:","prefixBold":true} -->
<p class="itinerary-type has-medium-font-size">Card Link</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->


<!-- wp:group {"metadata":{"name":"Drinks Basis Row"},"className":"itin-drinks-wrapper","style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group itin-drinks-wrapper"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"drinksBasisIcon"} /-->
<!-- wp:paragraph {"metadata":{"name":"Drinks Basis Value"},"className":"itinerary-drinks","fontSize":"medium","prefix":"Drinks Basis:","prefixBold":true} -->
<p class="itinerary-drinks has-medium-font-size">Card Link</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->


<!-- wp:group {"metadata":{"name":"Room Basis Row"},"className":"itin-room-wrapper","style":{"spacing":{"blockGap":"0.3125rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group itin-room-wrapper"><!-- wp:lsx-tour-operator/icons {"iconType":"solid","iconName":"roomBasisIcon"} /-->
<!-- wp:paragraph {"metadata":{"name":"Room Basis Value"},"className":"itinerary-room","fontSize":"medium","prefix":"Room Basis:","prefixBold":true} -->
<p class="itinerary-room has-medium-font-size">Card Link</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->


</div><!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
);
