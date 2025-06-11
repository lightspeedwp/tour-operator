<?php
/**
 * Tour Operator - Modals Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-3.0+
 */

namespace lsx\frontend;

/**
 * Class Modals
 *
 * @package lsx\frontend
 */
class Modals {

	/**
	 * Enable Modals
	 *
	 * @since 1.0.0
	 * @var      boolean|Frontend
	 */
	public $enable_modals = false;

	/**
	 * Holds the modal ids for output in the footer
	 *
	 * @since 1.0.0
	 * @var array|Frontend
	 */
	public $modal_ids = array();

	/**
	 * Tour Operator Admin constructor.
	 */
	public function __construct() {
		$this->enable_modals = true;
		add_filter( 'lsx_to_connected_list_item', array( $this, 'add_modal_attributes' ), 10, 3 );

		add_action( 'wp_footer', array( $this, 'output_modals' ), 10 );
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function add_modal_attributes( $html, $post_id, $link ) {
		if ( true === $this->enable_modals && true === $link ) {
			$html = '<a href="#to-modal-' . $post_id . '">' . get_the_title( $post_id ) . '</a>';

			if ( ! in_array( $post_id, $this->modal_ids ) ) {
				$this->modal_ids[] = $post_id;
			}
		}

		return $html;
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function output_modals( $content ) {
		if ( false === $this->enable_modals || empty( $this->modal_ids ) ) {
			return $content;
		}

		ob_start();
		foreach ( $this->modal_ids as $post_id ) {
			?>
			<dialog id="to-modal-<?php echo esc_attr( $post_id ); ?>" class="wp-block-hm-popup" data-trigger="click" data-expiry="7" data-backdrop-opacity="0.75">
				<div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow">
				<p>Title</p>
				</div>
			</dialog>
			<?php
		}

		$temp = ob_get_clean();

		 echo ( $temp );
	}
}
