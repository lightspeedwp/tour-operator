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
<div class="wp-block-group alignwide travel-information is-style-section-9" aria-label="' . esc_attr__( 'Travel information categories', 'tour-operator' ) . '"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Additional Info', 'tour-operator' ) . '"},"align":"full","className":"lsx-general-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull lsx-general-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-general">' . esc_html__( 'General', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"content","layout":{"type":"constrained"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"additional_info"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-general" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Banking', 'tour-operator' ) . '"},"className":"lsx-banking-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-banking-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-banking">' . esc_html__( 'Banking', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"banking"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-banking" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Climate', 'tour-operator' ) . '"},"className":"lsx-climate-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-climate-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-climate">' . esc_html__( 'Climate', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"climate"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-climate" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Cuisine', 'tour-operator' ) . '"},"className":"lsx-cuisine-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-cuisine-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-cuisine">' . esc_html__( 'Cuisine', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"cuisine"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-cuisine" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Electricity', 'tour-operator' ) . '"},"className":"lsx-electricity-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-electricity-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-electricity">' . esc_html__( 'Electricity', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"content","layout":{"type":"constrained"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"electricity"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"fontSize":"medium"} -->
<p class="has-medium-font-size" style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"name":"' . esc_attr__( 'More Button', 'tour-operator' ) . '"},"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-electricity" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Dress', 'tour-operator' ) . '"},"className":"lsx-dress-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-dress-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-dress">' . esc_html__( 'Dress', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"dress"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-dress" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Health', 'tour-operator' ) . '"},"className":"lsx-health-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-health-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-health">' . esc_html__( 'Health', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"health"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-health" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Safety', 'tour-operator' ) . '"},"className":"lsx-safety-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-safety-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-safety">' . esc_html__( 'Safety', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"safety"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-safety" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Transport', 'tour-operator' ) . '"},"className":"lsx-transport-wrapper additional-info is-style-shadow-sm overflow-hidden","style":{"border":{"radius":"0.5rem"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-transport-wrapper additional-info is-style-shadow-sm overflow-hidden has-base-background-color has-contrast-color has-text-color has-background" style="border-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-transport">' . esc_html__( 'Transport', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"transport"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-transport" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Visa', 'tour-operator' ) . '"},"className":"lsx-visa-wrapper additional-info is-style-shadow-xsm is-style-default overflow-hidden","style":{"border":{"radius":{"topLeft":"0.5rem","topRight":"0.5rem","bottomLeft":"0.5rem","bottomRight":"0.5rem"}}},"backgroundColor":"custom-white","textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-visa-wrapper additional-info is-style-shadow-xsm is-style-default overflow-hidden has-custom-white-background-color has-contrast-color has-text-color has-background" style="border-top-left-radius:0.5rem;border-top-right-radius:0.5rem;border-bottom-left-radius:0.5rem;border-bottom-right-radius:0.5rem"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Content', 'tour-operator' ) . '"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Title', 'tour-operator' ) . '"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4,"textColor":"contrast","fontSize":"large"} -->
<h4 class="wp-block-heading has-text-align-center has-contrast-color has-text-color has-large-font-size" id="h-visa">' . esc_html__( 'Visa', 'tour-operator' ) . '</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Description', 'tour-operator' ) . '"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"visa"}}}},"fontSize":"medium"} -->
<p class="has-medium-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-visa" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px">' . esc_html__( 'Read more', 'tour-operator' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->',
);
