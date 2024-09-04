<?php
namespace lsx\to\blocks;


class Block_Patterns {

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Holds the slug of the projects pattern category.
	 *
	 * @var string
	 */
	private $pattern_category = 'lsx-tour-operator';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function __construct() {
		//Register our pattern category
		add_action( 'init', array( $this, 'register_block_category' ) );

		// Register our block patterns
		add_action( 'init', array( $this, 'register_block_patterns' ), 10 );

		// Register our the content filters.
		add_filter( 'query_loop_block_query_vars', array( $this, 'replace_related_vars' ), 10, 3 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx\tour_operator\classes\Block_Patterns();    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Registers the projects pattern category
	 *
	 * @return void
	 */
	public function register_block_category() {
		register_block_pattern_category(
			$this->pattern_category,
			array( 'label' => __( 'LSX Tour Operator', 'lsx-tour-operator' ) )
		);
	}  

	/**
	 * Registers our block patterns with the 
	 *
	 * @return void
	 */
	public function register_block_patterns() {
		$patterns = array(
			'lsx-tour-operator/tour-price' => $this->tour_price(),
			'lsx-tour-operator/tour-price-merge-tag' => $this->tour_price_merge_tag(),
			'lsx-tour-operator/related-items' => $this->related_items(),
		);

		foreach ( $patterns as $key => $function ) {
			register_block_pattern( $key, $function );
		}
	}

	/**
	 * Portfolio - Featured Pattern - Basic Style
	 *
	 * @return void
	 */
	public function tour_price() {
		return array(
			'title'       => __( 'Tour Price', 'lsx-projects' ),
			'description' => '',
			'categories'  => array( $this->pattern_category ),
			'content'     => '<!-- wp:shortcode -->
			[lsx_to_custom_field name="price"]
			<!-- /wp:shortcode -->',
		);
	}

	/**
	 * Portfolio - Featured Pattern - Basic Style
	 *
	 * @return void
	 */
	public function tour_price_merge_tag() {
		return array(
			'title'       => __( 'Tour Price (merge tag)', 'lsx-projects' ),
			'description' => '',
			'categories'  => array( $this->pattern_category ),
			'content'     => '<!-- wp:paragraph -->
			<p>lsx_to_price</p>
			<!-- /wp:paragraph -->',
		);
	}

	/**
	 * Portfolio - Related Posts
	 *
	 * @return void
	 */
	public function related_items() {
		return array(
			'title'       => __( 'Related Projects', 'lsx-projects' ),
			'description' => __( 'Displays the related portfolio based on the matching project category.', 'lsx-projects' ),
			'categories'  => array( $this->pattern_category ),
			'content'     => $this->get_related_content(),
		);
	}

	private function get_related_content() {
		$content = '
		<!-- wp:group {"tagName":"main","style":{"spacing":{"margin":{"top":"0"},"padding":{"top":"40px","bottom":"80px"}}},"backgroundColor":"base","className":"site-content","layout":{"type":"constrained"}} -->
			<main class="wp-block-group site-content has-base-background-color has-background" style="margin-top:0;padding-top:40px;padding-bottom:80px">
				<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
					<div class="wp-block-group alignwide">
						<!-- wp:heading {"level":3,"align":"wide","style":{"typography":{"fontStyle":"normal","fontWeight":"700"},"spacing":{"padding":{"bottom":"var:preset|spacing|x-small"}}},"fontSize":"max-48"} -->
							<h3 class="wp-block-heading alignwide has-max-48-font-size" style="padding-bottom:var(--wp--preset--spacing--x-small);font-style:normal;font-weight:700"><strong>' . __( 'Related Projects', 'lsx-projects' ) . '</strong></h3>
						<!-- /wp:heading -->
						
						<!-- wp:query {"queryId":5,"query":{"related":1,"perPage":2,"pages":0,"offset":0,"postType":"project","order":"asc","orderBy":"title","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"displayLayout":{"type":"flex","columns":2},"align":"full","layout":{"type":"constrained"}} -->
							<div class="wp-block-query alignfull">
								<!-- wp:post-template -->
									<!-- wp:post-title /-->
									
									<!-- wp:post-excerpt /-->
								<!-- /wp:post-template -->
								
								<!-- wp:query-no-results -->
									<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
									<p></p>
									<!-- /wp:paragraph -->
								<!-- /wp:query-no-results -->
							</div>
						<!-- /wp:query -->
					</div>
				<!-- /wp:group -->
			</main>
		<!-- /wp:group -->';
		return $content;
	}

	/**
	 * A function to replace the query post vars.
	 *
	 * @param array $query
	 * @param WP_Block $block
	 * @param int $page
	 * @return array
	 */
	public function replace_related_vars( $query, $block, $page ) {
		if ( ! is_admin() && is_singular( array( 'tour', 'accommodation', 'destination' ) ) && isset( $block->context['query']['related'] ) ) {
			$group     = array();
			$terms     = get_the_terms( get_the_ID(), 'project-group' );

			if ( is_array( $terms ) && ! empty( $terms ) ) {
				foreach( $terms as $term ) {
					$group[] = $term->term_id;
				}
			}
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'project-group',
					'field'    => 'term_id',
					'terms'     => $group,
				)
			);
			$query['orderby']      = 'rand';
			$query['post__not_in'] = array( get_the_ID() );
		}
		return $query;
	}
}
Block_Patterns::get_instance();
