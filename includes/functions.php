<?php
/**
 * Tour Operator Helper Functions
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @copyright 2017 LightSpeed
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns an array of the tour taxonomies.
 *
 * @since unknown
 * @return array List of tour operator taxonomies.
 */
function lsx_to_get_taxonomies() {
	return tour_operator()->get_taxonomies();
}

/**
 * Returns an array of the tour post types.
 *
 * @since unknown
 * @return array List of tour operator post types.
 */
function lsx_to_get_post_types() {
	return tour_operator()->get_post_types();
}

/**
 * Checks if the current tour has an itinerary
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_has_itinerary() {
	global $tour_itinerary;

	$has_itinerary = false;

	if ( null === $tour_itinerary ) {
		$tour_itinerary = new \lsx\legacy\Itinerary_Query();
	}

	if ( is_object( $tour_itinerary ) ) {
		$has_itinerary = $tour_itinerary->has_itinerary();
	}

	return $has_itinerary;
}

/**
 * Runs the current itinerary loop, used in a "while" statement
 * e.g  while(lsx_to_itinerary_loop()) {lsx_to_itinerary_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_loop() {
	global $tour_itinerary;

	if ( is_object( $tour_itinerary ) ) {
		return $tour_itinerary->while_itinerary();
	} else {
		return false;
	}
}

/**
 * Sets up the current itinerary itinerary
 * e.g  while(lsx_to_itinerary_loop()) {lsx_to_itinerary_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_loop_item() {
	global $tour_itinerary;

	if ( is_object( $tour_itinerary ) ) {
		$tour_itinerary->current_itinerary_item();
	}
}

/**
 * resets the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_loop_reset() {
	global $tour_itinerary;

	if ( is_object( $tour_itinerary ) ) {
		$tour_itinerary->reset_loop();
	}
}

/**
 * Outputs The current Itinerary title, can only be used in the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_title( $echo = true ) {
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['title'] ) ) {
			$title = apply_filters( 'the_title', $tour_itinerary->itinerary['title'] );
			$title = apply_filters( 'lsx_to_itinerary_title', $title, $tour_itinerary );
			if ( true === $echo ) {
				echo wp_kses_post( $title );
			} else {
				return $title;
			}
		}
	}
}

/**
 * Outputs The current Itinerary slug, can only be used in the itinerary loop
 * as an ID.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_slug() {
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['title'] ) ) {
			echo wp_kses_post( sanitize_title( $tour_itinerary->itinerary['title'] ) );
		}
	}
}

/**
 * Outputs The current Itinerary Tagline, can only be used in the itinerary
 * loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_tagline() {
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['tagline'] ) ) {
			echo wp_kses_post( apply_filters( 'the_title', $tour_itinerary->itinerary['tagline'] ) );
		}
	}
}

/**
 * Outputs The current Itinerary description, can only be used in the itinerary
 * loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_description( $echo = true ) {
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['description'] ) ) {
			if ( $echo ) {
				echo wp_kses_post( apply_filters( 'the_content', $tour_itinerary->itinerary['description'] ) );
			} else {
				return wp_kses_post( apply_filters( 'the_content', $tour_itinerary->itinerary['description'] ) );
			}
		}
	}
}

/**
 * Checks if the current itinerary item has a thumbnail.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_has_thumbnail() {
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary ) {
		return true;
	}
}

/**
 * Outputs The current Itinerary thumbnail, can only be used in the itinerary
 * loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_thumbnail( $size = 'lsx-thumbnail-square', $meta_key = 'accommodation_to_tour' ) {
	global $tour_itinerary;
	$accommodation_id = '';
	$temp_id          = '';
	$tour_operator    = tour_operator();

	if ( ( isset( $tour_operator->options['tour']['itinerary_use_destination_images'] ) && '' !== $tour_operator->options['tour']['itinerary_use_destination_images'] )
		|| true === apply_filters( 'lsx_to_itinerary_use_destination_images', false ) ) {
		$meta_key = 'destination_to_tour';
	}

	$size = apply_filters( 'lsx_to_itinerary_thumbnail_size', $size );

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		$thumbnail_src = false;

		if ( ! empty( $tour_itinerary->itinerary['featured_image_id'] ) ) {
			$tour_itinerary->save_used_image( $tour_itinerary->itinerary['featured_image_id'] );
			$thumbnail = wp_get_attachment_image_src( $tour_itinerary->itinerary['featured_image_id'], $size );

			if ( is_array( $thumbnail ) ) {
				$thumbnail_src = $thumbnail[0];
			}
		} elseif ( ! empty( $tour_itinerary->itinerary[ $meta_key ] ) ) {
			$accommodation_images = [];

			if ( is_string( $tour_itinerary->itinerary[ $meta_key ] ) ) {
				$tour_itinerary->itinerary[ $meta_key ] = array( $tour_itinerary->itinerary[ $meta_key ] );
			}

			foreach ( $tour_itinerary->itinerary[ $meta_key ] as $accommodation_id ) {
				$tour_itinerary->register_current_gallery( $accommodation_id, $meta_key );
				$current_image_id = false;

				// Try for a thumbnail first.
				$temp_id = get_post_thumbnail_id( $accommodation_id );

				if ( false === $temp_id || 0 === $temp_id || $tour_itinerary->is_image_used( $temp_id ) ) {
					$current_image_id = $tour_itinerary->find_next_image( $accommodation_id );
				} else {
					$current_image_id = $temp_id;
				}

				if ( false !== $current_image_id ) {
					$tour_itinerary->save_used_image( $current_image_id );
					$temp_src_array = wp_get_attachment_image_src( $current_image_id, $size );

					if ( is_array( $temp_src_array ) ) {
						$accommodation_images[] = $temp_src_array[0];
					}
				}
			}

			if ( ! empty( $accommodation_images ) ) {
				$thumbnail_src = $accommodation_images[0];
			}
		}

		// If it is the last day of the itinerary and there is no image, then use the featured image of the tour.
		if ( $tour_itinerary->index === $tour_itinerary->count && ( false === $thumbnail_src || '' === $thumbnail_src ) ) {

			$temp_id = get_post_thumbnail_id();

			if ( false !== $temp_id ) {
				$temp_src_array = wp_get_attachment_image_src( $temp_id, $size );
				if ( is_array( $temp_src_array ) ) {
					$thumbnail_src = $temp_src_array[0];
				}
			}
		}
		$thumbnail_src = apply_filters( 'lsx_to_itinerary_thumbnail_src', $thumbnail_src, $tour_itinerary->index, $tour_itinerary->count );

		// Check weather or not to display the placeholder.
		if ( false === $thumbnail_src || '' === $thumbnail_src ) {
			$thumbnail_src = \lsx\legacy\Placeholders::placeholder_url( null, 'tour', $size );
		}

		return $thumbnail_src;
	}
}

/**
 * Resolves an itinerary day's `featured_image` field to a real attachment URL
 * plus its numeric ID, whatever shape the raw submitted/stored value is in.
 *
 * The `featured_image` field (registered in includes/metaboxes/config-tour.php)
 * is a CMB2 `file` type nested in a `group`, so CMB2 normally re-sanitizes its
 * value as a URL on every save via CMB2_Sanitize::file() -> sanitize_and_secure_url().
 * That call chain runs WordPress core's esc_url_raw()/set_url_scheme(), which
 * treat any schemeless string as a bare domain missing its protocol and
 * prefix it with "https://" -- the same behaviour that turns "example.com"
 * typed into a user profile's Website field into "https://example.com". A
 * bare attachment ID such as "945" is not a domain, but core has no way to
 * know that, so on the very next save it silently becomes the non-functional
 * "https://945", however that "945" got there in the first place (a direct
 * postmeta write from an importer, a stale value from before this field's
 * type changed, or any other path that bypassed CMB2's own media-picker JS).
 *
 * This is called from lsx_to_sanitize_itinerary_featured_image() below in
 * place of CMB2's default sanitizer, so every save resolves whatever is
 * there -- correct, bare-ID, or already-corrupted -- to a working URL and ID
 * pair instead of re-corrupting or perpetuating it.
 *
 * @since 2.3.0
 *
 * @param string $raw_value The field's own submitted/stored value.
 * @param string $raw_id    The value of its companion `_id` hidden input,
 *                           i.e. what CMB2's own media-picker JS
 *                           (CMB2_Type_File::render(), cmb2.js
 *                           handlers.single) sets when a user actually
 *                           picks an image through "Add or Upload File".
 *                           Empty when the field's value arrived by any
 *                           other path.
 * @return array{url: string, id: string} Both empty when neither value
 *                           resolves to an attachment that still exists.
 */
