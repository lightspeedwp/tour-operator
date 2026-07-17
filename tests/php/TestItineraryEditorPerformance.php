<?php

/**
 * Regression guard for the tour itinerary edit-screen performance fix.
 *
 * The tour edit screen used to initialise a TinyMCE editor for every WYSIWYG
 * field of every itinerary day on page load, making long tours take minutes to
 * open. The fix has two halves that BOTH must stay in place:
 *
 *   1. The itinerary group is rendered collapsed ('closed' => true), so its
 *      WYSIWYG editors are not visible/initialised up front.
 *   2. assets/js/admin-itinerary-lazy-wysiwyg.js defers each row's editor
 *      init until the row is expanded.
 *
 * These tests fail if either half is removed, or if the itinerary WYSIWYG
 * fields are silently downgraded away from rich text.
 *
 * Standalone (no WordPress test suite required): the metabox config file is a
 * plain array builder, so we stub the few WP/LSX helpers it calls and include it.
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

use PHPUnit\Framework\TestCase;

class TestItineraryEditorPerformance extends TestCase
{
	/** @var array The built tour metabox config. */
	private static $metabox;

	public static function setUpBeforeClass(): void
	{
		require_once __DIR__ . '/utils/wp-stubs-for-config.php';
		// config-tour.php populates a local $metabox variable.
		$metabox = null;
		require dirname(__DIR__, 2) . '/includes/metaboxes/config-tour.php';
		self::$metabox = $metabox;
	}

	private function get_itinerary_group(): array
	{
		$this->assertIsArray(self::$metabox, 'config-tour.php should build a $metabox array');
		foreach (self::$metabox['fields'] as $field) {
			if (isset($field['id']) && 'itinerary' === $field['id']) {
				return $field;
			}
		}
		$this->fail('Itinerary group field not found in tour metabox config');
	}

	/**
	 * The itinerary group must stay a repeatable group.
	 */
	public function test_itinerary_is_repeatable_group()
	{
		$group = $this->get_itinerary_group();
		$this->assertSame('group', $group['type']);
		$this->assertTrue(! empty($group['repeatable']), 'Itinerary must remain repeatable');
	}

	/**
	 * The itinerary group MUST render collapsed. This is what prevents every
	 * day's editors from initialising on page load.
	 */
	public function test_itinerary_group_renders_collapsed()
	{
		$group = $this->get_itinerary_group();
		$this->assertArrayHasKey('options', $group);
		$this->assertTrue(
			! empty($group['options']['closed']),
			"Itinerary group must keep 'closed' => true so its WYSIWYG editors lazy-load. "
				. 'Removing this reintroduces the slow-edit-screen bug.'
		);
	}

	/**
	 * The three itinerary rich-text fields must remain WYSIWYG (not downgraded to
	 * textarea) — the performance fix must not cost us rich text.
	 */
	public function test_itinerary_rich_text_fields_are_wysiwyg()
	{
		$group  = $this->get_itinerary_group();
		$byId   = [];
		foreach ($group['fields'] as $sub) {
			$byId[$sub['id']] = $sub['type'];
		}
		foreach (['description', 'included', 'excluded'] as $id) {
			$this->assertArrayHasKey($id, $byId, "Itinerary '$id' field should exist");
			$this->assertSame('wysiwyg', $byId[$id], "Itinerary '$id' must stay a WYSIWYG rich-text field");
		}
	}

	/**
	 * The lazy-init script must exist and wire up expand-triggered init, otherwise
	 * collapsed rows would never get their editors.
	 */
	public function test_lazy_wysiwyg_script_present()
	{
		$path = dirname(__DIR__, 2) . '/assets/js/admin-itinerary-lazy-wysiwyg.js';
		$this->assertFileExists($path, 'Lazy WYSIWYG init script is missing');
		$js = file_get_contents($path);
		$this->assertStringContainsString('wysiwyg.init', $js, 'Script must override CMB2 wysiwyg.init');
		$this->assertStringContainsString('cmb-repeatable-grouping', $js, 'Script must react to CMB2 group rows');
	}
}
