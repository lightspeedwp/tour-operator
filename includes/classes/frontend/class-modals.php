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
	public $options = [];

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
		$this->options = get_option( 'lsx_to_settings', [] );
		
		add_action( 'wp_loaded', [ $this, 'init' ], 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylescripts' ), 1 );

		//Register our mega menu template part area.
		add_filter( 'default_wp_template_part_areas', [ $this, 'register_template_part_category' ], 10, 1 );
	}

	/**
	 * Runs after the WP query is setup.
	 *
	 * @return void
	 */
	public function init() {
		add_filter( 'lsx_to_settings_fields', [ $this, 'settings_fields' ], 10, 1 );
		add_filter( 'lsx_to_connected_list_item', array( $this, 'add_modal_attributes' ), 10, 3 );
		add_action( 'wp_footer', array( $this, 'output_modals' ), 10 );
	}

	/**
	 * Adds in our modal fields.
	 *
	 * @param array $fields
	 * @return void
	 */
	public function settings_fields( $fields = [] ) {
		$fields['post_types']['template']['enable_modals'] = array(
			'label'   => esc_html__( 'Enable Preview Modals', 'tour-operator' ),
			'desc'    => esc_html__( 'Links to this item will trigger a popup preview modal allowing a quick look at it before clicking through. ', 'tour-operator' ),
			'type'    => 'checkbox',
			'default' => 0,
		);
		$fields['post_types']['template']['modal_template'] = array(
			'label'   => esc_html__( 'Modal Template', 'tour-operator' ),
			'type'    => 'select',
			'default' => 'default',
			'options' => $this->get_template_part_options()
		);
		return $fields;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_stylescripts() {
		//if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			$prefix = 'src/';
			$suffix = '';
		/*} else {
			$prefix = '';
			$suffix = '.min';
		}*/
		
		wp_register_script( 'lsx-to-modals', LSX_TO_URL . 'assets/js/' . $prefix . 'modals' . $suffix . '.js', array( 'jquery' ), LSX_TO_VER, true );
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function add_modal_attributes( $html, $post_id, $link ) {
		$post_type = get_post_type( $post_id );
		if ( isset( $this->options[ $post_type . '_enable_modals' ] ) && 1 === (int) $this->options[ $post_type . '_enable_modals' ] && true === $link ) {
			$html = '<a class="" href="#to-modal-' . $post_id . '">' . get_the_title( $post_id ) . '</a>';

			if ( ! in_array( $post_id, $this->modal_ids ) ) {
				$this->modal_ids[] = $post_id;
			}
		}

		return $html;
	}

	/**
	 * a filter to overwrite the links with modal tags.
	 */
	public function output_modals( $content = '' ) {
		if ( empty( $this->modal_ids ) ) {
			return;
		}
		wp_enqueue_script( 'lsx-to-modals' );

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

		if ( $modal_query->have_posts() ) {
			while ( $modal_query->have_posts() ) {
				$modal_query->the_post();

				$modal_id  = get_the_ID();
				$temp_html = '';


				$temp_html = '<dialog id="to-modal-' . $modal_id . '" class="wp-block-hm-popup" data-trigger="click" data-expiry="7" data-backdrop-opacity="0.75">';

				$template = $this->get_selected_template();

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

	public function get_selected_template() {
		$post_type = get_post_type();

		$template  = '<div class="wp-block-template-part">';
		switch ( $post_type ) {
			case 'accommodation':
				$template .= '<!-- wp:pattern {"slug":"lsx-tour-operator/accommodation-card"} /-->';	
			break;
			
			case 'destination':
				$template .= '<!-- wp:pattern {"slug":"lsx-tour-operator/destination-card"} /-->';	
			break;

			case 'tour':
				$template .= '<!-- wp:pattern {"slug":"lsx-tour-operator/tour-card"} /-->';	
			break;

			default:
				$template .= '<p>' . __( 'Please select a pattern or customize your layout with the Tour Operator blocks.', 'tour-operator' ) . '</p>';
			break;
		}
		$template  .= '</div>';

		if ( isset( $this->options[ $post_type . '_modal_template'] ) && 'default' !== $this->options[ $post_type . '_modal_template'] ) {
			$template = '<!-- wp:template-part { "slug":"' . $this->options[ $post_type . '_modal_template'] . '","area":"lsx_to_modals"} /-->';
		}

		return $template;
	}

	/**
	 * Registers the Modals template part.
	 *
	 * @param array $parts
	 * @return array
	 */
	public function register_template_part_category( $parts ) {
		$parts[] = array(
			'area'        => 'lsx_to_modals',
			'label'       => _x( 'Modals', 'template part area', 'tour-operator' ),
			'description' => __(
				'Design an advanced popup modals for your site.',
				'tour-operator'
			),
			'icon'        => 'welcome-widgets-menus',
			'area_tag'    => 'div',
		);
		return $parts;
	}

	/**
	 * Get a list of all registered header template parts for the site editor.
	 *
	 * @return array List of header template part names and titles.
	 */
	function get_template_part_options() {
		// Get all template parts of the 'header' area.
		$templates = get_block_templates( array(
			'post_type'   => 'wp_template_part',
			'area'        => 'lsx_to_modals',
		), 'wp_template_part' );

		$options = array();
		$options['default'] = __( 'Default', 'tour-operator' );

		if ( ! empty( $templates ) ) {
			foreach ( $templates as $template ) {
				$options[ $template->slug ] = $template->title;
			}
		} else {
			$options[ '' ] = __( 'No other templates found.', 'tour-operator' );
		}

		return $options;
	}
}