function lsx_to_resolve_itinerary_featured_image( string $raw_value, string $raw_id ): array {
	// The companion hidden field takes priority: when it is populated, a
	// human picked this image through the media modal in this very save, so
	// it is already known-good and there is nothing to resolve.
	if ( ctype_digit( $raw_id ) && (int) $raw_id > 0 ) {
		$url = wp_get_attachment_url( (int) $raw_id );

		if ( ! empty( $url ) ) {
			return array(
				'url' => $url,
				'id'  => $raw_id,
			);
		}
	}

	if ( '' === $raw_value ) {
		return array(
			'url' => '',
			'id'  => '',
		);
	}

	$attachment_id = match ( true ) {
		ctype_digit( $raw_value ) => (int) $raw_value,
		str_starts_with( $raw_value, 'https://' ) && ctype_digit( substr( $raw_value, 8 ) ) => (int) substr( $raw_value, 8 ),
		str_starts_with( $raw_value, 'http://' ) && ctype_digit( substr( $raw_value, 7 ) ) => (int) substr( $raw_value, 7 ),
		default => null,
	};

	if ( null !== $attachment_id ) {
		$url = wp_get_attachment_url( $attachment_id );

		return empty( $url ) ? array(
			'url' => '',
			'id'  => '',
		) : array(
			'url' => $url,
			'id'  => (string) $attachment_id,
		);
	}

	// Already a real URL -- the expected shape. Resolve its attachment ID too,
	// so `featured_image_id` (what lsx_to_itinerary_thumbnail() above reads
	// first, before falling back to the connected destination/accommodation's
	// own image) is finally populated instead of staying permanently empty.
	$resolved_id = attachment_url_to_postid( $raw_value );

	return array(
		'url' => $raw_value,
		'id'  => $resolved_id > 0 ? (string) $resolved_id : '',
	);
}

