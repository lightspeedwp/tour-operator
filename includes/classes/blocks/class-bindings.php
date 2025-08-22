<?php
namespace lsx\blocks;

use stdClass;

/**
 * Registers our Custom Fields
 *
 * @package lsx
 * @author  LightSpeed
 */
class Bindings {

	/**
	 * Holds array of itinerary fields slugs
	 *
	 * @var array
	 */
	public $itinerary_fields;

	/**
	 * Holds array of unit fields slugs
	 *
	 * @var array
	 */
	public $unit_fields;

	/**
	 * Holds array of unit types
	 *
	 * @var array
	 */
	public $unit_types;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		

		$this->itinerary_fields = array(
			'title',
			'description',
			'location',
			'accommodation',
			'type',
			'drinks',
			'room',
			'included',
			'excluded',
		);
		$this->unit_fields = array(
			'type',
			'title',
			'description',
			'price',
			'gallery',
		);
		$this->unit_types = array(
			'chalet' => esc_html__( 'Chalet', 'tour-operator' ),
			'room'   => esc_html__( 'Room', 'tour-operator' ),
			'spa'    => esc_html__( 'Spa', 'tour-operator' ),
			'tent'   => esc_html__( 'Tent', 'tour-operator' ),
			'villa'  => esc_html__( 'Villa', 'tour-operator' ),
		);
		add_action( 'init', array( $this, 'register_block_bindings' ) );
		add_filter( 'render_block', array( $this, 'render_itinerary_block' ), 10, 3 );
		add_filter( 'render_block', array( $this, 'render_units_block' ), 10, 3 );
		add_filter( 'render_block', array( $this, 'render_gallery_block' ), 10, 3 );
		add_filter( 'render_block', array( $this, 'render_videos_block' ), 10, 3 );
		add_filter( 'render_block', array( $this, 'render_map_block' ), 10, 3 );
		add_filter( 'render_block', array( $this, 'render_permalink_block' ), 10, 3 );
		add_filter( 'render_block_core/cover', array( $this, 'render_banner_block' ), 10, 3 );
	}

	/**
	 * Registers the custom block bindings.
	 *
	 * @return void
	 */
	public function register_block_bindings() {
		if ( ! function_exists( 'register_block_bindings_source' ) ) {
			return;
		}
		register_block_bindings_source(
			'lsx/post-connection',
			array(
				'label' => __( 'Post Connection', 'tour-operator' ),
				'get_value_callback' => array( $this, 'post_connections_callback' )
			)
		);

		register_block_bindings_source(
			'lsx/post-meta',
			array(
				'label' => __( 'Post Meta', 'tour-operator' ),
				'get_value_callback' => array( $this, 'post_meta_callback' )
			)
		);
	
		register_block_bindings_source(
			'lsx/tour-itinerary',
			array(
				'label' => __( 'Itinerary', 'tour-operator' ),
				'get_value_callback' => array( $this, 'empty_callback' )
			)
		);

		register_block_bindings_source(
			'lsx/accommodation-units',
			array(
				'label' => __( 'Units', 'tour-operator' ),
				'get_value_callback' => array( $this, 'empty_callback' )
			)
		);

		register_block_bindings_source(
			'lsx/gallery',
			array(
				'label' => __( 'Gallery', 'tour-operator' ),
				'get_value_callback' => array( $this, 'empty_callback' )
			)
		);

		register_block_bindings_source(
			'lsx/map',
			array(
				'label' => __( 'Map', 'tour-operator' ),
				'get_value_callback' => array( $this, 'empty_callback' )
			)
		);
	}

	/**
	 * Registers the post connections callback.
	 *
	 * @param array $source_args
	 * @param object $block_instance
	 * @return string|int|array
	 */
	public function post_connections_callback( $source_args, $block_instance ) {
		if ( 'core/image' === $block_instance->parsed_block['blockName'] ) {
			return 'test_image';
		} elseif ( 'core/paragraph' === $block_instance->parsed_block['blockName'] ) {
	
			if ( ! isset( $source_args['key'] ) ) {
				return '';
			}

			$value = '';

			switch ( $source_args['key'] ) {

				case 'post_children':
					$children = lsx_to_item_has_children( get_the_ID(), 'destination' );
					if ( false !== $children && ! empty( $children ) ) {
						$value = $this->prep_links( $children );
					}
				break;

				case 'post_parent':
					$args     = new stdClass;
					$args->ID = wp_get_post_parent_id();
					$value    = $this->prep_links( [ $args ] );
				break;

				case 'facilities':
					$value = lsx_to_accommodation_facilities( '', '', false );
				break;

				default:
					// For custom fields.	

					$single = true;
					if ( isset( $source_args['single'] ) ) {
						$single = (bool) $source_args['single'];
					}
			
					// Get the 
					$only_parents = false;
					if ( isset( $source_args['parents'] ) ) {
						$only_parents = (bool) $source_args['parents'];
					}
					
					$value = get_post_meta( get_the_ID(), $source_args['key'], $single );

					if ( false === $value || empty( $value ) ) {
						break;
					}

					if ( ! is_array( $value ) ) {
						$value = [ $value ];
					}
			
					$value  = array_filter( $value );
					$values = array();
					foreach( $value as $pid ) {
						if ( true === $only_parents ) {
							$pid_parent = get_post_parent( $pid );
							if ( null !== $pid_parent ) {
								continue;
							}
						}

						$values[] = apply_filters( 'lsx_to_connected_list_item', '<a href="' . get_permalink( $pid ) . '">' . get_the_title( $pid ) . '</a>', $pid, true );
					}

					$seperator = '';
					if ( 1 < count( $values ) ) {
						$seperator = ', ';
					}
					$value = implode( $seperator, $values );
					
				break;

			}

			return $value;
		}
	}

	/**
	 * Register our post meta callback.
	 *
	 * @param array $source_args
	 * @param object $block_instance
	 * @return string|int|array
	 */
	public function post_meta_callback( $source_args, $block_instance ) {
		$value = '';

		if ( 'core/image' === $block_instance->parsed_block['blockName'] || 'core/cover' === $block_instance->parsed_block['blockName'] ) {

			$key = str_replace( '-', '_', $source_args['key'] );
			$value = get_post_meta( get_the_ID(), $key, true );

			return $value;
		} elseif ( 'core/paragraph' === $block_instance->parsed_block['blockName'] ) {

			$key = str_replace( '-', '_', $source_args['key'] );
	
			$multiples = [
				'best_time_to_visit',
				'spoken_languages',
				'suggested_visitor_types',
				'special_interests'
			];

			$single = true;
			if (  in_array( $key, $multiples )  ) {
				$single = false;
			}
			$saved = lsx_to_custom_field_query( $key, '', '', false, get_the_ID(), $single );

			if ( null !== $saved ) {
				$date_transforms = [
					'booking_validity_start',
					'booking_validity_end',
				];
				if ( in_array( $key, $date_transforms ) ) {
					$saved = wp_date( 'j M Y', $saved );
				}
	
				$value = $saved;
				
			}
		}
		return $value;
	}

	/**
	 * Renders the itinerary block with custom content.
	 *
	 * This function processes the block content by checking if it belongs to a specific
	 * custom block variation and then iteratively builds the itinerary content based on
	 * predefined fields and templates. It returns the final rendered block content.
	 *
	 * @param string $block_content The original content of the block.
	 * @param array  $parsed_block  Parsed data for the block, including type and attributes.
	 * @param object $block_obj     Block object instance for the current block being processed.
	 * 
	 * @return string Returns the modified block content after processing itinerary data.
	 */
	public function render_itinerary_block( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/group'
		);
		$allowed_sources = array(
			'lsx/tour-itinerary'
		);
		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}

		if ( ! isset( $parsed_block['attrs']['metadata']['bindings']['content']['source'] ) ) {
			return $block_content;
		}

		if ( ! in_array( $parsed_block['attrs']['metadata']['bindings']['content']['source'], $allowed_sources ) ) {
			return $block_content;
		}

		$pattern = $block_content;
		$group   = array();

		// Iterate through and build our itinerary from the block content template.
		if ( lsx_to_has_itinerary() ) {
			$itinerary_count = 1;
			while ( lsx_to_itinerary_loop() ) {
				lsx_to_itinerary_loop_item();
				$build   = $pattern;

				foreach ( $this->itinerary_fields as $field ) {
					$build   = $this->build_itinerary_field( $build, $field, $itinerary_count );
				}
				$build   = $this->build_image( $build, 'itinerary-image' );
				$group[] = $build;

				$itinerary_count++;
			}
		}

		$block_content = implode( '', $group );
		return $block_content;
	}

	/**
	 * Modifies the HTML content by updating the innerHTML of any heading tag (h1-h6) 
	 * that has the class "itinerary-title" with the result of the lsx_to_itinerary_title function.
	 *
	 * @param string $build The original HTML content to be modified. Default is an empty string.
	 * @param string $field The field to build.
	 * @return string The modified HTML content where the specified heading tags have updated innerHTML.
	 */
	public function build_itinerary_field( $build = '', $field = '', $count = 1 ) {
		$pattern     = '';
		$value       = '';

		switch ( $field ) {
			case 'title':
				$value   = lsx_to_itinerary_title( false );
				$pattern = '/(<h[1-6]\s+[^>]*\bclass="[^"]*\bitinerary-title\b[^"]*"[^>]*>).*?(<\/h[1-6]>)/is';
			break;

			case 'description':
				$classes = $this->find_description_classes( $build, 'itinerary' );
				if ( '' !== $classes ) {
					$value   = lsx_to_itinerary_description( false );
					$pattern = '/<p\s+[^>]*\bclass="[^"]*\bitinerary-description\b[^"]*"[^>]*>.*?<\/p>/is';
					
					if ( empty( $value ) ) {
						$value = '';
					}
					$value = '<div class="' . $classes . '"/>' . $value . '</div>';
				}
			break;

			case 'location':
				$value   = lsx_to_itinerary_destinations( '', '', false );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-location\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			case 'accommodation':
				$value   = lsx_to_itinerary_accommodation( '', '', false );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-accommodation\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			case 'type':
				$value   = lsx_to_itinerary_accommodation_type( '', '', false );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-type\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			case 'drinks':
				$value = lsx_to_itinerary_drinks_basis( '', '', false );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-drinks\b[^"]*"[^>]*>).*?(<\/p>)/is';	
			break;

			case 'room':
				$value = lsx_to_itinerary_room_basis( '', '', false );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-room\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			case 'included':
				$value = lsx_to_itinerary_includes( '', '', false );
				$value = wp_strip_all_tags( $value, [ 'a', 'ul', 'li', 'ol', 'strong', 'i' ] );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-included\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			case 'excluded':
				$value = lsx_to_itinerary_excludes( '', '', false );
				$value = wp_strip_all_tags( $value, [ 'a', 'ul', 'li', 'ol', 'strong', 'i' ] );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-excluded\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			default:
			break;
		}

		// if the value is emtpy than add a css class to hide the element.
		if ( '' === $value || false === $value || empty( $value ) ) {
			$pattern = '/\bitin-' . $field . '-wrapper\b/';
			$value   = 'hidden itin-' . $field . '-wrapper';
		}

		$replacement = '$1' . $value . '$2';
		$build = preg_replace( $pattern, $replacement, $build);
		
		return $build;
	}

	/**
	 * Modifies the HTML content by updating the innerHTML of any heading tag (h1-h6) 
	 * that has the class "itinerary-title" with the result of the lsx_to_itinerary_title function.
	 *
	 * @param string $build The original HTML content to be modified. Default is an empty string.
	 * @param string $field The field to build.
	 * @return string The modified HTML content where the specified heading tags have updated innerHTML.
	 */
	public function build_image( $build = '', $classname = 'itinerary-image' ) {
		global $rooms;
		//Create our tag manager object so we can inject the itinerary content.
		$tags = new \WP_HTML_Tag_Processor( $build );

		if ( $tags->next_tag( array( 'class_name' => $classname ) ) ) {

			$size = 'medium';
			$classes = $tags->get_attribute( 'class' );
			$classes = explode( ' ', $classes );
			foreach ( $classes as $class ) {
				if ( 0 <= stripos( $class, 'size-' ) ) {
					$size = str_replace( 'size-', '', $class );
				}
			}

			if ( $tags->next_tag( array( 'tag_name' => 'img' ) ) ) {

				if ( 'itinerary-image' === $classname ) {
					$img_src = lsx_to_itinerary_thumbnail( $size );
				} else {
					$img_src = $rooms->item_thumbnail( $size );
				}
				$tags->set_attribute( 'rel', sanitize_key( $classname ) );
				$tags->set_attribute( 'src', $img_src );
				$build = $tags->get_updated_html();
			}
			

			
		}
		
		return $build;
	}

	/**
	 * Renders the units block with custom content.
	 *
	 * This function processes the block content by checking if it belongs to a specific
	 * custom block variation and then iteratively builds the units content based on
	 * predefined fields and templates. It returns the final rendered block content.
	 *
	 * @param string $block_content The original content of the block.
	 * @param array  $parsed_block  Parsed data for the block, including type and attributes.
	 * @param object $block_obj     Block object instance for the current block being processed.
	 * 
	 * @return string Returns the modified block content after processing units data.
	 */
	public function render_units_block( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/group'
		);
		$allowed_sources = array(
			'lsx/accommodation-units'
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}

		if ( ! isset( $parsed_block['attrs']['metadata']['bindings']['content']['source'] ) ) {
			return $block_content;
		}

		if ( ! in_array( $parsed_block['attrs']['metadata']['bindings']['content']['source'], $allowed_sources ) ) {
			return $block_content;
		}

		
		$pattern = $block_content;
		$group   = array();

		// Iterate through and build our unit tempalte from the block content template.
		if ( lsx_to_accommodation_has_rooms() ) {
			// Loop through the rooms outputing only the current type.
			global $rooms;

			$count = 1;
			while ( lsx_to_accommodation_room_loop() ) {
				lsx_to_accommodation_room_loop_item();
				
				$build   = $pattern;
				foreach ( $this->unit_fields as $field ) {
					$build   = $this->build_unit_field( $build, $field, $count );
				}
				$build   = $this->build_image( $build, 'unit-image' );
				$group[] = $build;
				$count++;
				
			}
		}
		$block_content = implode( '', $group );
		return $block_content;
	}

	/**
	 * Modifies the HTML content by updating the innerHTML
	 *
	 * @param string $build The original HTML content to be modified. Default is an empty string.
	 * @param string $field The field to build.
	 * @return string The modified HTML content where the specified heading tags have updated innerHTML.
	 */
	public function build_unit_field( $build = '', $field = '', $count = 1 ) {
		global $rooms;
		$pattern       = '';
		$value         = '';
		$tour_operator = tour_operator();

		switch ( $field ) {
			case 'title':
				$value   = wp_strip_all_tags( $rooms->item_title( '', '', false ) );
				$pattern = '/(<h[1-6]\s+[^>]*\bclass="[^"]*\bunit-title\b[^"]*"[^>]*>).*?(<\/h[1-6]>)/is';
			break;

			case 'description':
				// Maintain any formatting set of the parent tag.
				$classes = $this->find_description_classes( $build, 'unit' );

				if ( '' !== $classes ) {
					$value   = $rooms->item_description( false );
					$pattern = '/<p\s+[^>]*\bclass="[^"]*\bunit-description\b[^"]*"[^>]*>.*?<\/p>/is';
					
					if ( ! empty( $value ) ) {
						$value = '<div class="' . $classes . '"/>' . $value . '</div>';
					}
				}

			break;

			case 'type':
				$value   = $rooms->item_type( '', '', false );
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bunit-type\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			case 'price':
				$value       = $rooms->item_price( '', '', false );
				$letter_code = '';

				if ( is_object( $tour_operator ) && isset( $tour_operator->options['currency'] ) && ! empty( $tour_operator->options['currency'] ) ) {
					$letter_code = $tour_operator->options['currency'];
					$currency = '<span class="currency-icon ' . mb_strtolower( $letter_code ) . '"></span>';
				}

				$value = $currency . $value;

				// Get the currency settings
				if ( is_object( $tour_operator ) &&  ( isset( $tour_operator->options['country_code_disabled'] ) && 0 === intval( $tour_operator->options['country_code_disabled'] ) || ! isset( $tour_operator->options['country_code_disabled'] ) ) ) {
					$value = $letter_code . $value;
				}

				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bunit-price\b[^"]*"[^>]*>).*?(<\/p>)/is';
			break;

			default:
			break;
		}

		// if the value is emtpy than add a css class to hide the element.
		if ( '' === $value ) {
			$pattern = '/\bunit-' . $field . '-wrapper\b/';
			$value   = 'hidden unit-' . $field . '-wrapper';
		}	

		$replacement = '$1 ' . $value . ' $2';
		$build       = preg_replace($pattern, $replacement, $build);
		return $build;
	}

	/**
	 * Finds all class names of the <p> tag that includes the class "itinerary-description".
	 *
	 * @param string $content The original HTML content.
	 * @param string $prefix The css classname prefix before the -description.
	 * @return string An string containing class names found with "{$prefix}-description".
	 */
	public function find_description_classes( $content, $prefix = '' ) {
		$classes = '';

		// Regular expression to match any <p> tag with class "itinerary-description" among other classes
		$pattern = '/<p\s+[^>]*\bclass="([^"]*\b' . $prefix . '-description\b[^"]*)"/is';
		// Array to hold the matches
		$matches = [];
		// Perform the matching
		$match_count = preg_match_all( $pattern, $content, $matches );
		// $matches[1] contains the matched class attribute values

		if ( 0 < $match_count ) {
			$classes = implode( '', $matches[1] );
		}
		return $classes;
	}

	/**
	 * Removes all "class" attributes from a given HTML content.
	 *
	 * @param string $content The original HTML content.
	 * @return string The HTML content without any "class" attributes.
	 */
	function purge_class_attribute( $content ) {
		// Regular expression to match class attributes
		$pattern = '/\s*class="[^"]*"/i';
		// Replace matched class attributes with an empty string
		$result = preg_replace($pattern, '', $content);
		return $result;
	}

	/**
	 * Callback function to process gallery blocks.
	 *
	 * This function checks if the given block instance is of type 'core/group'
	 * and returns an empty string if it is. It serves as a conditional handler
	 * based on the block type.
	 *
	 * @param array $source_args Arguments provided by the source.
	 * @param object $block_instance Instance of the block currently being processed.
	 * 
	 * @return string Returns an empty string if the block is of type 'core/group', otherwise no return value.
	 */
	public function empty_callback( $source_args, $block_instance ) {
		if ( 'core/group' === $block_instance->parsed_block['blockName'] ) {
			return '';
		}
	}

	/**
	 * Renders the gallery block with custom content.
	 *
	 * This function processes the block content by checking if it belongs to a specific
	 * custom block variation and then iteratively builds the gallery content based on
	 * predefined fields and templates. It returns the final rendered block content.
	 *
	 * @param string $block_content The original content of the block.
	 * @param array  $parsed_block  Parsed data for the block, including type and attributes.
	 * @param object $block_obj     Block object instance for the current block being processed.
	 * 
	 * @return string Returns the modified block content after processing gallery data.
	 */
	public function render_gallery_block( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/gallery'
		);
		$allowed_sources = array(
			'lsx/gallery'
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}

		if ( ! isset( $parsed_block['attrs']['metadata']['bindings']['content']['source'] ) ) {
			return $block_content;
		}

		if ( ! in_array( $parsed_block['attrs']['metadata']['bindings']['content']['source'], $allowed_sources ) ) {
			return $block_content;
		}

		// Get the columns setting from block attributes
		$columns = isset( $parsed_block['attrs']['columns'] ) ? $parsed_block['attrs']['columns'] : 3; // Default to 3 if not set

		$gallery = get_post_meta( get_the_ID(), 'gallery', true );

		if ( false === $gallery || empty($gallery ) ) {
			return '';
		}

		if ( ! is_array( $gallery ) ) {
			$gallery = [ $gallery ];
		}

		$classes = $this->find_gallery_classes( $block_content );
		$images  = array();

		$link_prefix = '';
		$link_suffix = '';
		$link        = false;
		if ( isset( $parsed_block['attrs']['linkTo'] ) && 'media' === $parsed_block['attrs']['linkTo'] ) {
			$link = true;
		}

		$target = '';
		if ( isset( $parsed_block['attrs']['linkTarget'] ) ) {
			$target = 'target="' . $parsed_block['attrs']['linkTarget'] . '"';
		}

		$count = 1;
		foreach ( $gallery as $gid => $gurl ) {

			if ( $link ) {
				$link_prefix = '<a ' . $target . ' rel="gallery" href="' . $gurl . '">';
				$link_suffix = '</a>';
			}

			$build = '<figure class="wp-block-image">';
			// phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
			$build .= $link_prefix . '<img src="' . $gurl . '" alt="" class="wp-image-' . $gid . '"/>' . $link_suffix;
			$build .= '</figure>';
			$images[] = $build;
			$count++;
		}
		$block_content = '<figure class="' . $classes . '">' . implode( '', $images ) . '</figure>';
		return $block_content;
	}

	/**
	 * Renders the videos block with custom content.
	 *
	 * This function processes the block content by checking if it belongs to a specific
	 * custom block variation and then iteratively builds the videos content based on
	 * predefined fields and templates. It returns the final rendered block content.
	 *
	 * @param string $block_content The original content of the block.
	 * @param array  $parsed_block  Parsed data for the block, including type and attributes.
	 * @param object $block_obj     Block object instance for the current block being processed.
	 * 
	 * @return string Returns the modified block content after processing gallery data.
	 */
	public function render_videos_block( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/gallery'
		);
		$allowed_sources = array(
			'lsx/videos'
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}

		if ( ! isset( $parsed_block['attrs']['metadata']['bindings']['content']['source'] ) ) {
			return $block_content;
		}

		if ( ! in_array( $parsed_block['attrs']['metadata']['bindings']['content']['source'], $allowed_sources ) ) {
			return $block_content;
		}

		$videos = get_post_meta( get_the_ID(), 'videos', true );

		if ( false === $videos || empty($videos ) ) {
			return '';
		}

		if ( ! is_array( $videos ) || isset( $videos['url'] ) ) {
			$videos = [ $videos ];
		}

		$classes = $this->find_gallery_classes( $block_content );
		$images  = array();
		$count   = 1;

		foreach ( $videos as $index => $vid_data ) {

			$build = '<figure class="wp-block-image wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
			' . wp_oembed_get( $vid_data['url'] ) . '
			</div></figure>';

			$images[] = $build;
			$count++;
		}

		$block_content = '<figure class="lsx-block-videos ' . $classes . '">' . implode( '', $images ) . '</figure>';

		// Ensure the core/embed block styles are loaded for video embeds
		if ( ! wp_style_is( 'wp-block-embed', 'enqueued' ) ) {
			wp_enqueue_style( 'wp-block-embed' );
		}
		return $block_content;
	}

	/**
	 * Finds all class names of the current gallery.
	 *
	 * @param string $content The original HTML content.
	 * @param string $prefix The css classname prefix before the -description.
	 * @return string An string containing class names found with "{$prefix}-description".
	 */
	public function find_gallery_classes( $content ) {
		$classes = '';

		// Regular expression to match any <p> tag with class "itinerary-description" among other classes
		$pattern = '/<figure\s+[^>]*\bclass="([^"]*\bwp-block-gallery\b[^"]*)"/is';
		// Array to hold the matches
		$matches = [];
		// Perform the matching
		$match_count = preg_match_all( $pattern, $content, $matches );
		// $matches[1] contains the matched class attribute values

		if ( 0 < $match_count ) {
			$classes = implode( '', $matches[1] );
		}
		return $classes;
	}

	/**
	 * Renders the map block with custom content.
	 *
	 * This function processes the block content by checking if it belongs to a specific
	 * custom block variation and then iteratively builds the map content based on
	 * predefined fields and templates. It returns the final rendered block content.
	 *
	 * @param string $block_content The original content of the block.
	 * @param array  $parsed_block  Parsed data for the block, including type and attributes.
	 * @param object $block_obj     Block object instance for the current block being processed.
	 * 
	 * @return string Returns the modified block content after processing map data.
	 */
	public function render_map_block( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/group'
		);
		$allowed_sources = array(
			'lsx/map'
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}

		if ( ! isset( $parsed_block['attrs']['metadata']['bindings']['content']['source'] ) ) {
			return $block_content;
		}

		if ( ! in_array( $parsed_block['attrs']['metadata']['bindings']['content']['source'], $allowed_sources ) ) {
			return $block_content;
		}

		$type = 'wetu';
		if ( isset( $parsed_block['attrs']['metadata']['bindings']['content']['type'] ) ) {
			$type = $parsed_block['attrs']['metadata']['bindings']['content']['type'];
		}

		$url_params = [
			'b',
			'd',
			'e',
			'p'
		];
		$url_params = apply_filters( 'lsx_to_wetu_map_url_params', $url_params );

		if ( ! empty( $url_params ) ) {
			$url_params = '?m=' . implode( '', $url_params );
		} else {
			$url_params = '';
		}

		$map = '';
		switch ( $type ) {
			case 'wetu':
				$pattern = '/<figure\b[^>]*>(.*?)<\/figure>/s';

				$post_type = get_post_type();
				$wetu_id   = get_post_meta( get_the_ID(), 'lsx_wetu_id', true );

				switch ( $post_type ) {
					case 'tour':
						$url = 'https://wetu.com/Itinerary/VI/' . $wetu_id . $url_params;
					break;

					case 'accommodation':
						$url = 'https://wetu.com/EmbedMap/' . $url_params . '&ids=' . $wetu_id;
					break;

					default:
						$location = get_post_meta( get_the_ID(), 'location', true );
						if ( isset( $location['lat'] ) && isset( $location['lng'] ) ) {
							$url = 'https://wetu.com/EmbedMap/?center=' . $location['lat'] . ',' . $location['lng'] . '&zoom=5';
						} else {
							$wetu_id = false;
						}
					break;
				}

				if ( ! empty( $wetu_id ) ) {
					$map = '<iframe width="100%" height="500" frameborder="0" allowfullscreen="" class="wetu-map" class="block perfmatters-lazy entered pmloaded" data-src="' . $url . '" data-ll-status="loaded" src="' . $url . '"></iframe>';
					$block_content = preg_replace( $pattern, $map, $block_content );
				}
				
			break;

			case 'google':
				preg_match('/class="([^"]*)"/', $block_content, $matches);
				$class_string = $matches[1];

				if ( lsx_to_has_map() ) {
					$map = lsx_to_map( '', '', false );
					$map = str_replace( 'class="lsx-map"', 'class="lsx-map ' . $class_string . '"', $map );
					$block_content = $map;
				}
			break;

			default:
			break;
		}

		return $block_content;
	}

	/**
	 * Takes an array of IDs and iterate to return the post links.
	 *
	 * @param array $items
	 * @return string
	 */
	public function prep_links( $items ) {
		if ( ! is_array( $items ) ) {
			$items = [ $items ];
		}
		$item_links = [];
		foreach ( $items as $item ) {
			$item_links[] = '<a href="' . get_permalink( $item->ID ) . '" title="' . get_the_title( $item->ID ) . '">' . get_the_title( $item->ID ) . '</a>';
		}
		return implode( ', ', $item_links );
	}

	/**
	 * Renders the p block with custom content.
	 *
	 * @param string $block_content The original content of the block.
	 * @param array  $parsed_block  Parsed data for the block, including type and attributes.
	 * @param object $block_obj     Block object instance for the current block being processed.
	 * 
	 * @return string Returns block with the permalink added.
	 */
	public function render_permalink_block( $block_content, $parsed_block, $block_obj ) {
		// Determine if this is the custom block variation.
		if ( ! isset( $parsed_block['blockName'] ) || ! isset( $parsed_block['attrs'] )  ) {
			return $block_content;
		}
		$allowed_blocks = array(
			'core/button'
		);

		if ( ! in_array( $parsed_block['blockName'], $allowed_blocks, true ) ) {
			return $block_content; 
		}

		if ( ! isset( $parsed_block['attrs']['metadata']['name'] ) ) {
			return $block_content;
		}

		if ( 'Permalink' !== $parsed_block['attrs']['metadata']['name'] ) {
			return $block_content;
		}

		$url           = get_permalink();
		$pattern       = '/#permalink/s';
		$block_content = preg_replace( $pattern, $url, $block_content );

		return $block_content;
	}

	/**
	 * Filter the cover block content.
	 *
	 * @param string $block_content The block content about to be rendered.
	 * @param array  $parsed_block  The full block, including name and attributes.
	 * @param object $instance      The block instance.
	 * @return string Modified block content.
	 */
	public function render_banner_block( $block_content, $parsed_block, $instance ) {
		if ( 'core/cover' !== $parsed_block['blockName'] ) {
			return $block_content;
		}

		if ( ! isset( $parsed_block['attrs']['metadata']['bindings']['content']['source'] ) ) {
			return $block_content;
		}

		if ( ! in_array( $parsed_block['attrs']['metadata']['bindings']['content']['source'], array( 'lsx/post-meta' ), true ) ) {
			return $block_content;
		}

		$image_id = get_post_meta( get_the_ID(), 'banner_image_id', true );

		// If no valid image ID is set, return the original block content.
		if ( empty( $image_id ) ) {
			return $block_content;
		}

		$block_content = $this->rebuild_cover_block_image( $image_id, $block_content );

		return $block_content;
	}

	/**
	 * Rebuilds the cover block content with the correct image data based on an attachment ID.
	 *
	 * @param int    $attachment_id The attachment ID to find the image for.
	 * @param string $block_content The original block content.
	 * @return string The rebuilt block content.
	 */
	public function rebuild_cover_block_image( $attachment_id, $block_content ) {
		if ( ! $attachment_id ) {
			return $block_content;
		}

		// Get base image data.
		$full_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		if ( ! $full_image ) {
			return $block_content;
		}

		// Core-calculated responsive attributes (respects filters/CDN integrations).
		$srcset     = wp_get_attachment_image_srcset( $attachment_id, 'full' );
		$sizes_attr = wp_get_attachment_image_sizes( $attachment_id, 'full' );

		// Create new img tag with all attributes.
		$new_img = sprintf(
			'<img width="%d" height="%d" src="%s" class="wp-block-cover__image-background wp-post-image" alt="" data-object-fit="cover" decoding="async" fetchpriority="high" %s %s',
			(int) $full_image[1],
			(int) $full_image[2],
			esc_url( $full_image[0] ),
			$srcset ? sprintf( 'srcset="%s"', esc_attr( $srcset ) ) : '',
			$sizes_attr ? sprintf( 'sizes="%s"', esc_attr( $sizes_attr ) ) : ''
		);

		// Replace only the Cover's background image.
		$pattern       = '/<img[^>]*class="[^"]*wp-block-cover__image-background[^"]*"[^>]*>/';
		$block_content = preg_replace( $pattern, $new_img . ' />', $block_content, 1 );

		return $block_content;
	}
}
