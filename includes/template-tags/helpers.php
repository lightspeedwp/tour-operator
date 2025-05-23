<?php
/**
 * Template Tags
 *
 * @package   		tour-operator
 * @subpackage 		template-tags
 * @category 		helpers
 * @license   		GPL3
 */

/* ================== CONDITIONAL ================== */

/**
 * Checks if the current post_type is disabled
 *
 * @param		$post_type | string
 * @return		boolean
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_to_is_single_disabled( $post_type = false, $post_id = false ) {
	return lsx_to_is_helper( $post_type, $post_id, 'disable_single' );
}

/**
 * Checks if the current post_type is disabled
 *
 * @param		$post_type | string
 * @return		boolean
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_to_is_collapsible( $post_type = false, $post_id = false ) {
	return lsx_to_is_helper( $post_type, $post_id, 'disable_collapsible' );
}

/**
 * A helper functions that checks the post type for a specific option
 *
 * @param		$post_type | string
 * @param       $post_id string | boolean
 * @param       $meta_key string | boolean
 * @return		boolean
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_to_is_helper( $post_type = false, $post_id = false, $meta_key = false ) {
	$tour_operator = tour_operator();

	if ( false === $post_type ) {
		$post_type = get_post_type();
	}

	if ( is_object( $tour_operator ) && isset( $tour_operator->options[ $post_type ] ) && isset( $tour_operator->options[ $post_type ][ $meta_key ] ) ) {
		return true;
	} else {
		if ( false === $post_id ) {
			global $post;
			$post_id = $post->ID;
		}

		if ( ! empty( $post_id ) ) {
			$single_desabled = get_post_meta( $post_id, $meta_key, true );

			if ( ! empty( $single_desabled ) ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

/**
 * Check if the current item has child pages or if its a parent ""
 *
 * @param	$post_id string
 * @param	$post_type string
 */
function lsx_to_item_has_children( $post_id = false, $post_type = false ) {
	global $wpdb;

	if ( false === $post_id ) {
		return false;
	}
	if ( false === $post_type ) {
		$post_type = 'page';
	}

	// phpcs:disable WordPress.DB -- Start ignoring
	$children = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID
			FROM {$wpdb->posts}
			WHERE (post_type = %s AND post_status = 'publish')
			AND post_parent = %d
			ORDER BY post_title ASC
			LIMIT 100",
			$post_type,
			$post_id
		)
	);
	// phpcs:enable -- Stop ignoring

	if ( count( $children ) > 0 ) {
		return $children;
	} else {
		return false;
	}
}


/* ==================   HOOKED   ================== */

/**
 * Return post_type section title from the settings page
 *
 * @param		$post_type | string
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_to_get_post_type_section_title( $post_type = false, $section = '', $default = '' ) {
	$section_title = ( ! empty( $section )) ? ($section . '_section_title') : 'section_title';
	$tour_operator = tour_operator();

	if ( false === $post_type ) {
		$post_type = get_post_type();
	}

	if ( is_object( $tour_operator ) && isset( $tour_operator->options[ $post_type ] ) && isset( $tour_operator->options[ $post_type ][ $section_title ] ) && ! empty( $tour_operator->options[ $post_type ][ $section_title ] ) && '' !== $tour_operator->options[ $post_type ][ $section_title ] ) {
		return $tour_operator->options[ $post_type ][ $section_title ];
	} else {
		return $default;
	}
}

/* ================== TAXONOMY ================== */
/**
 * Checks if the current term has a thumbnail
 *
 * @param	$term_id
 */
