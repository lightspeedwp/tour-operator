<?php
/**
 * Tour Operator - Post Types Class
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

namespace lsx;

/**
 * Class Post_Types
 * Handles registration of post plugin post types.
 *
 * @package lsx
 */

class Post_Types extends Frame {

	/**
	 * Holds an type of object.
	 *
	 * @since   1.1.0
	 * @var     string
	 */
	protected $type = 'post-types';

	/**
	 * Register a Post Type for the plugin.
	 *
	 * @since 1.1.0
	 *
	 * @param string $slug The post type slug.
	 * @param array  $args The post type config arguments.
	 */
	protected function register_object( $slug, $args ) {
		$this->object[ $slug ] = register_post_type( $slug, $args );
	}
}
