<?php
/**
 * Tour Operator - Post Expirator Class
 *
 * @package   tour_operator
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Post_Expirator class.
 *
 * @package lsx
 * @author  LightSpeed
 */
class Post_Expirator
{

	/**
	 * Holds the shared instance
	 *
	 * @since  1.1.0
	 * @access protected
	 */
	protected static $instance = null;

	/**
	 * Constructor. Sets up action to render styles.
	 *
	 * @since 1.1.0
	 */
	public function __construct() {

	    //Dashboard Views
		add_action( 'manage_posts_custom_column', array(
			$this,
			'column_value',
		) );

		add_filter( 'manage_posts_columns', array(
			$this,
			'add_column',
		), 10, 2 );

		add_action( 'save_post', array(
			$this,
			'update_post_meta',
		), 20 );

		//Expiration Methods
		add_action( 'lsxToPostExpiratorExpire', array(
			$this,
			'post_expirator_expire',
		) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @codeCoverageIgnore
	 * @since 1.1.0
	 * @return self A single instance of the share class.
	 */
	public static function init() {

		// If the single instance hasn't been set, set it now.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/**
	 * Outputs the current rows column value. WP Dashboard View
	 *
	 * @since 1.1.0
	 */
	public function column_value( $column_name ) {
		global $post;
		$id = $post->ID;

		if ( 'lsx_to_expirationdate' === $column_name ) {
			$ed = get_post_meta( $id, '_to_expiration-date', true );
			echo esc_html( $ed ? get_date_from_gmt( gmdate( 'Y-m-d H:i:s', $ed ), get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) : esc_html__( "Never", 'tour-operator' ) );
		}
	}

	/**
	 * Registers the Expiration Date Column for the post lists WP Dashboard
	 *
	 * @since 1.1.0
	 */
	public function add_column( $columns, $type ) {
		if ( in_array( $type, array( 'special', 'tour' ) ) ) {
			$columns['lsx_to_expirationdate'] = esc_html__( 'Expires', 'tour-operator' );
		}
		return $columns;
	}

	/**
	 * Saves the custom field
	 *
	 * @since 1.1.0
	 */
	public function update_post_meta( $id ) {

		$posttype = get_post_type( $id );
		if ( 'special' !== $posttype && 'tour' !== $posttype ) {
			return;
		}

		$booking_dates = $this->get_booking_dates();
		if ( isset ( $_POST['expire_post'] ) && ! empty( $booking_dates ) ) {

			foreach ( $booking_dates as $date_range ) {
				$month  = (int) $_POST['lsx_to_expirationdate_month'];
				$day    = (int) $_POST['lsx_to_expirationdate_day'];
				$year   = (int) $_POST['lsx_to_expirationdate_year'];

				$hour   = (int) '11';
				$minute = (int) '30';

				$opts = array();
				$ts   = get_gmt_from_date( "$year-$month-$day $hour:$minute:0", 'U' );

				$opts['expiretype'] = sanitize_text_field( $_POST['lsx_to_expirationdate_expiretype'] );
				$opts['id']         = $id;

				$this->schedule_expirator_event( $id, $ts, $opts );
			}

		} else {
			$this->unschedule_expirator_event( $id );
		}

		return;

	}

	/**
	 * Check the post array for the travel dates if there are any.
	 *
	 * @return array
	 */
	public function get_booking_dates() {
		$dates = array();
		$booking_validity_start = false;
		$booking_validity_end = false;
		if ( isset( $_POST['booking_validity_start'] ) && ! empty( $_POST['booking_validity_start'] ) ) {
			$booking_validity_start = implode( '', $_POST['booking_validity_start'] );
		}
		if ( isset( $_POST['booking_validity_end'] ) && ! empty( $_POST['booking_validity_end'] ) ) {
			$booking_validity_end = implode( '', $_POST['booking_validity_end'] );;
		}
		if ( false !== $booking_validity_start && false !== $booking_validity_end ) {
			$dates[] = array( $booking_validity_start, $booking_validity_end );
		}
		$dates = $this->raw_format_dates( $dates );
		return $dates;
	}

	/**
	 * strtotime all the values in the array
	 *
	 * @param array $dates
	 * @return array
	 */
	public function raw_format_dates( $dates = array() ) {
		if ( ! empty( $dates ) ) {
			$new_dates = array();
			foreach ( $dates as $date_range ) {
				$temp = array();
				if ( isset( $date_range[0] ) && '' !== $date_range[0] ) {
					$temp[] = strtotime( $date_range[0] );
				}
				if ( isset( $date_range[1] ) && '' !== $date_range[1] ) {
					$temp[] = strtotime( $date_range[1] );
				}
				$new_dates[] = $temp;
			}
			$dates = $new_dates;
		}
		return $dates;
	}

	/**
	 * Expires a post
     *
     * @param  $id string
	 * @since 1.1.0
     * @return bool
	 */
	public function post_expirator_expire( $id ) {
		if ( empty( $id ) ) {
			return false;
		}

		if ( is_null( get_post( $id ) ) ) {
			return false;
		}

		$postoptions = get_post_meta( $id, '_to_expiration-date-options', true );

		if ( empty( $postoptions['expiretype'] ) ) {
			$posttype                  = get_post_type( $id );
			$postoptions['expiretype'] = apply_filters( 'lsx_to_postexpirator_custom_posttype_expire', $postoptions['expiretype'], $posttype );
		}

		kses_remove_filters();

		// Do Work
		if ( 'draft' == $postoptions['expiretype'] ) {
			wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
		} elseif ( 'private' == $postoptions['expiretype'] ) {
			wp_update_post( array( 'ID' => $id, 'post_status' => 'private' ) );
		} elseif ( 'delete' == $postoptions['expiretype'] ) {
			wp_delete_post( $id );
		}

		return $id;
	}

	/**
	 * Registers the post expirator cron event
	 *
	 * @param  $id string
	 * @since 1.1.0
	 * @return void
	 */
	public function schedule_expirator_event( $id, $ts, $opts ) {
		if ( wp_next_scheduled( 'lsxToPostExpiratorExpire', array( $id ) ) !== false ) {
			wp_clear_scheduled_hook( 'lsxToPostExpiratorExpire', array( $id ) );
		}

		wp_schedule_single_event( $ts, 'lsxToPostExpiratorExpire', array( $id ) );

		update_post_meta( $id, '_to_expiration-date', $ts );
		update_post_meta( $id, '_to_expiration-date-options', $opts );
		update_post_meta( $id, '_to_expiration-date-status', 'saved' );
	}

	/**
	 * De-registers the post expirator cron event
	 *
	 * @param  $id string
	 * @since 1.1.0
	 * @return void
	 */
	function unschedule_expirator_event( $id ) {
		delete_post_meta( $id, '_to_expiration-date' );
		delete_post_meta( $id, '_to_expiration-date-options' );

		if ( wp_next_scheduled( 'lsxToPostExpiratorExpire', array( $id ) ) !== false ) {
			wp_clear_scheduled_hook( 'lsxToPostExpiratorExpire', array( $id ) );
		}

		update_post_meta( $id, '_to_expiration-date-status', 'saved' );
	}
}