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
	 * @var      array|Frontend
	 */
	public $modal_ids = array();

	/**
	 * Tour Operator Admin constructor.
	 */
	public function __construct() {
		add_filter( 'lsx_to_connected_list_item', array( $this, 'add_modal_attributes' ), 10, 3 );
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function add_modal_attributes( $html, $post_id, $link ) {
		if ( true === $this->enable_modals && true === $link ) {
			$html = '<a data-toggle="modal" data-target="#lsx-modal-' . $post_id . '" href="#">' . get_the_title( $post_id ) . '</a>';

			if ( ! in_array( $post_id, $this->modal_ids ) ) {
				$this->modal_ids[] = $post_id;
			}
		}

		return $html;
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function output_modals() {
		global $lsx_to_archive, $post;

		if ( true === $this->enable_modals && ! empty( $this->modal_ids ) ) {
			$temp = $lsx_to_archive;
			$lsx_to_archive = 1;

			foreach ( $this->modal_ids as $post_id ) {
				$post = get_post( $post_id );
				?>
				<div class="lsx-modal modal fade" id="lsx-modal-<?php echo esc_attr( $post_id ); ?>" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<div class="modal-body">
								<?php lsx_to_content( 'content', 'modal' ); ?>
							</div>
						</div>
					</div>
				</div>
				<?php
			}

			$lsx_to_archive = $temp;
			wp_reset_postdata();
		}
		?>
		<div class="lsx-modal modal fade" id="lsx-modal-placeholder" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-header">
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
