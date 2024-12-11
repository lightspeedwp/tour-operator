<?php
/**
 * Template Tags
 *
 * @package         tour-operator
 * @subpackage      template-tags
 * @category        general
 * @license         GPL3
 */

/**
 * Used Functions
 */ 

/**
 * Outputs The current Itinerary connected destinations, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_room_basis( $before = '', $after = '', $echo = true ) {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['room_basis'] ) && 'None' !== $tour_itinerary->itinerary['room_basis'] ) {
			$label = lsx_to_room_basis_label( $tour_itinerary->itinerary['room_basis'] );
			if ( $echo ) {
				echo wp_kses_post( $before . $label . $after );
			} else {
				return $before . $label . $after;
			}
		}
	}
	return '';
}

/**
 * Return the Room basis Label.
 *
 * @param string $index
 * @return string
 */
function lsx_to_room_basis_label( $index = '' ) {
	$label = $index;
	if ( isset( tour_operator()->legacy->tour->room_basis[ $index ] ) ) {
		$label = tour_operator()->legacy->tour->room_basis[ $index ];
	}
	return $label;
}

/**
 * Return the Drinks basis Label.
 *
 * @param string $index
 * @return string
 */
function lsx_to_drinks_basis_label( $index = '' ) {
	$label = $index;
	if ( isset( tour_operator()->legacy->tour->drinks_basis[ $index ] ) ) {
		$label = tour_operator()->legacy->tour->drinks_basis[ $index ];
	}
	return $label;
}

/**
 * Outputs The current Itinerary connected destinations, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_drinks_basis( $before = '', $after = '', $echo = true ) {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && ! empty( $tour_itinerary->itinerary ) ) {
		if ( ! empty( $tour_itinerary->itinerary['drinks_basis'] ) && 'None' !== $tour_itinerary->itinerary['drinks_basis'] ) {
			$label = lsx_to_drinks_basis_label( $tour_itinerary->itinerary['drinks_basis'] );
			if ( $echo ) {
				echo wp_kses_post( $before . $label . $after );
			} else {
				return $before . $label . $after;
			}
		}
	}
	return '';
}
