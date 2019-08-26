<?php
/**
 * Helper functions for the Schema class.
 *
 * @package Tour Operator
 */
namespace lsx\legacy;

/**
 * Schema utility functions.
 *
 * @since 11.6
 */
class Schema_Utils {

	/**
	 * Retrieve a users Schema ID.
	 *
	 * @param string               $place_id The Name of the Reviewer you need a for.
	 * @param string               $type the type of the place.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 *
	 * @return string The user's schema ID.
	 */
	public static function get_places_schema_id( $place_id, $type, $context ) {
		$url = $context->site_url . '#/schema/' . strtolower( $type ) . '/' . wp_hash( $place_id . get_the_title( $place_id ) );
		return trailingslashit( $url );
	}

	/**
	 * Retrieve a users Schema ID.
	 *
	 * @param string               $name The Name of the Reviewer you need a for.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 *
	 * @return string The user's schema ID.
	 */
	public static function get_subtrip_schema_id( $name, $context ) {
		$url = $context->site_url . '#/subtrip/' . wp_hash( $name . $context->id );
		return trailingslashit( $url );
	}

	/**
	 * Retrieve an offer Schema ID.
	 *
	 * @param string               $id      post ID of the place being added.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 * @param string               $local   if the Schema is local true / false.
	 *
	 * @return string The user's schema ID.
	 */
	public static function get_offer_schema_id( $id, $context, $local = false ) {
		if ( false === $local ) {
			$url = $context->site_url;
		} else {
			$url = get_permalink( $context->id );
		}
		$url .= '#/schema/offer/';
		$url .= wp_hash( $id . get_the_title( $id ) );
		return trailingslashit( $url );
	}

	/**
	 * Retrieve an review Schema ID.
	 *
	 * @param string               $id      post ID of the place being added.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 * @param string               $local   if the Schema is local true / false.
	 *
	 * @return string The user's schema ID.
	 */
	public static function get_review_schema_id( $id, $context, $local = false ) {
		if ( false === $local ) {
			$url = $context->site_url;
		} else {
			$url = get_permalink( $context->id );
		}
		$url .= '#/schema/review/';
		$url .= wp_hash( $id . get_the_title( $id ) );
		return trailingslashit( $url );
	}

	/**
	 * Retrieve an Article Schema ID.
	 *
	 * @param string               $id      post ID of the place being added.
	 * @param WPSEO_Schema_Context $context A value object with context variables.
	 * @param string               $local   if the Schema is local true / false.
	 *
	 * @return string The user's schema ID.
	 */
	public static function get_article_schema_id( $id, $context, $local = false ) {
		if ( false === $local ) {
			$url = get_permalink( $id ) . WPSEO_Schema_IDs::ARTICLE_HASH;
		} else {
			$url = get_permalink( $context->id ) . '#/schema/article/' . wp_hash( $id . get_the_title( $id ) );
		}
		return trailingslashit( $url );
	}

	/**
	 * Generates the place graph piece for the subtrip / Itinerary arrays.
	 *
	 * @param array  $data         subTrip / itinerary data.
	 * @param string $type         The type in data to save the terms in.
	 * @param string $post_id      The post ID of the current Place to add.
	 * @param WPSEO_Schema_Context $context      The post ID of the current Place to add.
	 * @param string $contained_in The @id of the containedIn place.
	 *
	 * @return mixed array $data Place data.
	 */
	public static function add_place( $data, $type, $post_id, $context, $contained_in = false ) {
		$at_id                       = self::get_places_schema_id( $post_id, $type, $context );
		$this->place_ids[ $post_id ] = $at_id;
		$place                       = array(
			'@type'       => $type,
			'@id'         => $at_id,
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
}
