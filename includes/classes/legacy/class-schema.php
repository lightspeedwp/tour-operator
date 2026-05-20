<?php

/**
 * Schema Class
 *
 * Entry point for Tour Operator structured data. Loads the shared helper class
 * and the three P1 graph pieces (Trip, Accommodation, TouristDestination).
 *
 * When Yoast SEO is active the pieces are registered via the Yoast graph API.
 * When Yoast is inactive a standalone JSON-LD block is printed in <head> using
 * the same piece classes via `output_standalone_schema()`.
 *
 * @package   Tour Operator
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2019 lightspeedwp
 */

namespace lsx\legacy;

/**
 * Main Schema orchestrator class.
 *
 * @package Schema
 * @author  LightSpeed
 */
class Schema
{

	/**
	 * Holds instances of the class
	 *
	 * @var instance
	 **/
	protected static $instance;

	/**
	 * Constructor
	 *
	 * Loads new graph-piece classes and registers them either with Yoast SEO
	 * (when the WPSEO_Graph_Piece interface is present) or as a standalone
	 * wp_head output (when Yoast is inactive).
	 */
	public function __construct()
	{
		// Always load shared helpers and piece classes.
		require_once LSX_TO_PATH . 'includes/classes/schema/class-lsx-to-schema-helpers.php';
		require_once LSX_TO_PATH . 'includes/classes/schema/pieces/class-lsx-to-schema-trip.php';
		require_once LSX_TO_PATH . 'includes/classes/schema/pieces/class-lsx-to-schema-accommodation.php';
		require_once LSX_TO_PATH . 'includes/classes/schema/pieces/class-lsx-to-schema-destination.php';

		if (interface_exists('WPSEO_Graph_Piece')) {
			// Yoast SEO is active: register new pieces via its graph API.
			add_filter('wpseo_schema_graph_pieces', array($this, 'add_graph_pieces'), 11, 2);
		} else {
			// No Yoast: output a standalone JSON-LD graph in <head>.
			add_action('wp_head', array($this, 'output_standalone_schema'), 5);
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance()
	{
		// If the single instance hasn't been set, set it now.
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Adds new graph pieces to the Yoast SEO schema graph.
	 *
	 * Each piece is wrapped in a LSX_TO_Schema_Piece_Adapter so that it
	 * satisfies the WPSEO_Graph_Piece interface without the piece classes
	 * themselves depending on Yoast.
	 *
	 * @param array                 $pieces  Existing graph pieces.
	 * @param \WPSEO_Schema_Context $context Yoast context object.
	 * @return array Updated graph pieces.
	 */
	public function add_graph_pieces($pieces, $context)
	{
		$pieces[] = new LSX_TO_Schema_Piece_Adapter(new \lsx\schema\pieces\Trip($context));
		$pieces[] = new LSX_TO_Schema_Piece_Adapter(new \lsx\schema\pieces\Accommodation($context));
		$pieces[] = new LSX_TO_Schema_Piece_Adapter(new \lsx\schema\pieces\Destination($context));
		return $pieces;
	}

	/**
	 * Prints a standalone JSON-LD schema graph when Yoast SEO is not active.
	 *
	 * Only outputs data for the current single post when a matching piece
	 * reports is_needed() === true. The graph is printed as a single
	 * application/ld+json script with an @graph array.
	 *
	 * @return void
	 */
	public function output_standalone_schema()
	{
		$pieces = array(
			new \lsx\schema\pieces\Trip(),
			new \lsx\schema\pieces\Accommodation(),
			new \lsx\schema\pieces\Destination(),
		);

		foreach ($pieces as $piece) {
			if ($piece->is_needed()) {
				$graph = array(
					'@context' => 'https://schema.org',
					'@graph'   => array($piece->generate()),
				);
				$json = wp_json_encode($graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				if ($json) {
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<script type="application/ld+json">' . "\n" . $json . "\n</script>\n";
				}
				// Only one piece should match per page.
				break;
			}
		}
	}
}

// ---------------------------------------------------------------------------
// Yoast adapter – only defined when the WPSEO_Graph_Piece interface exists.
// ---------------------------------------------------------------------------
if (interface_exists('WPSEO_Graph_Piece') && ! class_exists(__NAMESPACE__ . '\LSX_TO_Schema_Piece_Adapter')) {
	/**
	 * Thin adapter that satisfies the WPSEO_Graph_Piece interface and
	 * delegates to an LSX Tour Operator schema piece class.
	 *
	 * This keeps the piece classes themselves free of Yoast dependencies so
	 * they can be instantiated and unit-tested without Yoast present.
	 */
	class LSX_TO_Schema_Piece_Adapter implements \WPSEO_Graph_Piece
	{
		/**
		 * The wrapped schema piece instance.
		 *
		 * @var object
		 */
		private $piece;

		/**
		 * Constructor.
		 *
		 * @param object $piece Schema piece with is_needed() and generate() methods.
		 */
		public function __construct($piece)
		{
			$this->piece = $piece;
		}

		/**
		 * Determines whether the piece should be added to the graph.
		 *
		 * @return bool
		 */
		public function is_needed()
		{
			return $this->piece->is_needed();
		}

		/**
		 * Generates the piece data.
		 *
		 * @return array
		 */
		public function generate()
		{
			return $this->piece->generate();
		}
	}
}
