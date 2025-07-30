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
 * @since 2.1.0
 * @package lsx\frontend
 */
class Modals {

	/**
	 * Enable Modals
	 *
	 * @since 2.1.0
	 * @var      boolean|array
	 */
	public $options = [];

	/**
	 * Holds the modal ids for output in the footer
	 *
	 * @since 2.1.0
	 * @var array
	 */
	public $modal_ids = [];

	/**
	 * Holds any modals that registered HTML to display
	 *
	 * @since 2.1.0
	 * @var array
	 */
	public $modal_contents = [];

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
		add_filter( 'lsx_to_custom_field_query', array( $this, 'travel_information_excerpt' ), 5, 10 );
		add_action( 'wp_footer', array( $this, 'output_modal_ids' ), 10 );
		add_action( 'wp_footer', array( $this, 'output_modal_contents' ), 11 );
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
	public function output_modal_ids( $content = '' ) {
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

				$template   = $this->get_selected_template();
				$temp_html .= do_blocks( $template );

				$temp_html .= '</dialog>';

				$modal_html[] = $temp_html;
			}

			wp_reset_postdata();
		}

		if ( ! empty( $modal_html ) ) {
			$content .= implode( '', $modal_html );
		}

		echo wp_kses_post( $content );
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
	public function get_template_part_options() {
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

	/**
	 * Ouputs any of the items registered in the $modal_contents variable.
	 *
	 * @return void
	 */
	public function output_modal_contents() {
		if ( empty( $this->modal_contents ) ) {
			return;
		}

		wp_enqueue_script( 'lsx-to-modals' );

		foreach ( $this->modal_contents as $key => $content ) {


			// If you want to allow any data-* attribute, use a regex filter after wp_kses_post
			$modal  = '<dialog id="to-modal-' . $key . '" class="wp-block-hm-popup" data-trigger="click" data-expiry="7" data-backdrop-opacity="0.75">';
			$modal .= '<div class="wp-block-template-part">';
			$modal .= '<p class="has-small-font-size" style="padding-top:0;"><strong>' . ucwords( $key ) . '</strong></p>';
			$modal .= $content;
			$modal .= '</div>';
			$modal .= '</dialog>';
			
			echo wp_kses_post( $modal );
		}
	}

	/**
	 * Filter the travel information and return a shortened version.
	 */
	public function travel_information_excerpt( $html = '', $meta_key = false, $value = false, $before = '', $after = '' ) {
		$limit_chars = 150;
		$ti_keys     = [
			'electricity',
			'banking',
			'cuisine',
			'climate',
			'transport',
			'dress',
			'health',
			'safety',
			'visa',
			'additional_info',
		];

		if ( get_post_type() === 'destination' && in_array( $meta_key, $ti_keys )  ) {
			$this->modal_contents[ $meta_key ] = $html;

			$value = wp_trim_excerpt( wp_strip_all_tags( $html ) );
			$value = str_replace( '<br>', ' ', $value );
			$value = str_replace( '<br />', ' ', $value );
		
			if ( strlen( $value ) > $limit_chars ) {
				$position = strpos( $value, ' ', $limit_chars );
				if ( false !== $position ) {
					$value_output = substr( $value, 0, $position );
				} else {
					$value_output = $value;
				}
				$value = trim( force_balance_tags( $value_output . '...' ) );
			}
	
			$html = trim( force_balance_tags( $value ) );
		}
		return $html;
	}
}
