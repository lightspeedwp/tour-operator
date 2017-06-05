<?php
/**
 * Tour Operator Helper Functions
 *
 * @package   tour_operator
 * @author    David Cramer
 * @license   GPL-2.0+
 * @copyright 2017 David Cramer
 */

/**
 * Tour Operator class autoloader.
 * It locates and finds class via classes folder structure.
 *
 * @since 1.0.7
 *
 * @param string $class class name to be checked and loaded.
 */
function tour_operator_autoload_class( $class ) {
	$parts = explode( '\\', $class );
	$name  = strtolower( str_replace( '_', '-', array_shift( $parts ) ) );
	if ( file_exists( LSX_TO_PATH . 'classes/' . $name ) ) {
		if ( ! empty( $parts ) ) {
			$name .= '/' . implode( '/', $parts );
		}
		$class_file = LSX_TO_PATH . 'classes/class-' . $name . '.php';
		if ( file_exists( $class_file ) ) {
			include_once $class_file;
		}
	} elseif ( empty( $parts ) && file_exists( LSX_TO_PATH . 'classes/class-' . $name . '.php' ) ) {
		include_once LSX_TO_PATH . 'classes/class-' . $name . '.php';
	}
}

/**
 * Tour Operator Helper to load and manipulate the overall instance.
 *
 * @since 1.0.7
 * @return  Tour_Operator  A single instance
 */
function tour_operator() {
	// Init tour operator and return object.
	return Tour_Operator::get_instance();
}

/**
 * Returns an array of the tour taxonomies.
 *
 * @since unknown
 * @return array List of tour operator taxonomies.
 */
function lsx_to_get_taxonomies() {
	return tour_operator()->get_taxonomies();
}

/**
 * Returns an array of the tour post types.
 *
 * @since unknown
 * @return array List of tour operator post types.
 */
function lsx_to_get_post_types() {
	return tour_operator()->get_post_types();
}

/**
 * Checks if the current tour has an itinerary
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_has_itinerary() {
	global $tour_itinerary;
	$has_itinerary = false;
	if ( null === $tour_itinerary ) {
		$tour_itinerary = new LSX_TO_Itinerary_Query();
	}
	if ( is_object( $tour_itinerary ) ) {
		$has_itinerary = $tour_itinerary->has_itinerary();
	}

	return $has_itinerary;
}

/**
 * Runs the current itinerary loop, used in a "while" statement
 * e.g  while(lsx_to_itinerary_loop()) {lsx_to_itinerary_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_loop() {
	global $tour_itinerary;
	if ( is_object( $tour_itinerary ) ) {
		return $tour_itinerary->while_itinerary();
	} else {
		return false;
	}
}

/**
 * Sets up the current itinerary itinerary
 * e.g  while(lsx_to_itinerary_loop()) {lsx_to_itinerary_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_loop_item() {
	global $tour_itinerary;
	if ( is_object( $tour_itinerary ) ) {
		$tour_itinerary->current_itinerary_item();
	}
}

/**
 * resets the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_loop_reset() {
	global $tour_itinerary;
	if ( is_object( $tour_itinerary ) ) {
		$tour_itinerary->reset_loop();
	}
}

/**
 * Outputs The current Itinerary title, can only be used in the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_title() {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( false !== $tour_itinerary->itinerary['title'] ) {
			$title = apply_filters( 'the_title', $tour_itinerary->itinerary['title'] );
			echo wp_kses_post( $title );
		}
	}
}

/**
 * Outputs The current Itinerary slug, can only be used in the itinerary loop
 * as an ID.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_slug() {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( false !== $tour_itinerary->itinerary['title'] ) {
			echo wp_kses_post( sanitize_title( $tour_itinerary->itinerary['title'] ) );
		}
	}
}

/**
 * Outputs The current Itinerary Tagline, can only be used in the itinerary
 * loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_tagline() {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( isset( $tour_itinerary->itinerary['tagline'] ) && false !== $tour_itinerary->itinerary['tagline'] ) {
			echo wp_kses_post( apply_filters( 'the_title', $tour_itinerary->itinerary['tagline'] ) );
		}
	}
}

/**
 * Outputs The current Itinerary description, can only be used in the itinerary
 * loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_description() {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( false !== $tour_itinerary->itinerary['description'] ) {
			echo wp_kses_post( apply_filters( 'the_content', $tour_itinerary->itinerary['description'] ) );
		}
	}
}

/**
 * Checks if the current itinerary item has a thumbnail.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_has_thumbnail() {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary ) {
		return true;
	}
}

/**
 * Outputs The current Itinerary thumbnail, can only be used in the itinerary
 * loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */

