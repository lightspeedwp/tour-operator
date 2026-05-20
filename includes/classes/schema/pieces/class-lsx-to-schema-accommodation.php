<?php
/**
 * Accommodation Schema Graph Piece
 *
 * Outputs schema.org Accommodation markup for the `accommodation` post type.
 * When Yoast SEO is active the class is registered as a graph piece via the
 * Yoast adapter in class-schema.php. When Yoast is inactive the standalone
 * fallback calls `generate()` directly.
 *
 * Fields mapped (per implementation plan):
 *   name, description, url, mainEntityOfPage, image, slogan (tagline),
 *   numberOfRooms, checkinTime, checkoutTime, availableLanguage (Language[]),
 *   starRating (only for official ratings: TGCSA / Hotelstars Union),
 *   containedInPlace → destination_to_accommodation,
 *   address + geo → location meta,
 *   offers → Offer (price, sale_price, priceCurrency, priceSpecification),
 *   additionalProperty → single_supplement, best_time_to_visit,
 *                         minimum_child_age, suggested_visitor_types,
 *                         special_interests.
 *
 * @package    Tour_Operator
 * @subpackage Schema
 * @since      2.2.0
 */

namespace lsx\schema\pieces;

use lsx\schema\Helpers;

/**
 * Generates schema.org Accommodation data for a single accommodation.
 */
class Accommodation {

	/**
	 * Yoast Schema Context (null when Yoast is not active).
	 *
	 * @var \WPSEO_Schema_Context|null
	 */
	protected $context;

	/**
	 * Post ID being processed.
	 *
	 * @var int
	 */
	protected $post_id;

	/**
	 * Post object being processed.
	 *
	 * @var \WP_Post|null
	 */
	protected $post;

	/**
	 * Canonical URL for the current post.
	 *
	 * @var string
	 */
	protected $canonical;

	/**
	 * Official rating classification system slugs.
	 *
	 * Only these types map to schema.org `starRating`; user-generated or
	 * unspecified ratings are intentionally excluded to prevent misleading
	 * structured data. Use the `lsx_to_official_rating_types` filter to add
	 * further official classification systems.
	 *
	 * @var string[]
	 */
	const OFFICIAL_RATING_TYPES = array( 'tgcsa', 'hotelstars_union' );
	public function __construct( $context = null ) {
		$this->context   = $context;
		$this->post_id   = ( null !== $context ) ? (int) $context->id : (int) get_the_ID();
		$this->post      = get_post( $this->post_id );
		$this->canonical = (string) get_permalink( $this->post_id );
	}

	/**
	 * Determines whether this piece should be added to the graph.
	 *
	 * @return bool
	 */
	public function is_needed() {
		return is_singular( 'accommodation' );
	}

	/**
	 * Generates and returns the Accommodation schema data array.
	 *
	 * @return array Schema.org Accommodation data.
	 */
	public function generate() {
		$data = array(
			'@type'            => 'Accommodation',
			'@id'              => $this->canonical . '#/schema/accommodation/' . $this->post_id,
			'name'             => get_the_title( $this->post_id ),
			'url'              => $this->canonical,
			'mainEntityOfPage' => array( '@id' => $this->canonical ),
		);

		// Description: prefer excerpt over stripped post content.
		$description = $this->get_description();
		if ( '' !== $description ) {
			$data['description'] = $description;
		}

		// Tagline → slogan.
		$tagline = Helpers::get_meta( $this->post_id, 'tagline' );
		if ( '' !== $tagline ) {
			$data['slogan'] = sanitize_text_field( $tagline );
		}

		// Image.
		$data = $this->add_image( $data );

		// numberOfRooms.
		$rooms = (int) Helpers::get_meta( $this->post_id, 'number_of_rooms' );
		if ( $rooms > 0 ) {
			$data['numberOfRooms'] = $rooms;
		}

		// Check-in / check-out times.
		$checkin  = Helpers::format_time( Helpers::get_meta( $this->post_id, 'checkin_time' ) );
		$checkout = Helpers::format_time( Helpers::get_meta( $this->post_id, 'checkout_time' ) );
		if ( '' !== $checkin ) {
			$data['checkinTime'] = $checkin;
		}
		if ( '' !== $checkout ) {
			$data['checkoutTime'] = $checkout;
		}

		// Available languages.
		$data = $this->add_languages( $data );

		// Star rating (official ratings only).
		$data = $this->add_star_rating( $data );

		// Address and geo coordinates.
		$data = $this->add_location( $data );

		// Contained in (related destinations).
		$data = $this->add_contained_in( $data );

		// Offers.
		$data = $this->add_offers( $data );

		// Additional properties.
		$data = $this->add_additional_properties( $data );

		/**
		 * Filter the complete Accommodation schema data array.
		 *
		 * @param array $data    Accommodation schema data.
		 * @param int   $post_id Current accommodation post ID.
		 */
		return (array) apply_filters( 'lsx_to_schema_accommodation_data', $data, $this->post_id );
	}

