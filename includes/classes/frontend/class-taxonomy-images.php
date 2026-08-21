<?php
/**
 * Tour Operator - Modals Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-3.0+
 */

namespace lsx\frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Taxonomy_Images
 *
 * @since 2.1.0
 * @package lsx\frontend
 */
class Taxonomy_Images {

	/**
	 * Options array
	 *
	 * @since 2.1.0
	 * @var      boolean|array
	 */
	public $options = [];

	/**
	 * Tour Operator Admin constructor.
	 */
	public function __construct() {
		$this->options = get_option( 'lsx_to_settings', [] );
		$this->init_hooks();
	}

	/**
	 * Initialize hooks for taxonomy images functionality.
	 *
	 * @since 2.1.0
	 */
	private function init_hooks() {
		add_filter( 'render_block_core/post-featured-image', [ $this, 'filter_featured_image_block' ], 10, 3 );
	}

	/**
	 * Filter the core/post-featured-image block to use term thumbnail when term ID is present
	 * or display placeholder when no image exists.
	 *
	 * @since 2.1.0
	 *
	 * @param string   $block_content The block content.
	 * @param array    $block         The full block, including name and attributes.
	 * @param WP_Block $instance      The block instance.
	 * @return string The filtered block content.
	 */
	public function filter_featured_image_block( $block_content, $block, $instance ) {

		// Check if we have a term ID in the block context
		if ( isset( $instance->context['termId'] ) ) {
			$term_id = $instance->context['termId'];
			$thumbnail_id = $this->get_term_thumbnail_id( $term_id );
	
			if ( $thumbnail_id ) {
				$attributes = $block['attrs'] ?? [];
				return $this->render_term_featured_image( $thumbnail_id, $attributes, $term_id );
			}
		}
	
		// If block content is empty (no featured image), add placeholder
		if ( empty( trim( $block_content ) ) || false === strpos( $block_content, '<img' ) ) {
			return $this->render_placeholder_image( $block );
		}
	
		return $block_content;
	}

	/**
	 * Render a placeholder image when no featured image exists.
	 *
	 * @since 2.1.0
	 *
	 * @param array $block The full block, including name and attributes.
	 * @return string The placeholder image HTML.
	 */
	private function render_placeholder_image( $block ) {
		$attributes = $block['attrs'] ?? [];
		
		// Get placeholder URL - check settings first, then fall back to default
		$options = get_option( 'lsx_to_settings', [] );
		$placeholder_url = LSX_TO_URL . 'assets/img/blocks/placeholder.png';
		
		// Check for custom placeholder in settings
		if ( ! empty( $options['general']['default_placeholder_id'] ) ) {
			$custom_placeholder = wp_get_attachment_image_url( $options['general']['default_placeholder_id'], 'large' );
			if ( $custom_placeholder ) {
				$placeholder_url = $custom_placeholder;
			}
		}
		
		// Build image attributes
		$img_attr = [
			'src'   => esc_url( $placeholder_url ),
			'alt'   => esc_attr__( 'Placeholder image', 'tour-operator' ),
			'class' => 'wp-post-image lsx-placeholder-image',
		];
		
		// Handle aspect ratio
		$extra_styles = '';
		if ( ! empty( $attributes['aspectRatio'] ) ) {
			$extra_styles .= 'width:100%;height:100%;object-fit:cover;';
		}
		
		if ( ! empty( $extra_styles ) ) {
			$img_attr['style'] = $extra_styles;
		}
		
		// Build img tag
		$img_html = '<img';
		foreach ( $img_attr as $name => $value ) {
			$img_html .= ' ' . $name . '="' . $value . '"';
		}
		$img_html .= ' />';
		
		// Wrap in link if needed
		if ( ! empty( $attributes['isLink'] ) ) {
			$post_id = get_the_ID();
			$permalink = get_permalink( $post_id );
			$link_target = $attributes['linkTarget'] ?? '_self';
			$img_html = sprintf(
				'<a href="%s" target="%s">%s</a>',
				esc_url( $permalink ),
				esc_attr( $link_target ),
				$img_html
			);
		}
		
		// Generate wrapper with aspect ratio
		$wrapper_styles = '';
		if ( ! empty( $attributes['aspectRatio'] ) ) {
			$wrapper_styles = 'style="aspect-ratio:' . esc_attr( $attributes['aspectRatio'] ) . ';"';
		}
		
		$wrapper_attributes = get_block_wrapper_attributes( 
			! empty( $wrapper_styles ) ? [ 'style' => 'aspect-ratio:' . $attributes['aspectRatio'] . ';' ] : []
		);
		
		return "<figure {$wrapper_attributes}>{$img_html}</figure>";
	}

