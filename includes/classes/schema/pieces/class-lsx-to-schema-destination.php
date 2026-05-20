<?php
/**
 * Destination Schema Graph Piece
 *
 * Outputs schema.org TouristDestination markup for the `destination` post type.
 * When Yoast SEO is active the class is registered as a graph piece via the
 * Yoast adapter in class-schema.php. When Yoast is inactive the standalone
 * fallback calls `generate()` directly.
 *
 * Fields mapped (per implementation plan):
 *   name, description, url, mainEntityOfPage, image, slogan (tagline),
 *   touristType → travel-style taxonomy,
 *   containedInPlace → parent destination post,
 *   containsPlace → direct child destination posts,
 *   address + geo → location meta,
 *   additionalProperty → best_time_to_visit, electricity, banking, cuisine,
 *                         climate, transport, dress, health, safety, visa,
 *                         additional_info.
 *
 * @package    Tour_Operator
 * @subpackage Schema
 * @since      2.2.0
 */

namespace lsx\schema\pieces;

use lsx\schema\Helpers;

/**
 * Generates schema.org TouristDestination data for a single destination.
 */
class Destination {

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
		return is_singular( 'destination' );
	}

	/**
	 * Generates and returns the TouristDestination schema data array.
	 *
	 * @return array Schema.org TouristDestination data.
	 */
	public function generate() {
		$data = array(
			'@type'            => 'TouristDestination',
			'@id'              => $this->canonical . '#/schema/destination/' . $this->post_id,
			'name'             => get_the_title( $this->post_id ),
			'url'              => $this->canonical,
			'mainEntityOfPage' => array( '@id' => $this->canonical ),
		);

		// Description.
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

		// touristType from travel-style taxonomy.
		$data = $this->add_tourist_type( $data );

		// containedInPlace (parent destination).
		$data = $this->add_contained_in( $data );

		// containsPlace (direct child destinations).
		$data = $this->add_contains_places( $data );

		// Address and geo coordinates.
		$data = $this->add_location( $data );

		// Additional properties (travel information fields).
		$data = $this->add_additional_properties( $data );

		/**
		 * Filter the complete TouristDestination schema data array.
		 *
		 * @param array $data    TouristDestination schema data.
		 * @param int   $post_id Current destination post ID.
		 */
		return (array) apply_filters( 'lsx_to_schema_destination_data', $data, $this->post_id );
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
	 * Add touristType from the `travel-style` taxonomy.
	 *
	 * Each term becomes an Audience node with the term name as audienceType.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_tourist_type( array $data ) {
		$terms = get_the_terms( $this->post_id, 'travel-style' );
		if ( ! is_array( $terms ) || empty( $terms ) ) {
			return $data;
		}

		$audiences = array();
		foreach ( $terms as $term ) {
			if ( ! is_object( $term ) || '' === $term->name ) {
				continue;
			}
			$audiences[] = array(
				'@type'        => 'Audience',
				'audienceType' => sanitize_text_field( $term->name ),
			);
		}

		if ( ! empty( $audiences ) ) {
			$data['touristType'] = $audiences;
		}

		return $data;
	}

	/**
	 * Add containedInPlace from the destination post parent.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_contained_in( array $data ) {
		if ( ! is_object( $this->post ) ) {
			return $data;
		}

		$parent_id = (int) $this->post->post_parent;
		if ( $parent_id <= 0 ) {
			return $data;
		}

		$parent = get_post( $parent_id );
		if ( ! is_object( $parent ) || 'destination' !== $parent->post_type ) {
			return $data;
		}

		$data['containedInPlace'] = array(
			'@type' => 'TouristDestination',
			'name'  => get_the_title( $parent_id ),
			'url'   => get_permalink( $parent_id ),
		);

		return $data;
	}

	/**
	 * Add containsPlace from direct child destinations.
	 *
	 * Fetches published direct children of the current destination post and
	 * lists each as a TouristDestination. This is most useful for country pages
	 * that contain region children.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_contains_places( array $data ) {
		$children = get_posts(
			array(
				'post_type'      => 'destination',
				'post_parent'    => $this->post_id,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids',
			)
		);

		if ( empty( $children ) ) {
			return $data;
		}

		$places = array();
		foreach ( $children as $child_id ) {
			$child_id = (int) $child_id;
			$places[] = array(
				'@type' => 'TouristDestination',
				'name'  => get_the_title( $child_id ),
				'url'   => get_permalink( $child_id ),
			);
		}

		if ( ! empty( $places ) ) {
			$data['containsPlace'] = $places;
		}

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
	 * Append additionalProperty nodes for all travel information fields.
	 *
	 * Tourism-specific travel information (electricity, banking, cuisine, etc.)
	 * is mapped to PropertyValue nodes because Schema.org does not provide clean
	 * first-class properties for these facts. HTML is stripped to plain text.
	 *
	 * Fields: best_time_to_visit, electricity, banking, cuisine, climate,
	 * transport, dress, health, safety, visa, additional_info.
	 *
	 * @param array $data Schema data.
	 * @return array
	 */
	protected function add_additional_properties( array $data ) {
		$properties = array();

		// Best time to visit.
		$best_time_slugs = Helpers::get_meta_array( $this->post_id, 'best_time_to_visit' );
		if ( ! empty( $best_time_slugs ) ) {
			$labels = Helpers::month_slugs_to_labels( $best_time_slugs );
			if ( '' !== $labels ) {
				$properties[] = Helpers::make_property_value( 'Best time to visit', $labels );
			}
		}

		// Travel information fields from config-destination.php.
		// Note: 'safety' is handled separately below so it can also populate
		// the dedicated safetyConsideration property.
		$travel_info_fields = array(
			'electricity'     => 'Electricity',
			'banking'         => 'Banking',
			'cuisine'         => 'Cuisine',
			'climate'         => 'Climate',
			'transport'       => 'Transport',
			'dress'           => 'Dress',
			'health'          => 'Health',
			'visa'            => 'Visa',
			'additional_info' => 'General information',
		);

		foreach ( $travel_info_fields as $meta_key => $label ) {
			$raw = Helpers::strip_to_text( Helpers::get_meta( $this->post_id, $meta_key ) );
			if ( '' !== $raw ) {
				$properties[] = Helpers::make_property_value( $label, $raw );
			}
		}

		// Safety: add as additionalProperty and, when concise (≤300 chars),
		// also promote to the dedicated safetyConsideration property.
		$safety = Helpers::strip_to_text( Helpers::get_meta( $this->post_id, 'safety' ) );
		if ( '' !== $safety ) {
			$properties[] = Helpers::make_property_value( 'Safety', $safety );
			if ( mb_strlen( $safety ) <= 300 ) {
				$data['safetyConsideration'] = $safety;
			}
		}

		if ( ! empty( $properties ) ) {
			$data['additionalProperty'] = $properties;
		}

		return $data;
	}
}