if ( ! function_exists( 'lsx_to_has_term_thumbnail' ) ) {
	function lsx_to_has_term_thumbnail( $term_id = false ) {
		if ( false !== $term_id ) {
			$term_thumbnail = get_term_meta( $term_id, 'thumbnail', true );

			if ( false !== $term_thumbnail && '' !== $term_thumbnail ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Outputs the current terms thumbnail
 *
 * @param	$term_id string
 */
if ( ! function_exists( 'lsx_to_term_thumbnail' ) ) {
	function lsx_to_term_thumbnail( $term_id = false, $size = 'lsx-thumbnail-single' ) {
		if ( false !== $term_id ) {
			echo wp_kses_post( lsx_to_get_term_thumbnail( $term_id,$size ) );
		}
	}
}
/**
 * Outputs the current terms thumbnail
 *
 * @param	$term_id string
 */
if ( ! function_exists( 'lsx_to_get_term_thumbnail' ) ) {
	function lsx_to_get_term_thumbnail( $term_id = false, $size = 'lsx-thumbnail-single' ) {
		if ( false !== $term_id ) {
			$term_thumbnail_id = get_term_meta( $term_id, 'thumbnail', true );
			$img               = wp_get_attachment_image_src( $term_thumbnail_id,$size );
			$image_url         = $img[0];
			// phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
			$img               = '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="' . esc_url( $image_url ) . '" />';
			$img               = apply_filters( 'lsx_lazyload_slider_images', $img, $term_thumbnail_id, $size, false, $image_url );
			return $img;
		}
	}
}
/**
 * Gets the current connected team member panel
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_to_term_tagline( $term_id = false, $before = '', $after = '', $echo = true ) {
	if ( false !== $term_id ) {
		$taxonomy_tagline = get_term_meta( $term_id, 'tagline', true );

		if ( false !== $taxonomy_tagline && '' !== $taxonomy_tagline ) {
			$return = $before . $taxonomy_tagline . $after;

			if ( $echo ) {
				echo wp_kses_post( $return );
			} else {
				return $return;
			}
		}
	}
}

/* ==================   QUERY    ================== */

/**
 * Checks if a custom field query exists, and set a transient for it, so we dont have to query it again later.
 *
 * @param		$meta_key	| string
 * @param		$single		| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_to_has_custom_field_query( $meta_key = false, $id = false, $is_tax = false ) {
	if ( false !== $meta_key ) {
		$custom_field = get_transient( $id . '_' . $meta_key );

		if ( false === $custom_field ) {
			if ( $is_tax ) {
				$custom_field = get_term_meta( $id, $meta_key, true );
			} else {
				$custom_field = get_post_meta( $id, $meta_key, true );
			}

			if ( false !== $custom_field && '' !== $custom_field ) {
				set_transient( $id . '_' . $meta_key, $custom_field, 30 );
				return true;
			}
		} else {
			return true;
		}
	}

	return false;
}

/**
 * Queries a basic custom field
 *
 * @param		$meta_key	| string
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_to_custom_field_query( $meta_key = false, $before = '', $after = '', $echo = false, $post_id = false, $single = true ) {
	if ( false !== $meta_key ) {
		//Check to see if we already have a transient set for this.
		// TODO Need to move this to enclose the entire function and change to a !==,  that way you have to set up the custom field via the lsx_to_has_{custom_field} function
		if ( false === $post_id ) {
			$post_id = get_the_ID();
		}

		$value = get_transient( $post_id . '_' . $meta_key );
		if ( defined( 'WP_DEBUG' ) && ( true === WP_DEBUG || 'true' === WP_DEBUG ) ) {
			$value = false;
		}

		if ( false === $value || '' === $value ) {
			$value = get_post_meta( $post_id, $meta_key, $single );

			if ( is_array( $value ) ) {
				$value = array_unique( $value );

				//Try to exclude any old data
				$old_data_keys = [
					'special_interests'
				];
				if ( in_array( $meta_key, $old_data_keys ) ) {
					foreach ( $value as $vkey => $vv ) {
						if ( is_array( $vv ) ) {
							unset( $value[ $vkey ] );
						}
					}
				}

				$value = implode( ', ', $value );
			}
		}

		if ( false !== $value && '' !== $value ) {
			$return_html = $before . $value . $after;

			$return = apply_filters( 'lsx_to_custom_field_query', $return_html, $meta_key, $value, $before, $after );

			if ( $echo ) {
				// wp_kses_post is removing data-price-XX attribute.
				// we tried to use 'wp_kses_allowed_html' on LSX Currencies without success
				// echo wp_kses_post( $return );
				// @codingStandardsIgnoreStart
				echo $return;
				// @codingStandardsIgnoreEnd
			} else {
				return $return;
			}
		}
	}
}

/**
 * Outputs a list of the ids you give it
 *
 * @param		$connected_ids | array() | the array of ids
 * @param		$type | string | the post type
 * @param		$link | boolean | link the items or not
 * @param		$seperator | string | what to seperate the items by.
 *
 * @package 	lsx-framework
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_to_connected_list( $connected_ids = false, $type = false, $link = true, $seperator = ', ', $parent = false ) {
	if ( false === $connected_ids || false === $type ) {
		return false;
	} else {
		if ( ! is_array( $connected_ids ) ) {
			$connected_ids = explode( ',', $connected_ids );
		}

		$filters = array(
			'post_type'   => $type,
			'post_status' => 'publish',
			'post__in'	  => $connected_ids,
			'orderby'     => 'post__in',
		);

		if ( false !== $parent ) {
			$filters['post_parent'] = $parent;
		}

		$connected_query = get_posts( $filters );

		if ( is_array( $connected_query ) ) {
			global $post;

			$post_original = $post;
			$connected_list = array();

			foreach ( $connected_query as $cp ) {
				$post = $cp;
				$html = '';

				if ( $link ) {
					$has_single = ! lsx_to_is_single_disabled( $type, $cp->ID );
					$permalink = '';

					if ( $has_single ) {
						$permalink = get_the_permalink( $cp->ID );
					} elseif ( is_search() || ! is_post_type_archive( $type ) ) {
						$has_single = true;
						$permalink = get_post_type_archive_link( $type ) . '#' . $type . '-' . $cp->post_name;
					}

					$html .= '<a href="' . $permalink . '">';
				}

				$html .= get_the_title( $cp->ID );

				if ( $link ) {
					$html .= '</a>';
				}

				$html = apply_filters( 'lsx_to_connected_list_item', $html, $cp->ID, $link );
				$connected_list[] = $html;
			}

			$post = $post_original;

			return implode( $seperator, $connected_list );
		}
	}
}

/**
 * Outputs the country label or the country code based on the string you send
 *
 * @param $value string
 * @param $label boolean default true
 * @return string
 */
function to_country_data( $value = '', $label = true ) {
	$return = '';
	$data = include LSX_TO_PATH . '/includes/constants/country-codes.php';

	if ( true === $label ) {
		if ( isset( $data[ $value ] ) ) {
			$return = $data[ $value ];
		}
	} else {
		if ( in_array( $value, $data ) ) {
			$return = array_search( $value, $data );

		}
	}

	return $return;
}

/**
 * Output the provided countries continent code
 *
 * @param $country_code string
 * @return string
 */
function to_continent_code( $country_code = '' ) {
	$return = '';
	$continents = include LSX_TO_PATH . '/includes/constants/continents-codes.php';
	if ( isset( $continents[ $country_code ] ) ) {
		$return = $continents[ $country_code ];
	}
	return $return;
}

/**
 * Output the provided continent codes label
 *
 * @param $continent_code string
 * @return string
 */
function to_continent_label( $continent_code = '' ) {
	$return = '';
	$labels = array(
		'AF' => esc_html__( 'Africa', 'tour-operator' ),
		'AS' => esc_html__( 'Asia', 'tour-operator' ),
		'EU' => esc_html__( 'Europe', 'tour-operator' ),
		'OC' => esc_html__( 'Oceania', 'tour-operator' ),
		'NA' => esc_html__( 'North America', 'tour-operator' ),
		'SA' => esc_html__( 'South America', 'tour-operator' ),
		'AN' => esc_html__( 'Antarctica', 'tour-operator' ),
	);
	if ( isset( $labels[ $continent_code ] ) ) {
		$return = $labels[ $continent_code ];
	}
	return $return;
}

/**
 * Output the provided countries continent code
 *
 * @param $country_code string
 * @return string
 */
function to_continent_region_label( $country_code = '' ) {
	$return = '';
	$intermediate_regions = include LSX_TO_PATH . '/includes/constants/continent-intermediate-regions.php';
	if ( isset( $intermediate_regions[ $country_code ] ) ) {
		$return = $intermediate_regions[ $country_code ];
	} else {
		$regions = include LSX_TO_PATH . '/includes/constants/continent-regions.php';
		if ( isset( $regions[ $country_code ] ) ) {
			$return = $regions[ $country_code ];
		}
	}
	return $return;
}

/**
 * Gets the price type label based on the index
 *
 * @param string $label_index the index of the label you want to retrive.
 * @return string
 */
function lsx_to_get_price_type_label( $label_index = '' ) {
	$label = ''; 
	switch ( $label_index ) {
		case '':
			$label = '';
			break;

		case 'per_person_per_night':
			$label = esc_html__( 'Per Person Per Night', 'tour-operator' );
			break;

		case 'per_person_sharing':
			$label = esc_html__( 'Per Person Sharing', 'tour-operator' );
			break;

		case 'per_person_sharing_per_night':
			$label = esc_html__( 'Per Person Sharing Per Night', 'tour-operator' );
			break;

		case 'total_percentage':
			$label = esc_html__( 'Percentage Off Your Price.', 'tour-operator' );
			break;

		default:
			$label = '';
			break;
	}
	$label = apply_filters( 'lsx_to_price_type_label', $label );
	return $label;
}