function lsx_to_itinerary_thumbnail() {
	global $tour_itinerary;

	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		$thumbnail_src = false;

		if ( false !== $tour_itinerary->itinerary['featured_image'] && '' !== $tour_itinerary->itinerary['featured_image'] ) {
			$tour_itinerary->save_used_image( $tour_itinerary->itinerary['featured_image'] );
			$thumbnail = wp_get_attachment_image_src( $tour_itinerary->itinerary['featured_image'], 'lsx-thumbnail-wide' );
			if ( is_array( $thumbnail ) ) {
				$thumbnail_src = $thumbnail[0];
			}
		} elseif ( isset( $tour_itinerary->itinerary['accommodation_to_tour'] ) && ! empty( $tour_itinerary->itinerary['accommodation_to_tour'] ) ) {
			$accommodation_images = false;

			foreach ( $tour_itinerary->itinerary['accommodation_to_tour'] as $accommodation_id ) {
				$tour_itinerary->register_current_gallery( $accommodation_id );
				$current_image_id = false;

				//Try for a thumbnail first.
				$temp_id = get_post_thumbnail_id( $accommodation_id );
				if ( false === $temp_id || $tour_itinerary->is_image_used( $temp_id ) ) {
					$current_image_id = $tour_itinerary->find_next_image( $accommodation_id );
				} else {
					$current_image_id = $temp_id;
				}

				if ( false !== $current_image_id ) {
					$tour_itinerary->save_used_image( $current_image_id );
					$temp_src_array = wp_get_attachment_image_src( $current_image_id, 'lsx-thumbnail-wide' );
					if ( is_array( $temp_src_array ) ) {
						$accommodation_images[] = $temp_src_array[0];
					}
				}
			}

			if ( false !== $accommodation_images ) {
				$thumbnail_src = $accommodation_images[0];
			}
		}

		$thumbnail_src = apply_filters( 'lsx_to_itinerary_thumbnail_src', $thumbnail_src, $tour_itinerary->index, $tour_itinerary->count );

		//Check weather or not to display the placeholder.
		if ( false === $thumbnail_src || '' === $thumbnail_src ) {
			$thumbnail_src = LSX_TO_Placeholders::placeholder_url( null, 'tour' );
		}
		echo wp_kses_post( apply_filters( 'lsx_to_lazyload_filter_images', '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="' . $thumbnail_src . '" />' ) );
	}
}

