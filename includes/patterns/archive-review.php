<?php
// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
return array(
	'title'         => __( 'Reviews Archive', 'tour-operator' ),
	'description'   => __( 'A display for reviews.', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'templateTypes' => array( 'archive' ),
	'content'     => '<!-- wp:group {"style":{"position":{"type":"sticky","top":"0px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:template-part {"slug":"header","area":"header"} /--></div>
<!-- /wp:group -->

<!-- wp:cover {"url":"https://tour-operator.lightspeedwp.dev/wp-content/uploads/2024/09/TO-faq-bottom-banner-image.png","id":60881,"dimRatio":70,"overlayColor":"secondary-900","isUserOverlayColor":true,"minHeight":300,"minHeightUnit":"px","metadata":{"name":"Hero"},"align":"full","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-cover alignfull" style="margin-top:0;margin-bottom:0;min-height:300px"><span aria-hidden="true" class="wp-block-cover__background has-secondary-900-background-color has-background-dim-70 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-60881" alt="" src="https://tour-operator.lightspeedwp.dev/wp-content/uploads/2024/09/TO-faq-bottom-banner-image.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:group {"style":{"spacing":{"padding":{"top":"10px","bottom":"10px"}},"border":{"bottom":{"color":"var:preset|color|primary-200","width":"2px"},"top":[],"right":[],"left":[]},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"large","layout":{"type":"default"}} -->
<div class="wp-block-group has-large-font-size" style="border-bottom-color:var(--wp--preset--color--primary-200);border-bottom-width:2px;padding-top:10px;padding-bottom:10px;font-style:normal;font-weight:600"><!-- wp:query-title {"type":"archive","textAlign":"center","showPrefix":false} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:group {"metadata":{"name":"Breadcrumbs"},"align":"full","style":{"spacing":{"padding":{"top":"6px","bottom":"6px","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}},"elements":{"link":{":hover":{"color":{"text":"var:preset|color|tertiary"}},"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"primary-900","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-primary-900-background-color has-text-color has-background has-link-color" style="margin-top:0;margin-bottom:0;padding-top:6px;padding-right:var(--wp--preset--spacing--x-small);padding-bottom:6px;padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:yoast-seo/breadcrumbs /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Archive Description"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--small);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"metadata":{"name":"Content"},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Hear what our travellers have to say about their experiences with us. From breathtaking destinations to seamless service, our guests share their stories and insights to help you plan your next adventure. Read through reviews and discover why so many travellers choose us for their unforgettable journeys.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Archive Content"},"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|x-small","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-small);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:query {"queryId":1,"query":{"perPage":"9","pages":"0","offset":"0","postType":"review","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"align":"wide","layout":{"type":"constrained","contentSize":""}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"lock":{"move":false,"remove":false},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":null}} -->
<!-- wp:group {"metadata":{"name":"Review Card"},"className":"is-style-shadow-sm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"},"dimensions":{"minHeight":""}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-shadow-sm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"8px","topRight":"8px"}}}} /-->

<!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"0px","left":"10px","right":"10px"}},"dimensions":{"minHeight":"97px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="min-height:97px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Review Author"},"className":"center-vertically","style":{"dimensions":{"minHeight":"3rem"},"spacing":{"padding":{"top":"6px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group center-vertically" style="min-height:3rem;padding-top:6px"><!-- wp:post-title {"textAlign":"center","isLink":true,"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Review Information"},"style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"},"blockGap":"0"},"border":{"top":{"color":"var:preset|color|primary","width":"2px"},"right":[],"bottom":{"color":"var:preset|color|primary","width":"2px"},"left":[]}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--primary);border-top-width:2px;border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large","metadata":{"name":"Tours Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tour-operator.lightspeedwp.dev/wp-content/uploads/2024/09/Typetours-icon.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"> <strong>Tours: </strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"tour_to_review"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"10px","padding":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"},"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large","linkDestination":"none","metadata":{"name":"Rating Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tour-operator.lightspeedwp.dev/wp-content/uploads/2024/09/rating-icon-TO-black-20px-1.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"><strong>Rating: </strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"rating"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"10px","padding":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large","metadata":{"name":"Accommodation Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="https://tour-operator.lightspeedwp.dev/wp-content/uploads/2024/09/Typeaccommodation-icon.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"><strong>Accommodation: </strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"accommodation_to_review"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Review Text"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"align":"center","placeholder":"Add text or blocks that will display when the query returns no results."} -->
<p class="has-text-align-center">Unfortunately, there are no reviews listed at the moment. Please check back soon as we regularly update our offerings.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->

<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--x-small);margin-bottom:var(--wp--preset--spacing--x-small)"><!-- wp:query-pagination {"paginationArrow":"chevron","align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers {"midSize":0} /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:group --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","area":"footer"} /-->' );
