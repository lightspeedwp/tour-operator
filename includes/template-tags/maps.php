<?php
/**
 * Template Tags
 *
 * @package   to-maps
 * @author    LightSpeed
 * @license   GPL-3.0+
 * @link
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Checks if maps are enabled.
 *
 * @return boolean
 */
function lsx_to_is_map_enabled() {
	$options = tour_operator()->legacy->options;
	$return = true;
	if ( false !== $options && isset( $options['maps_disabled'] ) && 'on' === $options['maps_disabled'] ) {
		$return = false;
	}
	return $return;
}

if ( ! function_exists( 'lsx_to_map' ) ) {
	/**
	 * Outputs the current post type map.
	 *
	 * @param string  $before
	 * @param string  $after
	 * @param boolean $echo
	 * @return string
	 */
	function lsx_to_map( $before = '', $after = '', $echo = true ) {
		$location = get_transient( get_the_ID() . '_location' );

		if ( false !== $location ) {
			$map = '';
			$map_override = apply_filters( 'lsx_to_map_override', false );
			if ( false === $map_override ) {
				$zoom = 15;
				if ( is_array( $location ) && isset( $location['zoom'] ) ) {
					$zoom = $location['zoom'];
				}

				$zoom = apply_filters( 'lsx_to_map_zoom', $zoom );
				$map_type = 'default';
				$parent_id = false;
				$connections = false;

				if ( is_singular( 'tour' ) ) {
					$map_type = 'itinerary';
				} elseif ( is_post_type_archive( 'destination' ) ) {
					$map_type = 'region_archive';
					$parent_id = '0';
				} elseif ( is_singular( 'destination' ) ) {
					$map_type = 'region_archive';
					$parent_id = get_queried_object_id();
				} elseif ( is_tax( 'continent' ) ) {
					$map_type = 'continent_archive';
					$parent_id = '0';
				}

				switch ( $map_type ) {
					case 'itinerary':
						$args = array(
							'zoom' => $zoom,
							'width' => '100%',
							'height' => '500px',
							'type' => 'route',
						);

						if ( isset( $location['kml'] ) ) {
							$args['kml'] = $location['kml'];
						} elseif ( isset( $location['connections'] ) ) {
							$args['connections'] = $location['connections'];
						}

						break;

					case 'region_archive':
						$args = array();
						$connections = array();
						if ( false !== lsx_to_item_has_children( $parent_id, 'destination' ) ) {
							$region_args = array(
								'post_type' => 'destination',
								'post_status' => 'publish',
								'nopagin' => true,
								'posts_per_page' => '-1',
								'fields' => 'ids',
							);
							$region_args['post_parent'] = $parent_id;

							if ( true === lsx_to_display_fustion_tables() ) {
								$region_args['post_parent'] = 0;
								$args['fusion_tables'] = true;
								$args['fusion_tables_colour_border'] = lsx_to_fustion_tables_attr( 'colour_border', '#000000' );
								$args['fusion_tables_width_border'] = lsx_to_fustion_tables_attr( 'width_border', '2' );
								$args['fusion_tables_colour_background'] = lsx_to_fustion_tables_attr( 'colour_background', '#000000' );
							}
							$regions = new WP_Query( $region_args );
							if ( isset( $regions->posts ) && ! empty( $regions->posts ) ) {
								$connections = $regions->posts;
							}
						} else {
							$accommodation = get_post_meta( $parent_id, 'accommodation_to_destination', false );
							if ( false !== $accommodation && ! empty( $accommodation ) ) {
								$connections = $accommodation;
							}
						}

						$args['content'] = 'excerpt';

						if ( false !== $connections && '' !== $connections && ! empty( $connections ) ) {
							$args['connections'] = $connections;
							$args['type'] = 'cluster';

							if ( '0' === $parent_id ) {
								$args['disable_cluster_js'] = true;
							}
						} else {
							$args['longitude'] = $location['longitude'];
							$args['latitude'] = $location['latitude'];
						}

						// Check to see if the zoom is disabled.
						$manual_zoom = get_post_meta( $parent_id, 'disable_auto_zoom', true );
						if ( false !== $manual_zoom && '' !== $manual_zoom ) {
							$args['disable_auto_zoom'] = true;
							$args['zoom'] = $manual_zoom;
						} else {
							$args['zoom'] = $zoom;
						}

						break;

					case 'continent_archive':
						$args = array();

						$country_args = array(
							'post_type' => 'destination',
							'post_status' => 'publish',
							'nopagin' => true,
							'posts_per_page' => '-1',
							'fields' => 'ids',
							'post_parent' => $parent_id,
						);

						if ( isset( get_queried_object()->term_id ) ) {
							// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
							$country_args['tax_query'] = array(
								array(
									'taxonomy' => 'continent',
									'field'    => 'term_id',
									'terms'    => array( get_queried_object()->term_id ),
								),
							);
						}

						if ( true === lsx_to_display_fustion_tables() ) {
							$args['fusion_tables'] = true;
							$args['fusion_tables_colour_border'] = lsx_to_fustion_tables_attr( 'colour_border', '#000000' );
							$args['fusion_tables_width_border'] = lsx_to_fustion_tables_attr( 'width_border', '2' );
							$args['fusion_tables_colour_background'] = lsx_to_fustion_tables_attr( 'colour_background', '#000000' );
						}

						$countries = new WP_Query( $country_args );

						if ( isset( $countries->posts ) && ! empty( $countries->posts ) ) {
							$connections = $countries->posts;
						}

						$args['content'] = 'excerpt';

						if ( false !== $connections && '' !== $connections ) {
							$args['connections'] = $connections;
							$args['type'] = 'cluster';
							if ( '0' === $parent_id ) {
								$args['disable_cluster_js'] = true;
							}
						}

						break;

					default:
						$args = array(
							'longitude' => $location['longitude'],
							'latitude' => $location['latitude'],
							'zoom' => $zoom,
							'width' => '100%',
							'height' => '500px',
						);

						break;
				}
				$args = apply_filters( 'lsx_to_maps_args', $args, get_the_ID() );
				$map  = tour_operator()->frontend->maps->map_output( get_the_ID(), $args );
			} else {
				$map = $map_override;
			}

			if ( true === $echo ) {
				// @codingStandardsIgnoreLine
				echo $before . $map . $after;
			} else {
				return $before . $map . $after;
			}
		}
	}
}

