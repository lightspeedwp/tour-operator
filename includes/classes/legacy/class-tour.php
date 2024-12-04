<?php
/**
 * Tour Post Type Class
 *
 * @package   Tour
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package Tour
 * @author  LightSpeed
 */
class Tour {

	/**
	 * The slug for this plugin
	 *
	 * @since 1.0.0
	 * @var      string
	 */
	protected $slug = 'tour';

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 * @var      object
	 */
	public $search_fields = false;

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function __construct() {
		$this->options = get_option( '_lsx-to_settings', false );

		if ( false !== $this->options && isset( $this->options[ $this->slug ] ) && ! empty( $this->options[ $this->slug ] ) ) {
			$this->options = $this->options[ $this->slug ];
		} else {
			$this->options = false;
		}

		// activate property post type.
		add_action( 'init', array( $this, 'set_vars' ) );

		include( 'class-itinerary-query.php' );

		add_filter( 'lsx_to_itinerary_class', array( $this, 'itinerary_class' ) );
		add_filter( 'lsx_to_itinerary_needs_read_more', array( $this, 'itinerary_needs_read_more' ) );

		$this->is_wetu_active = false;

		add_filter( 'lsx_to_custom_field_query', array( $this, 'price_filter' ), 10, 5 );

		add_filter( 'lsx_to_custom_field_query', array( $this, 'rating' ), 10, 5 );

		add_action( 'lsx_to_modal_meta', array( $this, 'content_meta' ) );

		add_filter( 'body_class', array( $this, 'tour_classes' ), 10, 1 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Test to see if wetu is active
	 *
	 * @return    null
	 */
	public function set_vars() {
		if ( class_exists( 'WETU_Importer' ) ) {
			$this->is_wetu_active = true;
		}
	}

	/**
	 * returns the itinerary metabox fields
	 */
	public function itinerary_class( $classes ) {
		global $tour_itinerary;

		if ( false !== $this->options && isset( $this->options['shorten_itinerary'] ) ) {
			if ( $tour_itinerary->index > 3 ) {
				$classes[] = 'hidden';
			}
		}

		return $classes;
	}

	/**
	 * Outputs the read more button if needed
	 */
	public function itinerary_needs_read_more( $return ) {
		if ( false !== $this->options && isset( $this->options['shorten_itinerary'] ) ) {
			$return = true;
		}

		return $return;
	}

	/**
	 * Adds in additional info for the price custom field
	 */
	public function price_filter( $html = '', $meta_key = false, $value = false, $before = '', $after = '' ) {
		$currency_fields = [
			'price',
			'single_supplement'
		];

		if ( get_post_type() === 'tour' && in_array( $meta_key, $currency_fields ) ) {
			$value         = preg_replace( '/[^0-9,.]/', '', $value );
			$value         = ltrim( $value, '.' );
			$value         = str_replace( ',', '', $value );
			$value         = number_format( (int) $value, 2 );
			$tour_operator = tour_operator();
			$currency      = '';

			if ( is_object( $tour_operator ) && isset( $tour_operator->options['currency'] ) && ! empty( $tour_operator->options['currency'] ) ) {
				$currency = $tour_operator->options['currency'];
				$currency = '<span class="currency-icon ' . strtolower( $currency ) . '">' . $currency . '</span>';
			}

			$value = $currency . $value;
			$html  = $before . $value . $after;
		}
		return $html;
	}

	/**
	 * Filter and make the star ratings
	 */
	public function rating( $html = '', $meta_key = false, $value = false, $before = '', $after = '' ) {
		if ( get_post_type() === 'tour' && 'rating' === $meta_key ) {
			$ratings_array = array();
			$counter       = 5;

			while ( $counter > 0 ) {
				if ( $value >= 0 ) {
					$ratings_array[] = '<i class="fa fa-star"></i>';
				} else {
					$ratings_array[] = '<i class="fa fa-star-o"></i>';
				}

				$counter --;
				$value --;
			}

			$rating_type        = get_post_meta( get_the_ID(), 'rating_type', true );
			$rating_description = '';

			if ( false !== $rating_type && '' !== $rating_type && esc_html__( 'Unspecified', 'tour-operator' ) !== $rating_type ) {
				$rating_description = ' <small>(' . $rating_type . ')</small>';
			}

			$html = $before . implode( '', $ratings_array ) . $rating_description . $after;

		}

		return $html;
	}

	/**
	 * Outputs the tour meta on the modal
	 */
	public function content_meta() {
		if ( 'tour' === get_post_type() ) { 
        ?>
			<?php
				$meta_class = 'lsx-to-meta-data lsx-to-meta-data-';

				lsx_to_price( '<span class="' . $meta_class . 'price"><span class="lsx-to-meta-data-key">' . esc_html__( 'From price', 'tour-operator' ) . ':</span> ', '</span>' );
				lsx_to_duration( '<span class="' . $meta_class . 'duration"><span class="lsx-to-meta-data-key">' . esc_html__( 'Duration', 'tour-operator' ) . ':</span> ', '</span>' );
				the_terms( get_the_ID(), 'travel-style', '<span class="' . $meta_class . 'style"><span class="lsx-to-meta-data-key">' . esc_html__( 'Travel Style', 'tour-operator' ) . ':</span> ', ', ', '</span>' );
				lsx_to_connected_countries( '<span class="' . $meta_class . 'destinations"><span class="lsx-to-meta-data-key">' . esc_html__( 'Destinations', 'tour-operator' ) . ':</span> ', '</span>', true );

				if ( function_exists( 'lsx_to_connected_activities' ) ) {
					lsx_to_connected_activities( '<span class="' . $meta_class . 'activities"><span class="lsx-to-meta-data-key">' . esc_html__( 'Activities', 'tour-operator' ) . ':</span> ', '</span>' );
				}
			?>
		<?php 
        }
	}

	/**
	 * Adds in the onsale classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function tour_classes( $classes ) {
		if ( ! is_singular( 'tour' ) ) {
			return $classes;
		}

		$sale_price = get_post_meta( get_the_ID(), 'sale_price', true );
		if ( false !== $sale_price && ! empty( $sale_price ) && 0 !== intval( $sale_price ) ) {
			$classes[] = 'on-sale';
		}
		return $classes;
	}
}
