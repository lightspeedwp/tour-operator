<?php
/**
 * The Trip Schema for Tours
 *
 * @package tour-operator
 */

/**
 * Returns schema Review data.
 *
 * @since 10.2
 */
class LSX_TO_Schema_Trip implements WPSEO_Graph_Piece {

	/**
	 * A value object with context variables.
	 *
	 * @var \WPSEO_Schema_Context
	 */
	private $context;

	/**
	 * This holds the meta_key => scehma_type of the fields you want to add to your subtrip.
	 *
	 * @var array()
	 */
	public $itinerary_fields;

	/**
	 * This holds array of Places that have been generated
	 *
	 * @var array()
	 */
	public $place_ids;

	/**
	 * Constructor.
	 *
	 * @param \WPSEO_Schema_Context $context A value object with context variables.
	 */
	public function __construct( WPSEO_Schema_Context $context ) {
		$this->context          = $context;
		$this->itinerary_fields = array(
			'accommodation_to_tour' => 'Accommodation',
			'destination_to_tour'   => 'State',
		);
		$this->place_ids        = array();
	}

	/**
	 * Determines whether or not a piece should be added to the graph.
	 *
	 * @return bool
	 */
	public function is_needed() {
		if ( ! is_singular() ) {
			return false;
		}

		if ( $this->context->site_represents === false ) {
			return false;
		}

		return self::is_tour_post_type( get_post_type() );
	}

	/**
	 * Returns Review data.
	 *
	 * @return array $data Review data.
	 */
	public function generate() {
		$this->post = get_post( $this->context->id );
		$data = array(
			'@type'            => 'Trip',
			'@id'              => $this->context->canonical . '#tour',
			'name'             => $this->post->post_title,
			'description'      => wp_strip_all_tags( $this->post->post_content ),
			'mainEntityOfPage' => array(
				'@id' => $this->context->canonical . WPSEO_Schema_IDs::WEBPAGE_HASH,
			),
		);
		if ( $this->context->site_represents_reference ) {
			$data['provider'] = $this->context->site_represents_reference;
		}
		$data = $this->add_itinerary( $data );
		$data = $this->add_image( $data );
		$data = $this->add_sub_trips( $data );
		$data = $this->add_offers( $data );
		return $data;
	}

	/**
	 * Determines whether a given post type should have Review schema.
	 *
	 * @param string $post_type Post type to check.
	 *
	 * @return bool True if it has tour schema, false if not.
	 */
	public static function is_tour_post_type( $post_type = null ) {
		if ( is_null( $post_type ) ) {
			$post_type = get_post_type();
		}

		/**
		 * Filter: 'wpseo_schema_tour_post_types' - Allow changing for which post types we output Review schema.
		 *
		 * @api string[] $post_types The post types for which we output Review.
		 */
		$post_types = apply_filters( 'wpseo_schema_tour_post_types', array( 'tour' ) );

		return in_array( $post_type, $post_types );
	}

	/**
	 * Adds the itinerary destinations as an itemList
	 *
	 * @param array $data Trip data.
	 *
	 * @return array $data Trip data.
	 */
	private function add_itinerary( $data ) {
		$places       = array();
		$destinations = get_post_meta( $this->context->id, 'destination_to_tour', false );
		if ( ! empty( $destinations ) ) {
			foreach ( $destinations as $destination ) {
				if ( '' !== $destination ) {
					$parent = wp_get_post_parent_id( $destination );
					if ( false === $parent || 0 === $parent ) {
						$places = $this->add_place( $places, 'Country', $destination );
					}
				}
			}
			if ( ! empty( $places ) ) {
				$data['itinerary'] = $places;
			}
		}

		return $data;
	}

	/**
	 * Adds the itinerary destinations as an itemList
	 *
	 * @param array $data Trip data.
	 *
	 * @return array $data Trip data.
	 */
	private function add_sub_trips( $data ) {
		/**
		 * Filter: 'wpseo_schema_tour_sub_trips_meta_key' - Allow changing the custom field meta_key used to assign the Sub Trips to a post type Trip data.
		 *
		 * @api string $meta_key The chosen meta_key.
		 */
		$meta_key = apply_filters( 'wpseo_schema_tour_sub_trips_meta_key', 'itinerary' );
		return $this->add_subtrip_days( $data, 'subTrip', $meta_key );
	}

	/**
	 * Adds the days of the subTrip to the dta.
	 *
	 * @param array  $data     Trip data.
	 * @param string $key      The key in data to save the terms in.
	 * @param string $taxonomy The taxonomy to retrieve the terms from.
	 *
	 * @return mixed array $data Review data.
	 */
	private function add_subtrip_days( $data, $key, $meta_key ) {
		$itinerary  = get_post_meta( get_the_ID(), 'itinerary', false );
		$list_array = array();
		$i          = 0;

		if ( ! empty( $itinerary ) ) {
			foreach ( $itinerary as $day ) {
				$i++;
				$schema = array(
					'@type'    => 'Trip',
					'@id'         => $this->get_subtrip_schema_id( $day['title'], $this->context ),
					'name'        => $day['title'],
					'description' => wp_strip_all_tags( $day['description'] ),
				);

				$itinerary_fields = apply_filters( 'wpseo_schema_tour_sub_trips_additional_fields', $this->itinerary_fields );
				$places           = $this->add_subtrip_places( $itinerary_fields, $day );
				if ( ! empty( $places ) ) {
					$schema['itinerary'] = $places;
				}

				$list_array[] = $schema;
			}

			$data[ $key ] = $list_array;
		}
		return $data;
	}