	// -------------------------------------------------------------------------
	// Private helpers
	// -------------------------------------------------------------------------

	/**
	 * Get post description.
	 *
	 * @return string Plain-text description.
	 */
	protected function get_description() {
		if ( ! is_object( $this->post ) ) {
			return '';
		}
		if ( '' !== $this->post->post_excerpt ) {
			return Helpers::strip_to_text( $this->post->post_excerpt );
		}
		$content = apply_filters( 'the_content', $this->post->post_content );
		return Helpers::strip_to_text( $content );
	}

	/**
	 * Add image from Yoast context or featured image fallback.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_image( array $data ) {
		if ( null !== $this->context && $this->context->has_image && defined( 'WPSEO_Schema_IDs::PRIMARY_IMAGE_HASH' ) ) {
			$data['image'] = array( '@id' => $this->canonical . \WPSEO_Schema_IDs::PRIMARY_IMAGE_HASH );
		} else {
			$thumbnail_url = get_the_post_thumbnail_url( $this->post_id, 'large' );
			if ( $thumbnail_url ) {
				$data['image'] = esc_url( $thumbnail_url );
			}
		}
		return $data;
	}

	/**
	 * Add availableLanguage from the spoken_languages multiselect field.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_languages( array $data ) {
		$languages = Helpers::get_meta_array( $this->post_id, 'spoken_languages' );
		if ( empty( $languages ) ) {
			return $data;
		}

		$nodes = array();
		foreach ( $languages as $lang ) {
			$label = sanitize_text_field( (string) $lang );
			if ( '' !== $label ) {
				$nodes[] = array(
					'@type' => 'Language',
					'name'  => ucfirst( $label ),
				);
			}
		}

		if ( ! empty( $nodes ) ) {
			$data['availableLanguage'] = $nodes;
		}

		return $data;
	}

	/**
	 * Add starRating for official accommodation ratings only.
	 *
	 * Only outputs `starRating` when `rating_type` is one of the recognised
	 * official classification systems (TGCSA, Hotelstars Union). An unspecified
	 * or user-review rating is NOT mapped to `starRating` to avoid misleading
	 * structured data.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_star_rating( array $data ) {
		$rating      = Helpers::get_meta( $this->post_id, 'rating' );
		$rating_type = Helpers::get_meta( $this->post_id, 'rating_type' );

		/**
		 * Filter the list of official rating type slugs that map to starRating.
		 *
		 * @param string[] $types Official rating type slugs.
		 */
		$official_types = (array) apply_filters( 'lsx_to_official_rating_types', self::OFFICIAL_RATING_TYPES );

		if ( '' === $rating || '0' === $rating || ! in_array( $rating_type, $official_types, true ) ) {
			return $data;
		}

		$data['starRating'] = array(
			'@type'       => 'Rating',
			'ratingValue' => (int) $rating,
			'bestRating'  => 5,
			'worstRating' => 1,
		);