	/**
	 * Get the thumbnail ID from term meta.
	 *
	 * @since 2.1.0
	 *
	 * @param int $term_id The term ID.
	 * @return int|false The thumbnail attachment ID or false if not found.
	 */
	private function get_term_thumbnail_id( $term_id ) {
		$thumbnail_id = get_term_meta( $term_id, 'thumbnail', true );
		return $thumbnail_id ? (int) $thumbnail_id : false;
	}

	/**
	 * Render the featured image for a term, mimicking core block functionality.
	 *
	 * @since 2.1.0
	 *
	 * @param int   $thumbnail_id The attachment ID for the thumbnail.
	 * @param array $attributes   Block attributes.
	 * @param int   $term_id      The term ID.
	 * @return string The rendered featured image HTML.
	 */
	private function render_term_featured_image( $thumbnail_id, $attributes, $term_id ) {
		$is_link    = isset( $attributes['isLink'] ) && $attributes['isLink'];
		$size_slug  = isset( $attributes['sizeSlug'] ) ? $attributes['sizeSlug'] : 'post-thumbnail';
		$attr       = $this->get_image_border_attributes( $attributes );

		// Set alt text for term
		if ( $is_link ) {
			$term = get_term( $term_id );
			if ( $term && ! is_wp_error( $term ) ) {
				$attr['alt'] = trim( wp_strip_all_tags( $term->name ) );
			} else {
				$attr['alt'] = sprintf(
					// translators: %d is the term ID.
					__( 'Untitled term %d', 'tour-operator' ),
					$term_id
				);
			}
		}

		$extra_styles = '';

		// Handle aspect ratio and dimensions
		if ( ! empty( $attributes['aspectRatio'] ) ) {
			$extra_styles .= 'width:100%;height:100%;';
		} elseif ( ! empty( $attributes['height'] ) ) {
			$extra_styles .= "height:{$attributes['height']};";
		}

		if ( ! empty( $attributes['scale'] ) ) {
			$extra_styles .= "object-fit:{$attributes['scale']};";
		}

		// Handle shadow styles
		if ( ! empty( $attributes['style']['shadow'] ) ) {
			$shadow_styles = wp_style_engine_get_styles( array( 'shadow' => $attributes['style']['shadow'] ) );
			if ( ! empty( $shadow_styles['css'] ) ) {
				$extra_styles .= $shadow_styles['css'];
			}
		}

		if ( ! empty( $extra_styles ) ) {
			$attr['style'] = empty( $attr['style'] ) ? $extra_styles : $attr['style'] . $extra_styles;
		}

		$featured_image = wp_get_attachment_image( $thumbnail_id, $size_slug, false, $attr );

		if ( ! $featured_image ) {
			return '';
		}

		// Get overlay markup if needed
		$overlay_markup = $this->get_overlay_element_markup( $attributes );

		// Handle link wrapping
		if ( $is_link ) {
			$term = get_term( $term_id );
			$term_link = $term && ! is_wp_error( $term ) ? get_term_link( $term ) : '';
			
			if ( $term_link && ! is_wp_error( $term_link ) ) {
				$link_target = $attributes['linkTarget'] ?? '_self';
				$rel = ! empty( $attributes['rel'] ) ? 'rel="' . esc_attr( $attributes['rel'] ) . '"' : '';
				$height = ! empty( $attributes['height'] ) ? 'style="' . esc_attr( safecss_filter_attr( 'height:' . $attributes['height'] ) ) . '"' : '';
				
				$featured_image = sprintf(
					'<a href="%1$s" target="%2$s" %3$s %4$s>%5$s%6$s</a>',
					esc_url( $term_link ),
					esc_attr( $link_target ),
					$rel,
					$height,
					$featured_image,
					$overlay_markup
				);
			}
		} else {
			$featured_image = $featured_image . $overlay_markup;
		}

		// Generate wrapper attributes
		$aspect_ratio = ! empty( $attributes['aspectRatio'] )
			? esc_attr( safecss_filter_attr( 'aspect-ratio:' . $attributes['aspectRatio'] ) ) . ';'
			: '';
		$width = ! empty( $attributes['width'] )
			? esc_attr( safecss_filter_attr( 'width:' . $attributes['width'] ) ) . ';'
			: '';
		$height = ! empty( $attributes['height'] )
			? esc_attr( safecss_filter_attr( 'height:' . $attributes['height'] ) ) . ';'
			: '';

		if ( ! $height && ! $width && ! $aspect_ratio ) {
			$wrapper_attributes = get_block_wrapper_attributes();
		} else {
			$wrapper_attributes = get_block_wrapper_attributes( array( 'style' => $aspect_ratio . $width . $height ) );
		}

		return "<figure {$wrapper_attributes}>{$featured_image}</figure>";
	}

