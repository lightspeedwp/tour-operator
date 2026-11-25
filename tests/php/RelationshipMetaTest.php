<?php

/**
 * Unit tests for lsx\legacy\Relationship_Meta.
 *
 * Runs without a WordPress install: the post meta functions are stubbed by an in-memory
 * store that reproduces the row semantics of wp-includes/meta.php, including the fact
 * that a key can hold several rows and that get_post_meta( ..., true ) returns only the
 * first of them.
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

use PHPUnit\Framework\TestCase;

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/**
 * Minimal stand-in for the wp_postmeta table.
 */
class TO_Test_Meta_Store {

	/**
	 * Rows, keyed by object ID then meta key, each an ordered list of values.
	 *
	 * @var array<int, array<string, array<int, mixed>>>
	 */
	public static $rows = array();

	/**
	 * Number of add/delete operations performed since the last reset.
	 *
	 * @var int
	 */
	public static $writes = 0;

	/**
	 * Empties the store between tests.
	 *
	 * @return void
	 */
	public static function reset() {
		self::$rows   = array();
		self::$writes = 0;
	}

	/**
	 * Seeds the rows for one key verbatim, bypassing the class under test.
	 *
	 * @param int               $object_id Object ID.
	 * @param string            $meta_key  Meta key.
	 * @param array<int, mixed> $values    One entry per database row.
	 * @return void
	 */
	public static function seed( $object_id, $meta_key, array $values ) {
		self::$rows[ $object_id ][ $meta_key ] = $values;
	}

	/**
	 * Returns the raw rows for one key.
	 *
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key.
	 * @return array<int, mixed>
	 */
	public static function rows( $object_id, $meta_key ) {
		return self::$rows[ $object_id ][ $meta_key ] ?? array();
	}
}

if ( ! function_exists( 'absint' ) ) {
	/**
	 * @param mixed $maybeint Value to convert.
	 * @return int
	 */
	function absint( $maybeint ) {
		return abs( (int) $maybeint );
	}
}

if ( ! function_exists( 'get_post_meta' ) ) {
	/**
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key.
	 * @param bool   $single    Return the first row only.
	 * @return mixed
	 */
	function get_post_meta( $object_id, $meta_key, $single = false ) {
		$rows = TO_Test_Meta_Store::rows( $object_id, $meta_key );

		if ( $single ) {
			return $rows[0] ?? '';
		}

		return $rows;
	}
}

if ( ! function_exists( 'add_post_meta' ) ) {
	/**
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key.
	 * @param mixed  $value     Value to store.
	 * @param bool   $unique    Refuse when the key already has a row.
	 * @return int|false
	 */
	function add_post_meta( $object_id, $meta_key, $value, $unique = false ) {
		$rows = TO_Test_Meta_Store::rows( $object_id, $meta_key );

		if ( $unique && ! empty( $rows ) ) {
			return false;
		}

		$rows[] = $value;
		TO_Test_Meta_Store::seed( $object_id, $meta_key, $rows );
		++TO_Test_Meta_Store::$writes;

		return count( $rows );
	}
}

if ( ! function_exists( 'delete_post_meta' ) ) {
	/**
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key.
	 * @return bool
	 */
	function delete_post_meta( $object_id, $meta_key ) {
		if ( isset( TO_Test_Meta_Store::$rows[ $object_id ][ $meta_key ] ) ) {
			++TO_Test_Meta_Store::$writes;
		}
		unset( TO_Test_Meta_Store::$rows[ $object_id ][ $meta_key ] );
		return true;
	}
}

require_once dirname( __DIR__, 2 ) . '/includes/classes/legacy/class-relationship-meta.php';

use lsx\legacy\Relationship_Meta;

class RelationshipMetaTest extends TestCase {

	const KEY = 'destination_to_accommodation';

	protected function setUp(): void {
		parent::setUp();
		TO_Test_Meta_Store::reset();
	}

