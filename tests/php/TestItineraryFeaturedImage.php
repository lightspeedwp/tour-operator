<?php

/**
 * Regression tests for the itinerary `featured_image` URL-corruption bug.
 *
 * A bare attachment ID stored in a tour's itinerary `featured_image` field
 * (e.g. "945") becomes the non-functional "https://945" the moment a human
 * re-saves the tour in wp-admin, because that field is a CMB2 `file` type
 * nested in a `group`, and CMB2's default save-time sanitizer
 * (CMB2_Sanitize::file() -> sanitize_and_secure_url()) treats any schemeless
 * string as a bare domain missing its protocol. lsx_to_resolve_itinerary_featured_image()
 * and lsx_to_sanitize_itinerary_featured_image() (includes/functions.php)
 * replace that default sanitizer for this one field so every save resolves
 * whatever is stored -- correct, bare-ID, or already-corrupted -- to a
 * working URL and ID pair instead of re-corrupting or perpetuating it.
 *
 * This is part of the "Simple Tests" suite (phpunit-simple.xml): it stubs
 * only the two WordPress functions the code under test calls, backed by an
 * in-memory fake attachment table, and never requires a WordPress install.
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

use PHPUnit\Framework\TestCase;

// includes/functions.php guards itself with `if ( ! defined( 'ABSPATH' ) ) { exit; }`
// -- correct for production, but it means simply require-ing the file with no
// WordPress loaded silently exits the whole PHP process (no error, no
// output) rather than failing loudly. Define it before the require below.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

if ( ! function_exists( 'wp_get_attachment_url' ) ) {
	function wp_get_attachment_url( $attachment_id ) {
		return $GLOBALS['test_fake_attachments'][ $attachment_id ] ?? false;
	}
}

if ( ! function_exists( 'attachment_url_to_postid' ) ) {
	function attachment_url_to_postid( $url ) {
		$id = array_search( $url, $GLOBALS['test_fake_attachments'], true );
		return false === $id ? 0 : $id;
	}
}

if ( ! function_exists( 'esc_url_raw' ) ) {
	// A faithful-enough stand-in for WP core's real esc_url_raw(): reject a
	// disallowed/missing scheme (this is the actual security property under
	// test -- a `javascript:`/`data:` value must not survive), pass an
	// allowed http(s) URL through unchanged otherwise. Real esc_url_raw()
	// also percent-encodes a few characters; none of this file's fixtures
	// contain any, so that behaviour isn't exercised here.
	function esc_url_raw( $url, $protocols = null ) {
		if ( '' === $url ) {
			return '';
		}

		$scheme = strtolower( (string) parse_url( $url, PHP_URL_SCHEME ) );

		return in_array( $scheme, array( 'http', 'https' ), true ) ? $url : '';
	}
}

if ( ! function_exists( 'lsx_to_resolve_itinerary_featured_image' ) ) {
	require_once dirname( __DIR__, 2 ) . '/includes/functions.php';
}

/**
 * Minimal stand-in for the parent CMB2_Field group object. The real class
 * lives in the vendored plugins/cmb2/ and needs a full field-registration
 * pass to construct; lsx_to_sanitize_itinerary_featured_image() only reads
 * ->id(), ->index and ->data_to_save from it, so a fake exposing exactly
 * that is enough to exercise the real function under test.
 */
class Test_Fake_CMB2_Group {
	public $index;
	public $data_to_save;

	/**
	 * @param int   $index        Which repeatable group row this fake represents.
	 * @param array $data_to_save The full posted meta-box save array, keyed
	 *                            the same way CMB2::save_group_field() sets
	 *                            it: `data_to_save[<group id>][<index>][<sub field id>]`.
	 */
	public function __construct( int $index, array $data_to_save ) {
		$this->index        = $index;
		$this->data_to_save = $data_to_save;
	}

	/**
	 * @return string Always "itinerary" -- the only group this fake needs to represent.
	 */
	public function id() {
		return 'itinerary';
	}
}

class Test_Fake_CMB2_Field {
	public $group;

	/**
	 * @param Test_Fake_CMB2_Group|null $group The parent group field, or null
	 *                                          to exercise the no-group case
	 *                                          (see test_sanitization_cb_without_group_does_not_fatal()).
	 */
	public function __construct( ?Test_Fake_CMB2_Group $group = null ) {
		$this->group = $group;
	}
}

