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

	//
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

		// Regular expression to match any heading tag (h1-h6) with class "itinerary-title"
		$pattern = '/(<h[1-6]\s+[^>]*\bclass="[^"]*\bitinerary-title\b[^"]*"[^>]*>).*?(<\/h[1-6]>)/is';
		// Replacement pattern to insert "test" as the new innerHTML
		$replacement = '$1test$2';
		// Perform the replacement
		$block_content = preg_replace($pattern, $replacement, $block_content);

		return $block_content;
	}
}










