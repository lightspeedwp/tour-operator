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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

		// Yoast 14+ removed the WPSEO_Graph_Piece interface, so detect Yoast by
		// its version constant (defined before plugins_loaded, when this runs).
		if (defined('WPSEO_VERSION')) {
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
	 * Yoast only requires is_needed() and generate() on each piece, so the
	 * piece classes are registered directly. Yoast keys pieces by class name,
	 * so each piece must keep its own class to avoid overwriting the others.
	 *
	 * @param array                                   $pieces  Existing graph pieces.
	 * @param \Yoast\WP\SEO\Context\Meta_Tags_Context $context Yoast context object.
	 * @return array Updated graph pieces.
	 */
	public function add_graph_pieces($pieces, $context)
	{
		$pieces[] = new \lsx\schema\pieces\Trip($context);
		$pieces[] = new \lsx\schema\pieces\Accommodation($context);
		$pieces[] = new \lsx\schema\pieces\Destination($context);
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
				// JSON_HEX_TAG prevents </script> injection; JSON_HEX_AMP avoids
				// HTML entity issues. JSON_UNESCAPED_UNICODE keeps readability.
				$flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP;
				$json  = wp_json_encode($graph, $flags);
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