/**
 * Outputs The current Itinerary connected destinations, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_destinations( $before = '', $after = '' ) {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( is_array( $tour_itinerary->itinerary['destination_to_tour'] ) && ! empty( $tour_itinerary->itinerary['destination_to_tour'] ) ) {
			echo wp_kses_post( $before . lsx_to_connected_list( $tour_itinerary->itinerary['destination_to_tour'], 'destination', true, ', ' ) . $after );
		}
	}
}

/**
 * Outputs The current Itinerary connected accommodation, can only be used in
 * the itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_accommodation( $before = '', $after = '' ) {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( is_array( $tour_itinerary->itinerary['accommodation_to_tour'] ) && ! empty( $tour_itinerary->itinerary['accommodation_to_tour'] ) ) {
			echo wp_kses_post( $before . lsx_to_connected_list( $tour_itinerary->itinerary['accommodation_to_tour'], 'accommodation', true, ', ' ) . $after );
		}

		//display the additional accommodation information.
		foreach ( $tour_itinerary->itinerary['accommodation_to_tour'] as $accommodation ) {
			lsx_to_accommodation_rating( '<div class="meta rating">' . __( 'Rating', 'tour-operator' ) . ': ', '</div>', $accommodation );
			the_terms( $accommodation, 'accommodation-type', '<div class="meta accommodation-type">' . __( 'Type', 'tour-operator' ) . ': ', ', ', '</div>' );
			lsx_to_accommodation_special_interests( '<div class="meta special_interests">' . __( 'Special Interests', 'tour-operator' ) . ': <span>', '</span></div>', $accommodation );
		}
	}
}

/**
 * Outputs The current Itinerary connected activities, can only be used in the
 * itinerary loop.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_activities( $before = '', $after = '' ) {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( isset( $tour_itinerary->itinerary['activity_to_tour'] ) && is_array( $tour_itinerary->itinerary['activity_to_tour'] ) && ! empty( $tour_itinerary->itinerary['activity_to_tour'] ) ) {
			echo wp_kses_post( $before . lsx_to_connected_list( $tour_itinerary->itinerary['activity_to_tour'], 'activity', true, ', ' ) . $after );
		}
	}
}

/**
 * Outputs the 'itinerary' class.
 *
 * @param    $classes string or array
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_class( $classes = false ) {
	global $post;

	if ( false !== $classes ) {
		if ( ! is_array( $classes ) ) {
			$classes = explode( ' ', $classes );
		}
		$classes = apply_filters( 'lsx_to_itinerary_class', $classes, $post->ID );
	}
	echo 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
}


/**
 * Outputs the 'read more' button if needed.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_read_more() {
	if ( lsx_to_itinerary_needs_read_more() ) {
		$label = esc_html__( 'Read More', 'tour-operator' )
		?>
        <div class="view-more aligncenter">
            <a href="#"
               class="btn"><?php esc_html_e( $label, 'tour-operator' ); ?></a>
        </div>
		<?php
	}
}

/**
 * checks if the read more should be outputted
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_needs_read_more() {
	return apply_filters( 'lsx_itinerary_needs_read_more', false );
}

/**
 * Gets the days included field
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_includes( $before = '', $after = '' ) {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( ! empty( $tour_itinerary->itinerary['included'] ) ) {
			echo wp_kses_post( $before . $tour_itinerary->itinerary['included'] . $after );
		}
	}
}

/**
 * Gets the days excluded field
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      itinerary
 */
function lsx_to_itinerary_excludes( $before = '', $after = '' ) {
	global $tour_itinerary;
	if ( $tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary ) {
		if ( ! empty( $tour_itinerary->itinerary['excluded'] ) ) {
			echo wp_kses_post( $before . $tour_itinerary->itinerary['excluded'] . $after );
		}
	}
}

/**
 * Checks if the current accommodation has rooms
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      accommodation
 */
function lsx_to_accommodation_has_rooms() {
	global $rooms;
	$have_rooms = false;
	if ( null === $rooms ) {
		$rooms = new LSX_TO_Unit_Query();
	}
	if ( is_object( $rooms ) ) {
		$have_rooms = $rooms->have_query();
	}

	return $have_rooms;
}

/**
 * Runs the current room loop, used in a "while" statement
 * e.g  while(lsx_to_accommodation_room_loop())
 * {lsx_to_accommodation_room_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_loop() {
	global $rooms;
	if ( is_object( $rooms ) ) {
		return $rooms->while_query();
	} else {
		return false;
	}
}

/**
 * Sets up the current room
 * e.g  while(lsx_to_accommodation_room_loop())
 * {lsx_to_accommodation_room_loop_item();}
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_loop_item( $type = false ) {
	global $rooms;
	if ( is_object( $rooms ) ) {
		return $rooms->current_queried_item( $type );
	} else {
		return false;
	}
}

/**
 * Outputs The current Rooms title
 *
 * @param        $before | string
 * @param        $after  | string
 * @param        $echo   | boolean
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_title( $before = "", $after = "", $echo = true ) {
	global $rooms;
	if ( is_object( $rooms ) ) {
		$rooms->item_title( $before, $after, $echo );
	}
}

/**
 * Outputs The current Rooms Description
 *
 * @param        $before | string
 * @param        $after  | string
 * @param        $echo   | boolean
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_description( $before = "", $after = "", $echo = true ) {
	global $rooms;
	if ( is_object( $rooms ) ) {
		$rooms->item_description( $before, $after, $echo );
	}
}

/**
 * Checks if the current room item has a thumbnail.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_has_thumbnail() {
	global $rooms;
	if ( $rooms && $rooms->have_query ) {
		return true;
	}
}

/**
 * Outputs The current Room thumbnail
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_room_thumbnail( $before = "", $after = "", $echo = true ) {
	global $rooms;
	if ( is_object( $rooms ) ) {
		$rooms->item_thumbnail( $before, $after, $echo );
	}
}

/**
 * Checks if the current type has units.
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_check_type( $type = false ) {
	global $rooms;

	return $rooms->check_type( $type );
}

/**
 * Resets the loop
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      room
 */
