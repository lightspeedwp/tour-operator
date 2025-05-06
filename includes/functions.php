<?php
/**
 * Tour Operator Helper Functions
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @copyright 2017 LightSpeed
 */

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
	
	if ( isset( $tour_operator->options['tour']['itinerary_use_destination_images'] ) && '' !== $tour_operator->options['tour']['itinerary_use_destination_images'] ) {
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
				$temp_src_array   = wp_get_attachment_image_src( $temp_id, $size );
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
 * Outputs The current Itinerary connected destinations, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_destinations( $before = '', $after = '', $echo = true ) {
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) && ! empty( $tour_itinerary->itinerary['destination_to_tour'] ) ) {
		$itinerary_destinations = $tour_itinerary->itinerary['destination_to_tour'];
		if ( ! is_array( $itinerary_destinations ) ) {
			$itinerary_destinations = array( $itinerary_destinations );
		}
		$itinerary_destinations = $before . lsx_to_connected_list( $itinerary_destinations, 'destination', true, ', ' ) . $after;

		if ( true === $echo ) {
			echo wp_kses_post( $itinerary_destinations );
		} else {
			return $itinerary_destinations;
		}	
	}
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
	global $tour_itinerary;
	$return = '';

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) && ! empty( $tour_itinerary->itinerary['accommodation_to_tour'] ) ) {
		$itinerary_accommodation = $tour_itinerary->itinerary['accommodation_to_tour'];
		if ( ! is_array( $itinerary_accommodation ) ) {
			$itinerary_accommodation = array( $itinerary_accommodation );
		}
		$return = $before . lsx_to_connected_list( $itinerary_accommodation, 'accommodation', true, ', ' ) . $after;
		if ( true === $echo ) {
			echo wp_kses_post( $return );
		}
	}
	return $return;
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
	global $tour_itinerary;
	$return = '';

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) && ! empty( $tour_itinerary->itinerary['accommodation_to_tour'] ) ) {
		$itinerary_accommodation = $tour_itinerary->itinerary['accommodation_to_tour'];
		if ( ! is_array( $itinerary_accommodation ) ) {
			$itinerary_accommodation = array( $itinerary_accommodation );
		}
		$return = get_the_term_list( $itinerary_accommodation[0], 'accommodation-type', $before, ', ', $after );
		if ( true === $echo ) {
			echo wp_kses_post( $return );
		}
	}
	return $return;
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
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['activity_to_tour'] ) && is_array( $tour_itinerary->itinerary['activity_to_tour'] ) ) {
			echo wp_kses_post( $before . lsx_to_connected_list( $tour_itinerary->itinerary['activity_to_tour'], 'activity', true, ', ' ) . $after );
		}
	}
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
	global $rooms;
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
	global $rooms;
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
	global $rooms;
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
	global $rooms;
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
	global $rooms;
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
	global $rooms;
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
	global $rooms;
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
	global $rooms;
	return $rooms->reset_loop();
}