/**
 * CMB2 `sanitization_cb` for the itinerary `featured_image` field, wired up
 * in includes/metaboxes/config-tour.php.
 *
 * A `sanitization_cb` on a field nested in a CMB2 `group` pre-empts CMB2's
 * own default sanitizer entirely (CMB2_Field::sanitization_cb() checks for a
 * registered callback before ever constructing a CMB2_Sanitize instance),
 * which is what stops CMB2_Sanitize::file()'s URL-sanitization path from
 * running on this field at all. Returning the `supporting_field_id` /
 * `supporting_field_value` shape below is the same contract CMB2's own
 * group-save code (CMB2::save_group_field()) already understands for `file`
 * fields -- every `file`-type field is auto-flagged `has_supporting_data`
 * (see CMB2_Field::set_group_sub_field_defaults()) -- so returning it here
 * correctly writes the companion `featured_image_id` field too, exactly as
 * if CMB2's default handling had produced it.
 *
 * @since 2.3.0
 *
 * @param mixed      $value      The field's raw submitted value.
 * @param array      $field_args CMB2 field argument array (unused; required
 *                                by CMB2's sanitization_cb signature).
 * @param CMB2_Field $field      The CMB2_Field instance for this sub-field.
 * @return array{value: string, supporting_field_id: string, supporting_field_value: string}
 */
function lsx_to_sanitize_itinerary_featured_image( $value, $field_args, $field ) {
	$id_key = 'featured_image_id';
	$raw_id = '';

	if ( $field->group ) {
		$raw_id = $field->group->data_to_save[ $field->group->id() ][ $field->group->index ][ $id_key ] ?? '';
	}

	$resolved = lsx_to_resolve_itinerary_featured_image( (string) $value, (string) $raw_id );

	return array(
		'value'                  => $resolved['url'],
		'supporting_field_id'    => $id_key,
		'supporting_field_value' => $resolved['id'],
	);
}


/**
 * Helper for itinerary connected fields.
 *
 * @param string $field The field key to fetch.
 * @param string $type  The type for lsx_to_connected_list or taxonomy for get_the_term_list.
 * @param string $before
 * @param string $after
 * @param bool   $echo
 * @param bool   $term_list If true, use get_the_term_list instead of lsx_to_connected_list.
 * @return string|null
 */
function lsx_to_itinerary_connected_field( $field, $type, $before = '', $after = '', $echo = true, $term_list = false ) {
	global $tour_itinerary;
	if ( ! $tour_itinerary || empty( $tour_itinerary->has_itinerary ) ) {
		return '';
	}

	if ( $tour_itinerary->count === $tour_itinerary->index ) {
		$data = $tour_itinerary->itineraries[ $tour_itinerary->index - 2 ][ $field ] ?? '';
	} else {
		$data = $tour_itinerary->itinerary[ $field ] ?? '';
	}

	if ( empty( $data ) ) {
		return '';
	}

	$data = (array) $data;

	if ( $term_list ) {
		$first_term = array_values( $data );
		if ( is_array( $first_term ) && ! empty( $first_term ) ) {
			$first_term = $first_term[0];
		}
		$return = get_the_term_list( $first_term, $type, $before, ', ', $after );
	} else {
		$return = $before . lsx_to_connected_list( $data, $type, true, ', ' ) . $after;
	}

	if ( $echo ) {
		echo wp_kses_post( $return );
	}
	return $return;
}

