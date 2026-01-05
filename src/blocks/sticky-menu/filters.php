<?php
/**
 * Filters for the sticky menu block
 *
 * This file contains WordPress filters that modify block rendering to add
 * mobile-specific functionality for sticky menu sections. It is loaded
 * directly by the plugin and not via block.json's render callback.
 *
 * @package tour-operator
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'add_mobile_section_headers' ) ) {
	/**
	 * Add mobile header for sticky menu sections
	 *
	 * This function adds collapsible mobile headers to group blocks that have
	 * sticky menu functionality enabled. It wraps the block content with
	 * interactive controls for mobile navigation.
	 *
	 * @since 2.1.0
	 * @param string $block_content The block's rendered HTML content.
	 * @param array  $block         The full block, including name and attributes.
	 * @return string Modified block content with mobile headers added if applicable.
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
			<span class="lsx-to-sticky-caret"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M16.25 6.875L10 13.125L3.75 6.875" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>
		</button>
		<div id="%1$s-desc" class="lsx-to-sr-only">%3$s</div>',
			$section_id,
			$section_title,
			esc_html__( 'Toggle section content visibility', 'tour-operator' )
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
}
