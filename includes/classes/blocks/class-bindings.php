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
	 * Holds instance of the class
	 *
	 * @since   1.1.0
	 * @var     \lsx\blocks\Bindings
	 */
	private static $instance;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_block_bindings' ) );
		add_filter( 'render_block', array( $this, 'lsx_wetu_render_block' ), 10, 3 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return  \lsx\blocks\Bindings
	 */
	public static function init() {

		// If the single instance hasn't been set, set it now.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
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
			'lsx/itinerary-field',
			array(
				'label' => __( 'Itinerary Field', 'lsx-wetu-importer' ),
				'get_value_callback' => array( $this, 'itinerary_field_callback' )
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

	public function itinerary_callback( $source_args, $block_instance ) {
		if ( 'core/paragraph' === $block_instance->parsed_block['blockName'] ) {
			return 'bindings';
		}
	}

	public function itinerary_field_callback( $source_args, $block_instance ) {
		if ( 'core/image' === $block_instance->parsed_block['blockName'] ) {
			$value = 'test_image';
		} elseif ( 'core/paragraph' === $block_instance->parsed_block['blockName'] || 'core/heading' === $block_instance->parsed_block['blockName'] ) {
			$value = 'itin_field';
		}
		return $value;
	}


	function lsx_wetu_render_block( $block_content, $parsed_block, $block_obj ) {
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

		// Create our tag manager object so we can inject the itinerary content.
		/*$tags = new \WP_HTML_Tag_Processor( $block_content );
		if ( $tags->next_tag( array( 'class_name' => 'itinerary-title' ) ) ) {
			print_r('<pre>');
			print_r($tags);
			print_r('</pre>');
		}*/
		//die();

		$pattern = $block_content;
		$group   = array();

		// Iterate through and build our itinerary from the block content template.
		if ( lsx_to_has_itinerary() ) {
			$itinerary_count = 1;
			while ( lsx_to_itinerary_loop() ) {
				lsx_to_itinerary_loop_item();

				$build   = $pattern;
				$build   = $this->build_itinerary_field( $build, 'title' );
				$build   = $this->build_itinerary_field( $build, 'description' );
				$build   = $this->build_itinerary_field( $build, 'location' );
				$build   = $this->build_itinerary_field( $build, 'accommodation' );
				$build   = $this->build_itinerary_field( $build, 'type' );
				$build   = $this->build_itinerary_field( $build, 'drinks' );
				$build   = $this->build_itinerary_field( $build, 'room' );
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
	public function build_itinerary_field( $build = '', $field = '' ) {
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
				$classes = $this->find_description_classes( $build );
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
	 * Finds all class names of the <p> tag that includes the class "itinerary-description".
	 *
	 * @param string $content The original HTML content.
	 * @return string An string containing class names found with "itinerary-description".
	 */
	public function find_description_classes( $content ) {
		$classes = '';

		// Regular expression to match any <p> tag with class "itinerary-description" among other classes
		$pattern = '/<p\s+[^>]*\bclass="([^"]*\bitinerary-description\b[^"]*)"/is';
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
}
