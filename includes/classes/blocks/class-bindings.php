<?php
namespace lsx\blocks;

use stdClass;

/**
 * Registers our Custom Fields
 *
 * @package lsx
 * @author  LightSpeed
 */
class Bindings {

    public function __construct() {
        add_filter('render_block_bindings_source_value', array($this, 'filter_cover_block_binding'), 10, 4);
        add_filter('render_block_core/cover', array($this, 'filter_cover_block_content'), 10, 3);

        // ... rest of your existing constructor code ...
    }

    // ... your existing methods ...

    /**
     * Filter the block bindings value for the cover block
     */
    public function filter_cover_block_binding($value, $source_args, $block_instance, $source_name) {
        if ('core/cover' !== $block_instance->parsed_block['blockName']) {
            return $value;
        }

        if ('lsx/post-meta' !== $source_name) {
            return $value;
        }

        // If we have a numeric value, assume it's an attachment ID
        if (is_numeric($value)) {
            $image_url = wp_get_attachment_image_url($value, 'full');
            if ($image_url) {
                return $image_url;
            }
        }

        // Check if the value is already a URL
        if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // If we have a string that's not a URL, try to find the attachment
        if (is_string($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            $attachment_id = attachment_url_to_postid($value);
            if ($attachment_id) {
                $image_url = wp_get_attachment_image_url($attachment_id, 'full');
                if ($image_url) {
                    return $image_url;
                }
            }
        }

        return $value;
    }

    /**
     * Filter the cover block content
     */
    public function filter_cover_block_content($block_content, $block, $instance) {
        if ('core/cover' !== $block['blockName']) {
            return $block_content;
        }

        // Don't process if there's no URL
        if (!isset($block['attrs']['url'])) {
            return $block_content;
        }

        $url = $block['attrs']['url'];

        // If we have a numeric value, get the full size URL
        if (is_numeric($url)) {
            $image_url = wp_get_attachment_image_url($url, 'full');
            if ($image_url) {
                $url = $image_url;
            }
        }

        // Allow other plugins to modify the URL
        $url = apply_filters('lsx_cover_block_image_url', $url, $block, $instance);

        // Allow for dynamic image size selection
        if (isset($block['attrs']['metadata']['size'])) {
            $size = $block['attrs']['metadata']['size'];
            if (is_numeric($block['attrs']['url'])) {
                $sized_url = wp_get_attachment_image_url($block['attrs']['url'], $size);
                if ($sized_url) {
                    $url = $sized_url;
                }
            }
        }

        // Replace the URL in the block content
        $block_content = str_replace($block['attrs']['url'], $url, $block_content);

        return $block_content;
    }
}