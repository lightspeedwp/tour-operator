<?php

return array(
	'title'         => __( 'TO Gallery', 'tour-operator' ),
	'description'   => __( 'Display the attached images, with a lightbox gallery.', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'templateTypes' => array( 'single' ),
	'content'     => '
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
		<figure class="wp-block-image"><a href="' . LSX_TO_URL . 'assets/img/placeholders/placeholder-general-350x350.jpg"><img alt=""/></a></figure>
		<!-- /wp:image -->

		<!-- wp:image -->
		<figure class="wp-block-image"><a href="' . LSX_TO_URL . 'assets/img/placeholders/placeholder-general-350x350.jpg"><img alt=""/></a></figure>
		<!-- /wp:image -->

		<!-- wp:image -->
		<figure class="wp-block-image"><a href="' . LSX_TO_URL . 'assets/img/placeholders/placeholder-general-350x350.jpg"><img alt=""/></a></figure>
		<!-- /wp:image --></figure>
		<!-- /wp:gallery --></div>
		<!-- /wp:group -->
	',
);
