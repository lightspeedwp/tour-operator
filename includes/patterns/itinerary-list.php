<?php
return array(
	'title'         => __( 'Itinerary (list)', 'tour-operator' ),
	'description'   => __( '', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'templateTypes' => array( 'single' ),
	'content'     => '
		<!-- wp:columns {"metadata":{"categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/itinerary-card","name":"Itinerary (list)"},"align":"wide"} -->
		<div class="wp-block-columns alignwide"><!-- wp:column {"width":"100%"} -->
		<div class="wp-block-column" style="flex-basis:100%"><!-- wp:group {"layout":{"type":"constrained"}} -->
		<div class="wp-block-group"><!-- wp:columns {"align":"wide"} -->
		<div class="wp-block-columns alignwide"><!-- wp:column {"width":"25%"} -->
		<div class="wp-block-column" style="flex-basis:25%"><!-- wp:image {"id":2981,"sizeSlug":"full","linkDestination":"none","className":"itinerary-image","style":{"border":{"radius":"8px"}}} -->
		<figure class="wp-block-image size-full has-custom-border itinerary-image"><img src="https://beta.local/wp-content/uploads/2024/09/R0I3460.jpg" alt="" class="wp-image-2981" style="border-radius:8px" title=""/></figure>
		<!-- /wp:image --></div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"75%","style":{"spacing":{"blockGap":"0px"}}} -->
		<div class="wp-block-column" style="flex-basis:75%"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"bottom":"10px"}},"border":{"bottom":{"color":"var:preset|color|primary","width":"2px"},"top":[],"right":[],"left":[]}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignwide" style="border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;padding-bottom:10px"><!-- wp:heading {"level":3,"align":"wide","className":"itinerary-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}}},"textColor":"primary-700"} -->
		<h3 class="wp-block-heading alignwide itinerary-title has-primary-700-color has-text-color has-link-color">Day 1 (itinerary day)</h3>
		<!-- /wp:heading --></div>
		<!-- /wp:group -->

		<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"0px","bottom":"0px"},"padding":{"top":"10px","bottom":"10px"}}}} -->
		<div class="wp-block-columns alignwide" style="margin-top:0px;margin-bottom:0px;padding-top:10px;padding-bottom:10px"><!-- wp:column {"width":"60%"} -->
		<div class="wp-block-column" style="flex-basis:60%"><!-- wp:paragraph {"className":"itinerary-description","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}}},"textColor":"primary-700"} -->
		<p class="itinerary-description has-primary-700-color has-text-color has-link-color"><strong>Itinerary Description</strong></p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"40%","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
		<div class="wp-block-column" style="padding-top:0;padding-bottom:0;flex-basis:40%"><!-- wp:group {"style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"},"margin":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|x-small"},"border":{"radius":"8px"}},"backgroundColor":"primary-bg","layout":{"type":"constrained"}} -->
		<div class="wp-block-group has-primary-bg-background-color has-background" style="border-radius:8px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Information"},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group"><!-- wp:heading {"level":4} -->
		<h4 class="wp-block-heading"><strong>Information</strong></h4>
		<!-- /wp:heading -->

		<!-- wp:group {"className":"itin-location-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group itin-location-wrapper" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":60633,"width":"20px","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="wp-block-image size-full is-resized"><img src="https://tour-operator.lsx.design/wp-content/uploads/2024/09/Typelocation-icon.png" alt="" class="wp-image-60633" style="width:20px"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"><strong>Location</strong>:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"metadata":{"name":"Location","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"itinerary-location","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}},"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"textColor":"primary-700"} -->
		<p class="itinerary-location has-primary-700-color has-text-color has-link-color" style="padding-top:2px;padding-bottom:2px">Location</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"itin-accommodation-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group itin-accommodation-wrapper" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":60630,"width":"20px","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="wp-block-image size-full is-resized"><img src="https://tour-operator.lsx.design/wp-content/uploads/2024/09/Typeaccommodation-icon.png" alt="" class="wp-image-60630" style="width:20px"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"><strong>Accommodation</strong>:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"metadata":{"name":"Accommodation","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"itinerary-accommodation","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}}},"textColor":"primary-700"} -->
		<p class="itinerary-accommodation has-primary-700-color has-text-color has-link-color">Accommodation </p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"itin-type-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group itin-type-wrapper" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":60627,"width":"20px","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="wp-block-image size-full is-resized"><img src="https://tour-operator.lsx.design/wp-content/uploads/2024/09/accommodation-type-TO-icon-black-20px-2.png" alt="" class="wp-image-60627" style="width:20px"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"><strong>Type</strong>:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"metadata":{"name":"Type","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"itinerary-type","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}},"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"textColor":"primary-700"} -->
		<p class="itinerary-type has-primary-700-color has-text-color has-link-color" style="padding-top:2px;padding-bottom:2px">Accommodation Type </p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"itin-drinks-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group itin-drinks-wrapper" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":60618,"width":"20px","height":"auto","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="wp-block-image size-full is-resized"><img src="https://tour-operator.lsx.design/wp-content/uploads/2024/09/drinks-icon-TO-black-20px-2-1.png" alt="" class="wp-image-60618" style="object-fit:cover;width:20px;height:auto"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"><strong>Drinks Basis</strong>:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"metadata":{"name":"Drinks Basis","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"itinerary-drinks","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}}},"textColor":"primary-700"} -->
		<p class="itinerary-drinks has-primary-700-color has-text-color has-link-color">Drinks Basis </p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"itin-room-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group itin-room-wrapper" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":60617,"width":"20px","sizeSlug":"full","linkDestination":"none"} -->
		<figure class="wp-block-image size-full is-resized"><img src="https://tour-operator.lsx.design/wp-content/uploads/2024/09/room-basis-TO-black-20px-2-1.png" alt="" class="wp-image-60617" style="width:20px"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"><strong>Room Basis</strong>:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"metadata":{"name":"Room Basis","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"itinerary-room","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}}},"textColor":"primary-700"} -->
		<p class="itinerary-room has-primary-700-color has-text-color has-link-color">Room Basis </p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns --></div>
		<!-- /wp:group --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns -->
	',
);
