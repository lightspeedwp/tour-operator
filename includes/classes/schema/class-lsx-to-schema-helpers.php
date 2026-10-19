<?php
/**
 * Schema Helper Functions
 *
 * Shared normalisation utilities used by all Tour Operator schema graph pieces.
 * Pure-PHP methods (price, duration, date, time, property-value builders) carry
 * no WordPress dependency so they can be unit-tested in isolation.
 *
 * @package    Tour_Operator
 * @subpackage Schema
 * @since      2.2.0
 */

namespace lsx\schema;

/**
 * Static normalisation helpers for schema output.
 */
class Helpers {

	/**
	 * Safely retrieve a single post meta value.
	 *
	 * Returns an empty string when the meta key is missing or the value is empty.
	 *
	 * @param int    $post_id  Post ID.
	 * @param string $meta_key Meta key.
	 * @return string
	 */
	public static function get_meta( $post_id, $meta_key ) {
		$value = get_post_meta( (int) $post_id, $meta_key, true );
		if ( false === $value || null === $value ) {
			return '';
		}
		return (string) $value;
	}

	/**
	 * Get Yoast's primary image @id fragment.
	 *
	 * Uses the current Yoast Schema_IDs constant when available (the legacy
	 * WPSEO_Schema_IDs class was removed in Yoast 14), falling back to the
	 * value Yoast has always used.
	 *
	 * @return string Hash fragment, e.g. '#primaryimage'.
	 */
	public static function primary_image_hash() {
		if ( class_exists( '\Yoast\WP\SEO\Config\Schema_IDs' ) ) {
			return \Yoast\WP\SEO\Config\Schema_IDs::PRIMARY_IMAGE_HASH;
		}
		return '#primaryimage';
	}

	/**
	 * Safely retrieve a multi-value post meta field as an array.
	 *
	 * Handles both CMB2 serialised multiselect values (stored as a single
	 * serialised array) and pw_multiselect values (stored as multiple rows).
	 *
	 * @param int    $post_id  Post ID.
	 * @param string $meta_key Meta key.
	 * @return array Flat array of non-empty scalar values.
	 */
	public static function get_meta_array( $post_id, $meta_key ) {
		// Attempt single-value read first; CMB2 multicheck/multiselect stores
		// a serialised PHP array in one row so get_post_meta( …, true ) gives
		// the deserialized array directly.
		$single = get_post_meta( (int) $post_id, $meta_key, true );
		if ( is_array( $single ) && ! empty( $single ) ) {
			return array_values(
				array_filter(
					$single,
					static function ( $item ) {
						return is_scalar( $item ) && '' !== $item;
					}
				)
			);
		}

		// Fall back to multi-value read (pw_multiselect stores separate rows).
		$multi = get_post_meta( (int) $post_id, $meta_key, false );
		if ( ! is_array( $multi ) ) {
			return array();
		}

		$flat = array();
		foreach ( $multi as $item ) {
			if ( is_array( $item ) ) {
				// Flatten one level for safety.
				foreach ( $item as $sub ) {
					if ( is_scalar( $sub ) && '' !== $sub ) {
						$flat[] = $sub;
					}
				}
			} elseif ( is_scalar( $item ) && '' !== $item ) {
				$flat[] = $item;
			}
		}

		return array_values( array_unique( $flat ) );
	}

	/**
	 * Normalise a raw price string to a numeric value.
	 *
	 * Strips currency symbols, spaces, and thousands separators.
	 * Returns an empty string when the value is not parseable as a positive number.
	 *
	 * @param string $value Raw price value.
	 * @return string Numeric string or empty string.
	 */
	public static function normalise_price( $value ) {
		$value = (string) $value;
		// Treat a trailing ",d" or ",dd" as a decimal comma (e.g. "1.250,50").
		if ( preg_match( '/,\d{1,2}$/', $value ) ) {
			$value = str_replace( array( '.', ',' ), array( '', '.' ), $value );
		}
		$numeric = preg_replace( '/[^\d.]/', '', $value );
		if ( '' === $numeric || ! is_numeric( $numeric ) || (float) $numeric <= 0 ) {
			return '';
		}
		// Return without trailing zeros for whole numbers, keep decimals otherwise.
		$float = (float) $numeric;
		return ( $float === floor( $float ) ) ? (string) (int) $float : (string) $float;
	}

	/**
	 * Get the site currency code from Tour Operator settings.
	 *
	 * Checks `options['currency']` (block-era) then `options['general']['currency']`
	 * (legacy) and defaults to `'USD'` when neither is set.
	 *
	 * @return string ISO 4217 currency code (e.g. 'ZAR', 'USD').
	 */
	public static function get_currency() {
		$tour_operator = tour_operator();
		if ( is_object( $tour_operator ) ) {
			if ( ! empty( $tour_operator->options['currency'] ) ) {
				return strtoupper( sanitize_text_field( $tour_operator->options['currency'] ) );
			}
			if ( ! empty( $tour_operator->options['general']['currency'] ) ) {
				return strtoupper( sanitize_text_field( $tour_operator->options['general']['currency'] ) );
			}
		}
		return 'USD';
	}

	/**
	 * Format a day count as an ISO 8601 duration string.
	 *
	 * Returns `'P7D'` for 7 days, or an empty string when the value is not a
	 * positive integer.
	 *
	 * @param string $value Raw duration value (expected to be a day count).
	 * @return string ISO 8601 duration string or empty string.
	 */
	public static function format_iso_duration( $value ) {
		$int = (int) $value;
		if ( $int < 1 ) {
			return '';
		}
		return 'P' . $int . 'D';
	}