if ( ! function_exists( 'lsx_to_display_fustion_tables' ) ) {
	/**
	 * Return if the fusion tables are enabled or not
	 *
	 * @package to-maps
	 * @subpackage template-tags
	 */
	function lsx_to_display_fustion_tables() {
		$temp = get_option( '_lsx-to_settings', false );
		if ( isset( $temp['fusion_tables_enabled'] ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'lsx_to_fustion_tables_attr' ) ) {
	/**
	 * Return fusion tables attribute.
	 *
	 * @package to-maps
	 * @subpackage template-tags
	 */
	function lsx_to_fustion_tables_attr( $attribute, $default ) {
		$temp = get_option( '_lsx-to_settings', false );

		if ( false !== $temp && isset( $temp ) ) {
			if ( isset( $temp[ 'fusion_tables_' . $attribute ] ) && ! empty( $temp[ 'fusion_tables_' . $attribute ] ) ) {
				return $temp[ 'fusion_tables_' . $attribute ];
			} else {
				return $default;
			}
		}
	}
}

if ( ! function_exists( 'lsx_to_maps_has_api_key' ) ) {
	/**
	 * Checks to see if the API key is actually set.
	 *
	 * @package to-maps
	 * @subpackage template-tags
	 * @category meta
	 */
	function lsx_to_maps_has_api_key() {
		$options = tour_operator()->options;
		if ( false !== $options && isset( $options['googlemaps_key'] ) ) {
			$return = true;
		} else {
			$return = $options;
		}
		return $return;
	}
}

if ( ! function_exists( 'lsx_to_has_map' ) ) {
	/**
	 * Checks if the current item has a map
	 *
	 * @return boolean
	 *
	 * @package tour-operator
	 * @subpackage template-tags
	 * @category general
	 */
	function lsx_to_has_map( $is_enqueque_script = false ) {
		// If the maps are disabled via the settings.
		if ( ! lsx_to_is_map_enabled() || true === apply_filters( 'lsx_to_disable_map', false ) ) {
			return false;
		}

		// Get any existing copy of our transient data.
		$location = get_transient( get_the_ID() . '_location' );
		if ( false === $location ) {
			// It wasn't there, so regenerate the data and save the transient.
			$kml = false;

			if ( is_post_type_archive( 'destination' ) ) {
				$location = array(
					'latitude' => true,
				);
			} elseif ( is_singular( 'tour' ) ) {
				$file_id = get_post_meta( get_the_ID(), 'itinerary_kml', true );

				if ( false !== $file_id ) {
					$kml = wp_get_attachment_url( $file_id );
				}

				$location = false;
				$accommodation_connected = lsx_to_get_tour_itinerary_ids();
				$accommodation_connected = apply_filters( 'lsx_to_maps_tour_connections', $accommodation_connected );
				if ( is_array( $accommodation_connected ) && ! empty( $accommodation_connected ) ) {
					$location = array(
						'latitude' => true,
						'connections' => $accommodation_connected,
					);
				}
			} else {
				$location = get_post_meta( get_the_ID(), 'location', true );
			}

			$location = apply_filters( 'lsx_to_has_maps_location', $location, get_the_ID() );

			if ( false !== $location && '' !== $location && is_array( $location ) && isset( $location['latitude'] ) && '' !== $location['latitude'] ) {
				set_transient( get_the_ID() . '_location', $location, 30 );
				return true;
			} elseif ( false !== $kml ) {
				set_transient(
					get_the_ID() . '_location',
					array(
						'kml' => $kml,
					),
					30
				);
				return true;
			} else {
				return false;
			}
		} else if ( is_array( $location ) && ( ( isset( $location['latitude'] ) && '' !== $location['latitude'] ) || ( isset( $location['kml'] ) && '' !== $location['kml'] ) ) ) {
			return true;
		} else {
			return false;
		}
	}
}
