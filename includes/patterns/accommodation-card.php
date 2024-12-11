<?php

return array(
	'title'         => __( 'Accommodation Card', 'tour-operator' ),
	'description'   => __( '', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'content'       => '<!-- wp:group {"metadata":{"name":"Accommodation Card"},"className":"is-style-shadow-sm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-shadow-sm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"8px","topRight":"8px"}}}} /-->

		<!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"0px","left":"10px","right":"10px"}},"dimensions":{"minHeight":"97px"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="min-height:97px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Accommodation Title"},"className":"center-vertically","style":{"dimensions":{"minHeight":"3rem"},"spacing":{"padding":{"top":"5px"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group center-vertically" style="min-height:3rem;padding-top:5px"><!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"},":hover":{"color":{"text":"var:preset|color|primary-700"}}}}},"textColor":"contrast","fontSize":"small"} /--></div>
		<!-- /wp:group -->

		<!-- wp:group {"metadata":{"name":"Accommodation Information"},"style":{"spacing":{"padding":{"top":"10px","bottom":"5px","left":"10px","right":"10px"},"blockGap":"0px"},"border":{"top":{"color":"var:preset|color|primary","width":"2px"},"bottom":{"color":"var:preset|color|primary","width":"2px"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--primary);border-top-width:2px;border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;padding-top:10px;padding-right:10px;padding-bottom:5px;padding-left:10px"><!-- wp:group {"className":"lsx-price-wrapper","style":{"spacing":{"blockGap":"10px","padding":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group lsx-price-wrapper" style="padding-top:0;padding-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fixed","flexSize":"100px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":60622,"width":"20px","height":"auto","scale":"cover","sizeSlug":"full","linkDestination":"none","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"From Price Icon"}} -->
		<figure class="wp-block-image size-full is-resized"><img src="' . LSX_TO_URL . 'assets/img/blocks/unit-price.png" alt="" class="wp-image-60622" style="object-fit:cover;width:20px;height:auto"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px">From:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}},"__default":{"source":"core/pattern-overrides"}},"name":"Price"},"className":"amount","style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p class="amount" style="padding-top:2px;padding-bottom:2px"><strong>price</strong></p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"lsx-accommodation-type-wrapper","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group lsx-accommodation-type-wrapper"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fixed","flexSize":"100px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":60627,"width":"20px","height":"auto","scale":"cover","sizeSlug":"full","linkDestination":"none","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"Accommodation Type Icon"}} -->
		<figure class="wp-block-image size-full is-resized"><img src="' . LSX_TO_URL . 'assets/img/blocks/unit-type.png" alt="" class="wp-image-60627" style="object-fit:cover;width:20px;height:auto"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px">Type:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group"><!-- wp:post-terms {"term":"accommodation-type","style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"},":hover":{"color":{"text":"var:preset|color|primary-700"}}}}},"textColor":"contrast","fontSize":"x-small","fontFamily":"secondary"} /--></div>
		<!-- /wp:group --></div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"lsx-rooms-wrapper","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group lsx-rooms-wrapper"><!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"100px"},"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"id":61041,"width":"20px","height":"auto","sizeSlug":"full","linkDestination":"none","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"Number of Rooms Icon"}} -->
		<figure class="wp-block-image size-full is-resized"><img src="' . LSX_TO_URL . 'assets/img/blocks/rooms.png" alt="" class="wp-image-61041" style="width:20px;height:auto"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px">Rooms:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"number_of_rooms"}},"__default":{"source":"core/pattern-overrides"}},"name":"Number of Rooms"},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"></p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group -->

		<!-- wp:group {"metadata":{"name":"Accommodation Text Content"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
		<!-- /wp:group --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group -->'
);