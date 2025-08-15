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
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );

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
		add_action( 'wp_footer', array( $this, 'output_template_part_modals' ), 12 );

		$this->create_default_templates();
	}

	/**
	 * Create default templates if they don't exist
	 *
	 * @return void
	 */
	public function create_default_templates() {
		// Check if modal templates exist
		$existing_templates = get_posts( [
			'post_type' => 'wp_template_part',
			'meta_query' => [
				[
					'key' => 'area',
					'value' => 'lsx_to_modals',
					'compare' => '='
				]
			],
			'numberposts' => 1,
			'post_status' => 'any'
		] );

		// If no modal templates exist, create the defaults
		if ( empty( $existing_templates ) ) {
			$this->create_default_modal_templates();
		}
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

		if ( $modal_query->have_posts() ) {
			while ( $modal_query->have_posts() ) {
				$modal_query->the_post();

				$modal_id = get_the_ID();
				$template = $this->get_selected_template();
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

		$template  = '<div class="wp-block-template-part">';
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
			$modal_html = $this->generate_modal_html( $key, wpautop( $content ), true );
			$this->output_modal( $modal_html );
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

		if ( get_post_type() === 'destination' && in_array( $meta_key, $ti_keys ) ) {
			// Store full content for modal with the meta-key
			$modal_key = 'travel-info-' . $meta_key;
			$this->modal_contents[ $modal_key ] = $html;

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

				// Create truncated text and close the content wrapper early
				$html = trim( force_balance_tags( $value_output . '...' ) );
			} else {
				$html = trim( force_balance_tags( $value ) );
			}
		}

		return $html;
	}

	/**
	 * Creates default modal template parts in the database
	 *
	 * @return void
	 */
	public function create_default_modal_templates() {
		$current_theme = get_stylesheet();

		$templates = [
			'accommodation' => [
				'title' => __( 'Accommodation Modal', 'tour-operator' ),
				'content' => '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"Accommodation Card"},"className":"is-style-default","backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-default has-base-background-color has-background"><!-- wp:post-featured-image {"aspectRatio":"3/2"} /-->

<!-- wp:group {"metadata":{"name":"Content"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"Accommodation Title"},"className":"center-vertically","layout":{"type":"constrained"}} -->
<div class="wp-block-group center-vertically"><!-- wp:post-title {"textAlign":"center","level":3,"fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Accommodation Information"},"style":{"border":{"top":{"color":"var:preset|color|primary","width":"2px"},"bottom":{"color":"var:preset|color|primary","width":"2px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--primary);border-top-width:2px;border-bottom-color:var(--wp--preset--color--primary);border-bottom-width:2px"><!-- wp:group {"className":"lsx-price-wrapper","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group lsx-price-wrapper"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"id":60622,"width":"20px","height":"auto","scale":"cover","sizeSlug":"full","linkDestination":"none","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"From Price Icon"}} -->
<figure class="wp-block-image size-full is-resized"><img src="http://localwp.local/wp-content/plugins/tour-operator/assets/img/blocks/unit-price.png" alt="" class="wp-image-60622" style="object-fit:cover;width:20px;height:auto"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>From:</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}},"__default":{"source":"core/pattern-overrides"}},"name":"Price"},"className":"amount"} -->
<p class="amount"><strong>price</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-accommodation-type-wrapper","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group lsx-accommodation-type-wrapper"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"id":60627,"width":"20px","height":"auto","scale":"cover","sizeSlug":"full","linkDestination":"none","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"Accommodation Type Icon"}} -->
<figure class="wp-block-image size-full is-resized"><img src="http://localwp.local/wp-content/plugins/tour-operator/assets/img/blocks/unit-type.png" alt="" class="wp-image-60627" style="object-fit:cover;width:20px;height:auto"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Type:</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"accommodation-type","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"},":hover":{"color":{"text":"var:preset|color|primary-700"}}}}},"textColor":"contrast","fontSize":"x-small","fontFamily":"secondary"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-rooms-wrapper","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group lsx-rooms-wrapper"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"id":61041,"width":"20px","height":"auto","sizeSlug":"full","linkDestination":"none","metadata":{"bindings":{"__default":{"source":"core/pattern-overrides"}},"name":"Number of Rooms Icon"}} -->
<figure class="wp-block-image size-full is-resized"><img src="http://localwp.local/wp-content/plugins/tour-operator/assets/img/blocks/rooms.png" alt="" class="wp-image-61041" style="width:20px;height:auto"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Rooms:</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"number_of_rooms"}},"__default":{"source":"core/pattern-overrides"}},"name":"Number of Rooms"}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Accommodation Text Content"},"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
				'description' => __( 'This modal displays the accommodation details including the featured image, title, excerpt, and additional information.', 'tour-operator' ),
				'categories' => [ 'lsx_to_modals' ],
			],
			'destination' => [
				'title' => __( 'Destination Modal', 'tour-operator' ),
				'content' => '<!-- wp:group {"metadata":{"name":"Destination Modal"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"aspectRatio":"3/2"} /-->

<!-- wp:group {"metadata":{"name":"Content"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"Destination Title"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-title {"textAlign":"center","level":3} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Destination Description"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
				'description' => __( 'This modal displays the destination details including the featured image, title, excerpt, and travel information.', 'tour-operator' ),
				'categories' => [ 'lsx_to_modals' ],
			],
			'tour' => [
				'title' => __( 'Tour Modal', 'tour-operator' ),
				'content' => '<!-- wp:group {"metadata":{"name":"Tour Modal"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"aspectRatio":"3/2"} /-->

<!-- wp:group {"metadata":{"name":"Content"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"Tour Title"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-title {"textAlign":"center","level":3} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Tour Information"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"className":"lsx-price-wrapper","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group lsx-price-wrapper"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","height":"auto","sizeSlug":"large","metadata":{"name":"From Price Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="' . LSX_TO_URL . 'assets/img/blocks/unit-price.png" alt="" style="width:20px;height:auto"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p><strong>From:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"price"}}},"name":"From Price"},"className":"amount price"} -->
<p class="amount price"><strong>price</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"lsx-duration-wrapper","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group lsx-duration-wrapper"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"20px","sizeSlug":"large","metadata":{"name":"Duration Icon"}} -->
<figure class="wp-block-image size-large is-resized"><img src="' . LSX_TO_URL . 'assets/img/blocks/duration.png" alt="" style="width:20px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p><strong>Duration:</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"duration"}}},"name":"Duration"}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Days</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Tour Text Content"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-excerpt {"moreText":"View More","excerptLength":40} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
				'description' => __( 'This modal displays the tour details including the featured image, title, excerpt, and tour information.', 'tour-operator' ),
				'categories' => [ 'lsx_to_modals' ],
			],
			'enquiry' => [
				'title' => __( 'Enquiry Form Modal', 'tour-operator' ),
				'content' => '<!-- wp:group {"metadata":{"name":"Enquiry Form Modal"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p>Insert your contact form here.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
				'description' => __( 'This modal displays an enquiry form via shortcode or block insert.', 'tour-operator' ),
				'categories' => [ 'lsx_to_modals' ]
			]
		];

		foreach ( $templates as $slug => $template ) {
			$template_slug = 'modal-' . $slug;

			// Check if the template already exists
			$existing_template = get_posts( [
				'post_type' => 'wp_template_part',
				'name' => $template_slug,
				'post_status' => 'any',
				'numberposts' => 1
			] );

			// Create or update the template
			$template_data = [
				'post_title' => $template['title'],
				'post_content' => $template['content'],
				'post_status' => 'publish',
				'post_type' => 'wp_template_part',
				'post_name' => $template_slug,
				'post_author' => get_current_user_id(),
				'post_excerpt' => '', // Required for template parts
				'meta_input' => [
					'theme' => $current_theme,
					'area' => 'lsx_to_modals',
					'_wp_template_part_area' => 'lsx_to_modals',
					'_wp_template_part_theme' => $current_theme,
					'_wp_template_part_slug' => $template_slug,
				]
			];

			if ( ! empty( $existing_template ) ) {
				$template_data['ID'] = $existing_template[0]->ID;
				$post_id = wp_update_post( $template_data );
			} else {
				$post_id = wp_insert_post( $template_data );
			}

			// Add taxonomy relationships that WordPress expects
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				// Get or create the theme term
				$theme_term = get_term_by( 'name', $current_theme, 'wp_theme' );
				if ( ! $theme_term ) {
					$theme_term_data = wp_insert_term( $current_theme, 'wp_theme' );
					if ( ! is_wp_error( $theme_term_data ) ) {
						$theme_term_id = $theme_term_data['term_id'];
					} else {
						continue; // Skip this template if we can't create the theme term
					}
				} else {
					$theme_term_id = $theme_term->term_id;
				}

				$area_term = get_term_by( 'name', 'lsx_to_modals', 'wp_template_part_area' );
				$area_term_id = $area_term->term_id;

				// Set the taxonomy relationships
				wp_set_object_terms( $post_id, [ $theme_term_id ], 'wp_theme', false );
				wp_set_object_terms( $post_id, [ $area_term_id ], 'wp_template_part_area', false );

				wp_update_post( [
					'ID' => $post_id,
					'post_name' => $template_slug
				] );
			}

			wp_cache_delete( 'wp_template_part', 'themes' );
			if ( function_exists( 'wp_clean_themes_cache' ) ) {
				wp_clean_themes_cache();
			}
		}
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
		$modal_options = array();

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
	 * Register modal content for template parts to be output in footer
	 *
	 * @param string $template_slug The template part slug
	 */
	public function register_modal_content( $template_slug ) {
		// Check if modal is already registered to avoid duplicates
		$modal_id = 'to-modal-' . $template_slug;

		if ( ! isset( $this->modal_contents[ $modal_id ] ) ) {
			// Get the template part content
			$template_content = '<!-- wp:template-part {"slug":"' . $template_slug . '","area":"lsx_to_modals"} /-->';
			$this->modal_contents[ $modal_id ] = do_blocks( $template_content );
		}
	}

	/**
	 * Output template part modals that are referenced by modal-button blocks
	 *
	 * @return void
	 */
	public function output_template_part_modals() {
		global $post;

		// Only run on pages that might have modal buttons
		if ( ! $post || ! has_blocks( $post->post_content ) ) {
			return;
		}

		// Parse blocks to find modal-button blocks
		$blocks = parse_blocks( $post->post_content );
		$modal_data = $this->find_modal_button_blocks( $blocks );

		if ( empty( $modal_data['template_slugs'] ) && empty( $modal_data['custom_content'] ) ) {
			return;
		}

		wp_enqueue_script( 'lsx-to-modals' );

		// Output modal HTML for each referenced template
		foreach ( $modal_data['template_slugs'] as $template_slug ) {
			$modal_id = 'to-modal-' . $template_slug;

			// Get the template part content
			$template_content = '<!-- wp:template-part {"slug":"' . $template_slug . '","area":"lsx_to_modals"} /-->';
			$rendered_content = do_blocks( $template_content );

			// Generate and output modal using reusable method
			$modal_html = $this->generate_modal_html( $modal_id, $rendered_content );
			$this->output_modal( $modal_html );
		}

		// Output custom content modals
		foreach ( $modal_data['custom_content'] as $modal_id => $custom_content ) {
			$modal_html = $this->generate_modal_html( $modal_id, wpautop( $custom_content ), true );
			$this->output_modal( $modal_html );
		}
	}

	/**
	 * Recursively find modal-button blocks and extract their modalId values
	 *
	 * @param array $blocks Array of parsed blocks
	 * @return array Array with template slugs and custom content blocks
	 */
	private function find_modal_button_blocks( $blocks ) {
		$modal_data = array(
			'template_slugs' => array(),
			'custom_content' => array()
		);

		foreach ( $blocks as $block ) {
			// Check if this is a modal-button block
			if ( 'lsx-tour-operator/modal-button' === $block['blockName'] &&
				isset( $block['attrs']['modalId'] ) &&
				! empty( $block['attrs']['modalId'] ) ) {

				$modal_id = $block['attrs']['modalId'];

				// Handle custom content with shortened blockId as unique identifier
				if ( $modal_id === 'custom' &&
					isset( $block['attrs']['customContent'] ) &&
					! empty( $block['attrs']['customContent'] ) &&
					isset( $block['attrs']['blockId'] ) ) {

					$short_block_id = substr( $block['attrs']['blockId'], 0, 8 );
					$unique_modal_id = 'to-modal-custom-' . $short_block_id;
					$modal_data['custom_content'][$unique_modal_id] = $block['attrs']['customContent'];
				} elseif ( $modal_id !== 'custom' ) {
					// Handle template slugs
					$modal_data['template_slugs'][] = $modal_id;
				}
			}

			// Recursively check inner blocks
			if ( ! empty( $block['innerBlocks'] ) ) {
				$inner_modal_data = $this->find_modal_button_blocks( $block['innerBlocks'] );
				$modal_data['template_slugs'] = array_merge( $modal_data['template_slugs'], $inner_modal_data['template_slugs'] );
				$modal_data['custom_content'] = array_merge( $modal_data['custom_content'], $inner_modal_data['custom_content'] );
			}
		}

		$modal_data['template_slugs'] = array_unique( $modal_data['template_slugs'] );
		return $modal_data;
	}

	/**
	 * Generate modal HTML with consistent structure
	 *
	 * @param string $modal_id The modal ID (without 'to-modal-' prefix)
	 * @param string $content The modal content
	 * @param bool $add_wrapper Whether to wrap content in template-part div
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
		$modal_html = '<dialog id="' . esc_attr( $full_modal_id ) . '" class="wp-block-hm-popup" data-trigger="click" data-expiry="7" data-backdrop-opacity="0.75" tabindex="-1">';
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
		$close_button = '<button class="wp-block-hm-popup__close" aria-label="' . esc_attr__( 'Close', 'tour-operator' ) . '" data-close>';
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
			'id' => true,
			'class' => true,
			'data-trigger' => true,
			'data-expiry' => true,
			'data-backdrop-opacity' => true,
			'tabindex' => true,
		);
		$allowed_html['svg'] = array(
			'width' => true,
			'height' => true,
			'viewbox' => true,
			'fill' => true,
			'xmlns' => true,
		);
		$allowed_html['path'] = array(
			'd' => true,
			'stroke' => true,
			'stroke-width' => true,
			'stroke-linecap' => true,
			'stroke-linejoin' => true,
		);
		$allowed_html['button'] = array(
			'class' => true,
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
