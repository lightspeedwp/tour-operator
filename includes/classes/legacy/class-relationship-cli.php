<?php
/**
 * WP-CLI command for converting legacy relationship meta to the canonical shape.
 *
 * @package   \lsx\legacy\Relationship_CLI
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2026 lightspeedwp
 */

namespace lsx\legacy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Converts relationship keys stored as one row per connected ID into a single row
 * holding a serialised array.
 *
 * Saving a post repairs its own relationship keys, so this command is only needed to
 * clear the legacy shape in bulk rather than waiting for every post to be edited.
 *
 * @package \lsx\legacy\Relationship_CLI
 * @author  LightSpeed
 */
class Relationship_CLI {

	/**
	 * Normalises relationship meta stored across multiple rows.
	 *
	 * ## OPTIONS
	 *
	 * [--dry-run]
	 * : Report what would change without writing anything.
	 *
	 * [--key=<key>]
	 * : Limit the run to a single relationship meta key.
	 *
	 * ## EXAMPLES
	 *
	 *     wp tour-operator normalise-relationships --dry-run
	 *     wp tour-operator normalise-relationships --key=tour_to_destination
	 *
	 * @param array $args       Positional arguments.
	 * @param array $assoc_args Associative arguments.
	 * @return void
	 */
	public function normalise_relationships( $args, $assoc_args ) {
		global $wpdb;

		$dry_run = isset( $assoc_args['dry-run'] );
		$only    = isset( $assoc_args['key'] ) ? (string) $assoc_args['key'] : '';
		// create_post_connections() is defined on the legacy Tour_Operator, not on the
		// \lsx\Tour_Operator instance that the tour_operator() helper returns.
		$keys = Tour_Operator::get_instance()->create_post_connections();

		if ( '' !== $only ) {
			if ( ! in_array( $only, $keys, true ) ) {
				\WP_CLI::error( sprintf( '%s is not a relationship meta key.', $only ) );
			}
			$keys = array( $only );
		}

		$converted    = 0;
		$rows_removed = 0;

		foreach ( $keys as $key ) {
			// Post IDs holding more than one row for this key, i.e. the legacy shape.
			// A one-off migration query: there is no meta_query equivalent for "more than
			// one row", and caching the result would defeat the point of the command.
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$post_ids = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s GROUP BY post_id HAVING COUNT(*) > 1",
					$key
				)
			);

			if ( empty( $post_ids ) ) {
				continue;
			}

			foreach ( $post_ids as $post_id ) {
				$post_id = (int) $post_id;
				$before  = get_post_meta( $post_id, $key, false );
				$ids     = Relationship_Meta::normalise( $before );

				// Every row beyond the first is removed when the key is collapsed.
				$rows_removed += count( $before ) - 1;
				++$converted;

				\WP_CLI::log(
					sprintf(
						'%spost %d %s: %d rows -> %d ids',
						$dry_run ? '[dry-run] ' : '',
						$post_id,
						$key,
						count( $before ),
						count( $ids )
					)
				);

				if ( ! $dry_run ) {
					Relationship_Meta::save_ids( $post_id, $key, $ids );
				}

				// get_post_meta() caches every post it touches, and a full run covers
				// thousands. Drop the runtime cache periodically so memory does not grow
				// with the size of the site.
				//
				// The wp_cache_supports() check is not redundant: where a persistent
				// drop-in does not implement flush_runtime(), some WordPress versions
				// fall back to wp_cache_flush(), which would flush the whole shared
				// object cache mid-migration. Skip the trim rather than risk that.
				if ( 0 === $converted % 200
					&& function_exists( 'wp_cache_flush_runtime' )
					&& function_exists( 'wp_cache_supports' )
					&& wp_cache_supports( 'flush_runtime' ) ) {
					wp_cache_flush_runtime();
				}
			}
		}

		if ( 0 === $converted ) {
			\WP_CLI::success( 'No relationship meta needed converting.' );
			return;
		}

		\WP_CLI::success(
			sprintf(
				'%s %d post/key pairs (%d surplus rows removed).',
				$dry_run ? 'Would convert' : 'Converted',
				$converted,
				$rows_removed
			)
		);
	}
}
