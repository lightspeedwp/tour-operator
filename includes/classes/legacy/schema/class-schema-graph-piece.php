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
class LSX_TO_Schema_Graph_Piece implements WPSEO_Graph_Piece {

	/**
	 * A value object with context variables.
	 *
	 * @var \WPSEO_Schema_Context
	 */
	public $context;

	/**
	 * This is the post type that you want the piece to output for.
	 *
	 * @var string;
	 */
	public $post_type;

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

		if ( false === $this->context->site_represents ) {
			return false;
		}

		return \lsx\legacy\Schema_Utils::is_type( get_post_type(), $this->post_type );
	}

	/**
	 * Returns Review data.
	 *
	 * @return array $data Review data.
	 */
	public function generate() {
		$data = array();
		return $data;
	}

	/**
	 * Adds the itinerary destinations as an itemList
	 *
	 * @param array $data Trip data.
	 *
	 * @return array $data Trip data.
	 */
	public function add_destinations( $data ) {
		$places       = array();
		$destinations = get_post_meta( $this->context->id, 'destination_to_' . $this->post_type, false );
		if ( ! empty( $destinations ) ) {
			foreach ( $destinations as $destination ) {
				if ( '' !== $destination ) {
					$parent = wp_get_post_parent_id( $destination );
					if ( false === $parent || 0 === $parent ) {
						$places                          = \lsx\legacy\Schema_Utils::add_place( $places, 'Country', $destination, $this->context );
						$this->place_ids[ $destination ] = \lsx\legacy\Schema_Utils::get_places_schema_id( $destination, 'Country', $this->context );
					} else {
						$places                          = \lsx\legacy\Schema_Utils::add_place( $places, 'State', $destination, $this->context );
						$this->place_ids[ $destination ] = \lsx\legacy\Schema_Utils::get_places_schema_id( $destination, 'State', $this->context );
					}
				}
			}
			if ( ! empty( $places ) ) {
				$data['containedInPlace'] = $places;
			}
		}

		return $data;
	}

	/**
	 * Adds in the default price and any special prices as Offers if found.
	 *
	 * @param array $data The array of fields to loop through.
	 *
	 * @return array $offers Offer data.
	 */
	public function add_offers( $data ) {
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
	public function get_default_offer( $data ) {
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
			$data = \lsx\legacy\Schema_Utils::add_offer( $data, $this->context->id, $this->context, $offer_args, true );
		}
		return $data;
	}

	/**
	 * Gets the single special post and adds it as a special "Offer".
	 *
	 * @param  array $data An array of offers already added.
	 * @return array $data
	 */
	public function get_special_offer( $data, $special_id ) {
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
			$data = \lsx\legacy\Schema_Utils::add_offer( $data, $special_id, $this->context, $offer_args );
		}
		return $data;
	}

	/**
	 * Gets the default price and sets it as a "Standard" "Offer"
	 *
	 * @param  array $data An array of offers already added.
	 * @return array $data
	 */
	public function get_special_offers( $data ) {
		$specials = get_post_meta( $this->context->id, 'special_to_' . $this->post_type, false );
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
	public function add_reviews( $data ) {
		$reviews       = get_post_meta( $this->context->id, 'review_to_' . $this->post_type, false );
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
	public function add_articles( $data ) {
		$posts       = get_post_meta( $this->context->id, 'post_to_' . $this->post_type, false );
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
}
