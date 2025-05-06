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
 * Returns the Drinks basis labels.
 *
 * @return void
 */
function lsx_to_get_room_basis_options() {
	return [
		'None'                                 => esc_html__( 'None', 'tour-operator' ),
		'BedAndBreakfast'                      => esc_html__( 'B&amp;B: Bed and Breakfast', 'tour-operator' ),
		'RoomOnly'                             => esc_html__( 'Room Only', 'tour-operator' ),
		'SelfCatering'                         => esc_html__( 'Self Catering', 'tour-operator' ),
		'Lunch'                                => esc_html__( 'Lunch', 'tour-operator' ),
		'Dinner'                               => esc_html__( 'Dinner', 'tour-operator' ),
		'LunchAndDinner'                       => esc_html__( 'Lunch and Dinner', 'tour-operator' ),
		'BedBreakfastAndLunch'                 => esc_html__( 'Bed, Breakfast and Lunch', 'tour-operator' ),
		'DinnerBedAndBreakfast'                => esc_html__( 'Dinner, Bed and Breakfast', 'tour-operator' ),
		'HalfBoard'                            => esc_html__( 'Half Board - Dinner, Bed and Breakfast', 'tour-operator' ),
		'DinnerBedBreakfastAndActivities'      => esc_html__( 'Half Board Plus - Dinner, Bed, Breakfast and Activities', 'tour-operator' ),
		'DinnerBedBreakfastAndLunch'           => esc_html__( 'Full Board - Dinner, Bed, Breakfast and Lunch', 'tour-operator' ),
		'DinnerBedBreakfastLunchAndActivities' => esc_html__( 'Full Board Plus -  Dinner, Bed, Breakfast, Lunch and Activities', 'tour-operator' ),
		'AllInclusiveBedAndAllMeals'           => esc_html__( 'All Inclusive - Bed and All Meals', 'tour-operator' ),
		'FullyInclusive'                       => esc_html__( 'Fully Inclusive - Bed, All Meals, Fees and Activities', 'tour-operator' ),
		'ExclusiveClubPremierBenefits'         => esc_html__( 'Premier - Executive Club / Premier Benefits', 'tour-operator' ),
		'Camping'                              => esc_html__( 'Camping', 'tour-operator' ),
		'CateredCamping'                       => esc_html__( 'Catered Camping', 'tour-operator' ),
	];
}

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
	$label   = $index;
	$options = lsx_to_get_room_basis_options();
	if ( isset( $options[ $index ] ) ) {
		$label = $options[ $index ];
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

/**
 * Return the Drinks basis Label.
 *
 * @param string $index
 * @return string
 */
function lsx_to_drinks_basis_label( $index = '' ) {
	$label   = $index;
	$options = lsx_to_get_drink_basis_options();
	if ( isset( $options[ $index ] ) ) {
		$label = $options[ $index ];
	}
	return $label;
}

function lsx_to_get_drink_basis_options() {
	return [
		'None'                => esc_html__( 'None', 'tour-operator' ),
		'TeaCoffee'           => esc_html__( 'Tea and Coffee Only', 'tour-operator' ),
		'DrinksSoft'          => esc_html__( 'Tea, Coffee and Soft Drinks Only', 'tour-operator' ),
		'DrinksLocalBrands'   => esc_html__( 'All Local Brands (Spirits, Wine and Beers)', 'tour-operator' ),
		'DrinksExclSpirits'   => esc_html__( 'All Local Brands (excl Spirits)', 'tour-operator' ),
		'DrinksExclChampagne' => esc_html__( 'All Drinks (excl Champagne)', 'tour-operator' ),
		'DrinksExclPremium'   => esc_html__( 'All Drinks (excl Premium Brands)', 'tour-operator' ),
		'AllDrinks'           => esc_html__( 'All Drinks', 'tour-operator' ),
	];
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
