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
	 * Constructor.
	 *
	 * @param \WPSEO_Schema_Context $context A value object with context variables.
	 */
	public function __construct( WPSEO_Schema_Context $context ) {
		$this->context = $context;
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
		$post = get_post( $this->context->id );
		$data = array(
			'@type'            => 'Trip',
			'@id'              => $this->context->canonical . '#tour',
			'name'             => get_the_title(),
			'mainEntityOfPage' => array(
				'@id' => $this->context->canonical . WPSEO_Schema_IDs::WEBPAGE_HASH,
			),
		);
		if ( $this->context->site_represents_reference ) {
			$data['provider'] = $this->context->site_represents_reference;
		}

		$data = $this->add_image( $data );
		$data = $this->add_itinerary( $data );
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
		/**
		 * Filter: 'wpseo_schema_tour_itinerary_meta_key' - Allow changing the custom field meta_key used to assign the itinerary to a post type Trip data.
		 *
		 * @api string $meta_key The chosen meta_key.
		 */
		$meta_key = apply_filters( 'wpseo_schema_tour_itinerary_meta_key', 'itinerary' );

		return $this->add_days( $data, 'itinerary', $meta_key );
	}

	/**
	 * Adds the days of the itinerary to the dta.
	 *
	 * @param array  $data     Trip data.
	 * @param string $key      The key in data to save the terms in.
	 * @param string $taxonomy The taxonomy to retrieve the terms from.
	 *
	 * @return mixed array $data Review data.
	 */
	private function add_days( $data, $key, $meta_key ) {
		$itinerary  = get_post_meta( get_the_ID(), 'itinerary', false );
		$list_array = array();
		$i          = 0;

		if ( ! empty( $itinerary ) ) {

			foreach ( $itinerary as $day ) {
				$i++;
				$schema       = array(
					'@type'    => 'ListItem',
					'position' => $i,
					'item'     => array(
						'@id'         => $this->get_itinerary_day_schema_id( $day['title'], $this->context ),
						'name'        => $day['title'],
						'description' => wp_strip_all_tags( $day['description'] ),
					),
				);
				$list_array[] = $day;
			}

			$data[ $key ] = array(
				'@type' => 'ItemList',
				'itemListElement' => implode( ',', $list_array ),
			);
		}
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
	public function get_itinerary_day_schema_id( $name, $context ) {
		return $context->site_url . 'day/' . wp_hash( $name . $context->id );
	}
}
