<?php
// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
return array(
	'title'         => __( 'Accommodation Archive', 'tour-operator' ),
	'description'   => __( 'A grid display for Accommodation.', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'templateTypes' => array( 'archive' ),
	'content'     => '
<!-- wp:group {"style":{"position":{"type":"sticky","top":"0px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:template-part {"slug":"header","area":"header"} /--></div>
<!-- /wp:group -->

<!-- wp:cover {"url":"https://tour-operator.lightspeedwp.dev/wp-content/uploads/2024/10/accommodation-archive-banner-image.png","id":61303,"dimRatio":70,"overlayColor":"secondary-900","isUserOverlayColor":true,"minHeight":300,"minHeightUnit":"px","metadata":{"name":"Hero"},"align":"full","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-cover alignfull" style="margin-top:0;margin-bottom:0;min-height:300px"><span aria-hidden="true" class="wp-block-cover__background has-secondary-900-background-color has-background-dim-70 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-61303" alt="" src="https://tour-operator.lightspeedwp.dev/wp-content/uploads/2024/10/accommodation-archive-banner-image.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:group {"style":{"spacing":{"padding":{"top":"10px","bottom":"10px"}},"border":{"bottom":{"color":"var:preset|color|primary-200","width":"2px"},"top":[],"right":[],"left":[]},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"large","layout":{"type":"default"}} -->
<div class="wp-block-group has-large-font-size" style="border-bottom-color:var(--wp--preset--color--primary-200);border-bottom-width:2px;padding-top:10px;padding-bottom:10px;font-style:normal;font-weight:600"><!-- wp:query-title {"type":"archive","textAlign":"center","showPrefix":false} /--></div>
<!-- /wp:group -->

<!-- wp:paragraph {"align":"center","metadata":{"name":"Tagline"},"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-200"}}}},"textColor":"primary-200","fontSize":"small"} -->
<p class="has-text-align-center has-primary-200-color has-text-color has-link-color has-small-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:group {"metadata":{"name":"Breadcrumbs"},"align":"full","style":{"spacing":{"padding":{"top":"6px","bottom":"6px","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}},"elements":{"link":{":hover":{"color":{"text":"var:preset|color|tertiary"}},"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"primary-900","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-primary-900-background-color has-text-color has-background has-link-color" style="margin-top:0;margin-bottom:0;padding-top:6px;padding-right:var(--wp--preset--spacing--x-small);padding-bottom:6px;padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:yoast-seo/breadcrumbs /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Archive Description"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|small","bottom":"0","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--small);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:0;padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:group {"metadata":{"name":"Content"},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Discover a wide variety of accommodation options designed to suit every travellerâ€™s needs and preferences. Whether you\'re seeking the indulgence of a five-star resort, the charm of a boutique hotel, or the simplicity of a rustic cabin, our collection has something for everyone. Each accommodation is carefully chosen to provide comfort, convenience, and a seamless blend with the local surroundings, ensuring that your stay is as memorable as the destinations themselves.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Archive Content"},"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|x-small","right":"var:preset|spacing|x-small"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--x-small)"><!-- wp:query {"queryId":1,"query":{"perPage":"9","pages":"3","offset":"0","postType":"accommodation","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"align":"wide","layout":{"type":"constrained","contentSize":""}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"lock":{"move":false,"remove":false},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":null}} -->
<!-- wp:pattern {"slug":"lsx-tour-operator/accommodation-card"} /-->

<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"align":"center","placeholder":"Add text or blocks that will display when the query returns no results."} -->
<p class="has-text-align-center">Unfortunately, there is no accommodation listed at the moment. Please check back soon as we regularly update our offerings.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->

<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"},"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--x-small);margin-bottom:var(--wp--preset--spacing--x-small);padding-top:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-small)"><!-- wp:query-pagination {"paginationArrow":"chevron","align":"wide","className":"is-style-default","layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:group --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","area":"footer"} /-->' );
