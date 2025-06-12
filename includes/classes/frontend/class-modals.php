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

		add_action( 'wp_footer', array( $this, 'output_modals2' ), 10 );
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

		foreach ( $this->modal_ids as $post_id ) {
			?>
			<dialog id="to-modal-<?php echo esc_attr( $post_id ); ?>" class="wp-block-hm-popup" data-trigger="click" data-expiry="7" data-backdrop-opacity="0.75">
				<?php
					$post_type = get_post_type( $post_id );
					switch ( $post_type ) {
						case 'accommodation':
							$template = '<!-- wp:pattern {"slug":"lsx-tour-operator/accommodation-card"} /-->';	
						break;
						
						case 'destination':
							$template = '<!-- wp:pattern {"slug":"lsx-tour-operator/destination-card"} /-->';	
						break;

						case 'tour':
							$template = '<!-- wp:pattern {"slug":"lsx-tour-operator/tour-card"} /-->';	
						break;

						default:
							$template = '<p>' . __( 'Please select a pattern or customize your layout with the Tour Operator blocks.', 'tour-operator' ) . '</p>';
						break;
					}
					
					echo do_blocks( $template );
				?>
			</dialog>
			<?php
		}

		$temp = ob_get_clean();

		 echo ( $temp );
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function output_modals2( $content = '' ) {
		if ( false === $this->enable_modals || empty( $this->modal_ids ) ) {
			return;
		}

		do_action( 'qm/debug', $this->modal_ids );

		$modal_args  = [
			'post__in' => $this->modal_ids,
			'post_status' => 'publish',
			'post_type' => 'any',
			'ignore_sticky_posts' => true,
			'posts_per_page' => -1,
			'nopagin' => true,
		];
		$modal_query = new \WP_Query( $modal_args );
		$modal_html  = [];

		do_action( 'qm/debug', $modal_query );

		if ( $modal_query->have_posts() ) {
			while ( $modal_query->have_posts() ) {
				$modal_query->the_post();

				do_action( 'qm/debug', $modal_query->post );

				$modal_id  = get_the_ID();
				$temp_html = '<dialog id="to-modal-' . $modal_id . '" class="wp-block-hm-popup" data-trigger="click" data-expiry="7" data-backdrop-opacity="0.75">';

				$post_type = get_post_type();
				switch ( $post_type ) {
					case 'accommodation':
						$template = '<!-- wp:pattern {"slug":"lsx-tour-operator/accommodation-card"} /-->';	
					break;
					
					case 'destination':
						$template = '<!-- wp:pattern {"slug":"lsx-tour-operator/destination-card"} /-->';	
					break;

					case 'tour':
						$template = '<!-- wp:pattern {"slug":"lsx-tour-operator/tour-card"} /-->';	
					break;

					default:
						$template = '<p>' . __( 'Please select a pattern or customize your layout with the Tour Operator blocks.', 'tour-operator' ) . '</p>';
					break;
				}

				$temp_html .= do_blocks( $template );
				$temp_html .= '</dialog>';

				$modal_html[] = $temp_html;
			}

			wp_reset_postdata();
		}

		if ( ! empty( $modal_html ) ) {
			$content .= implode( '', $modal_html );
		}

		echo $content;
	}
}
