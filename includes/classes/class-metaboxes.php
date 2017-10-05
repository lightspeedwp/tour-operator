<?php
/**
 * Tour Operator - Metabox Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

namespace lsx;

/**
 * Class Metaboxes
 * Handles registration of metaboxes within the plugin.
 *
 * @package lsx
 */
class Metaboxes extends Object {

	/**
	 * Holds an type of object.
	 *
	 * @since   1.1.0
	 * @var     string
	 */
	protected $type = 'metaboxes';

	/**
	 * Metabox constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_filter( 'cmb_meta_boxes', array( $this, 'metaboxes' ) );
	}

	/**
	 * Adds metaboxes to CMB.
	 *
	 * @since 1.1.0
	 *
	 * @param array $boxes The list of registered metaboxes.
	 *
	 * @return array  The array of registered metaboxes.
	 */
	public function metaboxes( $boxes ) {
		return array_merge( $boxes, $this->object );
	}

	/**
	 * Register a taxonomy for the plugin.
	 *
	 * @since 1.1.0
	 *
	 * @param string $slug   The taxonomy slug.
	 * @param array  $config The taxonomy config arguments.
	 */
	protected function register_object( $slug, $config ) {
		$this->object[ $slug ] = $config;
	}

}