	/**
	 * The reported fatal: a key stored as one row per ID must not reach array_diff() as a
	 * string.
	 */
	public function test_remove_id_on_multi_row_scalar_meta_does_not_throw() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( '163', '19817', '21339' ) );

		// Reproduces the pre-fix read: a string, not an array.
		$this->assertIsString( get_post_meta( 161, self::KEY, true ) );

		Relationship_Meta::remove_id( 161, self::KEY, '19817' );

		$this->assertSame( array( '163', '21339' ), Relationship_Meta::get_ids( 161, self::KEY ) );
	}

	/**
	 * Removing from multi-row data must not leave the untouched rows behind.
	 */
	public function test_remove_id_collapses_multi_row_meta_to_a_single_array_row() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( '163', '19817', '21339' ) );

		Relationship_Meta::remove_id( 161, self::KEY, '163' );

		$rows = TO_Test_Meta_Store::rows( 161, self::KEY );
		$this->assertCount( 1, $rows, 'The key should collapse to exactly one row.' );
		$this->assertSame( array( '19817', '21339' ), $rows[0] );
	}

	/**
	 * The already-canonical serialised-array shape keeps working.
	 */
	public function test_remove_id_on_single_array_row() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( array( '163', '19817' ) ) );

		Relationship_Meta::remove_id( 161, self::KEY, '163' );

		$this->assertSame( array( '19817' ), Relationship_Meta::get_ids( 161, self::KEY ) );
	}

	/**
	 * A key mixing both shapes is read whole and repaired.
	 */
	public function test_get_ids_flattens_mixed_shapes_and_deduplicates() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( '163', array( '19817', '163' ), 21339 ) );

		$this->assertSame(
			array( '163', '19817', '21339' ),
			Relationship_Meta::get_ids( 161, self::KEY )
		);
	}

	/**
	 * Removing the last ID deletes the key rather than leaving an empty array behind.
	 */
	public function test_remove_last_id_deletes_the_key() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( '163' ) );

		Relationship_Meta::remove_id( 161, self::KEY, '163' );

		$this->assertSame( array(), TO_Test_Meta_Store::rows( 161, self::KEY ) );
		$this->assertSame( array(), Relationship_Meta::get_ids( 161, self::KEY ) );
	}

	/**
	 * Removing an ID that is not connected leaves the IDs intact.
	 */
	public function test_remove_unconnected_id_is_a_no_op_for_the_id_list() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( '163', '19817' ) );

		Relationship_Meta::remove_id( 161, self::KEY, '99999' );

		$this->assertSame( array( '163', '19817' ), Relationship_Meta::get_ids( 161, self::KEY ) );
	}

	/**
	 * Adding to multi-row data collapses it instead of appending another row.
	 */
	public function test_add_id_collapses_multi_row_meta() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( '163', '19817' ) );

		Relationship_Meta::add_id( 161, self::KEY, 21339 );

		$rows = TO_Test_Meta_Store::rows( 161, self::KEY );
		$this->assertCount( 1, $rows );
		$this->assertSame( array( '163', '19817', '21339' ), $rows[0] );
	}

	/**
	 * Adding to an empty key creates the canonical single row.
	 */
	public function test_add_id_to_empty_key() {
		Relationship_Meta::add_id( 161, self::KEY, '163' );

		$rows = TO_Test_Meta_Store::rows( 161, self::KEY );
		$this->assertCount( 1, $rows );
		$this->assertSame( array( '163' ), $rows[0] );
	}

	/**
	 * Adding an ID that is already connected must not duplicate it.
	 */
	public function test_add_existing_id_does_not_duplicate() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( array( '163', '19817' ) ) );

		Relationship_Meta::add_id( 161, self::KEY, '163' );

		$this->assertSame( array( '163', '19817' ), Relationship_Meta::get_ids( 161, self::KEY ) );
	}

	/**
	 * Integers and numeric strings are the same connection.
	 */
	public function test_int_and_string_ids_are_equivalent() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( 163, '19817' ) );

		Relationship_Meta::remove_id( 161, self::KEY, 163 );

		$this->assertSame( array( '19817' ), Relationship_Meta::get_ids( 161, self::KEY ) );
	}

	/**
	 * Empty, zero and non-scalar entries are discarded rather than stored.
	 */
	public function test_normalise_discards_unusable_values() {
		$this->assertSame(
			array( '163' ),
			Relationship_Meta::normalise( array( '', '0', 0, null, false, ' 163 ', new stdClass() ) )
		);
	}

	/**
	 * A scalar value is accepted wherever a list is expected.
	 */
	public function test_normalise_accepts_a_bare_scalar() {
		$this->assertSame( array( '163' ), Relationship_Meta::normalise( '163' ) );
	}

	/**
	 * Saving an unchanged canonical value must not rewrite the row.
	 */
	public function test_save_ids_skips_writing_when_already_canonical() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( array( '163', '19817' ) ) );
		$before = TO_Test_Meta_Store::rows( 161, self::KEY );
		TO_Test_Meta_Store::$writes = 0;

		Relationship_Meta::save_ids( 161, self::KEY, array( '163', '19817' ) );

		$this->assertSame( $before, TO_Test_Meta_Store::rows( 161, self::KEY ) );
		$this->assertSame(
			0,
			TO_Test_Meta_Store::$writes,
			'An unchanged canonical value should not be deleted and re-added.'
		);
	}

	/**
	 * Re-saving the same IDs over multi-row storage still collapses it, which is what
	 * lets a legacy key repair itself when its post is saved.
	 */
	public function test_save_ids_collapses_multi_row_storage_even_when_ids_are_unchanged() {
		TO_Test_Meta_Store::seed( 161, self::KEY, array( '163', '19817', '163' ) );

		Relationship_Meta::save_ids( 161, self::KEY, Relationship_Meta::get_ids( 161, self::KEY ) );

		$rows = TO_Test_Meta_Store::rows( 161, self::KEY );
		$this->assertCount( 1, $rows );
		$this->assertSame( array( '163', '19817' ), $rows[0] );
	}

	/**
	 * An invalid object ID is rejected rather than writing to object 0.
	 */
	public function test_invalid_object_id_is_rejected() {
		$this->assertSame( array(), Relationship_Meta::get_ids( 0, self::KEY ) );
		$this->assertFalse( Relationship_Meta::save_ids( 0, self::KEY, array( '163' ) ) );
		$this->assertFalse( Relationship_Meta::add_id( 161, '', '163' ) );
	}
}
