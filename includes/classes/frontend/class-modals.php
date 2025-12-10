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
		$this->maybe_set_default_modal_templates();

		add_action( 'wp_loaded', [ $this, 'init' ], 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylescripts' ), 1 );
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
	}

	/**
	 * Set default modal templates on first run if not already set.
	 *
	 * @return void
	 */
	public function maybe_set_default_modal_templates() {
		$post_types = [ 'tour', 'accommodation', 'destination' ];
		$updated    = false;

		foreach ( $post_types as $post_type ) {
			$option_key = $post_type . '_modal_template';

			// Only set if the option doesn't exist
			if ( ! isset( $this->options[ $option_key ] ) || empty( $this->options[ $option_key ] ) ) {
				$this->options[ $option_key ] = $this->get_default_modal_for_post_type( $post_type );
				$updated                      = true;
			}
		}

		// Save the updated options if any were changed
		if ( $updated ) {
			update_option( 'lsx_to_settings', $this->options );
		}
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
		add_filter( 'render_block_lsx-tour-operator/modal-button', array( $this, 'register_button_modal' ), 2, 10 );

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
		// Get the default modal template based on post type
		$default_modal = $this->get_default_modal_for_post_type( '{{post_type}}' );

		$fields['post_types']['template']['enable_modals']  = array(
			'label'   => esc_html__( 'Enable Preview Modals', 'tour-operator' ),
			'desc'    => esc_html__( 'Links to this item will trigger a popup preview modal allowing a quick look at it before clicking through. ', 'tour-operator' ),
			'type'    => 'checkbox',
			'default' => 0,
		);
		$fields['post_types']['template']['modal_template'] = array(
			'label'   => esc_html__( 'Modal Template', 'tour-operator' ),
			'type'    => 'select',
			'default' => $default_modal,
			'options' => $this->get_template_part_options(),
		);
		return $fields;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_stylescripts() {
		// if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			$prefix = 'src/';
			$suffix = '';
		/*
		} else {
			$prefix = '';
			$suffix = '.min';
		}*/

		wp_register_script( 'lsx-to-modals', LSX_TO_URL . 'build/modals.js', array( 'jquery' ), LSX_TO_VER, true );
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
			'post__in'            => $this->modal_ids,
			'post_status'         => 'publish',
			'post_type'           => 'any',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => -1,
			'nopagin'             => true,
		];
		$modal_query = new \WP_Query( $modal_args );

		if ( $modal_query->have_posts() ) {
			while ( $modal_query->have_posts() ) {
				$modal_query->the_post();

				$modal_id         = get_the_ID();
				$template         = $this->get_selected_template();
				$rendered_content = do_blocks( $template );

				// Generate and output modal using reusable method
				$modal_html = $this->generate_modal_html( $modal_id, $rendered_content );
				$this->output_modal( $modal_html );
			}

			wp_reset_postdata();
		}
	}

	public function get_selected_template() {
		$post_type = get_post_type();

		$template = '<div class="wp-block-template-part">';
		switch ( $post_type ) {
			case 'accommodation':
				$template .= '<!-- wp:template-part {"slug":"modal-accommodation"} /-->';
				break;

			case 'destination':
				$template .= '<!-- wp:template-part {"slug":"modal-destination"} /-->';
				break;

			case 'tour':
				$template .= '<!-- wp:template-part {"slug":"modal-tour"} /-->';
				break;

			default:
				$template .= '<p>' . __( 'Please select a pattern or customize your layout with the Tour Operator blocks.', 'tour-operator' ) . '</p>';
				break;
		}

		$template .= '</div>';

		if ( isset( $this->options[ $post_type . '_modal_template' ] ) && 'default' !== $this->options[ $post_type . '_modal_template' ] ) {
			$template = '<!-- wp:template-part { "slug":"' . $this->options[ $post_type . '_modal_template' ] . '","area":"modals"} /-->';
		}

		return $template;
	}

	/**
	 * Get the default modal template slug for a given post type.
	 *
	 * @param string $post_type The post type to get default modal for.
	 * @return string The default modal slug.
	 */
	public function get_default_modal_for_post_type( $post_type ) {
		$defaults = array(
			'tour'          => 'modal-tour',
			'accommodation' => 'modal-accommodation',
			'destination'   => 'modal-destination',
		);

		// Return the specific default or 'default' if not found
		return isset( $defaults[ $post_type ] ) ? $defaults[ $post_type ] : 'default';
	}

	/**
	 * Get a list of all registered modal template parts for the site editor.
	 *
	 * @return array List of modal template part names and titles.
	 */
	public function get_template_part_options() {
		// Get all template parts of the 'modals' area.
		$template_parts = get_posts(
			array(
				'post_type'      => 'wp_template_part',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'wp_template_part_area',
						'field'    => 'slug',
						'terms'    => 'modals',
					),
				),
			)
		);

		$options = array();

		if ( ! empty( $template_parts ) ) {
			foreach ( $template_parts as $template ) {
				$options[ $template->post_name ] = $template->post_title;
			}
		}

		// Only show "no templates" message if we found no modal template parts
		if ( count( $options ) === 1 ) {
			$options[''] = __( 'No other templates found.', 'tour-operator' );
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
			$modal_html = $this->generate_modal_html( $key, wpautop( $content ), true );
			$this->output_modal( $modal_html );
		}
	}

	/**
	 * Filter the travel information and return a shortened version.
	 */
	public function travel_information_excerpt( $html = '', $meta_key = false, $value = false, $before = '', $after = '' ) {

		if ( false === apply_filters( 'lsx_travel_information_modal_enable', true ) ) {
			return $html;
		}

		// Allow 3rd party to override the character limit.
		$limit_chars = apply_filters( 'lsx_travel_information_excerpt_length', 150 );
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

		if ( get_post_type() === 'destination' && in_array( $meta_key, $ti_keys ) ) {

			$title = $meta_key;
			if ( 'additional_info' === $title ) {
				$title = 'general';
			}
			$this->modal_contents[ $meta_key ] = '<h2 class="wp-block-heading" style="margin-top:0px;padding-right: 0px; padding-left: 0px;">' . ucwords( $title ) . '</h2>' . $html;

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

			// Remove empty P lines
			$html = str_replace( '<p></p>', '', $html );
		}
		return $html;
	}

	/**
	 * Enqueue editor scripts and localize modal options
	 */
	public function enqueue_editor_scripts() {
		// Only localize if we're in the admin/editor
		if ( ! is_admin() ) {
			return;
		}

		// Localize to the modal-button block's specific script handle
		wp_localize_script(
			'lsx-to-block-modal-button',
			'lsxModalButtonOptions',
			array(
				'apiUrl' => rest_url( 'tour-operator/v1/modal-options' ),
				'nonce'  => wp_create_nonce( 'wp_rest' ),
			)
		);
	}

	/**
	 * Register REST API routes
	 */
	public function register_rest_routes() {
		register_rest_route(
			'tour-operator/v1',
			'/modal-options',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_modal_options_api' ),
				'permission_callback' => array( $this, 'permissions_check' ),
			)
		);
	}

	/**
	 * Permission callback for REST API
	 */
	public function permissions_check() {
		return current_user_can( 'edit_posts' );
	}

	/**
	 * Get modal options from database for REST API
	 *
	 * @return \WP_REST_Response
	 */
	public function get_modal_options_api() {
		$modal_options = array(
			array(
				'label' => __( 'Select a modal...', 'tour-operator' ),
				'value' => '',
			),
		);

		// Use the existing get_template_part_options method but format for API
		$template_options = $this->get_template_part_options();

		foreach ( $template_options as $value => $label ) {
			// Skip the default option since we already added "Select a modal..."
			if ( $value !== 'default' && $value !== '' ) {
				$modal_options[] = array(
					'label' => $label,
					'value' => $value,
				);
			}
		}

		// Register modal HTML for template parts to be output in footer
		foreach ( $template_options as $slug => $title ) {
			if ( $slug !== 'default' && $slug !== '' ) {
				$this->register_modal_content( $slug );
			}
		}

		return rest_ensure_response( $modal_options );
	}

	/**
	 * Registers the modals for the buttons.
	 *
	 * @param string $block_content
	 * @param object $block
	 * @return string
	 */
	public function register_button_modal( $block_content, $block ) {
		if ( isset( $block['attrs']['modalId'] ) && ! empty( $block['attrs']['modalId'] ) ) {
			$modal_id = $block['attrs']['modalId'];

			// Register modal content for template parts to be output in footer
			$this->register_modal_content( $modal_id );
		}

		return $block_content;
	}

	/**
	 * Register modal content for template parts to be output in footer
	 *
	 * @param string $template_slug The template part slug
	 */
	public function register_modal_content( $template_slug ) {
		// Check if modal is already registered to avoid duplicates
		$modal_id = 'to-modal-' . $template_slug;

		if ( ! isset( $this->modal_contents[ $modal_id ] ) ) {
			// Get the template part content
			$template_content                  = '<!-- wp:template-part {"slug":"' . $template_slug . '","area":"modals"} /-->';
			$this->modal_contents[ $modal_id ] = do_blocks( $template_content );
		}
	}

	/**
	 * Generate modal HTML with consistent structure
	 *
	 * @param string $modal_id The modal ID (without 'to-modal-' prefix)
	 * @param string $content The modal content
	 * @param bool   $add_wrapper Whether to wrap content in template-part div
	 * @return string The complete modal HTML
	 */
	private function generate_modal_html( $modal_id, $content, $add_wrapper = false ) {
		// Ensure modal ID has proper prefix
		$full_modal_id = strpos( $modal_id, 'to-modal-' ) === 0 ? $modal_id : 'to-modal-' . $modal_id;

		// Create close button
		$close_button = $this->get_modal_close_button();

		// Wrap content if needed
		if ( $add_wrapper ) {
			$content = '<div class="wp-block-template-part">' . $content . '</div>';
		}

		// Create modal HTML
		$modal_html  = '<dialog id="' . esc_attr( $full_modal_id ) . '" class="wp-block-hm-popup" data-trigger="click" data-expiry="7" data-backdrop-opacity="0.75" tabindex="-1">';
		$modal_html .= '<div style="position:relative;">';
		$modal_html .= $content;
		$modal_html .= $close_button;
		$modal_html .= '</div>';
		$modal_html .= '</dialog>';

		return $modal_html;
	}

	/**
	 * Get the standardized modal close button HTML
	 *
	 * @return string The close button HTML
	 */
	private function get_modal_close_button() {
		$close_button  = '<button class="wp-block-hm-popup__close" aria-label="' . esc_attr__( 'Close', 'tour-operator' ) . '" data-close>';
		$close_button .= '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">';
		$close_button .= '<path d="M8 24.5L24 8.5M8 8.5L24 24.5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>';
		$close_button .= '</svg>';
		$close_button .= '</button>';

		return $close_button;
	}

	/**
	 * Get allowed HTML tags for modal content
	 *
	 * @return array Allowed HTML tags and attributes
	 */
	private function get_modal_allowed_html() {
		$allowed_html = wp_kses_allowed_html( 'post' );

		// Add modal-specific elements
		$allowed_html['dialog'] = array(
			'id'                    => true,
			'class'                 => true,
			'data-trigger'          => true,
			'data-expiry'           => true,
			'data-backdrop-opacity' => true,
			'tabindex'              => true,
		);
		$allowed_html['style']  = array(
			'type'  => true,
			'src'   => true,
			'async' => true,
			'defer' => true,
			'id'    => true,
			'class' => true,
		);
		$allowed_html['script'] = array(
			'type'  => true,
			'src'   => true,
			'async' => true,
			'defer' => true,
			'id'    => true,
			'class' => true,
		);
		$allowed_html['svg']    = array(
			'width'   => true,
			'height'  => true,
			'viewBox' => true,
			'fill'    => true,
			'xmlns'   => true,
		);
		$allowed_html['path']   = array(
			'd'               => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'stroke-linecap'  => true,
			'stroke-linejoin' => true,
		);
		$allowed_html['button'] = array(
			'class'      => true,
			'aria-label' => true,
			'data-close' => true,
		);

		return $allowed_html;
	}

	/**
	 * Output a modal with proper sanitization
	 *
	 * @param string $modal_html The modal HTML to output
	 */
	private function output_modal( $modal_html ) {
		echo wp_kses( $modal_html, $this->get_modal_allowed_html() );
	}
}
