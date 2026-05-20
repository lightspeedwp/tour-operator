<?php
/**
 * Trip Schema Graph Piece
 *
 * Outputs schema.org Trip markup for the `tour` post type. When Yoast SEO is
 * active the class is registered as a graph piece via the Yoast adapter in
 * class-schema.php. When Yoast is inactive the standalone fallback in the same
 * file calls `generate()` directly and prints a JSON-LD script tag.
 *
 * Fields mapped (per implementation plan):
 *   name, description, url, mainEntityOfPage, image, slogan (tagline),
 *   duration → ISO 8601 or additionalProperty, fromLocation (departs_from),
 *   toLocation (ends_in), provider (Yoast site_represents_reference),
 *   offers → Offer (price, sale_price, priceCurrency, availabilityStarts,
 *                    availabilityEnds),
 *   subTrip → itinerary day list,
 *   additionalProperty → single_supplement, best_time_to_visit, group_size,
 *                         highlights, included, not_included.
 *
 * @package    Tour_Operator
 * @subpackage Schema
 * @since      2.2.0
 */

namespace lsx\schema\pieces;

use lsx\schema\Helpers;

/**
 * Generates schema.org Trip data for a single tour.
 */
class Trip {

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
	 * Constructor.
	 *
	 * @param \WPSEO_Schema_Context|null $context Yoast context, or null for standalone use.
	 */
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
		return is_singular( 'tour' );
	}

	/**
	 * Generates and returns the Trip schema data array.
	 *
	 * @return array Schema.org Trip data.
	 */
	public function generate() {
		$data = array(
			'@type'            => 'Trip',
			'@id'              => $this->canonical . '#/schema/trip/' . $this->post_id,
			'name'             => get_the_title( $this->post_id ),
			'url'              => $this->canonical,
			'mainEntityOfPage' => array( '@id' => $this->canonical ),
		);

		// Description: prefer excerpt, fall back to stripped post content.
		$description = $this->get_description();
		if ( '' !== $description ) {
			$data['description'] = $description;
		}

		// Tagline → slogan.
		$tagline = Helpers::get_meta( $this->post_id, 'tagline' );
		if ( '' !== $tagline ) {
			$data['slogan'] = sanitize_text_field( $tagline );
		}

		// Duration → ISO 8601 when numeric, otherwise plain additionalProperty.
		$duration_raw = Helpers::get_meta( $this->post_id, 'duration' );
		if ( '' !== $duration_raw ) {
			$iso = Helpers::format_iso_duration( $duration_raw );
			if ( '' !== $iso ) {
				$data['duration'] = $iso;
			} else {
				$data = $this->append_property_value( $data, 'Duration', sanitize_text_field( $duration_raw ) );
			}
		}

		// Image: reference Yoast primary image when available, else featured image.
		$data = $this->add_image( $data );

		// fromLocation / toLocation (departs_from / ends_in destination posts).
		$data = $this->add_locations( $data );

		// Offers node (price, sale_price, booking window).
		$data = $this->add_offers( $data );

		// Provider: reference Yoast site_represents_reference when present.
		if ( null !== $this->context && ! empty( $this->context->site_represents_reference ) ) {
			$data['provider'] = $this->context->site_represents_reference;
		}

		// Itinerary: ordered subTrip list from repeatable CMB2 group.
		$data = $this->add_itinerary( $data );

		// Additional properties.
		$data = $this->add_additional_properties( $data );

		/**
		 * Filter the complete Trip schema data array.
		 *
		 * @param array $data    Trip schema data.
		 * @param int   $post_id Current tour post ID.
		 */
		return (array) apply_filters( 'lsx_to_schema_trip_data', $data, $this->post_id );
	}

	// -------------------------------------------------------------------------
	// Private helpers
	// -------------------------------------------------------------------------

	/**
	 * Get post description, preferring excerpt over stripped post content.
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
	 * Add image data from Yoast context or featured image fallback.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_image( array $data ) {
		if ( null !== $this->context && $this->context->has_image ) {
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
	 * Add fromLocation / toLocation from departs_from / ends_in meta fields.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_locations( array $data ) {
		$departs_from_id = (int) Helpers::get_meta( $this->post_id, 'departs_from' );
		if ( $departs_from_id > 0 && get_post( $departs_from_id ) ) {
			$data['fromLocation'] = array(
				'@type' => 'Place',
				'name'  => get_the_title( $departs_from_id ),
				'url'   => get_permalink( $departs_from_id ),
			);
		}

		$ends_in_id = (int) Helpers::get_meta( $this->post_id, 'ends_in' );
		if ( $ends_in_id > 0 && get_post( $ends_in_id ) ) {
			$data['toLocation'] = array(
				'@type' => 'Place',
				'name'  => get_the_title( $ends_in_id ),
				'url'   => get_permalink( $ends_in_id ),
			);
		}

		return $data;
	}

	/**
	 * Build the Offer node for pricing and booking windows.
	 *
	 * Uses sale_price as the active offer price when populated; otherwise falls
	 * back to the regular price. Booking validity timestamps are converted to
	 * ISO 8601 date strings.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_offers( array $data ) {
		$price      = Helpers::get_meta( $this->post_id, 'price' );
		$sale_price = Helpers::get_meta( $this->post_id, 'sale_price' );
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

		$start_date = Helpers::format_iso_date( Helpers::get_meta( $this->post_id, 'booking_validity_start' ) );
		$end_date   = Helpers::format_iso_date( Helpers::get_meta( $this->post_id, 'booking_validity_end' ) );

		if ( '' !== $start_date ) {
			$offer['availabilityStarts'] = $start_date;
		}
		if ( '' !== $end_date ) {
			$offer['availabilityEnds'] = $end_date;
		}

		$data['offers'] = $offer;
		return $data;
	}

	/**
	 * Build itinerary subTrip nodes from the repeatable CMB2 itinerary group.
	 *
	 * Each entry in the group becomes a `Trip` subtype with optional stop
	 * references to `Accommodation` and `TouristDestination` nodes.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_itinerary( array $data ) {
		$itinerary = get_post_meta( $this->post_id, 'itinerary', false );
		if ( empty( $itinerary ) || ! is_array( $itinerary ) ) {
			return $data;
		}

		$sub_trips = array();

		foreach ( $itinerary as $index => $day ) {
			if ( ! is_array( $day ) ) {
				continue;
			}

			$title = isset( $day['title'] ) ? sanitize_text_field( $day['title'] ) : '';
			if ( '' === $title ) {
				continue;
			}

			$sub_trip = array(
				'@type' => 'Trip',
				'@id'   => $this->canonical . '#/schema/trip/' . $this->post_id . '/day/' . ( (int) $index + 1 ),
				'name'  => $title,
			);

			$desc = isset( $day['description'] ) ? Helpers::strip_to_text( $day['description'] ) : '';
			if ( '' !== $desc ) {
				$sub_trip['description'] = $desc;
			}

			// Build itinerary stop list for this day.
			$stops = array();

			$accom_id = isset( $day['accommodation_to_tour'] ) ? (int) $day['accommodation_to_tour'] : 0;
			if ( $accom_id > 0 && get_post( $accom_id ) ) {
				$stops[] = array(
					'@type' => 'Accommodation',
					'name'  => get_the_title( $accom_id ),
					'url'   => get_permalink( $accom_id ),
				);
			}

			$dest_id = isset( $day['destination_to_tour'] ) ? (int) $day['destination_to_tour'] : 0;
			if ( $dest_id > 0 && get_post( $dest_id ) ) {
				$stops[] = array(
					'@type' => 'TouristDestination',
					'name'  => get_the_title( $dest_id ),
					'url'   => get_permalink( $dest_id ),
				);
			}

			if ( ! empty( $stops ) ) {
				$sub_trip['itinerary'] = $stops;
			}

			$sub_trips[] = $sub_trip;
		}

		if ( ! empty( $sub_trips ) ) {
			$data['subTrip'] = $sub_trips;
		}

		return $data;
	}

	/**
	 * Append schema additionalProperty nodes for tourism-specific fields.
	 *
	 * Fields: single_supplement, best_time_to_visit, group_size, highlights,
	 * included, not_included.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_additional_properties( array $data ) {
		$properties = array();

		// Single supplement (price value).
		$supplement = Helpers::normalise_price( Helpers::get_meta( $this->post_id, 'single_supplement' ) );
		if ( '' !== $supplement ) {
			$currency     = Helpers::get_currency();
			$properties[] = Helpers::make_property_value( 'Single supplement', $currency . ' ' . $supplement );
		}

		// Best time to visit (multiselect → month labels).
		$best_time_slugs = Helpers::get_meta_array( $this->post_id, 'best_time_to_visit' );
		if ( ! empty( $best_time_slugs ) ) {
			$labels = Helpers::month_slugs_to_labels( $best_time_slugs );
			if ( '' !== $labels ) {
				$properties[] = Helpers::make_property_value( 'Best time to visit', $labels );
			}
		}

		// Group size (wysiwyg field – strip HTML).
		$group_size = Helpers::strip_to_text( Helpers::get_meta( $this->post_id, 'group_size' ) );
		if ( '' !== $group_size ) {
			$properties[] = Helpers::make_property_value( 'Group size', $group_size );
		}

		// Highlights.
		$highlights = Helpers::strip_to_text( Helpers::get_meta( $this->post_id, 'highlights' ) );
		if ( '' !== $highlights ) {
			$properties[] = Helpers::make_property_value( 'Highlights', $highlights );
		}

		// Included.
		$included = Helpers::strip_to_text( Helpers::get_meta( $this->post_id, 'included' ) );
		if ( '' !== $included ) {
			$properties[] = Helpers::make_property_value( 'Included', $included );
		}

		// Not included.
		$not_included = Helpers::strip_to_text( Helpers::get_meta( $this->post_id, 'not_included' ) );
		if ( '' !== $not_included ) {
			$properties[] = Helpers::make_property_value( 'Not included', $not_included );
		}

		if ( ! empty( $properties ) ) {
			$data['additionalProperty'] = $properties;
		}

		return $data;
	}

	/**
	 * Append a single PropertyValue to the additionalProperty array.
	 *
	 * Used when a field (e.g. non-numeric duration) must be added before the
	 * main additionalProperty batch.
	 *
	 * @param array  $data  Schema data.
	 * @param string $name  Property name.
	 * @param string $value Property value.
	 * @return array
	 */
	protected function append_property_value( array $data, $name, $value ) {
		if ( ! isset( $data['additionalProperty'] ) ) {
			$data['additionalProperty'] = array();
		}
		$data['additionalProperty'][] = Helpers::make_property_value( $name, $value );
		return $data;
	}
}