	/**
	 * Format a Unix timestamp or date string as an ISO 8601 date (YYYY-MM-DD).
	 *
	 * Returns an empty string when the input cannot be parsed as a valid date.
	 *
	 * @param string $value Raw timestamp or date string.
	 * @return string ISO 8601 date string or empty string.
	 */
	public static function format_iso_date( $value ) {
		$value = (string) $value;
		if ( '' === $value ) {
			return '';
		}
		// Numeric UNIX timestamp.
		if ( is_numeric( $value ) && (int) $value > 0 ) {
			return gmdate( 'Y-m-d', (int) $value );
		}
		// Date string – parse in UTC so the result matches gmdate() above.
		$date = date_create( $value, new \DateTimeZone( 'UTC' ) );
		if ( false !== $date && $date->getTimestamp() > 0 ) {
			return $date->format( 'Y-m-d' );
		}
		return '';
	}

	/**
	 * Format a time value into HH:MM 24-hour format.
	 *
	 * Returns an empty string when the input cannot be parsed.
	 *
	 * @param string $value Raw time value (e.g. '14:00', '2:00 PM').
	 * @return string Formatted time string or empty string.
	 */
	public static function format_time( $value ) {
		$value = (string) $value;
		if ( '' === $value ) {
			return '';
		}
		// Parse in UTC so the server time zone cannot shift the time.
		$time = date_create( $value, new \DateTimeZone( 'UTC' ) );
		if ( false === $time ) {
			return '';
		}
		return $time->format( 'H:i' );
	}

	/**
	 * Convert an array of month slugs to a human-readable comma-separated string.
	 *
	 * Accepts lowercase month slugs (e.g. 'january') and returns their capitalised
	 * label equivalents (e.g. 'January'). Unknown slugs are silently ignored.
	 *
	 * @param array $slugs Array of month slug strings.
	 * @return string Comma-separated month labels, or empty string.
	 */
	public static function month_slugs_to_labels( array $slugs ) {
		static $map = null;
		if ( null === $map ) {
			$map = array(
				'january'   => 'January',
				'february'  => 'February',
				'march'     => 'March',
				'april'     => 'April',
				'may'       => 'May',
				'june'      => 'June',
				'july'      => 'July',
				'august'    => 'August',
				'september' => 'September',
				'october'   => 'October',
				'november'  => 'November',
				'december'  => 'December',
			);
			// Allow translations or overrides via WordPress filter.
			if ( function_exists( 'apply_filters' ) ) {
				$map = (array) apply_filters( 'lsx_to_schema_month_labels', $map );
			}
		}

		$labels = array();
		foreach ( $slugs as $slug ) {
			$slug = strtolower( trim( (string) $slug ) );
			if ( isset( $map[ $slug ] ) ) {
				$labels[] = $map[ $slug ];
			}
		}
		return implode( ', ', $labels );
	}

	/**
	 * Build a schema.org PropertyValue node.
	 *
	 * A list of values is output as a JSON array, or as a plain string when
	 * it holds a single item.
	 *
	 * @param string          $name  Property name (human-readable label).
	 * @param string|string[] $value Property value, or a list of values.
	 * @return array PropertyValue array.
	 */
	public static function make_property_value( $name, $value ) {
		if ( is_array( $value ) ) {
			$value = array_values( array_map( 'strval', $value ) );
			if ( 1 === count( $value ) ) {
				$value = $value[0];
			}
		} else {
			$value = (string) $value;
		}

		return array(
			'@type' => 'PropertyValue',
			'name'  => (string) $name,
			'value' => $value,
		);
	}

	/**
	 * Strip all HTML tags from a string and decode HTML entities.
	 *
	 * Block-level tags and line breaks become spaces so adjacent paragraphs do
	 * not run together, and all whitespace (including non-breaking spaces,
	 * tabs and line breaks) is collapsed to single spaces.
	 *
	 * Falls back to `strip_tags()` when `wp_strip_all_tags()` is not available
	 * (e.g. in unit tests without a WordPress environment).
	 *
	 * @param string $value Raw HTML string.
	 * @return string Plain text.
	 */
	public static function strip_to_text( $value ) {
		$value = preg_replace( '/<\/(?:p|li|div|h[1-6])>|<br\s*\/?>/i', ' ', (string) $value );
		if ( function_exists( 'wp_strip_all_tags' ) ) {
			$clean = wp_strip_all_tags( $value );
		} else {
			$clean = strip_tags( $value );
		}
		$clean = html_entity_decode( $clean, ENT_QUOTES, 'UTF-8' );
		return trim( preg_replace( '/[\s\x{00A0}]+/u', ' ', $clean ) );
	}

	/**
	 * Split an HTML or plain-text field into a list of clean text items.
	 *
	 * Each list item, paragraph, line break or plain-text line becomes one
	 * item. Nested lists are flattened and empty items (such as a trailing
	 * `&nbsp;`) are dropped.
	 *
	 * @param string $value Raw HTML or plain text.
	 * @return string[] Clean text items.
	 */
	public static function html_to_list( $value ) {
		$value = preg_replace( '/<\/?(?:li|p|div|ul|ol|h[1-6])\b[^>]*>|<br\s*\/?>/i', "\n", (string) $value );
		$items = array();
		foreach ( preg_split( '/\R/u', $value ) as $line ) {
			$line = self::strip_to_text( $line );
			if ( '' !== $line ) {
				$items[] = $line;
			}
		}
		return $items;
	}
}
