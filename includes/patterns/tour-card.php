<?php

return array(
	'title'         => __( 'Tour Card', 'tour-operator' ),
	'description'   => __( 'Display the tours', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'content'       => '<!-- wp:group {"metadata":{"name":"Tour Card"},"className":"is-style-shadow-sm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-shadow-sm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"8px","topRight":"8px"}}}} /-->

<!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"0px","left":"10px","right":"10px"}},"dimensions":{"minHeight":"97px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="min-height:97px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Tour Title"},"className":"center-vertically","style":{"dimensions":{"minHeight":"3rem"},"spacing":{"padding":{"top":"5px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group center-vertically" style="min-height:3rem;padding-top:5px"><!-- wp:post-title {"textAlign":"center","isLink":true,"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Tour Information"},"style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"},"blockGap":"2px"},"border":{"top":{"color":"var:preset|color|primary","width":"2px"},"right":[],"bottom":{"color":"var:preset|color|primary","width":"2px"},"left":[]}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--primary);border-top-width:2px;border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"className":"lsx-price-wrapper","style":{"spacing":{"blockGap":"10px","padding":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group lsx-price-wrapper" style="padding-top:0;padding-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fixed","flexSize":"130px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","height":"auto","sizeSlug":"large","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"From Price Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="' . LSX_TO_URL . 'assets/img/blocks/unit-price.png" alt="" style="width:20px;height:auto"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fit","flexSize":""},"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"><strong>From:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}},"__default":{"source":"core/pattern-overrides"}},"name":"From Price"},"className":"amount price","style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p class="amount price" style="padding-top:2px;padding-bottom:2px"><strong>price</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-duration-wrapper","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group lsx-duration-wrapper"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fixed","flexSize":"130px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"Duration Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="' . LSX_TO_URL . 'assets/img/blocks/duration.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fit","flexSize":""},"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"><strong>Duration:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"duration"}},"__default":{"source":"core/pattern-overrides"}},"name":"Duration"},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px">Days</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Tour Text Content"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->'
);