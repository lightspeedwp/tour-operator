<?php
namespace lsx\blocks;

/**
 * Registers our Block Template Parts
 *
 * Template parts are reusable structural components used within templates,
 * such as headers, footers, and sidebars.
 *
 * This class programmatically creates template part posts if they don't exist,
 * similar to how WordPress core handles default template parts.
 *
 * @package    Tour_Operator
 * @subpackage Blocks
 * @since      2.1.0
 * @version    2.1.0
 */
class Template_Parts {

	/**
	 * Initialize the class by creating template parts as posts.
	 *
	 * @since 2.1.0
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_template_part_areas' ], 10 );
		add_action( 'init', [ $this, 'create_template_parts' ], 20 );
	}

	/**
	 * Registers custom template part areas.
	 *
	 * WordPress core only provides 'header', 'footer', and 'uncategorized' (general) by default.
	 * This adds custom template parts areas for our template parts.
	 *
	 * @since 2.1.0
	 * @return void
	 */
	public function register_template_part_areas() {
		add_filter( 'default_wp_template_part_areas', [ $this, 'add_template_parts_area' ] );
	}

	/**
	 * Adds fast facts area to default template part areas.
	 *
	 * @since 2.1.0
	 *
	 * @param array $areas Existing template part areas.
	 * @return array Modified template part areas.
	 */
	public function add_template_parts_area( $areas ) {
		// Add template parts area if they don't exist
		$fast_facts_exists = false;
		$modals_exists = false;

		foreach ( $areas as $area ) {
			if ( isset( $area['area'] ) ) {
				if ( 'fast-facts' === $area['area'] ) {
					$fast_facts_exists = true;
				}
				if ( 'modals' === $area['area'] ) {
					$modals_exists = true;
				}
			}
		}

		if ( ! $fast_facts_exists ) {
			$areas[] = [
				'area'        => 'fast-facts',
				'label'       => __( 'Fast Facts Sidebar', 'tour-operator' ),
				'description' => __( 'Sidebar template parts for displaying supplementary content alongside main content.', 'tour-operator' ),
				'icon'        => 'sidebar',
				'area_tag'    => 'aside',
			];
		}

		if ( ! $modals_exists ) {
			$areas[] = [
				'area'        => 'modals',
				'label'       => __( 'Modals', 'tour-operator' ),
				'description' => __( 'Template parts for customizing the modals.', 'tour-operator' ),
				'icon'        => 'welcome-widgets-menus',
				'area_tag'    => 'div',
			];
		}

		return $areas;
	}

	/**
	 * Creates template part posts if they don't exist.
	 *
	 * Template parts are created as wp_template_part posts with the content
	 * from the parts/ directory. This approach ensures they're available in
	 * the editor and can be managed like other template parts.
	 *
	 * @since 2.1.0
	 * @return void
	 */
	public function create_template_parts() {
		/**
		 * Define template parts with metadata.
		 *
		 * Each template part requires:
		 * - title: Translatable display name
		 * - description: Translatable description of purpose
		 * - area: Template part area (header, footer, sidebar, uncategorized)
		 */
		$template_parts = [
			'fast-facts-tour'               => [
				'title'       => __( 'Tour Fast Facts', 'tour-operator' ),
				'description' => __( 'Fast facts sidebar for tour single templates with duration, price, group size, and other tour metadata.', 'tour-operator' ),
				'area'        => 'fast-facts',
			],
			'fast-facts-accommodation'      => [
				'title'       => __( 'Accommodation Fast Facts', 'tour-operator' ),
				'description' => __( 'Fast facts sidebar for accommodation single templates with rating, facilities, rooms, and other accommodation metadata.', 'tour-operator' ),
				'area'        => 'fast-facts',
			],
			'fast-facts-destination'        => [
				'title'       => __( 'Destination Fast Facts', 'tour-operator' ),
				'description' => __( 'Fast facts sidebar for all destination templates (countries and regions) with parent country, child regions, spoken languages, and travel styles.', 'tour-operator' ),
				'area'        => 'fast-facts',
			],
			'modal-tour'                    => [
				'title'       => __( 'Tour Modal', 'tour-operator' ),
				'description' => __( 'Modal template for tour quick view with essential tour information and booking options.', 'tour-operator' ),
				'area'        => 'modals',
			],
			'modal-accommodation'           => [
				'title'       => __( 'Accommodation Modal', 'tour-operator' ),
				'description' => __( 'Modal template for accommodation quick view with room details and booking options.', 'tour-operator' ),
				'area'        => 'modals',
			],
			'modal-destination'             => [
				'title'       => __( 'Destination Modal', 'tour-operator' ),
				'description' => __( 'Modal template for destination quick view with key information and related tours.', 'tour-operator' ),
				'area'        => 'modals',
			],
			'modal-enquiry'                 => [
				'title'       => __( 'Enquiry Modal', 'tour-operator' ),
				'description' => __( 'Modal template for enquiry form to capture customer queries and contact information.', 'tour-operator' ),
				'area'        => 'modals',
			],

		];

		/**
		 * Filters the template parts to be created.
		 *
		 * Allows themes and plugins to add or modify template parts.
		 *
		 * @since 2.1.0
		 *
		 * @param array $template_parts Array of template part configurations.
		 */
		$template_parts = apply_filters( 'lsx_to_template_parts', $template_parts );

		$theme = get_stylesheet();

		foreach ( $template_parts as $slug => $args ) {
			$this->maybe_create_template_part( $slug, $args, $theme );
		}
	}

	/**
	 * Creates a template part post if it doesn't exist.
	 *
	 * @since 2.1.0
	 *
	 * @param string $slug  Template part slug.
	 * @param array  $args  Template part arguments.
	 * @param string $theme Theme slug.
	 * @return void
	 */
	protected function maybe_create_template_part( $slug, $args, $theme ) {
		// Get template content from file.
		$file = LSX_TO_PATH . 'parts/' . $slug . '.html';

		// Check if template part file exists.
		if ( ! file_exists( $file ) ) {
			return;
		}

		// Read template content.
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$content = file_get_contents( $file );

		// Check if template part already exists.
		// Note: We must use tax_query WITHOUT the 'name' parameter because
		// WordPress ignores tax_query when 'name' is present in the query args.
		$query = new \WP_Query(
			[
				'post_type'      => 'wp_template_part',
				'posts_per_page' => -1,
				'post_status'    => 'any',
				'no_found_rows'  => true,
				'fields'         => 'ids',
				'tax_query'      => [
					[
						'taxonomy' => 'wp_theme',
						'field'    => 'slug',
						'terms'    => $theme,
					],
				],
			]
		);

		// Filter by slug manually since we can't use 'name' with tax_query
		$existing = array_filter(
			$query->posts,
			function ( $post_id ) use ( $slug ) {
				$post = get_post( $post_id );
				return $post && $post->post_name === $slug;
			}
		);

		// If template part doesn't exist, create it.
		if ( empty( $existing ) ) {
			$template_part_id = wp_insert_post(
				[
					'post_type'    => 'wp_template_part',
					'post_status'  => 'publish',
					'post_title'   => $args['title'],
					'post_name'    => $slug,
					'post_content' => $content,
					'meta_input'   => [
						'origin' => 'plugin',
					],
				]
			);

			if ( ! is_wp_error( $template_part_id ) ) {
				// Set theme taxonomy term.
				wp_set_post_terms( $template_part_id, [ $theme ], 'wp_theme' );

				// Set area taxonomy term.
				if ( isset( $args['area'] ) ) {
					wp_set_post_terms( $template_part_id, [ $args['area'] ], 'wp_template_part_area' );
				}
			}
		}
	}
}
