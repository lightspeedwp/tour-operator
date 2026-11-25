<?php
/**
 * Normalised storage for the post-to-post relationship meta.
 *
 * Relationship keys such as `tour_to_destination` have historically been written in two
 * different shapes: a single row holding a serialised array of IDs, and one row per
 * connected ID holding a bare scalar. Reading either shape with
 * `get_post_meta( $id, $key, true )` returns only the first row, which is a string in the
 * multi-row case, and writing with a `$prev_value` argument only rewrites the rows that
 * match that value. This class reads every row regardless of shape and always writes back
 * the single serialised array, so a mixed key repairs itself on the next save.
 *
 * @package   \lsx\legacy\Relationship_Meta
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
 * Reads and writes the post-to-post relationship meta in a single canonical shape.
 *
 * @package \lsx\legacy\Relationship_Meta
 * @author  LightSpeed
 */
class Relationship_Meta {

	/**
	 * Returns every connected ID stored against a relationship key.
	 *
	 * Reads all rows for the key, not just the first, and flattens any row that is itself
	 * an array, so both the serialised-array and the one-row-per-ID shapes are handled.
	 *
	 * @param int    $object_id The post holding the relationship meta.
	 * @param string $meta_key  The relationship meta key.
	 * @return array<int, string> Unique connected IDs as strings, reindexed from zero.
	 */
	public static function get_ids( $object_id, $meta_key ) {
		$object_id = absint( $object_id );

		if ( empty( $object_id ) || '' === (string) $meta_key ) {
			return array();
		}

		return self::normalise( get_post_meta( $object_id, $meta_key, false ) );
	}

	/**
	 * Flattens an arbitrarily shaped meta value into a list of unique ID strings.
	 *
	 * Nested arrays are flattened, objects and nulls are discarded, and empty or zero IDs
	 * are dropped so that `array_diff()` and `foreach` are always safe downstream.
	 *
	 * @param mixed $values A scalar, an array of scalars, or an array of arrays.
	 * @return array<int, string> Unique IDs as strings, reindexed from zero.
	 */
	public static function normalise( $values ) {
		if ( ! is_array( $values ) ) {
			$values = array( $values );
		}

		$ids = array();

		foreach ( $values as $value ) {
			if ( is_array( $value ) ) {
				$ids = array_merge( $ids, self::normalise( $value ) );
				continue;
			}

			if ( null === $value || is_object( $value ) || is_bool( $value ) ) {
				continue;
			}

			$value = trim( (string) $value );

			if ( '' === $value || '0' === $value ) {
				continue;
			}

			$ids[] = $value;
		}

		return array_values( array_unique( $ids ) );
	}

	/**
	 * Writes the connected IDs back as a single row holding a serialised array.
	 *
	 * Any pre-existing rows for the key are removed first, so a key that was previously
	 * stored as one row per ID collapses to the canonical shape. Writing is skipped when
	 * the stored value is already canonical and unchanged.
	 *
	 * @param int               $object_id The post holding the relationship meta.
	 * @param string            $meta_key  The relationship meta key.
	 * @param array<int, mixed> $ids       The connected IDs to store.
	 * @return bool True when the meta reflects the requested IDs.
	 */
	public static function save_ids( $object_id, $meta_key, $ids ) {
		$object_id = absint( $object_id );

		if ( empty( $object_id ) || '' === (string) $meta_key ) {
			return false;
		}

		$ids = self::normalise( $ids );
		$raw = get_post_meta( $object_id, $meta_key, false );

		if ( ! is_array( $raw ) ) {
			$raw = array();
		}

		if ( empty( $ids ) ) {
			if ( ! empty( $raw ) ) {
				delete_post_meta( $object_id, $meta_key );
			}
			return true;
		}

		// Already stored as a single serialised array with exactly these IDs.
		if ( 1 === count( $raw ) && is_array( $raw[0] ) && self::normalise( $raw[0] ) === $ids ) {
			return true;
		}

		delete_post_meta( $object_id, $meta_key );

		return (bool) add_post_meta( $object_id, $meta_key, $ids, true );
	}

	/**
	 * Adds a connected ID to a relationship key.
	 *
	 * @param int        $object_id    The post holding the relationship meta.
	 * @param string     $meta_key     The relationship meta key.
	 * @param int|string $connected_id The ID to connect.
	 * @return bool True when the meta reflects the requested IDs.
	 */
	public static function add_id( $object_id, $meta_key, $connected_id ) {
		$connected = self::normalise( array( $connected_id ) );

		if ( empty( $connected ) ) {
			return false;
		}

		return self::save_ids(
			$object_id,
			$meta_key,
			array_merge( self::get_ids( $object_id, $meta_key ), $connected )
		);
	}

	/**
	 * Removes a connected ID from a relationship key.
	 *
	 * @param int        $object_id    The post holding the relationship meta.
	 * @param string     $meta_key     The relationship meta key.
	 * @param int|string $connected_id The ID to disconnect.
	 * @return bool True when the meta reflects the requested IDs.
	 */
	public static function remove_id( $object_id, $meta_key, $connected_id ) {
		$ids = self::get_ids( $object_id, $meta_key );

		if ( empty( $ids ) ) {
			return false;
		}

		return self::save_ids(
			$object_id,
			$meta_key,
			array_diff( $ids, self::normalise( array( $connected_id ) ) )
		);
	}
}
