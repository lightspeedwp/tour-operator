<?php
return array(
	'title'         => __( 'Room Card', 'tour-operator' ),
	'description'   => __( '', 'tour-operator' ),
	'categories'    => array( $this->pattern_category ),
	'templateTypes' => array( 'single' ),
	'content'     => '
		<!-- wp:group {"metadata":{"name":"Room Card"},"align":"wide","style":{"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignwide has-base-background-color has-background" style="border-radius:8px"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"10px"}}}} -->
		<div class="wp-block-columns alignwide"><!-- wp:column {"width":"30%"} -->
		<div class="wp-block-column" style="flex-basis:30%"><!-- wp:image {"aspectRatio":"1","scale":"cover","className":"unit-image is-style-default","style":{"border":{"radius":{"topLeft":"8px","bottomLeft":"8px"}}}} -->
		<figure class="wp-block-image has-custom-border unit-image is-style-default"><img alt="" style="border-top-left-radius:8px;border-bottom-left-radius:8px;aspect-ratio:1;object-fit:cover"/></figure>
		<!-- /wp:image --></div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"70%","style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"20px"},"blockGap":"0"}}} -->
		<div class="wp-block-column" style="padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:10px;flex-basis:70%"><!-- wp:group {"layout":{"type":"default"}} -->
		<div class="wp-block-group"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"bottom":"10px"}},"border":{"bottom":{"color":"var:preset|color|primary","width":"2px"},"top":[],"right":[],"left":[]}},"layout":{"type":"default"}} -->
		<div class="wp-block-group alignwide" style="border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;padding-bottom:10px"><!-- wp:heading {"level":3,"className":"unit-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}}},"textColor":"primary-700","fontSize":"medium"} -->
		<h3 class="wp-block-heading unit-title has-primary-700-color has-text-color has-link-color has-medium-font-size"></h3>
		<!-- /wp:heading --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group -->

		<!-- wp:columns {"style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
		<div class="wp-block-columns" style="padding-top:0;padding-bottom:0"><!-- wp:column {"width":"66.66%","style":{"spacing":{"padding":{"top":"10px","bottom":"10px"}}}} -->
		<div class="wp-block-column" style="padding-top:10px;padding-bottom:10px;flex-basis:66.66%"><!-- wp:paragraph {"className":"unit-description","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}}},"textColor":"primary-700"} -->
		<p class="unit-description has-primary-700-color has-text-color has-link-color"></p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"33.33%"} -->
		<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:group {"metadata":{"name":"Information"},"style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"},"margin":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}},"border":{"radius":"8px"}},"backgroundColor":"primary-bg","layout":{"type":"constrained"}} -->
		<div class="wp-block-group has-primary-bg-background-color has-background" style="border-radius:8px;margin-top:var(--wp--preset--spacing--x-small);margin-bottom:var(--wp--preset--spacing--x-small);padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:heading {"level":4} -->
		<h4 class="wp-block-heading"><strong>Information</strong></h4>
		<!-- /wp:heading -->

		<!-- wp:group {"className":"itin-type-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group itin-type-wrapper" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large"} -->
		<figure class="wp-block-image size-large is-resized"><img src="https://tour-operator.lsx.design/wp-content/uploads/2024/09/accommodation-type-TO-icon-black-20px-2.png" alt="" style="width:20px"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"><strong>Unit</strong> <strong>Type</strong>:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:paragraph {"className":"unit-type","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}},"typography":{"textTransform":"capitalize"},"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"textColor":"primary-700"} -->
		<p class="unit-type has-primary-700-color has-text-color has-link-color" style="padding-top:2px;padding-bottom:2px;text-transform:capitalize"></p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"itin-type-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group itin-type-wrapper" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"From Price Icon"}} -->
		<figure class="wp-block-image size-large is-resized"><img src="https://tour-operator.lsx.design/wp-content/uploads/2024/09/from-price-TO-icon-black-20px-1.png" alt="" style="width:20px"/></figure>
		<!-- /wp:image -->

		<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
		<p style="padding-top:2px;padding-bottom:2px"><strong>From</strong>:</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"5px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group"><!-- wp:paragraph {"className":"unit-price","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary-700"}}},"spacing":{"padding":{"top":"2px","bottom":"2px"}}},"textColor":"primary-700"} -->
		<p class="unit-price has-primary-700-color has-text-color has-link-color" style="padding-top:2px;padding-bottom:2px"></p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns --></div>
		<!-- /wp:group -->
	',
);
