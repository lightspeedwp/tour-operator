<?php

/**
 * Unit Tests for Schema Helper Methods
 *
 * Tests the pure-PHP normalisation methods in lsx\schema\Helpers that carry
 * no WordPress dependency, so they can run without a WordPress environment.
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

// Stub WordPress functions used by the helpers so the file can be loaded
// without a WordPress environment.
if (! function_exists('wp_strip_all_tags')) {
	/**
	 * Stub for wp_strip_all_tags().
	 *
	 * @param string $text           Input text.
	 * @param bool   $remove_breaks  Unused in stub.
	 * @return string
	 */
	function wp_strip_all_tags($text, $remove_breaks = false)
	{
		return strip_tags((string) $text);
	}
}

if (! function_exists('apply_filters')) {
	/**
	 * Stub for apply_filters() – returns the second argument unchanged.
	 *
	 * @param string $hook  Unused.
	 * @param mixed  $value Value to return.
	 * @return mixed
	 */
	function apply_filters($hook, $value)
	{
		return $value;
	}
}

// Load the helpers class.
require_once dirname(dirname(dirname(__FILE__))) . '/includes/classes/schema/class-lsx-to-schema-helpers.php';

use PHPUnit\Framework\TestCase;
use lsx\schema\Helpers;

/**
 * Unit tests for lsx\schema\Helpers.
 */
class TestSchemaHelpers extends TestCase
{

	// -------------------------------------------------------------------------
	// normalise_price
	// -------------------------------------------------------------------------

	/**
	 * A plain numeric string is returned unchanged.
	 */
	public function test_normalise_price_plain_number()
	{
		$this->assertSame('12500', Helpers::normalise_price('12500'));
	}

	/**
	 * A price with a currency symbol and spaces is stripped to a numeric string.
	 */
	public function test_normalise_price_strips_currency_symbol()
	{
		$this->assertSame('3500', Helpers::normalise_price('R 3,500'));
		$this->assertSame('3500', Helpers::normalise_price('$ 3500'));
	}

	/**
	 * A float price is preserved.
	 */
	public function test_normalise_price_float()
	{
		$this->assertSame('1250.5', Helpers::normalise_price('1250.50'));
	}

	/**
	 * Zero is not a valid price – returns empty string.
	 */
	public function test_normalise_price_zero_returns_empty()
	{
		$this->assertSame('', Helpers::normalise_price('0'));
		$this->assertSame('', Helpers::normalise_price('0.00'));
	}

	/**
	 * Non-numeric input returns empty string.
	 */
	public function test_normalise_price_non_numeric_returns_empty()
	{
		$this->assertSame('', Helpers::normalise_price('POA'));
		$this->assertSame('', Helpers::normalise_price(''));
		$this->assertSame('', Helpers::normalise_price('contact us'));
	}

	// -------------------------------------------------------------------------
	// format_iso_duration
	// -------------------------------------------------------------------------

	/**
	 * A positive integer produces an ISO 8601 day duration.
	 */
	public function test_format_iso_duration_positive_int()
	{
		$this->assertSame('P7D', Helpers::format_iso_duration('7'));
		$this->assertSame('P14D', Helpers::format_iso_duration('14'));
		$this->assertSame('P1D', Helpers::format_iso_duration('1'));
	}

	/**
	 * Zero or negative values return empty string.
	 */
	public function test_format_iso_duration_zero_or_negative()
	{
		$this->assertSame('', Helpers::format_iso_duration('0'));
		$this->assertSame('', Helpers::format_iso_duration('-3'));
	}

	/**
	 * Non-numeric strings return empty string.
	 */
	public function test_format_iso_duration_non_numeric()
	{
		$this->assertSame('', Helpers::format_iso_duration(''));
		$this->assertSame('', Helpers::format_iso_duration('seven days'));
	}

	// -------------------------------------------------------------------------
	// format_iso_date
	// -------------------------------------------------------------------------

	/**
	 * A Unix timestamp is formatted as YYYY-MM-DD.
	 */
	public function test_format_iso_date_unix_timestamp()
	{
		// 2026-06-01 UTC
		$ts = mktime(0, 0, 0, 6, 1, 2026);
		$this->assertSame('2026-06-01', Helpers::format_iso_date((string) $ts));
	}

