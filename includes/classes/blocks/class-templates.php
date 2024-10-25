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
			// accommodation
			'accommodation' => [
				'single'  => [
					'title'       => __( 'Single Accommodations', 'tour-operator' ),
					'description' => __( 'Displays a single accommodation', 'tour-operator' ),
				],
				'archive' => [
					'title'       => __( 'Accommodation Archive', 'tour-operator' ),
					'description' => __( 'Displays all the accommodation.', 'tour-operator' ),
				],
			],
			//'destination',
			'destination' => [
				'single'  => [
					'title'       => __( 'Single Destination', 'tour-operator' ),
					'description' => __( 'Displays a single destination', 'tour-operator' ),
				],
				'archive' => [
					'title'       => __( 'Destination Archive', 'tour-operator' ),
					'description' => __( 'Displays all the destinations.', 'tour-operator' ),
				],
			],
			//'tour',
			'tour' => [
				'single'  => [
					'title'       => __( 'Single Tour', 'tour-operator' ),
					'description' => __( 'Displays a single tour', 'tour-operator' ),
				],
				'archive' => [
					'title'       => __( 'Tour Archive', 'tour-operator' ),
					'description' => __( 'Displays all the tours.', 'tour-operator' ),
				],
			],
		];

		foreach ( $post_types as $key => $labels ) {
			register_block_template( 'lsx-tour-operator//single-' . $key, [
				'title'       => $labels['single']['title'],
				'description' => $labels['single']['description'],
				'content'     => $this->get_template_content( 'single-' . $key . '.html' ),
				'post_types'  => [ $key ]
			] );

			register_block_template( 'lsx-tour-operator//archive-' . $key, [
				'title'       => $labels['archive']['title'],
				'description' => $labels['archive']['description'],
				'content'     => $this->get_template_content( 'archive-' . $key . '.html' ),
				'post_types'  => [ $key ]
			] );
		}

		register_block_template( 'lsx-tour-operator//search-results', [
			'title'       => __( 'Search Results', 'tour-operator' ),
			'description' => __( 'Displays when a visitor performs a search on your website.', 'tour-operator' ),
			'content'     => $this->get_template_content( 'search-results.html' ),
		] );

		register_block_template( 'lsx-tour-operator//index', [
			'title'       => __( 'Index', 'tour-operator' ),
			'description' => __( 'Used as a fallback template for all pages when a more specific template is not defined.', 'tour-operator' ),
			'content'     => $this->get_template_content( 'index.html' ),
		] );

		register_block_template( 'lsx-tour-operator//no-title', [
			'title'       => __( 'No Title', 'tour-operator' ),
			'description' => __( 'A generic page template with no page title displayed', 'tour-operator' ),
			'content'     => $this->get_template_content( 'no-title.html' ),
		] );

		register_block_template( 'lsx-tour-operator//pages', [
			'title'       => __( 'Pages', 'tour-operator' ),
			'description' => __( 'A generic page template with a page title displayed', 'tour-operator' ),
			'content'     => $this->get_template_content( 'no-title.html' ),
		] );

		register_block_template( 'lsx-tour-operator//single-region', [
			'title'       => __( 'Single Region', 'tour-operator' ),
			'description' => __( 'Used to display a region of a country in the Destination post-type', 'tour-operator' ),
			'content'     => $this->get_template_content( 'single-region.html' ),
			'post_types'  => [ 'destination' ]
		] );

		register_block_template( 'lsx-tour-operator//single-country', [
			'title'       => __( 'Single Region', 'tour-operator' ),
			'description' => __( 'Used to display a country in the Destination post-type', 'tour-operator' ),
			'content'     => $this->get_template_content( 'single-country.html' ),
			'post_types'  => [ 'destination' ]
		] );

		register_block_template( 'lsx-tour-operator//archive', [
			'title'       => __( 'All Archives', 'tour-operator' ),
			'description' => __( 'Displays any archive, including posts by a single author, category, tag, taxonomy, custom post type, and date. This template will serve as a fallback when more specific templates (e.g., Category or Tag) cannot be found.', 'tour-operator' ),
			'content'     => $this->get_template_content( 'archive.html' ),
		] );
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