class TestItineraryFeaturedImage extends TestCase {

	/**
	 * Resets the fake attachment table before every test so one test's
	 * fixtures can never leak into another.
	 */
	protected function setUp(): void {
		parent::setUp();
		$GLOBALS['test_fake_attachments'] = array();
	}

	/**
	 * Clears the fake attachment table after every test.
	 */
	protected function tearDown(): void {
		$GLOBALS['test_fake_attachments'] = array();
		parent::tearDown();
	}

	/**
	 * The exact corruption reported: "https://" followed by a bare
	 * attachment ID, with no path, produced by CMB2's default sanitizer
	 * treating the bare ID as a schemeless domain.
	 */
	public function test_corrupted_https_bare_id_resolves_to_real_url_and_id(): void {
		$GLOBALS['test_fake_attachments'][945] = 'https://example.com/wp-content/uploads/mkuze.jpg';

		$result = lsx_to_resolve_itinerary_featured_image( 'https://945', '' );

		$this->assertSame( 'https://example.com/wp-content/uploads/mkuze.jpg', $result['url'] );
		$this->assertSame( '945', $result['id'] );
	}

	/**
	 * http:// (not https://) is the same defect via the same mechanism.
	 */
	public function test_corrupted_http_bare_id_resolves_to_real_url_and_id(): void {
		$GLOBALS['test_fake_attachments'][31940] = 'https://example.com/wp-content/uploads/makuwa.jpg';

		$result = lsx_to_resolve_itinerary_featured_image( 'http://31940', '' );

		$this->assertSame( 'https://example.com/wp-content/uploads/makuwa.jpg', $result['url'] );
		$this->assertSame( '31940', $result['id'] );
	}

	/**
	 * The pre-corruption shape: a bare attachment ID with no scheme at all
	 * (e.g. from a direct postmeta write that bypassed CMB2's own
	 * media-picker JS entirely). This must resolve the same way as the
	 * corrupted form, not merely be left alone -- otherwise the very next
	 * save corrupts it via the same default-sanitizer path this function
	 * replaces.
	 */
	public function test_bare_id_resolves_to_real_url_and_id(): void {
		$GLOBALS['test_fake_attachments'][8076] = 'https://example.com/wp-content/uploads/kosi-bay.jpg';

		$result = lsx_to_resolve_itinerary_featured_image( '8076', '' );

		$this->assertSame( 'https://example.com/wp-content/uploads/kosi-bay.jpg', $result['url'] );
		$this->assertSame( '8076', $result['id'] );
	}

	/**
	 * The already-correct shape (a real URL, with no companion ID
	 * submitted) must be preserved, with its attachment ID resolved so
	 * `featured_image_id` -- what lsx_to_itinerary_thumbnail() actually
	 * reads first -- gets populated too.
	 */
	public function test_real_url_is_preserved_and_id_is_resolved(): void {
		$url                                      = 'https://example.com/wp-content/uploads/dolphins.jpg';
		$GLOBALS['test_fake_attachments'][23250] = $url;

		$result = lsx_to_resolve_itinerary_featured_image( $url, '' );

		$this->assertSame( $url, $result['url'] );
		$this->assertSame( '23250', $result['id'] );
	}

	/**
	 * The normal, already-working case: a human picks an image through the
	 * media modal. CMB2's own JS (cmb2.js handlers.single) sets the visible
	 * field to the real URL AND the hidden companion field to the real ID
	 * in the same submission -- the companion field must take priority and
	 * this must not regress into re-resolving a value that was already
	 * correct.
	 */
	public function test_companion_id_from_media_picker_takes_priority(): void {
		$GLOBALS['test_fake_attachments'][512] = 'https://example.com/wp-content/uploads/picked-via-modal.jpg';

		$result = lsx_to_resolve_itinerary_featured_image(
			'https://example.com/wp-content/uploads/picked-via-modal.jpg',
			'512'
		);

		$this->assertSame( 'https://example.com/wp-content/uploads/picked-via-modal.jpg', $result['url'] );
		$this->assertSame( '512', $result['id'] );
	}