function lsx_to_accommodation_reset_units_loop() {
	global $rooms;

	return $rooms->reset_loop();
}

/**
 * Outputs various units attached to the accommodation
 *
 * @package       tour-operator
 * @subpackage    template-tags
 * @category      unit
 */
function lsx_to_accommodation_units( $before = "", $after = "" ) {
	global $rooms;

	if ( lsx_to_accommodation_has_rooms() ) {

		$unit_types = array(
			'chalet' => esc_html__( 'Chalet', 'tour-operator' ),
			'room'   => esc_html__( 'Room', 'tour-operator' ),
			'spa'    => esc_html__( 'Spa', 'tour-operator' ),
			'tent'   => esc_html__( 'Tent', 'tour-operator' ),
			'villa'  => esc_html__( 'Villa', 'tour-operator' ),
		);
		foreach ( $unit_types as $type_key => $type_label ) {
			if ( lsx_to_accommodation_check_type( $type_key ) ) {
				?>
                <section id="<?php echo esc_attr( $type_key ); ?>s">
                    <h2 class="section-title"><?php esc_html_e( lsx_to_get_post_type_section_title( 'accommodation', $type_key . 's', $type_label . 's' ), 'tour-operator' ); ?></h2>
                    <div class="<?php echo esc_attr( $type_key ); ?>s-content rooms-content row">
						<?php while ( lsx_to_accommodation_room_loop() ) { ?>

							<?php if ( ! lsx_to_accommodation_room_loop_item( $type_key ) ) {
								continue;
							} ?>

                            <div class="panel col-sm-6">
                                <article class="unit type-unit">
                                    <div class="col-sm-4">
										<?php if ( lsx_to_accommodation_room_has_thumbnail() ) { ?>
                                            <div class="thumbnail">
												<?php lsx_to_accommodation_room_thumbnail(); ?>
                                            </div>
										<?php } ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="unit-info">
											<?php lsx_to_accommodation_room_title( '<h3>', '</h3>' ); ?>
											<?php lsx_to_accommodation_room_description( '<div class="entry-content">', '</div>' ); ?>
                                        </div>
                                    </div>
                                </article>
                            </div>

						<?php }
						lsx_to_accommodation_reset_units_loop(); ?>
                    </div>
                </section>
			<?php }
		}
	}
}

/**
 * SCP Order Uninstall hook
 */
register_uninstall_hook( __FILE__, 'lsx_to_scporder_uninstall' );

function lsx_to_scporder_uninstall() {
	global $wpdb;

	if ( function_exists( 'is_multisite' ) && is_multisite() ) {
		$curr_blog = $wpdb->blogid;
		$blogids   = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

		foreach ( $blogids as $blog_id ) {
			switch_to_blog( $blog_id );
			lsx_to_scporder_uninstall_db();
		}

		switch_to_blog( $curr_blog );
	} else {
		lsx_to_scporder_uninstall_db();
	}
}

function lsx_to_scporder_uninstall_db() {
	global $wpdb;
	$result = $wpdb->query( "DESCRIBE $wpdb->terms `lsx_to_term_order`" );

	if ( $result ) {
		$result = $wpdb->query( "ALTER TABLE $wpdb->terms DROP `lsx_to_term_order`" );
	}

	delete_option( 'lsx_to_scporder_install' );
}