		return $data;
	}

	/**
	 * Add address and geo coordinates from the `location` pw_map field.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_location( array $data ) {
		$location = get_post_meta( $this->post_id, 'location', true );
		if ( ! is_array( $location ) || empty( $location ) ) {
			return $data;
		}

		if ( ! empty( $location['address'] ) ) {
			$data['address'] = sanitize_text_field( $location['address'] );
		}

		if ( ! empty( $location['latitude'] ) && ! empty( $location['longitude'] ) ) {
			$data['geo'] = array(
				'@type'     => 'GeoCoordinates',
				'latitude'  => (float) $location['latitude'],
				'longitude' => (float) $location['longitude'],
			);
		}

		return $data;
	}

	/**
	 * Add containedInPlace from destination_to_accommodation relationship field.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_contained_in( array $data ) {
		$dest_ids = Helpers::get_meta_array( $this->post_id, 'destination_to_accommodation' );
		if ( empty( $dest_ids ) ) {
			return $data;
		}

		$places = array();
		foreach ( $dest_ids as $dest_id ) {
			$dest_id = (int) $dest_id;
			if ( $dest_id > 0 && get_post( $dest_id ) ) {
				$places[] = array(
					'@type' => 'TouristDestination',
					'name'  => get_the_title( $dest_id ),
					'url'   => get_permalink( $dest_id ),
				);
			}
		}

		if ( ! empty( $places ) ) {
			$data['containedInPlace'] = ( 1 === count( $places ) ) ? $places[0] : $places;
		}

		return $data;
	}

	/**
	 * Build Offer node for price, sale_price, and price_type.
	 *
	 * The price_type label is mapped to a PriceSpecification description so
	 * humans and search engines understand the pricing model (e.g. "Per Person
	 * Sharing Per Night").
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_offers( array $data ) {
		$price      = Helpers::get_meta( $this->post_id, 'price' );
		$sale_price = Helpers::get_meta( $this->post_id, 'sale_price' );
		$price_type = Helpers::get_meta( $this->post_id, 'price_type' );
		$currency   = Helpers::get_currency();

		$active_price = Helpers::normalise_price( '' !== $sale_price ? $sale_price : $price );
		if ( '' === $active_price ) {
			return $data;
		}

		$offer = array(
			'@type'         => 'Offer',
			'price'         => $active_price,
			'priceCurrency' => $currency,
		);

		// Human-readable price type as PriceSpecification.
		if ( '' !== $price_type && 'none' !== $price_type && function_exists( 'lsx_to_get_price_type_label' ) ) {
			$label = lsx_to_get_price_type_label( $price_type );
			if ( '' !== $label ) {
				$offer['priceSpecification'] = array(
					'@type'       => 'PriceSpecification',
					'description' => $label,
				);
			}
		}

		$data['offers'] = $offer;
		return $data;
	}

	/**
	 * Append additionalProperty nodes for tourism-specific fields.
	 *
	 * Fields: single_supplement, best_time_to_visit, minimum_child_age,
	 * suggested_visitor_types, special_interests.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_additional_properties( array $data ) {
		$properties = array();

		// Single supplement.
		$supplement = Helpers::normalise_price( Helpers::get_meta( $this->post_id, 'single_supplement' ) );
		if ( '' !== $supplement ) {
			$currency     = Helpers::get_currency();
			$properties[] = Helpers::make_property_value( 'Single supplement', $currency . ' ' . $supplement );
		}

		// Best time to visit.
		$best_time_slugs = Helpers::get_meta_array( $this->post_id, 'best_time_to_visit' );
		if ( ! empty( $best_time_slugs ) ) {
			$labels = Helpers::month_slugs_to_labels( $best_time_slugs );
			if ( '' !== $labels ) {
				$properties[] = Helpers::make_property_value( 'Best time to visit', $labels );
			}
		}

		// Minimum child age.
		$min_child_age = Helpers::get_meta( $this->post_id, 'minimum_child_age' );
		if ( '' !== $min_child_age ) {
			$properties[] = Helpers::make_property_value( 'Minimum child age', sanitize_text_field( $min_child_age ) );
		}

		// Suggested visitor types (multiselect – sanitise each value).
		$visitor_types = Helpers::get_meta_array( $this->post_id, 'suggested_visitor_types' );
		$visitor_types = array_filter(
			$visitor_types,
			static function ( $v ) {
				return '' !== $v;
			}
		);
		if ( ! empty( $visitor_types ) ) {
			$properties[] = Helpers::make_property_value(
				'Suitable for',
				implode( ', ', array_map( 'sanitize_text_field', $visitor_types ) )
			);
		}

		// Special interests (multiselect).
		$interests = Helpers::get_meta_array( $this->post_id, 'special_interests' );
		$interests = array_filter(
			$interests,
			static function ( $v ) {
				return '' !== $v;
			}
		);
		if ( ! empty( $interests ) ) {
			$properties[] = Helpers::make_property_value(
				'Special interests',
				implode( ', ', array_map( 'sanitize_text_field', $interests ) )
			);
		}

		if ( ! empty( $properties ) ) {
			$data['additionalProperty'] = $properties;
		}

		return $data;
	}
}
