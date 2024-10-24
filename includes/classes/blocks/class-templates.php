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
			//'tour',
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
