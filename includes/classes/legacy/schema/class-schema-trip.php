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
	 * This holds an object or the current trip post.
	 *
	 * @var WP_Post();
	 */
	public $post;

	/**
	 * This holds URL for the trip
	 *
	 * @var string
	 */
	public $post_url;

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
		$this->post             = get_post( $this->context->id );
		$this->post_url         = get_permalink( $this->context->id );
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
		$data = array(
			'@type'            => array(
				'Trip',
				'Product',
			),
			'@id'              => $this->context->canonical . '#tour',
			'name'             => $this->post->post_title,
			'description'      => wp_strip_all_tags( $this->post->post_content ),
			'url'              => $this->post_url,
			'mainEntityOfPage' => array(
				'@id' => $this->context->canonical . WPSEO_Schema_IDs::WEBPAGE_HASH,
			),
			'mpn'              => $this->context->id,
		);

		if ( $this->context->site_represents_reference ) {
			$data['provider'] = $this->context->site_represents_reference;
			$data['brand']    = $this->context->site_represents_reference;
		}

		$wetu_ref = get_post_meta( $this->context->id, 'lsx_wetu_ref', true );
		if ( false !== $wetu_ref && '' !== $wetu_ref ) {
			$data['sku']        = $wetu_ref;
			$data['identifier'] = $wetu_ref;
		}
		$data = $this->add_image( $data );
		$data = $this->add_itinerary( $data );
		$data = $this->add_sub_trips( $data );
		$data = $this->add_offers( $data );
		$data = $this->add_reviews( $data );
		$data = $this->add_articles( $data );

		if ( isset( $_GET['debug'] ) ) {
			print_r('<pre>');
			print_r($data);
			print_r('</pre>');
		}
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
						$places                          = \lsx\legacy\Schema_Utils::add_place( $places, 'Country', $destination, $this->context );
						$this->place_ids[ $destination ] = \lsx\legacy\Schema_Utils::get_places_schema_id( $destination, 'Country', $this->context );
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
					'@id'         => \lsx\legacy\Schema_Utils::get_subtrip_schema_id( $day['title'], $this->context ),
					'name'        => $day['title'],
					'description' => wp_strip_all_tags( $day['description'] ),
				);

				$itinerary_fields = apply_filters( 'lsx_to_schema_tour_sub_trips_additional_fields', $this->itinerary_fields );
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
							$places                       = \lsx\legacy\Schema_Utils::add_place( $places, $type, $place_id, $this->context, $contained_in );
							$this->place_ids[ $place_id ] = \lsx\legacy\Schema_Utils::get_places_schema_id( $place_id, $type, $this->context );
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
		$offers = $this->get_default_offer( $offers );
		$offers = $this->get_special_offers( $offers );
		if ( ! empty( $offers ) ) {
			$data['offers'] = $offers;
		}
		return $data;
	}

	/**
	 * Gets the default price and sets it as a "Standard" "Offer"
	 *
	 * @param  array $data An array of offers already added.
	 * @return array $data
	 */
	private function get_default_offer( $data ) {
		$price         = get_post_meta( $this->context->id, 'price', true );
		$currency      = 'USD';
		$tour_operator = tour_operator();
		if ( is_object( $tour_operator ) && isset( $tour_operator->options['general'] ) && is_array( $tour_operator->options['general'] ) ) {
			if ( isset( $tour_operator->options['general']['currency'] ) && ! empty( $tour_operator->options['general']['currency'] ) ) {
				$currency = $tour_operator->options['general']['currency'];
			}
		}
		if ( false !== $price && '' !== $price ) {
			$offer_args = array(
				'price'              => $price,
				'priceCurrency'      => $currency,
				'PriceSpecification' => __( 'Per Person Per Night', 'tour-operator' ),
				'availability'       => 'https://schema.org/OnlineOnly',
				'url'                => $this->post_url,
			);
			$data       = $this->add_offer( $data, $this->context->id, $offer_args, true );
		}
		return $data;
	}

	/**
	 * Gets the single special post and adds it as a special "Offer".
	 *
	 * @param  array $data An array of offers already added.
	 * @return array $data
	 */
	private function get_special_offer( $data, $special_id ) {
		$price         = get_post_meta( $special_id, 'price', true );
		$currency      = 'USD';
		$tour_operator = tour_operator();
		if ( is_object( $tour_operator ) && isset( $tour_operator->options['general'] ) && is_array( $tour_operator->options['general'] ) ) {
			if ( isset( $tour_operator->options['general']['currency'] ) && ! empty( $tour_operator->options['general']['currency'] ) ) {
				$currency = $tour_operator->options['general']['currency'];
			}
		}
		if ( false !== $price && '' !== $price ) {
			$offer_args = array(
				'price'         => $price,
				'priceCurrency' => $currency,
				'category'      => __( 'Special', 'tour-operator' ),
				'availability'  => 'https://schema.org/LimitedAvailability',
				'url'           => get_permalink( $special_id ),
			);
			$price_type = get_post_meta( $special_id, 'price_type', true );
			if ( false !== $price_type && '' !== $price_type && 'none' !== $price_type ) {
				$offer_args['PriceSpecification'] = lsx_to_get_price_type_label( $price_type );
			}
			$data = $this->add_offer( $data, $special_id, $offer_args );
		}
		return $data;
	}

	/**
	 * Gets the default price and sets it as a "Standard" "Offer"
	 *
	 * @param  array $data An array of offers already added.
	 * @return array $data
	 */
	private function get_special_offers( $data ) {
		$specials = get_post_meta( $this->context->id, 'special_to_tour', false );
		if ( ! empty( $specials ) ) {
			foreach ( $specials as $special_id ) {
				$data = $this->get_special_offer( $data, $special_id );
			}
		}
		return $data;
	}

	/**
	 * Gets the connected reviews post type and set it as the "Review" schema
	 *
	 * @param  array $data An array of offers already added.
	 * @return array $data
	 */
	private function add_reviews( $data ) {
		$reviews       = get_post_meta( $this->context->id, 'review_to_tour', false );
		$reviews_array = array();
		if ( ! empty( $reviews ) ) {
			$aggregate_value = 1;
			$review_count    = 0;
			foreach ( $reviews as $review_id ) {
				$rating      = get_post_meta( $review_id, 'rating', true );
				$author      = get_post_meta( $review_id, 'reviewer_name', true );
				$description = wp_strip_all_tags( get_the_content( $review_id ) );
				$review_args = array(
					'author'     => $author,
					'reviewBody' => $description,
				);
				// Add in the review rating.
				if ( false !== $rating && '' !== $rating && '0' !== $rating && 0 !== $rating ) {
					$review_args['reviewRating'] = array(
						'@type'       => 'Rating',
						'ratingValue' => $rating,
					);
				}
				$reviews_array = \lsx\legacy\Schema_Utils::add_review( $reviews_array, $review_id, $this->context, $review_args );
				$review_count++;
			}
			if ( ! empty( $reviews_array ) ) {
				$data['aggregateRating'] = array(
					'@type'       => 'AggregateRating',
					'ratingValue' => (string) $aggregate_value,
					'reviewCount' => (string) $review_count,
					'bestRating'  => '5',
					'worstRating' => '1',
				);
				$data['reviews']         = $reviews_array;
			}
		}
		return $data;
	}

	/**
	 * Gets the connected posts and set it as the "Article" schema
	 *
	 * @param  array $data An array of offers already added.
	 * @return array $data
	 */
	private function add_articles( $data ) {
		$posts       = get_post_meta( $this->context->id, 'post_to_tour', false );
		$posts_array = array();
		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post_id ) {
				$post_args = array(
					'articleBody' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
					'headline'    => get_the_title( $post_id ),
				);
				$section   = get_the_term_list( $post_id, 'category' );
				if ( ! is_wp_error( $section ) && '' !== $section && false !== $section ) {
					$post_args['articleSection'] = wp_strip_all_tags( $section );
				}
				if ( $this->context->site_represents_reference ) {
					$post_args['publisher'] = $this->context->site_represents_reference;
				}
				$image_url = get_the_post_thumbnail_url( $post_id, 'lsx-thumbnail-wide' );
				if ( false !== $image_url ) {
					$post_args['image'] = $image_url;
				}
				$posts_array = \lsx\legacy\Schema_Utils::add_article( $posts_array, $post_id, $this->context, $post_args );
			}
			if ( ! empty( $posts_array ) ) {
				$data['subjectOf'] = $posts_array;
			}
		}
		return $data;
	}

	/**
	 * Generates the "Offer" graph piece for the subtrip / Itinerary arrays.
	 *
	 * @param array  $data         subTrip / itinerary data.
	 * @param string $post_id      The post ID of the current Place to add.
	 * @param array  $args         and array of parameter you want added to the offer.
	 * @param string $local        if the Schema is local true / false.
	 *
	 * @return mixed array $data Place data.
	 */
	private function add_offer( $data, $post_id, $args = array(), $local = false ) {
		$defaults = array(
			'@id'                => \lsx\legacy\Schema_Utils::get_offer_schema_id( $post_id, $this->context, $local ),
			'price'              => false,
			'priceCurrency'      => false,
			'PriceSpecification' => false,
			'url'                => false,
			'availability'       => false,
			'category'           => __( 'Standard', 'tour-operator' ),
		);
		$args     = wp_parse_args( $args, $defaults );
		$args     = apply_filters( 'lsx_to_schema_tour_offer_args', $args );
		$offer    = array(
			'@type' => apply_filters( 'lsx_to_schema_tour_offer_type', 'Offer', $args ),
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
}
