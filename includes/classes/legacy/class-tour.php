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
		$this->options = get_option( 'lsx_to_settings', false );

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
			$tour_operator = tour_operator();
			$currency      = '';
			$letter_code   = '';
			$value         = number_format( (int) $value, 2 );

			// Get the currency settings
			if ( is_object( $tour_operator ) && isset( $tour_operator->options['currency'] ) && ! empty( $tour_operator->options['currency'] ) ) {
				$letter_code = $tour_operator->options['currency'];
				$currency    = '<span class="currency-icon ' . strtolower( $letter_code ) . '"></span>';
			}

			$value = $currency . $value;

			// Get the Sale Price
			if ( 'price' === $meta_key ) {
				$sale_price = get_post_meta( get_the_ID(), 'sale_price', true );
				if ( false !== $sale_price && ! empty( $sale_price ) && 0 !== intval( $sale_price ) ) {
					$value = '<span class="strike">' . $value . '</span>' . ' ' . $currency . number_format( intval( $sale_price ) , 2 );
				}
			}

			// Get the currency settings
			if ( is_object( $tour_operator ) &&  ( isset( $tour_operator->options['country_code_disabled'] ) && 0 === intval( $tour_operator->options['country_code_disabled'] ) || ! isset( $tour_operator->options['country_code_disabled'] ) ) ) {
				$value = $letter_code . $value;
			}

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
