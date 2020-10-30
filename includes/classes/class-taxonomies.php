<?php
/**
 * LSX Tour Operator - Taxonomy Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

namespace lsx;

/**
 * Class Taxonomies
 * Handles registration of taxonomies within the plugins taxonomies.
 *
 * @package lsx
 */
class Taxonomies extends Frame {

	/**
	 * Holds an type of object.
	 *
	 * @since   1.1.0
	 * @var     string
	 */
	protected $type = 'taxonomies';

	/**
	 * Register a taxonomy for the plugin.
	 *
	 * @since 1.1.0
	 *
	 * @param string $slug   The taxonomy slug.
	 * @param array  $config The taxonomy config arguments.
	 */
	protected function register_object( $slug, $config ) {
		register_taxonomy( $slug, $config['object_types'], $config['args'] );
		$this->object[ $slug ] = get_taxonomy( $slug );
	}

}