	/**
	 * An ISO date string round-trips correctly.
	 */
	public function test_format_iso_date_date_string()
	{
		$this->assertSame('2026-09-30', Helpers::format_iso_date('2026-09-30'));
	}

	/**
	 * Empty input returns empty string.
	 */
	public function test_format_iso_date_empty_returns_empty()
	{
		$this->assertSame('', Helpers::format_iso_date(''));
	}

	/**
	 * Invalid date strings return empty string.
	 */
	public function test_format_iso_date_invalid_returns_empty()
	{
		$this->assertSame('', Helpers::format_iso_date('not-a-date'));
	}

	// -------------------------------------------------------------------------
	// format_time
	// -------------------------------------------------------------------------

	/**
	 * A 24-hour time string is returned as HH:MM.
	 */
	public function test_format_time_24h()
	{
		$this->assertSame('14:00', Helpers::format_time('14:00'));
	}

	/**
	 * A 12-hour AM/PM time string is converted to 24-hour HH:MM.
	 */
	public function test_format_time_12h_ampm()
	{
		$this->assertSame('14:00', Helpers::format_time('2:00 PM'));
		$this->assertSame('09:00', Helpers::format_time('9:00 AM'));
	}

	/**
	 * Empty input returns empty string.
	 */
	public function test_format_time_empty_returns_empty()
	{
		$this->assertSame('', Helpers::format_time(''));
	}

	/**
	 * Unparseable input returns empty string.
	 */
	public function test_format_time_invalid_returns_empty()
	{
		$this->assertSame('', Helpers::format_time('not-a-time'));
	}

	// -------------------------------------------------------------------------
	// month_slugs_to_labels
	// -------------------------------------------------------------------------

	/**
	 * Valid month slugs are converted to capitalised labels.
	 */
	public function test_month_slugs_to_labels_basic()
	{
		$result = Helpers::month_slugs_to_labels(array('january', 'march', 'december'));
		$this->assertSame('January, March, December', $result);
	}

	/**
	 * A single slug returns a single label with no trailing comma.
	 */
	public function test_month_slugs_to_labels_single()
	{
		$this->assertSame('July', Helpers::month_slugs_to_labels(array('july')));
	}

	/**
	 * Unknown slugs are silently ignored.
	 */
	public function test_month_slugs_to_labels_unknown_ignored()
	{
		$result = Helpers::month_slugs_to_labels(array('january', 'unknown-month'));
		$this->assertSame('January', $result);
	}

	/**
	 * An empty array returns an empty string.
	 */
	public function test_month_slugs_to_labels_empty_array()
	{
		$this->assertSame('', Helpers::month_slugs_to_labels(array()));
	}

	// -------------------------------------------------------------------------
	// make_property_value
	// -------------------------------------------------------------------------

	/**
	 * make_property_value returns a valid PropertyValue array.
	 */
	public function test_make_property_value_structure()
	{
		$pv = Helpers::make_property_value('Single supplement', 'ZAR 1500');
		$this->assertIsArray($pv);
		$this->assertSame('PropertyValue', $pv['@type']);
		$this->assertSame('Single supplement', $pv['name']);
		$this->assertSame('ZAR 1500', $pv['value']);
	}

	// -------------------------------------------------------------------------
	// strip_to_text
	// -------------------------------------------------------------------------

	/**
	 * HTML tags are stripped and entities decoded.
	 */
	public function test_strip_to_text_html()
	{
		$this->assertSame('Hello World', Helpers::strip_to_text('<p>Hello <strong>World</strong></p>'));
	}

	/**
	 * HTML entities are decoded.
	 */
	public function test_strip_to_text_entities()
	{
		$this->assertSame("Safari & Wildlife Tour", Helpers::strip_to_text('Safari &amp; Wildlife Tour'));
	}

	/**
	 * Plain text passes through unchanged.
	 */
	public function test_strip_to_text_plain()
	{
		$this->assertSame('Plain text', Helpers::strip_to_text('Plain text'));
	}
}
