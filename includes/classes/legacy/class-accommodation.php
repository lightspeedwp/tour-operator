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

		$this->options = get_option( 'lsx_to_settings', false );

		$this->unit_types = array(
			''       => esc_html__( 'None', 'tour-operator' ),
			'chalet' => esc_html__( 'Chalet', 'tour-operator' ),
			'room'   => esc_html__( 'Room', 'tour-operator' ),
			'spa'    => esc_html__( 'Spa', 'tour-operator' ),
			'tent'   => esc_html__( 'Tent', 'tour-operator' ),
			'villa'  => esc_html__( 'Villa', 'tour-operator' ),
		);

		add_filter( 'lsx_to_custom_field_query', array( $this, 'price_filter' ), 5, 10 );

		add_filter( 'lsx_to_custom_field_query', array( $this, 'rating' ), 5, 10 );

		include( 'class-unit-query.php' );
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
	 * Adds in additional info for the price custom field
	 */
	public function price_filter( $html = '', $meta_key = false, $value = false, $before = '', $after = '' ) {
		$currency_fields = [
			'price',
			'single_supplement'
		];

		if ( get_post_type() === 'accommodation' && in_array( $meta_key, $currency_fields ) ) {
			$price_type    = get_post_meta( get_the_ID(), 'price_type', true );
			$value         = preg_replace( '/[^0-9,.]/', '', $value );
			$value         = ltrim( $value, '.' );
			$value         = str_replace( ',', '', $value );
			$value         = number_format( (int) $value, 2 );
			$tour_operator = tour_operator();
			$currency      = '';
			$letter_code   = '';

			if ( is_object( $tour_operator ) && isset( $tour_operator->options['currency'] ) && ! empty( $tour_operator->options['currency'] ) ) {
				$letter_code = $tour_operator->options['currency'];
				$currency = '<span class="currency-icon ' . mb_strtolower( $letter_code ) . '"></span>';
			}

			$value = apply_filters( 'lsx_to_accommodation_price', $value, $price_type, $currency );

			// Get the Sale Price
			if ( 'price' === $meta_key ) {
				$sale_price = get_post_meta( get_the_ID(), 'sale_price', true );
				if ( false !== $sale_price && ! empty( $sale_price ) && 0 !== intval( $sale_price ) ) {
					$value = number_format( intval( $sale_price ) , 2 );
				}
			}

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

			// Get the currency settings
			if ( is_object( $tour_operator ) &&  ( isset( $tour_operator->options['country_code_disabled'] ) && 0 === intval( $tour_operator->options['country_code_disabled'] ) || ! isset( $tour_operator->options['country_code_disabled'] ) ) ) {
				$value = $letter_code . $value;
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
					$ratings_array[] = '<figure class="wp-block-image size-large is-resized">';
					// phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
					$ratings_array[] = '<img src="';
					if ( (int) $value > 0 ) {
						$ratings_array[] = LSX_TO_URL . 'assets/img/rating-star-full.png';
					} else {
						$ratings_array[] = LSX_TO_URL . 'assets/img/rating-star-empty.png';
					}
					$ratings_array[] = '" alt="" style="width:20px;vertical-align:sub;">';
					$ratings_array[] = '</figure>';

					$counter --;
					$value --;
				}
				$html = $before . implode( '', $ratings_array ) . $after;
			}
		}
		return $html;
	}
}