	/**
	 * A real URL for an attachment this can't resolve back to a post ID
	 * (an external image, or one WordPress's own url-to-postid lookup fails
	 * on) must still be kept -- losing a working URL because its ID can't
	 * be resolved would be a regression in itself.
	 */
	public function test_real_url_with_unresolvable_id_keeps_url_with_empty_id(): void {
		$result = lsx_to_resolve_itinerary_featured_image( 'https://cdn.example.com/external.jpg', '' );

		$this->assertSame( 'https://cdn.example.com/external.jpg', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * An attachment ID (bare or corrupted) that no longer exists must be
	 * dropped, not carried forward as a broken value.
	 */
	public function test_bare_id_for_deleted_attachment_resolves_empty(): void {
		$result = lsx_to_resolve_itinerary_featured_image( '999999', '' );

		$this->assertSame( '', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * Same as above for the corrupted "https://<id>" shape.
	 */
	public function test_corrupted_https_bare_id_for_deleted_attachment_resolves_empty(): void {
		$result = lsx_to_resolve_itinerary_featured_image( 'https://999999', '' );

		$this->assertSame( '', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * An empty field (no image ever assigned to this day) must stay empty,
	 * not be turned into a placeholder or an error.
	 */
	public function test_empty_value_resolves_empty(): void {
		$result = lsx_to_resolve_itinerary_featured_image( '', '' );

		$this->assertSame( '', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * A companion ID field containing "0" (CMB2's own placeholder for "no
	 * attachment selected yet", set by CMB2_Type_File::render()) must not
	 * be treated as a real attachment ID.
	 */
	public function test_zero_companion_id_is_ignored(): void {
		$GLOBALS['test_fake_attachments'][945] = 'https://example.com/wp-content/uploads/mkuze.jpg';

		$result = lsx_to_resolve_itinerary_featured_image( 'https://945', '0' );

		$this->assertSame( 'https://example.com/wp-content/uploads/mkuze.jpg', $result['url'] );
		$this->assertSame( '945', $result['id'] );
	}

	/**
	 * The security property this fix depends on: this sanitization_cb
	 * replaces CMB2's default sanitizer entirely, so nothing else in the
	 * save path escapes a "real URL"-shaped value before it's stored. A
	 * disallowed scheme must be rejected here, not merely passed through,
	 * or any user with edit access could persist a `javascript:`/`data:`
	 * value in `featured_image` verbatim.
	 */
	public function test_disallowed_scheme_is_rejected_not_stored(): void {
		$result = lsx_to_resolve_itinerary_featured_image( 'javascript:alert(1)', '' );

		$this->assertSame( '', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * Same property, the other commonly-abused scheme.
	 */
	public function test_data_scheme_is_rejected_not_stored(): void {
		$result = lsx_to_resolve_itinerary_featured_image( 'data:text/html,<script>alert(1)</script>', '' );

		$this->assertSame( '', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * Near-miss shapes that don't match the exact "scheme + all-digits"
	 * pattern the corruption-repair branches look for. These fall through
	 * to the real-URL branch and are kept (sanitized, but otherwise
	 * verbatim) rather than repaired -- documenting that this is
	 * deliberate, not an oversight: the resolver only ever repairs the
	 * specific shapes this bug is known to produce, not free-form input
	 * that happens to start with digits after a scheme.
	 */
	public function test_trailing_slash_after_bare_id_is_not_repaired(): void {
		$result = lsx_to_resolve_itinerary_featured_image( 'https://945/', '' );

		$this->assertSame( 'https://945/', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * @see test_trailing_slash_after_bare_id_is_not_repaired() -- same
	 * documented "near-miss, not repaired" property, for a query string.
	 */
	public function test_query_string_after_bare_id_is_not_repaired(): void {
		$result = lsx_to_resolve_itinerary_featured_image( 'https://945?x=1', '' );

		$this->assertSame( 'https://945?x=1', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * @see test_trailing_slash_after_bare_id_is_not_repaired() -- same
	 * documented "near-miss, not repaired" property, for an uppercase scheme.
	 */
	public function test_uppercase_scheme_is_not_repaired(): void {
		// str_starts_with() is case-sensitive; "HTTPS://" doesn't match the
		// lowercase "https://" the corruption-repair branch checks for.
		$result = lsx_to_resolve_itinerary_featured_image( 'HTTPS://945', '' );

		$this->assertSame( 'HTTPS://945', $result['url'] );
		$this->assertSame( '', $result['id'] );
	}

	/**
	 * A companion ID pointing at a deleted attachment must not block
	 * resolving the field's own value -- it should fall through exactly as
	 * if no companion ID had been submitted at all.
	 */
	public function test_deleted_attachment_companion_id_falls_back_to_raw_value(): void {
		$GLOBALS['test_fake_attachments'][945] = 'https://example.com/wp-content/uploads/mkuze.jpg';

		$result = lsx_to_resolve_itinerary_featured_image( 'https://945', '999999' );

		$this->assertSame( 'https://example.com/wp-content/uploads/mkuze.jpg', $result['url'] );
		$this->assertSame( '945', $result['id'] );
	}

	/**
	 * lsx_to_sanitize_itinerary_featured_image() is the actual CMB2
	 * sanitization_cb wired up in includes/metaboxes/config-tour.php. This
	 * is an end-to-end check that it extracts the companion field from the
	 * group's data_to_save correctly and returns the has_supporting_data
	 * shape CMB2::save_group_field() expects -- a future edit could resolve
	 * the value correctly and then return the wrong array shape, or read
	 * the companion field from the wrong index.
	 */
	public function test_sanitization_cb_reads_companion_field_and_returns_supporting_data_shape(): void {
		$GLOBALS['test_fake_attachments'][945] = 'https://example.com/wp-content/uploads/mkuze.jpg';

		$group = new Test_Fake_CMB2_Group(
			2, // This day is the third row (index 2) in the repeatable group.
			array(
				'itinerary' => array(
					2 => array(
						'featured_image'    => 'https://945',
						'featured_image_id' => '',
					),
				),
			)
		);
		$field = new Test_Fake_CMB2_Field( $group );

		$result = lsx_to_sanitize_itinerary_featured_image( 'https://945', array(), $field );

		$this->assertSame( 'https://example.com/wp-content/uploads/mkuze.jpg', $result['value'] );
		$this->assertSame( 'featured_image_id', $result['supporting_field_id'] );
		$this->assertSame( '945', $result['supporting_field_value'] );
	}

	/**
	 * Same end-to-end check, but for a day where the media picker already
	 * submitted a companion ID in this save -- it must take priority over
	 * the visible field's own value, exactly as lsx_to_resolve_itinerary_featured_image()
	 * on its own already guarantees, but proven here through the actual
	 * group data_to_save shape CMB2 hands the callback.
	 */
	public function test_sanitization_cb_prioritizes_companion_id_from_group_data(): void {
		$GLOBALS['test_fake_attachments'][512] = 'https://example.com/wp-content/uploads/picked-via-modal.jpg';

		$group = new Test_Fake_CMB2_Group(
			0,
			array(
				'itinerary' => array(
					0 => array(
						'featured_image'    => 'https://example.com/wp-content/uploads/picked-via-modal.jpg',
						'featured_image_id' => '512',
					),
				),
			)
		);
		$field = new Test_Fake_CMB2_Field( $group );

		$result = lsx_to_sanitize_itinerary_featured_image(
			'https://example.com/wp-content/uploads/picked-via-modal.jpg',
			array(),
			$field
		);

		$this->assertSame( 'https://example.com/wp-content/uploads/picked-via-modal.jpg', $result['value'] );
		$this->assertSame( '512', $result['supporting_field_value'] );
	}

	/**
	 * A field with no group at all (should not happen in production --
	 * `featured_image` is always registered inside the `itinerary` group --
	 * but the callback must not fatal if it ever is) must fall back to
	 * resolving the value with no companion ID, not throw.
	 */
	public function test_sanitization_cb_without_group_does_not_fatal(): void {
		$GLOBALS['test_fake_attachments'][945] = 'https://example.com/wp-content/uploads/mkuze.jpg';

		$field = new Test_Fake_CMB2_Field( null );

		$result = lsx_to_sanitize_itinerary_featured_image( 'https://945', array(), $field );

		$this->assertSame( 'https://example.com/wp-content/uploads/mkuze.jpg', $result['value'] );
		$this->assertSame( '945', $result['supporting_field_value'] );
	}
}