/**
 * Outputs The current Itinerary connected destinations, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_destinations( $before = '', $after = '', $echo = true ) {
	return lsx_to_itinerary_connected_field( 'destination_to_tour', 'destination', $before, $after, $echo );
}

/**
 * Outputs The current Itinerary connected accommodation, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_accommodation( $before = '', $after = '', $echo = true ) {
	return lsx_to_itinerary_connected_field( 'accommodation_to_tour', 'accommodation', $before, $after, $echo );
}

/**
 * Outputs The current Itinerary connected accommodation, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_accommodation_type( $before = '', $after = '', $echo = true ) {
	return lsx_to_itinerary_connected_field( 'accommodation_to_tour', 'accommodation-type', $before, $after, $echo, true );
}

/**
 * Outputs The current Itinerary connected activities, can only be used in the
 * itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_activities( $before = '', $after = '' ) {
	return lsx_to_itinerary_connected_field( 'activity_to_tour', 'activity', $before, $after, true );
}

/**
 * Outputs the 'itinerary' class.
 *
 * @param    $classes string or array
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_class( $classes = false ) {
	global $post;

	if ( false !== $classes ) {
		if ( ! is_array( $classes ) ) {
			$classes = explode( ' ', $classes );
		}

		$classes = apply_filters( 'lsx_to_itinerary_class', $classes, $post->ID );
	}

	echo 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
}


/**
 * Outputs the 'read more' button if needed.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_read_more() {
	if ( lsx_to_itinerary_needs_read_more() ) {
		?>
		<div class="view-more text-center lsx-to-section-view-all">
			<a href="#" class="btn border-btn"><?php esc_html_e( 'Read More', 'tour-operator' ); ?></a>
		</div>
		<?php
	}
}

/**
 * checks if the read more should be outputted
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_needs_read_more() {
	return apply_filters( 'lsx_itinerary_needs_read_more', false );
}

/**
 * Gets the days included field
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_includes( $before = '', $after = '', $echo = true ) {
	global $tour_itinerary;
	$html = '';
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['included'] ) ) {
			$html = $before . $tour_itinerary->itinerary['included'] . $after;
		}
	}
	if ( true === $echo ) {
		echo wp_kses_post( $html );
	} else {
		return $html;
	}
}

/**
 * Gets the days excluded field
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_excludes( $before = '', $after = '', $echo = true ) {
	global $tour_itinerary;
	$html = '';
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['excluded'] ) ) {
			$html = $before . $tour_itinerary->itinerary['excluded'] . $after;
		}
	}
	if ( true === $echo ) {
		echo wp_kses_post( $html );
	} else {
		return $html;
	}
}

/**
 * Outputs The current Itinerary title, can only be used in the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_count( $echo = true ) {
	global $tour_itinerary;
	$count = 0;
	if ( $tour_itinerary && isset( $tour_itinerary->count ) && ! empty( $tour_itinerary->count ) ) {
		$count = $tour_itinerary->count;
	}
	if ( true === $echo ) {
		echo wp_kses_post( $count );
	} else {
		return $count;
	}
}

/**
 * Checks if the current accommodation has rooms
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      accommodation
 */
function lsx_to_accommodation_has_rooms() {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$have_rooms = false;
	if ( null === $rooms ) {
		$rooms = new \lsx\legacy\Unit_Query();
	}
	if ( is_object( $rooms ) ) {
		$have_rooms = $rooms->have_query();
	}
	return $have_rooms;
}

/**
 * Runs the current room loop, used in a "while" statement
 * e.g  while(lsx_to_accommodation_room_loop())
 * {lsx_to_accommodation_room_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_loop() {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	if ( is_object( $rooms ) ) {
		return $rooms->while_query();
	} else {
		return false;
	}
}

/**
 * Sets up the current room
 * e.g  while(lsx_to_accommodation_room_loop())
 * {lsx_to_accommodation_room_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_loop_item( $type = false ) {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	if ( is_object( $rooms ) ) {
		return $rooms->current_queried_item( $type );
	} else {
		return false;
	}
}

/**
 * Outputs The current Rooms title
 *
 * @param        $before | string
 * @param        $after  | string
 * @param        $echo   | boolean
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_title( $before = '', $after = '', $echo = true ) {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	if ( is_object( $rooms ) ) {
		$rooms->item_title( $before, $after, $echo );
	}
}

/**
 * Outputs The current Rooms Description
 *
 * @param        $before | string
 * @param        $after  | string
 * @param        $echo   | boolean
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_description( $before = '', $after = '', $echo = true ) {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	if ( is_object( $rooms ) ) {
		$rooms->item_description( $before, $after, $echo );
	}
}

/**
 * Checks if the current room item has a thumbnail.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_has_thumbnail() {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	if ( $rooms && $rooms->have_query ) {
		return true;
	}
}

/**
 * Checks if the current type has units.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_check_type( $type = false ) {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	return $rooms->check_type( $type );
}

/**
 * Resets the loop
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_reset_units_loop() {
	global $rooms; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	return $rooms->reset_loop();
}

/**
 * Sanitizes a tour title for safe output and storage.
 *
 * @since 2.1.0
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      tour
 *
 * @param string $title The tour title to sanitize.
 * @return string The sanitized tour title.
 */