	/**
	 * Generate border attributes for the image, similar to core functionality.
	 *
	 * @since 2.1.0
	 *
	 * @param array $attributes Block attributes.
	 * @return array Image attributes with border styles.
	 */
	private function get_image_border_attributes( $attributes ) {
		$border_styles = array();
		$sides = array( 'top', 'right', 'bottom', 'left' );

		// Border radius
		if ( isset( $attributes['style']['border']['radius'] ) ) {
			$border_styles['radius'] = $attributes['style']['border']['radius'];
		}

		// Border style
		if ( isset( $attributes['style']['border']['style'] ) ) {
			$border_styles['style'] = $attributes['style']['border']['style'];
		}

		// Border width
		if ( isset( $attributes['style']['border']['width'] ) ) {
			$border_styles['width'] = $attributes['style']['border']['width'];
		}

		// Border color
		$preset_color = array_key_exists( 'borderColor', $attributes ) ? "var:preset|color|{$attributes['borderColor']}" : null;
		$custom_color = $attributes['style']['border']['color'] ?? null;
		$border_styles['color'] = $preset_color ? $preset_color : $custom_color;

		// Individual border styles
		foreach ( $sides as $side ) {
			$border = $attributes['style']['border'][ $side ] ?? null;
			$border_styles[ $side ] = array(
				'color' => isset( $border['color'] ) ? $border['color'] : null,
				'style' => isset( $border['style'] ) ? $border['style'] : null,
				'width' => isset( $border['width'] ) ? $border['width'] : null,
			);
		}

		$styles = wp_style_engine_get_styles( array( 'border' => $border_styles ) );
		$attr = array();
		
		if ( ! empty( $styles['classnames'] ) ) {
			$attr['class'] = $styles['classnames'];
		}
		if ( ! empty( $styles['css'] ) ) {
			$attr['style'] = $styles['css'];
		}

		return $attr;
	}

	/**
	 * Generate overlay element markup, similar to core functionality.
	 *
	 * @since 2.1.0
	 *
	 * @param array $attributes Block attributes.
	 * @return string Overlay HTML markup.
	 */
	private function get_overlay_element_markup( $attributes ) {
		$has_dim_background = isset( $attributes['dimRatio'] ) && $attributes['dimRatio'];
		$has_gradient = isset( $attributes['gradient'] ) && $attributes['gradient'];
		$has_custom_gradient = isset( $attributes['customGradient'] ) && $attributes['customGradient'];
		$has_solid_overlay = isset( $attributes['overlayColor'] ) && $attributes['overlayColor'];
		$has_custom_overlay = isset( $attributes['customOverlayColor'] ) && $attributes['customOverlayColor'];
		$class_names = array( 'wp-block-post-featured-image__overlay' );
		$styles = array();

		if ( ! $has_dim_background ) {
			return '';
		}

		// Apply border classes and styles
		$border_attributes = $this->get_image_border_attributes( $attributes );

		if ( ! empty( $border_attributes['class'] ) ) {
			$class_names[] = $border_attributes['class'];
		}

		if ( ! empty( $border_attributes['style'] ) ) {
			$styles[] = $border_attributes['style'];
		}

		// Apply overlay and gradient classes
		if ( $has_dim_background ) {
			$class_names[] = 'has-background-dim';
			$class_names[] = "has-background-dim-{$attributes['dimRatio']}";
		}

		if ( $has_solid_overlay ) {
			$class_names[] = "has-{$attributes['overlayColor']}-background-color";
		}

		if ( $has_gradient || $has_custom_gradient ) {
			$class_names[] = 'has-background-gradient';
		}

		if ( $has_gradient ) {
			$class_names[] = "has-{$attributes['gradient']}-gradient-background";
		}

		// Apply background styles
		if ( $has_custom_gradient ) {
			$styles[] = sprintf( 'background-image: %s;', $attributes['customGradient'] );
		}

		if ( $has_custom_overlay ) {
			$styles[] = sprintf( 'background-color: %s;', $attributes['customOverlayColor'] );
		}

		return sprintf(
			'<span class="%s" style="%s" aria-hidden="true"></span>',
			esc_attr( implode( ' ', $class_names ) ),
			esc_attr( safecss_filter_attr( implode( ' ', $styles ) ) )
		);
	}
}
