<?php
/**
 * Server-side rendering for the Icons block.
 *
 * @package Tour_Operator
 * @subpackage Blocks
 * @since 2.1.0
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block default content.
 * @var WP_Block $block      Block instance.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$icon_type = isset( $attributes['iconType'] ) ? sanitize_key( $attributes['iconType'] ) : 'outline';
$icon_name = isset( $attributes['iconName'] ) ? sanitize_key( $attributes['iconName'] ) : '';

// If no icon name is provided, return nothing.
if ( empty( $icon_name ) ) {
	return;
}

// Get the SVG content.
$svg_content = lsx_to_get_icon_svg( $icon_type, $icon_name );

// If no SVG content found, return nothing.
if ( empty( $svg_content ) ) {
	return;
}

// Get block wrapper attributes.
$wrapper_attributes = get_block_wrapper_attributes();

?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<span class="block-icon-svg" style="font-size: inherit; display: inline-block;">
		<?php echo $svg_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG content is sanitized in lsx_to_get_icon_svg(). ?>
	</span>
</div>
