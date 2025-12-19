<?php
/**
 * Section Header Pattern
 *
 * A reusable section header with centered heading text flanked by horizontal separators.
 * Used across templates to create consistent section dividers.
 *
 * @package    Tour_Operator
 * @subpackage Patterns
 * @since      2.1.0
 * @version    2.1.0
 */

return array(
	'title'         => __( 'Section Header', 'tour-operator' ),
	'description'   => __( 'A section header with centered heading text flanked by horizontal separators.', 'tour-operator' ),
	'categories'    => array( 'lsx-tour-operator' ),
	'keywords'      => array(
		__( 'section', 'tour-operator' ),
		__( 'header', 'tour-operator' ),
		__( 'heading', 'tour-operator' ),
		__( 'separator', 'tour-operator' ),
		__( 'divider', 'tour-operator' ),
	),
	'postTypes'     => array( 'wp_template' ),
	'blockTypes'    => array( 'core/group' ),
	'templateTypes' => array( 'single', 'archive', 'single-destination' ),
	'viewportWidth' => 300,
	'content'       => '<!-- wp:group {"metadata":{"name":"' . esc_attr__( 'Section Header', 'tour-operator' ) . '","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/section-header"},"align":"wide","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"var:preset|spacing|small","left":"0","right":"0"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap"},"ariaLabel":"' . esc_attr__( 'Section Header', 'tour-operator' ) . '"} -->
<div aria-label="' . esc_attr__( 'Section Header', 'tour-operator' ) . '" class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--small);padding-left:0"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center","metadata":{"bindings":{"content":{"source":"core/pattern-overrides"}},"name":"' . esc_attr__( 'Heading', 'tour-operator' ) . '"},"placeholder":"' . esc_attr__( 'Section Title', 'tour-operator' ) . '","style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontFamily":"montserrat"} -->
<h2 class="wp-block-heading has-text-align-center has-montserrat-font-family" style="font-style:normal;font-weight:400">' . esc_html__( 'Section Title', 'tour-operator' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->',
);
