<?php
// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
return array(
	'title'         => __( 'Single Country', 'tour-operator' ),
	'description'   => __( 'Displays a single country page', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'templateTypes' => array( 'single' ),
	'content'     => '
    <!-- wp:group {"style":{"position":{"type":"sticky","top":"0px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:template-part {"slug":"header","area":"header"} /--></div>
<!-- /wp:group -->

<!-- wp:cover {"useFeaturedImage":true,"dimRatio":70,"overlayColor":"secondary-900","isUserOverlayColor":true,"metadata":{"name":"Hero"},"align":"full","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-cover alignfull" style="margin-top:0;margin-bottom:0"><span aria-hidden="true" class="wp-block-cover__background has-secondary-900-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:group {"style":{"spacing":{"padding":{"top":"10px","bottom":"10px"}},"border":{"bottom":{"color":"var:preset|color|primary-200","width":"2px"},"top":[],"right":[],"left":[]}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--primary-200);border-bottom-width:2px;padding-top:10px;padding-bottom:10px"><!-- wp:post-title {"textAlign":"center","level":1,"className":"wp-block-heading has-text-align-center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-200"}}}},"textColor":"primary-200"} /--></div>
<!-- /wp:group -->

<!-- wp:paragraph {"align":"center","metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"tagline"}}}},"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-200"}}}},"textColor":"primary-200","fontSize":"small"} -->
<p class="has-text-align-center has-primary-200-color has-text-color has-link-color has-small-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:group {"metadata":{"name":"Breadcrumbs"},"align":"full","style":{"spacing":{"padding":{"top":"6px","bottom":"6px","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}},"elements":{"link":{":hover":{"color":{"text":"var:preset|color|tertiary"}},"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"primary-900","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-primary-900-background-color has-text-color has-background has-link-color" style="margin-top:0;margin-bottom:0;padding-top:6px;padding-right:var(--wp--preset--spacing--x-small);padding-bottom:6px;padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:yoast-seo/breadcrumbs /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description \u0026 Fast Facts"},"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"primary-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide has-primary-bg-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|x-small","left":"var:preset|spacing|medium"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:post-title {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-900"}}}},"textColor":"primary-900"} /-->

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-small)"><!-- wp:post-content {"align":"wide","layout":{"type":"default"}} /-->

<!-- wp:read-more {"content":"Read More","fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:group {"align":"wide","className":"is-style-shadow-m","style":{"spacing":{"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"blockGap":"var:preset|spacing|x-small"},"border":{"radius":"8px","width":"3px"}},"backgroundColor":"base","borderColor":"primary-700","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide is-style-shadow-m has-border-color has-primary-700-border-color has-base-background-color has-background" style="border-width:3px;border-radius:8px;padding-top:var(--wp--preset--spacing--x-small);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-small);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Fast Facts</h3>
<!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"Regions List"},"className":"facts-regions-query-wrapper","style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group facts-regions-query-wrapper"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large"} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tourpress.pro/wp-content/uploads/2024/09/destinations-icon-black-20px.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"x-small"} -->
<p class="has-x-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Regions:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"5px","padding":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-connection","args":{"key":"post_children"}}}},"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}},"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"textColor":"primary-700"} -->
<p class="has-primary-700-color has-text-color has-link-color" style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-travel-style-wrapper","style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-travel-style-wrapper"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large"} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tourpress.pro/wp-content/uploads/2024/09/Typetype-icon.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"fontSize":"x-small"} -->
<p class="has-x-small-font-size" style="padding-top:2px;padding-bottom:2px"><strong>Travel Styles:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fill","flexSize":null},"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"travel-style","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|primary-700"},":hover":{"color":{"text":"var:preset|color|primary-900"}}}}},"textColor":"primary-700","fontSize":"x-small","fontFamily":"secondary"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-best-time-to-visit-wrapper","style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-best-time-to-visit-wrapper"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large"} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tourpress.pro/wp-content/uploads/2024/09/best-months-to-travel-TO-icon-black-20px-1-1.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"fontSize":"x-small"} -->
<p class="has-x-small-font-size" style="padding-top:2px;padding-bottom:2px"><strong>Best Months to Visit:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"best_time_to_visit"}}}},"className":"has-septenary-color has-text-color has-link-color","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}},"typography":{"textTransform":"capitalize"}},"textColor":"primary-700"} -->
<p class="has-septenary-color has-text-color has-link-color has-primary-700-color" style="text-transform:capitalize">Best Months to Visit</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"width":100,"className":"popmake-61261 is-style-cta","style":{"border":{"radius":"4px"}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 popmake-61261 is-style-cta"><a class="wp-block-button__link wp-element-button" style="border-radius:4px">Enquire Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Regions"},"align":"full","className":"lsx-regions-query-wrapper","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"blockGap":"var:preset|spacing|small","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull lsx-regions-query-wrapper" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|small","left":"0","right":"0"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Regions</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":3,"query":{"perPage":8,"postType":"destination","order":"asc","orderBy":"date"},"metadata":{"name":"Regions Query"},"align":"wide"} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"className":"lsx-regions-query","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"metadata":{"name":"Destination Card"},"className":"is-style-shadow-sm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-shadow-sm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"8px","topRight":"8px"}}}} /-->

