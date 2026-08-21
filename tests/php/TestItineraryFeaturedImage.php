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

	public function __construct( int $index, array $data_to_save ) {
		$this->index        = $index;
		$this->data_to_save = $data_to_save;
	}

	public function id() {
		return 'itinerary';
	}
}

class Test_Fake_CMB2_Field {
	public $group;

	public function __construct( ?Test_Fake_CMB2_Group $group = null ) {
		$this->group = $group;
	}
}

class TestItineraryFeaturedImage extends TestCase {

	protected function setUp(): void {
		parent::setUp();
		$GLOBALS['test_fake_attachments'] = array();
	}

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
