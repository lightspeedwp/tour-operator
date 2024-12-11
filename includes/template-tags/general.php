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

// =============== Itinerary ===================

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


// =============== Tours ===================

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

// ==============  Accommodation ================
/**
 * Outputs the accommodations facilities
 *
 * @param       $before | string
 * @param       $after  | string
 * @param       $echo   | boolean
 * @return      string
 *
 * @package     tour-operator
 * @subpackage  template-tags
 * @category    accommodation
 */
function lsx_to_accommodation_facilities( $before = '', $after = '', $echo = true ) {
	$args             = [];
	$facilities       = wp_get_object_terms( get_the_ID(), 'facility' );
	$main_facilities  = [];
	$child_facilities = [];
	$return           = '';

	if ( ! empty( $facilities ) && ! is_wp_error( $facilities ) ) {
		foreach ( $facilities as $facility ) {
			if ( 0 === $facility->parent ) {
				$main_facilities[] = $facility;
			} else {
				$child_facilities[ $facility->parent ][] = $facility;
			}
		}

		//Output in the order we want
		if ( count( $main_facilities ) > 0 && count( $child_facilities ) > 0 ) {
			$return .= '<div class="' . $heading->slug . ' wp-block-columns is-layout-flex wp-block-columns-is-layout-flex">';
			foreach ( $main_facilities as $heading ) {
				if ( isset( $child_facilities[ $heading->term_id ] ) ) {
					$return .= '<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
					<p class="has-medium-font-size facilities-title wp-block-heading"><a href="' . esc_url( get_term_link( $heading->slug, 'facility' ) ) . '">' . esc_html( $heading->name ) . '</a></h5>';
					$return .= '<ul class="facilities-list wp-block-list">';

					foreach ( $child_facilities[ $heading->term_id ] as $child_facility ) {
						$return .= '<li class="facility-item"><a href="' . esc_url( get_term_link( $child_facility->slug, 'facility' ) ) . '">' . esc_html( $child_facility->name ) . '</a></li>';
					}

					$return .= '</ul>';
					$return .= '</div>';
				}
			}
			$return .= '</div>';

			if ( ! empty( $return ) ) {
				$return = $before . $return . $after;

				if ( $echo ) {
					echo wp_kses_post( $return );
				} else {
					return $return;
				}
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}