<!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"0px","left":"10px","right":"10px"}},"dimensions":{"minHeight":"97px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="min-height:97px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Tour Title"},"className":"center-vertically","style":{"dimensions":{"minHeight":"4rem"},"border":{"bottom":{"color":"var:preset|color|primary","width":"2px"}},"spacing":{"padding":{"bottom":"10px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group center-vertically" style="border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;min-height:4rem;padding-bottom:10px"><!-- wp:post-title {"textAlign":"center","isLink":true,"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Destination Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-septenary-color has-text-color has-link-color" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Travel Information"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"primary-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-primary-bg-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|small","left":"0","right":"0"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Travel Information</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary","fontSize":"medium"} -->
<p class="has-septenary-color has-text-color has-link-color has-medium-font-size"><strong>Slider</strong></p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Additional Info"},"className":"lsx-additional-info-wrapper","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"},"blockGap":"0px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>General</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"additional_info"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Electricity"},"className":"lsx-electricity-wrapper","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"},"blockGap":"0px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-electricity-wrapper has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Electricity</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"electricity"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Banking"},"className":"lsx-banking-wrapper","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"},"blockGap":"0px"},"layout":{"selfStretch":"fixed","flexSize":"25%"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-banking-wrapper has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Banking</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"lsx-to-more-content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-to-more-content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"banking"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"name":"More Button"},"className":"lsx-to-more-link ","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Cuisine"},"className":"lsx-additional-info-wrapper is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Cuisine</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"cuisine"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Climate"},"className":"lsx-additional-info-wrapper is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Climate</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"climate"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Transport"},"className":"lsx-additional-info-wrapper is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Transport</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"transport"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Dress"},"className":"lsx-additional-info-wrapper is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Dress</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"dress"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Health"},"className":"lsx-additional-info-wrapper is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Health</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"health"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Safety"},"className":"lsx-additional-info-wrapper is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Safety</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"safety"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"metadata":{"name":"Visa"},"className":"lsx-additional-info-wrapper is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Visa</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"visa"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Gallery"},"className":"lsx-gallery-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-gallery-wrapper" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|small","left":"0","right":"0"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Gallery</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:gallery {"linkTo":"none","sizeSlug":"thumbnail","metadata":{"name":"TO Gallery","bindings":{"content":{"source":"lsx/gallery"}}},"align":"wide"} -->
<figure class="wp-block-gallery alignwide has-nested-images columns-default is-cropped"><!-- wp:image -->
<figure class="wp-block-image"><a href="https://tourpress.pro/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg"><img alt=""/></a></figure>
<!-- /wp:image -->

<!-- wp:image -->
<figure class="wp-block-image"><a href="https://tourpress.pro/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg"><img alt=""/></a></figure>
<!-- /wp:image -->

<!-- wp:image -->
<figure class="wp-block-image"><a href="https://tourpress.pro/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg"><img alt=""/></a></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Related Tours"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"primary-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-primary-bg-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|small","left":"0","right":"0"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Related Tours</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":1,"query":{"perPage":"3","pages":"3","offset":"0","postType":"tour","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"align":"wide","layout":{"type":"constrained","contentSize":""}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"lock":{"move":false,"remove":false},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"metadata":{"name":"Tour Card"},"className":"is-style-shadow-sm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-shadow-sm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"8px","topRight":"8px"}}}} /-->

<!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"0px","left":"10px","right":"10px"}},"dimensions":{"minHeight":"97px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="min-height:97px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Tour Title"},"className":"center-vertically","style":{"dimensions":{"minHeight":"3rem"},"spacing":{"padding":{"top":"5px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group center-vertically" style="min-height:3rem;padding-top:5px"><!-- wp:post-title {"textAlign":"center","isLink":true,"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Tour Information"},"style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"},"blockGap":"2px"},"border":{"top":{"color":"var:preset|color|primary","width":"2px"},"right":[],"bottom":{"color":"var:preset|color|primary","width":"2px"},"left":[]}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--primary);border-top-width:2px;border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"style":{"spacing":{"blockGap":"10px","padding":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fixed","flexSize":"130px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","height":"auto","sizeSlug":"large","metadata":{"name":"From Price Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tourpress.pro/wp-content/uploads/2024/09/from-price-TO-icon-black-20px-1.png" alt="" style="width:20px;height:auto"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fit","flexSize":""},"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"><strong>From:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fixed","flexSize":"130px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large","metadata":{"name":"Duration Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tourpress.pro/wp-content/uploads/2024/09/duration-TO-black-20px-icon.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fit","flexSize":""},"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"><strong>Duration:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"duration"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px">Days</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Tour Text Content"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-septenary-color has-text-color has-link-color" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:cover {"overlayColor":"secondary-900","isUserOverlayColor":true,"minHeightUnit":"px","metadata":{"name":"Reviews"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"}}}} -->
<div class="wp-block-cover" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--x-small)"><span aria-hidden="true" class="wp-block-cover__background has-secondary-900-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|small","left":"0","right":"0"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary-200"} -->
<hr class="wp-block-separator has-text-color has-primary-200-color has-alpha-channel-opacity has-primary-200-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"textColor":"base"} -->
<h2 class="wp-block-heading has-text-align-center has-base-color has-text-color has-link-color">Reviews</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary-200"} -->
<hr class="wp-block-separator has-text-color has-primary-200-color has-alpha-channel-opacity has-primary-200-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":67,"query":{"perPage":"2","pages":0,"offset":0,"postType":"review","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"align":"wide"} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:image {"sizeSlug":"large","align":"center"} -->
<figure class="wp-block-image aligncenter size-large"><img src="https://tourpress.pro/wp-content/uploads/2024/09/review-testominal-quote-mark-TO-tertiary-32px.png" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:post-excerpt {"textAlign":"center","showMoreOnNewLine":false,"excerptLength":40} /-->

<!-- wp:post-title {"textAlign":"center","fontSize":"small"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:template-part {"slug":"footer","area":"footer"} /-->
'
);