<?php
/**
 * Gallery Section Pattern
 *
 * A gallery section with decorative separators and heading for displaying
 * attached images in a lightbox gallery format.
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      1.0.0
 * @version    2.1.0
 */

// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage

return array(
	'title'         => __( 'Gallery Section', 'tour-operator' ),
	'description'   => __( 'Display attached images in a lightbox gallery with decorative heading.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'gallery', 'tour-operator' ),
		__( 'images', 'tour-operator' ),
		__( 'photos', 'tour-operator' ),
		__( 'lightbox', 'tour-operator' ),
		__( 'section', 'tour-operator' ),
	),
	'templateTypes' => array( 'single', 'single-tour', 'single-accommodation', 'single-destination' ),
	'viewportWidth' => 1200,
	'content'       => '<!-- wp:group {"tagName":"section","metadata":{"name":"' . esc_attr__( 'Gallery Section', 'tour-operator' ) . '","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/gallery-section"},"className":"lsx-gallery-wrapper","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"constrained"},"ariaLabel":"' . esc_attr__( 'Gallery Section', 'tour-operator' ) . '"} -->
<section aria-label="' . esc_attr__( 'Gallery Section', 'tour-operator' ) . '" class="wp-block-group lsx-gallery-wrapper" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Gallery Heading', 'tour-operator' ) . '"},"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|40","left":"0","right":"0"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--40);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Gallery', 'tour-operator' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Gallery Content', 'tour-operator' ) . '"},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:gallery {"linkTarget":"_blank","linkTo":"media","sizeSlug":"thumbnail","metadata":{"name":"' . esc_attr__( 'Gallery', 'tour-operator' ) . '","bindings":{"content":{"source":"lsx/gallery"}}},"align":"wide"} -->
<figure class="wp-block-gallery alignwide has-nested-images columns-default is-cropped"><!-- wp:image {"linkDestination":"media"} -->
<figure class="wp-block-image"><img alt="' . esc_attr__( 'Gallery image', 'tour-operator' ) . '"/></figure>
<!-- /wp:image -->

<!-- wp:image {"linkDestination":"media"} -->
<figure class="wp-block-image"><img alt="' . esc_attr__( 'Gallery image', 'tour-operator' ) . '"/></figure>
<!-- /wp:image -->

<!-- wp:image {"linkDestination":"media"} -->
<figure class="wp-block-image"><img alt="' . esc_attr__( 'Gallery image', 'tour-operator' ) . '"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->',
);
