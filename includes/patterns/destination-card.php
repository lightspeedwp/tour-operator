<?php
return array(
	'title'         => __( 'Destination Card', 'tour-operator' ),
	'description'   => __( 'A grid display for destinations.', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'templateTypes' => array( 'single' ),
	'content'     => '
		<!-- wp:group {"metadata":{"name":"Destination Card"},"className":"is-style-shadow-sm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-shadow-sm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","linkTarget":"_blank","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"8px","topRight":"8px"}}}} /-->

		<!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":"97px"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="min-height:97px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Tour Title"},"className":"center-vertically","style":{"dimensions":{"minHeight":"4rem"},"border":{"bottom":{"color":"var:preset|color|primary","width":"2px"}},"spacing":{"padding":{"bottom":"10px"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group center-vertically" style="border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px;min-height:4rem;padding-bottom:10px"><!-- wp:post-title {"textAlign":"center","isLink":true,"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"fontSize":"small"} /--></div>
		<!-- /wp:group -->

		<!-- wp:group {"metadata":{"name":"Destination Description"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|septenary"}}}},"textColor":"septenary","layout":{"type":"constrained"}} -->
		<div class="wp-block-group has-septenary-color has-text-color has-link-color" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
		<!-- /wp:group --></div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"View More Button"},"style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
		<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">View Destination</a></div>
		<!-- /wp:button --></div>
		<!-- /wp:buttons --></div>
		<!-- /wp:group -->
	',
);