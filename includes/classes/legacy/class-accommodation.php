<?php
/**
 * Accommodation Class, this registers the post type and adds certain filters
 * for layout.
 *
 * @package    \lsx\legacy\Accommodation
 * @author     LightSpeed Team
 * @license    GPL3
 * @link
 * @copyright  2015  LightSpeed Team
 */

namespace lsx\legacy;

/**
 * Plugin class.
 *
 * @package  Accommodation
 * @author   LightSpeed Team
 */
class Accommodation {

	/**
	 * The slug for this plugin
	 *
	 * @since 0.0.1
	 * @var      string
	 */
	protected $slug = 'accommodation';

	/**
	 * Holds class isntance
	 *
	 * @since 0.0.1
	 * @var      object|\lsx\legacy\Accommodation
	 */
	protected static $instance = null;

	/**
	 * If Wetu is active
	 *
	 * @since 0.0.1
	 * @var      boolean
	 */
	public $is_wetu_active = false;

	/**
	 * Holds and array of the Unit types available (slug => key)
	 *
	 * @since 0.0.1
	 * @var      array
	 */
	public $unit_types = false;

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function __construct() {
		$this->is_wetu_active          = false;

		$this->options = get_option( '_lsx-to_settings', false );

		$this->unit_types = array(
			''       => esc_html__( 'None', 'tour-operator' ),
			'chalet' => esc_html__( 'Chalet', 'tour-operator' ),
			'room'   => esc_html__( 'Room', 'tour-operator' ),
			'spa'    => esc_html__( 'Spa', 'tour-operator' ),
			'tent'   => esc_html__( 'Tent', 'tour-operator' ),
			'villa'  => esc_html__( 'Villa', 'tour-operator' ),
		);

		add_filter( 'lsx_to_entry_class', array( $this, 'entry_class' ) );

		add_filter( 'lsx_to_custom_field_query', array( $this, 'price_filter' ), 5, 10 );

		add_filter( 'lsx_to_custom_field_query', array( $this, 'rating' ), 5, 10 );

		include( 'class-unit-query.php' );

		add_action( 'lsx_to_map_meta', 'lsx_to_accommodation_meta' );
		add_action( 'lsx_to_modal_meta', 'lsx_to_accommodation_meta' );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 0.0.1
	 * @return    object|\lsx\legacy\Accommodation    A single instance of this
	 *                                           class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * A filter to set the content area to a small column on single
	 */
	function entry_class( $classes ) {
		global $post;

		if ( is_main_query() && is_singular( $this->slug ) ) {
			$classes[] = 'col-xs-12 col-sm-12 col-md-7';
		}

		return $classes;
	}

	/**
	 * Adds in additional info for the price custom field
	 */
	public function price_filter( $html = '', $meta_key = false, $value = false, $before = '', $after = '' ) {
		$currency_fields = [
			'price'
		];

		if ( get_post_type() === 'accommodation' && in_array( $meta_key, $currency_fields ) ) {
			$price_type    = get_post_meta( get_the_ID(), 'price_type', true );
			$value         = preg_replace( '/[^0-9,.]/', '', $value );
			$value         = ltrim( $value, '.' );
			$value         = str_replace( ',', '', $value );
			$value         = number_format( (int) $value, 2 );
			$tour_operator = tour_operator();
			$currency      = '';

			if ( is_object( $tour_operator ) && isset( $tour_operator->options['general'] ) && is_array( $tour_operator->options['general'] ) ) {
				if ( isset( $tour_operator->options['general']['currency'] ) && ! empty( $tour_operator->options['general']['currency'] ) ) {
					$currency = $tour_operator->options['general']['currency'];
					$currency = '<span class="currency-icon ' . mb_strtolower( $currency ) . '">' . $currency . '</span>';
				}
			}

			$value = apply_filters( 'lsx_to_accommodation_price', $value, $price_type, $currency );

			switch ( $price_type ) {
				case 'per_person_per_night':
				case 'per_person_sharing':
				case 'per_person_sharing_per_night':
					$value = $currency . $value . ' ' . ucwords( str_replace( '_', ' ', $price_type ) );
					break;

				case 'total_percentage':
					$value  .= '% ' . esc_html__( 'Off', 'tour-operator' );
					$before = str_replace( esc_html__( 'From price', 'tour-operator' ), '', $before );
					break;

				case 'none':
				default:
					$value = $currency . $value;
					break;
			}

			$html = $before . $value . $after;
		}

		return $html;
	}

	/**
	 * Filter and make the star ratings
	 */
	public function rating( $html = '', $meta_key = false, $value = false, $before = '', $after = '' ) {
		if ( get_post_type() === 'accommodation' && 'rating' === $meta_key ) {
			$ratings_array = array();
			$counter       = 5;
			$html          = '';
			if ( 0 !== (int) $value ) {
				while ( $counter > 0 ) {
					if ( (int) $value > 0 ) {
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
		}
		return $html;
	}
}