function lsx_to_sanitize_tour_title( $title = '' ) {
	if ( empty( $title ) || ! is_string( $title ) ) {
		return '';
	}

	$sanitized_title = sanitize_text_field( $title );

	/**
	 * Filters the sanitized tour title.
	 *
	 * @since 2.1.0
	 *
	 * @param string $sanitized_title The sanitized title.
	 * @param string $title           The original title.
	 */
	return apply_filters( 'lsx_to_sanitize_tour_title', $sanitized_title, $title );
}

/**
 * Get SVG icon content from the icons library.
 *
 * Retrieves an SVG icon from the Tour Operator icons block source directory.
 * The SVG is sanitized using wp_kses with allowed SVG elements and attributes.
 *
 * @since 2.1.0
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      icons
 *
 * @param string $icon_type The icon type/category (e.g., 'outline', 'solid').
 * @param string $icon_name The icon name in camelCase format (e.g., 'priceIcon').
 * @return string The sanitized SVG content, or empty string if not found.
 */
function lsx_to_get_icon_svg( $icon_type = 'outline', $icon_name = '' ) {
	if ( empty( $icon_name ) ) {
		return '';
	}

	// Convert camelCase icon name to kebab-case file name.
	$file_name = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $icon_name ) );

	// Build the path to the SVG file. The icons are copied into the build directory
	// so they survive packaging -- /src is excluded from the distributed plugin by .distignore.
	$svg_path = LSX_TO_PATH . 'build/blocks/icons/source-icons/' . $icon_type . '/' . $file_name . '.svg';

	// Fall back to the source directory for development installs running from an unbuilt checkout.
	if ( ! file_exists( $svg_path ) ) {
		$svg_path = LSX_TO_PATH . 'src/blocks/icons/source-icons/' . $icon_type . '/' . $file_name . '.svg';
	}

	// Check if the file exists.
	if ( ! file_exists( $svg_path ) ) {
		return '';
	}

	// Get the SVG content.
	$svg_content = file_get_contents( $svg_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

	if ( empty( $svg_content ) ) {
		return '';
	}

	// Sanitize the SVG content.
	$allowed_svg_tags = array(
		'svg'      => array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true,
			'fill'            => true,
		),
		'g'        => array(
			'fill'      => true,
			'clip-path' => true,
		),
		'title'    => array(
			'title' => true,
		),
		'path'     => array(
			'd'               => true,
			'fill'            => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'stroke-linecap'  => true,
			'stroke-linejoin' => true,
			'fill-rule'       => true,
			'clip-rule'       => true,
		),
		'circle'   => array(
			'cx'     => true,
			'cy'     => true,
			'r'      => true,
			'fill'   => true,
			'stroke' => true,
		),
		'rect'     => array(
			'x'         => true,
			'y'         => true,
			'width'     => true,
			'height'    => true,
			'fill'      => true,
			'stroke'    => true,
			'rx'        => true,
			'ry'        => true,
			'transform' => true,
		),
		'line'     => array(
			'x1'           => true,
			'y1'           => true,
			'x2'           => true,
			'y2'           => true,
			'stroke'       => true,
			'stroke-width' => true,
		),
		'polygon'  => array(
			'points' => true,
			'fill'   => true,
			'stroke' => true,
		),
		'polyline' => array(
			'points' => true,
			'fill'   => true,
			'stroke' => true,
		),
		'defs'     => array(),
		'clippath' => array(
			'id' => true,
		),
	);

	$svg_content = wp_kses( $svg_content, $allowed_svg_tags );

	/**
	 * Filters the SVG icon content.
	 *
	 * @since 2.1.0
	 *
	 * @param string $svg_content The SVG content.
	 * @param string $icon_type   The icon type.
	 * @param string $icon_name   The icon name.
	 */
	return apply_filters( 'lsx_to_icon_svg', $svg_content, $icon_type, $icon_name );
}
