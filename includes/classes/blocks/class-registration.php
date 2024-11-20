<?php
namespace lsx\blocks;

/**
 * The creation of the block variants and the code to control the display.
 *
 * @package lsx
 * @author  LightSpeed
 */
class Registration {
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_variations_script' ), 10 );
		add_filter( 'query_loop_block_query_vars', array( $this, 'query_args_filter' ), 10, 2 );
		add_filter( 'render_block', array( $this, 'maybe_hide_varitaion' ), 10, 3 );
	}

	/**
	 * Registers our variations block assets
	 *
	 * @return void
	 */
	public function enqueue_block_variations_script() {

		$scripts = [
			'general'       => '',
			'tour'          => '',
			'accommodation' => '',
			'destination'   => '',
			'query-loops'   => '',
		];

		// Make sure the script is only enqueued in the block editor.
		if ( is_admin() && function_exists( 'register_block_type' ) ) {
			
			foreach ( $scripts as $slug => $restrictions ) {
				wp_enqueue_script(
					'lsx-to-block-' . $slug . '-variations',  // Handle for the script.
					LSX_TO_URL . 'assets/js/blocks/' . $slug . '.js', // Path to your JavaScript file.
					array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),  // Dependencies.
					filemtime( LSX_TO_PATH . 'assets/js/blocks/' . $slug . '.js' ), // Versioning with file modification time.
					true  // Enqueue in the footer.
				);
			}

			// Enqueue linked-cover.js
			wp_enqueue_script(
				'lsx-to-linked-cover',
				LSX_TO_URL . 'assets/js/blocks/linked-cover.js',
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-data', 'wp-hooks' ),
				filemtime( LSX_TO_PATH . 'assets/js/blocks/linked-cover.js' )
			);

			// Enqueue linked-cover.js
			wp_enqueue_script(
				'lsx-to-slider-query',
				LSX_TO_URL . 'assets/js/blocks/slider-query.js',
				array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ),
				filemtime( LSX_TO_PATH . 'assets/js/blocks/slider-query.js' )
			);

			if ( array_key_exists( get_post_type(), tour_operator()->get_post_types() ) ) {
				wp_enqueue_script(
					'lsx-to-slotfills',  // Handle for the script.
					LSX_TO_URL . 'assets/js/blocks/slotfills.js', // Path to your JavaScript file.
					array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),  // Dependencies.
					filemtime( LSX_TO_PATH . 'assets/js/blocks/slotfills.js' ), // Versioning with file modification time.
					true  // Enqueue in the footer.
				);
			}
		}
	}

	public function query_args_filter( $query, $block ) {
		$block = $block->parsed_block;

		// Determine if this is the custom block variation.
		if ( ! isset( $block['attrs']['className'] )  ) {
			return $query;
		}
		
		$pattern = "/(lsx|facts)-(.*?)-query/";
		preg_match( $pattern, $block['attrs']['className'], $matches );

		if ( ! empty( $matches ) && isset( $matches[0] ) ) {
			// Save the first match to a variable
			$key = str_replace( [ 'facts-', 'lsx-', '-query' ], '', $matches[0] );
		} else {
			return $query;
		}

		do_action( 'qm/debug', [ $key ] );

		switch ( $key ) {
			case 'regions':
				// We only restric this on the destination post type, in case the block is used on a landing page.
				if ( 'destination' === get_post_type() ) {
					$query['post_parent__in'] = [ get_the_ID() ];
				}
			break;

			case 'related-regions':
				// We only restric this on the destination post type, in case the block is used on a landing page.
				$parent = wp_get_post_parent_id();
				if ( 'destination' === get_post_type() ) {
					$query['post_parent'] = $parent;
					$query['post__not_in'] = [ get_the_ID() ];
				}
			break;

			case 'featured-accommodation':
			case 'featured-tours':
			case 'featured-destinations':
				$query['meta_query'] = array(
					'relation' => 'OR',
					array(
						'key' => 'featured',
						'value' => true,
						'compare' => '=',
					),
				);

			break;
	
			// Accommodation relating to the tour via the destinations.
			case 'accommodation-related-tour':
			case 'tour-related-tour':

			// Tour Query Loops
			case 'tour-related-accommodation':
			case 'accommodation-related-accommodation':

				$to         = '';
				$from       = '';
				$directions = explode( '-related-', $key );
				$to         = $directions[0];
				$from       = $directions[1];

				// Get the current item IDS to exclude
				if ( $to === $from ) {
					$excluded_items = [ get_the_ID() ];
				} else {
					$excluded_items = get_post_meta( get_the_ID(), $to . '_to_' . $from, true );
					if ( ! empty( $excluded_items ) ) {
						if ( ! is_array( $excluded_items ) ) {
							$excluded_items = [ $excluded_items ];
						}
					} else {
						$excluded_items = [];
					}
				}

				// Get the current destinations attached 
				$destinations = get_post_meta( get_the_ID(), 'destination_to_' . $from, true );
				if ( ! empty( $destinations ) ) {
					$items = [];

					foreach ( $destinations as $destination ) {
						$found_items = get_post_meta( $destination, $to . '_to_destination', true );

						if ( ! empty( $found_items ) ) {
							if ( ! is_array( $found_items ) ) {
								$found_items = [ $found_items ];
							}
							$items = array_merge( $items, $found_items );
						}
					}
					if ( ! empty( $items ) ) {
						$items = array_unique( $items );
						$items = array_diff( $items, $excluded_items );
						$query['post__in'] = $items;
					}
				}



				$query['post__not_in'] = $excluded_items;

			break;

			// Destination Query Loops
			case 'tour-related-destination':
			case 'accommodation-related-destination':

			// CPTs Reviews Query Loops
			case 'review-related-tour':
			case 'review-related-accommodation':
			case 'review-related-destination':
				
				$to         = '';
				$from       = '';
				$directions = explode( '-related-', $key );
				$to         = $directions[0];
				$from       = $directions[1];

				$found_items = get_post_meta( get_the_ID(), $to . '_to_' . $from, true );
				if ( false !== $found_items && ! empty( $found_items ) ) {
					if ( ! is_array( $found_items ) ) {
						$found_items = [ $found_items ];
					}
					$query['post__in'] = $found_items;
				} else {
					$query['no_relation'] = true;
					$query['post__in']    = [ get_the_ID() ];
				}

			break;

			default:
			break;
		}

		return $query;
	}

	/**
	 * A function to detect variation, and alter the query args.
	 * 
	 * Following the https://developer.wordpress.org/news/2022/12/building-a-book-review-grid-with-a-query-loop-block-variation/
	 *
	 * @param string|null   $pre_render   The pre-rendered content. Default null.
	 * @param array         $parsed_block The block being rendered.
	 * @param WP_Block|null $parent_block If this is a nested block, a reference to the parent block.
	 */
	public function maybe_hide_varitaion( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/group',
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}
		if ( ! isset( $parsed_block['attrs']['className'] ) || '' === $parsed_block['attrs']['className'] || false === $parsed_block['attrs']['className'] ) {
			return $block_content;
		}

		$pattern = "/(lsx|facts)-(.*?)-wrapper/";
		preg_match( $pattern, $parsed_block['attrs']['className'], $matches );

		if ( empty( $matches ) ) {
			return $block_content;
		}

		if ( ! empty( $matches ) && isset( $matches[0] ) ) {
			// Save the first match to a variable
			$key = str_replace( [ 'facts-', 'lsx-', '-wrapper' ], '', $matches[0] );
		} else {
			return $block_content;
		}

		/*
		 * 1 - Check if it is an itinerary or a units query
		 * 2 - See if it is a post query
		 * 3 - See if it is a taxonomy query
		 * 4 - Lastly default to the custom fields
		 */

		if ( 0 < stripos( $key, '-query' ) ) {
			
			$query_key      = str_replace( [ '-query' ], '', $key );
			$current_parent = get_post_parent( get_the_ID() );

			switch ( $query_key ) {
				case 'regions':
					// If the current item is not a country
					if ( null !== $current_parent ) {
						return '';
					}

					if ( false === lsx_to_item_has_children( get_the_ID(), 'destination' ) ) {
						return '';
					}

				break;

				case 'related-regions':
					// If the current item is a country, then there wont be any other child regions.
					if ( null === $current_parent ) {
						return '';
					}

					if ( false === lsx_to_item_has_children( $current_parent, 'destination' ) ) {
						return '';
					}
				
				break;

				case 'country':
					// If the current item is not a country
					if ( null === $current_parent ) {
						return '';
					}

				break;

				default:

					do_action( 'qm/debug', $query_key );

				break;
			}
		} else if ( taxonomy_exists( $key ) ) {
			// Check to see if this is a taxonomy or a custom field.
			$tax_args = array(
				'fields' => 'ids'
			);
			if ( empty( wp_get_post_terms( get_the_ID(), $key, $tax_args ) ) ) {
				$block_content = '';
			}
		} else {
			$key        = str_replace( '-', '_', $key );
			$key_array  = [ $key ];
			$has_values = false;

			// If this is a wrapper that houses many fields, then we need to review them all.
			if ( 'include_exclude' === $key ) {
				$key_array = [ 'included', 'not_included' ];
			}

			foreach ( $key_array as $meta_key ) {
				$value = lsx_to_custom_field_query( $meta_key, '', '', false );
				
				// we need to see if the posts exist before we can use them
				if ( stripos( $meta_key, '_to_' ) && 0 === $this->post_ids_exist( $value ) ) {
					continue;
				}

				if ( ! empty( $value ) && '' !== $value ) {
					$has_values = true;
				}
			}
			
			if ( false === $has_values ) {
				$block_content = '';
			}
		}

		return $block_content;
	}

	/**
	* Determines if a post exists based on the ID.
	*
	*
	* @global wpdb $wpdb WordPress database abstraction object.
	*
	* @param string $title   Post title.
	* @param string $content Optional. Post content.
	* @param string $date    Optional. Post date.
	* @param string $type    Optional. Post type.
	* @param string $status  Optional. Post status.
	* @return int Post ID if post exists, 0 otherwise.
	*/
	protected function post_ids_exist( $ids ) {
		global $wpdb;

		if ( is_array( $ids ) ) {
			$ids = implode( ',', $ids );
		}

		$ids = wp_unslash( sanitize_post_field( 'id', $ids, 0, 'db' ) );

		$query = "SELECT COUNT(ID)
				  FROM $wpdb->posts
				  WHERE 1=1
				  AND ID IN (%s)
				  AND post_status IN ('draft', 'publish')";

		return (int) $wpdb->get_var( $wpdb->prepare( $query, $ids ) );
	}
}