	/**
	 * Adds in the accommodation and destination Place if found.
	 *
	 * @param array  $itinerary_fields The array of fields to loop through.
	 * @param string $day The itinrary day array to grab the post_ids from.
	 *
	 * @return array $palces Places data.
	 */
	private function add_subtrip_places( $itinerary_fields, $day ) {
		$places = array();
		if ( ! empty( $itinerary_fields ) ) {
			foreach ( $itinerary_fields as $key => $type ) {

				if ( isset( $day[ $key ] ) && '' !== $day[ $key ] && ! empty( $day[ $key ] ) ) {
					foreach ( $day[ $key ] as $place_id  ) {
						if ( '' !== $place_id ) {
							// Here we are linking the regions to the country.
							$contained_in = false;
							$parent_id = wp_get_post_parent_id( $place_id );
							if ( false !== $parent_id && ! empty( $this->place_ids ) && isset( $this->place_ids[ $parent_id ] ) ) {
								$contained_in = $this->place_ids[ $parent_id ];
							}
							$places = $this->add_place( $places, $type, $place_id, $contained_in );
						}
					}
				}
			}
		}
		return $places;
	}

	/**
	 * Adds in the default price and any special prices as Offers if found.
	 *
	 * @param array  $data The array of fields to loop through.
	 * @param string $day The itinrary day array to grab the post_ids from.
	 *
	 * @return array $offers Offer data.
	 */
	private function add_offers( $data ) {
		$offers = array();
		$tour_operator = tour_operator();
		if ( is_object( $tour_operator ) && isset( $tour_operator->options['general'] ) && is_array( $tour_operator->options['general'] ) ) {
			if ( isset( $tour_operator->options['general']['currency'] ) && ! empty( $tour_operator->options['general']['currency'] ) ) {
				$currency = $tour_operator->options['general']['currency'];
			}
		}

		// Check for a price.
		$price = get_post_meta( get_the_ID(), 'price', true );
		if ( false !== $price && '' !== $price ) {
			$offer_args = array(
				'price'         => $price,
				'priceCurrency' => $currency,
			);
			$offers[]   = $this->add_offer( $offers, $this->context->id, $offer_args );
		}
		if ( ! empty( $offers ) ) {
			$data['offers'] = $offers;
		}
		return $data;
	}

	/**
	 * Generates the place graph piece for the subtrip / Itinerary arrays.
	 *
	 * @param array  $data         subTrip / itinerary data.
	 * @param string $post_id      The post ID of the current Place to add.
	 * @param array  $args         and array of parameter you want added to the offer.
	 *
	 * @return mixed array $data Place data.
	 */
	private function add_offer( $data, $post_id, $args = array() ) {
		$defaults = array(
			'price'         => false,
			'priceCurrency' => false,
			'category'      => 'Standard',
		);
		$args     = wp_parse_args( $args, $defaults );
		$offer    = array(
			'@type' => 'Offer',
			'@id'   => $this->get_offer_schema_id( $post_id, $this->context ),
		);
		foreach ( $args as $key => $value ) {
			if ( false !== $value ) {
				$offer[ $key ] = $value;
			}
		}
		$data[] = $offer;
		return $data;
	}

	/**
	 * Generates the place graph piece for the subtrip / Itinerary arrays.
	 *
	 * @param array  $data         subTrip / itinerary data.
	 * @param string $type         The type in data to save the terms in.
	 * @param string $post_id      The post ID of the current Place to add.
	 * @param string $contained_in The @id of the containedIn place.
	 *
	 * @return mixed array $data Place data.
	 */
	private function add_place( $data, $type, $post_id, $contained_in = false ) {
		$place = array(
			'@type'       => $type,
			'@id'         => $this->get_places_schema_id( $post_id, $type, $this->context ),
			'name'        => get_the_title( $post_id ),
			'description' => get_the_excerpt( $post_id ),
			'url'         => get_permalink( $post_id ),
		);
		if ( false !== $contained_in ) {
			$place['containedInPlace'] = array(
				'@type' => 'Country',
				'@id'   => $contained_in,
			);
		}
		$data[] = $place;
		return $data;
	}

	/**
	 * Adds an image node if the post has a featured image.
	 *
	 * @param array $data The Review data.
	 *
	 * @return array $data The Review data.
	 */
	private function add_image( $data ) {
		if ( $this->context->has_image ) {
			$data['image'] = array(
				'@id' => $this->context->canonical . WPSEO_Schema_IDs::PRIMARY_IMAGE_HASH,
			);
		}

		return $data;
	}

	/**
	 * Retrieve a users Schema ID.
	 *
	 * @param string               $name The Name of the Reviewer you need a for.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 *
	 * @return string The user's schema ID.
	 */
	public function get_places_schema_id( $place_id, $type, $context ) {
		$url                          = $context->site_url . $type . '/' . wp_hash( $place_id . $context->id );
		$this->place_ids[ $place_id ] = $url;
		return $url;
	}

	/**
	 * Retrieve a users Schema ID.
	 *
	 * @param string               $name The Name of the Reviewer you need a for.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 *
	 * @return string The user's schema ID.
	 */
	public function get_subtrip_schema_id( $name, $context ) {
		return $context->site_url . 'day/' . wp_hash( $name . $context->id );
	}

	/**
	 * Retrieve a users Schema ID.
	 *
	 * @param string               $id      post ID of the place being added.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 *
	 * @return string The user's schema ID.
	 */
	public function get_offer_schema_id( $id, $context ) {
		$url = $context->site_url . 'offer/' . wp_hash( $id . $context->id );
		return $url;
	}
}
