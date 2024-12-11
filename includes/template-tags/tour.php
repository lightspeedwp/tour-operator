<?php
/**
 * Template Tags
 *
 * @package         tour-operator
 * @subpackage      template-tags
 * @category        tour
 * @license         GPL3
 */

/**
 * Gets the current tours price
 *
 * @param       $before | string
 * @param       $after  | string
 * @param       $echo   | boolean
 * @return      string
 *
 * @package     tour-operator
 * @subpackage  template-tags
 * @category    tour
 */
function lsx_to_price( $before = '', $after = '', $echo = true ) {
	lsx_to_custom_field_query( 'price', $before, $after, $echo );
}

/**
 * Gets the current tours duration
 *
 * @param       $before | string
 * @param       $after  | string
 * @param       $echo   | boolean
 * @return      string
 *
 * @package     tour-operator
 * @subpackage  template-tags
 * @category    tour
 */
function lsx_to_duration( $before = '', $after = '', $echo = true ) {
	lsx_to_custom_field_query( 'duration', $before, $after, $echo );
}

/**
 * Gets the current tours included pricing field
 *
 * @param       $before | string
 * @param       $after  | string
 * @param       $echo   | boolean
 * @return      string
 *
 * @package     tour-operator
 * @subpackage  template-tags
 * @category    tour
 */
function lsx_to_included( $before = '', $after = '', $echo = true ) {
	return lsx_to_custom_field_query( 'included', $before, $after, $echo );
}

/**
 * Gets the current tours not included pricing field
 *
 * @param       $before | string
 * @param       $after  | string
 * @param       $echo   | boolean
 * @return      string
 *
 * @package     tour-operator
 * @subpackage  template-tags
 * @category    tour
 */
function lsx_to_not_included( $before = '', $after = '', $echo = true ) {
	return lsx_to_custom_field_query( 'not_included', $before, $after, $echo );
}

/**
 * Gets the current tours departure points
 *
 * @param       $before | string
 * @param       $after  | string
 * @param       $echo   | boolean
 * @return      string
 *
 * @package     tour-operator
 * @subpackage  template-tags
 * @category    tour
 */
function lsx_to_departure_point( $before = '', $after = '', $echo = true ) {
	$departs_from = get_post_meta( get_the_ID(), 'departs_from', false );

	$options = get_option( '_lsx-to_settings', false );
	if ( ! empty( $departs_from ) && is_array( $departs_from ) && count( $departs_from ) > 0 ) {
		$connected_list = lsx_to_connected_list( $departs_from, 'destination', true, ', ' );
		if ( false !== $options && isset( $options[ 'destination' ] ) && isset( $options[ 'destination' ]['disable_single_region'] ) ) {
			$connected_list = strip_tags( $connected_list );
		}
		$return = $before . $connected_list . $after;

		if ( $echo ) {
			echo wp_kses_post( $return );
		} else {
			return $return;
		}
	}
}

/**
 * Gets the current tours end points
 *
 * @param       $before | string
 * @param       $after  | string
 * @param       $echo   | boolean
 * @return      string
 *
 * @package     tour-operator
 * @subpackage  template-tags
 * @category    tour
 */
function lsx_to_end_point( $before = '', $after = '', $echo = true ) {
	$end_point = get_post_meta( get_the_ID(), 'ends_in', false );
	$options   = get_option( '_lsx-to_settings', false );

	if ( ! empty( $end_point ) && is_array( $end_point ) && count( $end_point ) > 0 ) {
		$connected_list = lsx_to_connected_list( $end_point, 'destination', true, ', ' );
		if ( false !== $options && isset( $options[ 'destination' ] ) && isset( $options[ 'destination' ]['disable_single_region'] ) ) {
			$connected_list = strip_tags( $connected_list );
		}
		$return = $before . $connected_list . $after;

		if ( $echo ) {
			echo wp_kses_post( $return );
		} else {
			return $return;
		}
	}
}

/**
 * Retrieves the accommodation ids from the itinerary, mostly for use in the map.
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 *
 * @param string $meta_key
 * @param string $supress_filters
 * @return array
 */
function lsx_to_get_tour_itinerary_ids( $meta_key = 'accommodation_to_tour', $supress_filters = false ) {
	$tour_itinerary = new \lsx\legacy\Itinerary_Query();
	$itinerary_ids  = array();

	if ( false === $supress_filters ) {
		$meta_key = apply_filters( 'lsx_to_get_itinerary_ids_meta_key', $meta_key );
	}
	
	if ( $tour_itinerary->has_itinerary() ) {
		$itinerary_count = 1;
		while ( $tour_itinerary->while_itinerary() ) {
			$tour_itinerary->current_itinerary_item();

			if ( ! empty( $tour_itinerary->itinerary[ $meta_key ] ) && '' !== $tour_itinerary->itinerary[ $meta_key] ) {
				if ( ! is_array( $tour_itinerary->itinerary[ $meta_key ] ) ) {
					$d_ids = array( $tour_itinerary->itinerary[ $meta_key ] );
				} else {
					$d_ids = $tour_itinerary->itinerary[ $meta_key ];
				}
				$itinerary_ids = array_merge( $itinerary_ids, array_values( $d_ids ) );
			}
		}
	}
	return $itinerary_ids;
}
