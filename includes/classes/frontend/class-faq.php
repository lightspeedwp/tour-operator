<?php
/**
 * Tour Operator - FAQ Class
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
 * Class Faq
 *
 * Makes the Yoast FAQ block collapsible. The styles live in build/style.css,
 * the toggle script is only enqueued on pages that render the block.
 *
 * @since 2.2.0
 * @package lsx\frontend
 */
class Faq {

	/**
	 * Tour Operator FAQ constructor.
	 */
	public function __construct() {
		add_filter( 'render_block_yoast/faq-block', array( $this, 'enqueue_accordion_script' ), 10, 1 );
	}

	/**
	 * Enqueue the accordion script when a Yoast FAQ block is rendered.
	 *
	 * @param string $block_content The block content.
	 * @return string The unchanged block content.
	 */
	public function enqueue_accordion_script( $block_content ) {
		if ( ! wp_script_is( 'lsx-to-faq-accordion', 'enqueued' ) ) {
			wp_enqueue_script(
				'lsx-to-faq-accordion',
				LSX_TO_URL . 'build/faq-accordion.js',
				array(),
				LSX_TO_VER,
				array(
					'in_footer' => true,
					'strategy'  => 'defer',
				)
			);
		}

		return $block_content;
	}
}
