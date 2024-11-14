<?php
namespace lsx\blocks;

/**
 * Registers our Block Templates
 *
 * @package lsx
 * @author  LightSpeed
 */
class Templates {

	/**
	 * Holds array of out templates to be registered.
	 *
	 * @var array
	 */
	public $templates = [];

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type_templates' ] );
	}

	/**
	 * Registers our plugins templates.
	 *
	 * @return void
	 */
	public function register_post_type_templates() {

		/**
		 * The slugs of the built in post types we are using.
		 */
		$post_types = [
			'single-accommodation'  => [
				'title'       => __( 'Single Accommodations', 'tour-operator' ),
				'description' => __( 'Displays a single accommodation', 'tour-operator' ),
				'post_types'  => ['accommodation'],
			],
			'archive-accommodation' => [
				'title'       => __( 'Accommodation Archive', 'tour-operator' ),
				'description' => __( 'Displays all the accommodation.', 'tour-operator' ),
				'post_types'  => ['accommodations'],
			],
			'single-destination'  => [
				'title'       => __( 'Single Destination', 'tour-operator' ),
				'description' => __( 'Displays a single destination', 'tour-operator' ),
				'post_types'  => ['destination'],
			],
			'archive-destination' => [
				'title'       => __( 'Destination Archive', 'tour-operator' ),
				'description' => __( 'Displays all the destinations.', 'tour-operator' ),
				'post_types'  => ['destinations'],
			],
			'single-tour'  => [
				'title'       => __( 'Single Tour', 'tour-operator' ),
				'description' => __( 'Displays a single tour', 'tour-operator' ),
				'post_types'  => ['tour'],
			],
			'archive-tour' => [
				'title'       => __( 'Tour Archive', 'tour-operator' ),
				'description' => __( 'Displays all the tours.', 'tour-operator' ),
				'post_types'  => ['tours'],
			],
			'single-region' => [
				'title'       => __( 'Single Region', 'tour-operator' ),
				'description' => __( 'Used to display a region of a country in the Destination post-type', 'tour-operator' ),
				'post_types'  => ['destination'],
			],
			'single-country' => [
				'title'       => __( 'Single Country', 'tour-operator' ),
				'description' => __( 'Used to display a country in the Destination post-type', 'tour-operator' ),
				'post_types'  => ['destination'],
			],
			'search-results' => [
				'title'       => __( 'Search Results', 'tour-operator' ),
				'description' => __( 'Displays when a visitor performs a search on your website.', 'tour-operator' ),
			],
			'index' => [
				'title'       => __( 'Index', 'tour-operator' ),
				'description' => __( 'Used as a fallback template for all pages when a more specific template is not defined.', 'tour-operator' ),
			],
			'no-title' => [
				'title'       => __( 'No Title', 'tour-operator' ),
				'description' => __( 'A generic page template with no page title displayed', 'tour-operator' ),
			],
			'pages' => [
				'title'       => __( 'Pages', 'tour-operator' ),
				'description' => __( 'A generic page template with a page title displayed', 'tour-operator' ),
			],
			'archive' => [
				'title'       => __( 'All Archives', 'tour-operator' ),
				'description' => __( 'Displays any archive, including posts by a single author, category, tag, taxonomy, custom post type, and date. This template will serve as a fallback when more specific templates (e.g., Category or Tag) cannot be found.', 'tour-operator' ),
			],
		];

		foreach ( $post_types as $key => $labels ) {
			$args = [
				'title'       => $labels['title'],
				'description' => $labels['description'],
				'content'     => $this->get_template_content( $key . '.html' ),
			];
			if ( isset( $labels['post_types'] ) ) {
				$args['post_types'] = $labels['post_types'];
			}

			if ( function_exists( 'register_block_template' ) ) {
				register_block_template( 'lsx-tour-operator//' . $key, $args );
			}
		}
	}

	/**
	 * Gets the PHP template file and returns the content.
	 *
	 * @param [type] $template
	 * @return void
	 */
	protected function get_template_content( $template ) {
		ob_start();
		include LSX_TO_PATH . "/templates/{$template}";
		return ob_get_clean();
	}
}
