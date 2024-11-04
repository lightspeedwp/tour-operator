<?php
namespace lsx\blocks;

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
		add_filter( 'render_block', array( $this, 'maybe_hide_varitaion' ), 10, 3 );
	}

	public function register_block_bindings() {
		if ( ! function_exists( 'register_block_bindings_source' ) ) {
			return;
		}
		register_block_bindings_source(
			'lsx/post-connection',
			array(
				'label' => __( 'Post Connection', 'lsx-wetu-importer' ),
				'get_value_callback' => array( $this, 'post_connections_callback' )
			)
		);

		register_block_bindings_source(
			'lsx/post-meta',
			array(
				'label' => __( 'Post Meta', 'lsx-wetu-importer' ),
				'get_value_callback' => array( $this, 'post_meta_callback' )
			)
		);
	
		register_block_bindings_source(
			'lsx/tour-itinerary',
			array(
				'label' => __( 'Tour Itinerary', 'lsx-wetu-importer' ),
				'get_value_callback' => array( $this, 'itinerary_callback' )
			)
		);

		register_block_bindings_source(
			'lsx/accommodation-units',
			array(
				'label' => __( 'Accommodation Units', 'lsx-wetu-importer' ),
				'get_value_callback' => array( $this, 'units_callback' )
			)
		);

		register_block_bindings_source(
			'lsx/gallery',
			array(
				'label' => __( 'TO Gallery', 'lsx-wetu-importer' ),
				'get_value_callback' => array( $this, 'gallery_callback' )
			)
		);
	}

	public function post_connections_callback( $source_args, $block_instance ) {
		if ( 'core/image' === $block_instance->parsed_block['blockName'] ) {
			return 'test_image';
		} elseif ( 'core/paragraph' === $block_instance->parsed_block['blockName'] ) {
	
			// Gets the single
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
	
			if ( is_array( $value ) && ! empty( $value ) ) {
				$values = array();
				foreach( $value as $pid ) {
					if ( true === $only_parents ) {
						$pid_parent = get_post_parent( $pid );
						if ( null !== $pid_parent ) {
							continue;
						}
					}
	
					$values[] = '<a href="' . get_permalink( $pid ) . '">' . get_the_title( $pid ) . '</a>';
				}
				$value = implode( ',', $values );
			} else if ( ! is_array( $value ) && '' !== $value ) {
				
				switch ( $source_args['key'] ) {
					case 'lsx_wetu_id':
						$value = '<iframe width="100%" height="500" frameborder="0" allowfullscreen="" id="wetu_map" data-ll-status="loaded" src="https://wetu.com/Map/indexv2.html?itinerary=' . $value . '?m=b"></iframe>';
						break;
	
					default:
						$value = '<a href="' . get_permalink( $value ) . '">' . get_the_title( $value ) . '</a>';
					break;	
				}
			}
			return $value;
		}
	}

	public function post_meta_callback( $source_args, $block_instance ) {
		if ( 'core/image' === $block_instance->parsed_block['blockName'] ) {
			return 'test_image';
		} elseif ( 'core/paragraph' === $block_instance->parsed_block['blockName'] ) {
	
			$single = true;
			if ( 'best_time_to_visit' === $source_args['key'] ) {
				$single = false;
			}
			$value = lsx_to_custom_field_query( $source_args['key'], '', '', false, get_the_ID(), $single );
		}
		return $value;
	}

	/**
	 * Callback function to process itinerary-related blocks.
	 *
	 * This function checks if the given block instance is of type 'core/paragraph'
	 * and returns an empty string if it is. It serves as a conditional handler
	 * based on the block type.
	 *
	 * @param array $source_args Arguments provided by the source.
	 * @param object $block_instance Instance of the block currently being processed.
	 * 
	 * @return string Returns an empty string if the block is of type 'core/paragraph', otherwise no return value.
	 */
	public function itinerary_callback( $source_args, $block_instance ) {
		if ( 'core/group' === $block_instance->parsed_block['blockName'] ) {
			return '';
		}
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
		$replacement = '';
		switch ( $field ) {
			case 'title':
				// Regular expression to match any heading tag (h1-h6) with class "itinerary-title"
				$pattern     = '/(<h[1-6]\s+[^>]*\bclass="[^"]*\bitinerary-title\b[^"]*"[^>]*>).*?(<\/h[1-6]>)/is';

				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . lsx_to_itinerary_title( false ) . '$2';
			break;

			case 'description':
				// Maintain any formatting set of the parent tag.
				$classes = $this->find_description_classes( $build, 'itinerary' );
				if ( '' !== $classes ) {
					// Regular expression to replace any paragraph with class "itinerary-description"
					$pattern     = '/<p\s+[^>]*\bclass="[^"]*\bitinerary-description\b[^"]*"[^>]*>.*?<\/p>/is';
					// Replacement pattern to insert "test" as the new innerHTML
					$replacement = '$1<div class="' . $classes . '"/>' . lsx_to_itinerary_description( false ) . '</div>$2';
				}
			break;

			case 'location':
				// Regular expression to match any paragraph tag with class "itinerary-location"
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-location\b[^"]*"[^>]*>).*?(<\/p>)/is';
    
				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . lsx_to_itinerary_destinations( '', '', false ) . '$2';
			break;

			case 'accommodation':
				// Regular expression to match any paragraph tag with class "itinerary-accommodation"
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-accommodation\b[^"]*"[^>]*>).*?(<\/p>)/is';
    
				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . lsx_to_itinerary_accommodation( '', '', false ) . '$2';
			break;

			case 'type':
				// Regular expression to match any paragraph tag with class "itinerary-accommodation"
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-type\b[^"]*"[^>]*>).*?(<\/p>)/is';
    
				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . lsx_to_itinerary_accommodation_type( '', '', false ) . '$2';
			break;

			case 'drinks':
				// Regular expression to match any paragraph tag with class "itinerary-accommodation"
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-drinks\b[^"]*"[^>]*>).*?(<\/p>)/is';
    
				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . lsx_to_itinerary_drinks_basis( '', '', false ) . '$2';
			break;

			case 'room':
				// Regular expression to match any paragraph tag with class "itinerary-accommodation"
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bitinerary-room\b[^"]*"[^>]*>).*?(<\/p>)/is';
    
				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . lsx_to_itinerary_room_basis( '', '', false ) . '$2';
			break;

			default:
			break;
		}

		// Perform the replacement if the pattern is not empty
		if ( '' !== $pattern ) {
			$build = preg_replace($pattern, $replacement, $build);
		}
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
			if ( $tags->next_tag( array( 'tag_name' => 'img' ) ) ) {

				if ( 'itinerary-image' === $classname ) {
					$img_src = lsx_to_itinerary_thumbnail();
				} else {
					$img_src = $rooms->item_thumbnail();
				}
				
				$tags->set_attribute( 'src', $img_src );
				$build = $tags->get_updated_html();
			}
		}
		
		return $build;
	}

	/**
	 * Callback function to process itinerary-related blocks.
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
	public function units_callback( $source_args, $block_instance ) {
		if ( 'core/group' === $block_instance->parsed_block['blockName'] ) {
			return '';
		}
	}

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
				$build   = $this->build_image( $build, 'unit-gallery' );
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
		$pattern     = '';
		$replacement = '';
		switch ( $field ) {
			case 'title':
				// Regular expression to match any heading tag (h1-h6) with class "unit-title"
				$pattern = '/(<h[1-6]\s+[^>]*\bclass="[^"]*\bunit-title\b[^"]*"[^>]*>).*?(<\/h[1-6]>)/is';

				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . $rooms->item_title( '', '', false ) . '$2';
			break;

			case 'description':
				// Maintain any formatting set of the parent tag.
				$classes = $this->find_description_classes( $build, 'unit' );
				if ( '' !== $classes ) {
					// Regular expression to replace any paragraph with class "unit-description"
					$pattern     = '/<p\s+[^>]*\bclass="[^"]*\bunit-description\b[^"]*"[^>]*>.*?<\/p>/is';
					// Replacement pattern to insert "test" as the new innerHTML
					$replacement = '$1<div class="' . $classes . '"/>' . $rooms->item_description( false ) . '</div>$2';
				}
			break;

			case 'type':
				// Regular expression to match any paragraph tag with class "unit-type"
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bunit-type\b[^"]*"[^>]*>).*?(<\/p>)/is';
    
				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . $rooms->item_type( '', '', false ) . '$2';
			break;

			case 'price':
				// Regular expression to match any paragraph tag with class "itinerary-accommodation"
				$pattern = '/(<p\s+[^>]*\bclass="[^"]*\bunit-price\b[^"]*"[^>]*>).*?(<\/p>)/is';
    
				// Replacement pattern to insert "test" as the new innerHTML
				$replacement = '$1' . $rooms->item_price( '', '', false ) . '$2';
			break;

			default:
			break;
		}

		// Perform the replacement if the pattern is not empty
		if ( '' !== $pattern ) {
			$build = preg_replace($pattern, $replacement, $build);
		}
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
	public function gallery_callback( $source_args, $block_instance ) {
		if ( 'core/group' === $block_instance->parsed_block['blockName'] ) {
			return '';
		}
	}

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

		//var_dump($parsed_block['attrs']);

		$gallery = get_post_meta( get_the_ID(), 'gallery', true );
		if ( false === $gallery || empty($gallery ) ) {
			return $block_content;
		}

		$classes = $this->find_gallery_classes( $block_content );
		$images  = array();

		$link_prefix = '';
		$link_suffix = '';
		$link        = false;
		if ( isset( $parsed_block['attrs']['linkTo'] ) && 'media' === $parsed_block['attrs']['linkTo'] ) {
			$link = true;
		}

		$count = 1;
		foreach ( $gallery as $gid => $gurl ) {

			if ( $link ) {
				$link_prefix = '<a rel="gallery" href="' . $gurl . '">';
				$link_suffix = '</a>';
			}

			$build = '<figure class="wp-block-image">';
			$build .= $link_prefix . '<img src="' . $gurl . '" alt="" class="wp-image-' . $gid . '"/>' . $link_suffix;
			$build .= '</figure>';
			$images[] = $build;
			$count++;
		}
		$block_content = '<figure class="' . $classes . '">' . implode( '', $images ) . '</figure>';
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

		$pattern = "/lsx-(.*?)-wrapper/";
		preg_match( $pattern, $parsed_block['attrs']['className'], $matches );

		if ( empty( $matches ) ) {
			return $block_content;
		}

		do_action( 'qm/debug', $matches );
		
		if ( ! empty( $matches ) && isset( $matches[0] ) ) {
			// Save the first match to a variable
			$key = str_replace( [ 'lsx-', '-wrapper' ], '', $matches[0] );
		} else {
			return $block_content;
		}

		if ( 0 < stripos( $key, '-query' ) ) {
			
			$query_key      = str_replace( [ '-query' ], '', $key );
			$current_parent = get_post_parent( get_the_ID() );

			switch ( $query_key ) {
				case 'regions':
					// If the current item is not a country
					if ( null !== $current_parent ) {
						return '';
					}

					/**
					 * TODO: we need to check if there are any children.
					 */
				break;

				case 'related-regions':
					// If the current item is a country, then there wont be any other child regions.
					if ( null === $current_parent ) {
						return '';
					}

					/**
					 * TODO: we need to check if there are any other children of the current post parent.
					 */
				default:
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
			$key = str_replace( '-', '_', $key );
			$value = lsx_to_custom_field_query( $key, '', '', false );
			do_action( 'qm/debug', [ $key, $value ] );
			if ( empty( $value ) || '' === $value ) {
				$block_content = '';
			}
		}

		return $block_content;
	}
}
