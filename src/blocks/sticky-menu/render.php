<?php
/**
 * Server-side rendering for the sticky menu block
 *
 * @package tour-operator
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add mobile header for sticky menu sections
 */
function add_mobile_section_headers( $block_content, $block ) {
	// Only process group blocks with sticky menu enabled
	if ( 'core/group' !== $block['blockName'] ) {
		return $block_content;
	}

	$attributes = $block['attrs'] ?? array();

	if ( empty( $attributes['addToStickyMenu'] ) || empty( $attributes['stickyMenuId'] ) ) {
		return $block_content;
	}

	$section_id    = esc_attr( $attributes['stickyMenuId'] );
	$section_title = ! empty( $attributes['stickyMenuTitle'] ) ? esc_html( $attributes['stickyMenuTitle'] ) : esc_html( $section_id );

	// Create the mobile header button
	$mobile_header = sprintf(
		'<button class="lsx-to-section-header" aria-expanded="false" id="%1$s-header" aria-controls="%1$s-content" aria-describedby="%1$s-desc">
			<span>%2$s</span>
			<span class="lsx-to-caret" aria-hidden="true"></span>
		</button>
		<div id="%1$s-desc" class="lsx-to-sr-only">Toggle section content visibility</div>',
		$section_id,
		$section_title
	);

	// Wrap the entire block content with the header button outside
	// This ensures the button stays visible when content is collapsed
	$wrapped_content = sprintf(
		'<div class="lsx-to-sticky-menu-section-wrapper" role="region" aria-labelledby="%1$s-header">%2$s<div class="lsx-to-sticky-menu-section-content" id="%1$s-content">%3$s</div></div>',
		$section_id,
		$mobile_header,
		$block_content
	);

	return $wrapped_content;
}

add_filter( 'render_block', 'add_mobile_section_headers', 10, 2 );
