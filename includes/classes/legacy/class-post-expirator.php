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
			'expirationdate_column_value',
		) );

		add_filter( 'manage_posts_columns', array(
			$this,
			'expirationdate_add_column',
		), 10, 2 );

		//Custom Field View
		add_action( 'add_meta_boxes', array(
			$this,
			'register_metabox',
		) );
		add_action( 'admin_head', array(
			$this,
			'expirationdate_js_admin_header',
		) );
		add_action( 'save_post', array(
			$this,
			'expirationdate_update_post_meta',
		) );

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
	public function expirationdate_column_value( $column_name ) {
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
	public function expirationdate_add_column( $columns, $type ) {
		if ( in_array( $type, array( 'special', 'tour' ) ) ) {
			$columns['lsx_to_expirationdate'] = esc_html__( 'Expires', 'tour-operator' );
		}
		return $columns;
	}

	/**
	 * Registers the Expiration Date Meta Box.
	 *
	 * @since 1.1.0
	 */
	public function register_metabox() {
		$custom_post_types = array( 'special', 'tour' );
		foreach ( $custom_post_types as $t ) {
			add_meta_box( 'lsxtoexpirationdatediv', esc_html__( 'Expires', 'tour-operator' ), array($this,'expirationdate_meta_box'), $t, 'side', 'core' );
		}
	}

	/**
	 * Outputs the JS needed for the expiration date metabox
	 *
	 * @since 1.1.0
	 */
	public function expirationdate_js_admin_header() {
		?>
        <script type="text/javascript">
            //<![CDATA[
            function lsx_to_expirationdate_ajax_add_meta(expireenable) {
                var expire = document.getElementById(expireenable);

                if (expire.checked == true) {
                    if (document.getElementById('lsx_to_expirationdate_month')) {
                        document.getElementById('lsx_to_expirationdate_month').disabled = false;
                        document.getElementById('lsx_to_expirationdate_day').disabled = false;
                        document.getElementById('lsx_to_expirationdate_year').disabled = false;
                        document.getElementById('lsx_to_expirationdate_hour').disabled = false;
                        document.getElementById('lsx_to_expirationdate_minute').disabled = false;
                    }

                    document.getElementById('lsx_to_expirationdate_expiretype').disabled = false;
                } else {
                    if (document.getElementById('lsx_to_expirationdate_month')) {
                        document.getElementById('lsx_to_expirationdate_month').disabled = true;
                        document.getElementById('lsx_to_expirationdate_day').disabled = true;
                        document.getElementById('lsx_to_expirationdate_year').disabled = true;
                        document.getElementById('lsx_to_expirationdate_hour').disabled = true;
                        document.getElementById('lsx_to_expirationdate_minute').disabled = true;
                    }

                    document.getElementById('lsx_to_expirationdate_expiretype').disabled = true;
                }

                return true;
            }
            //]]>
        </script>
		<?php
	}

	/**
	 * Saves the custom field
	 *
	 * @since 1.1.0
	 */
	public function expirationdate_update_post_meta( $id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['enable-lsx-to-expirationdate'] ) ) {
			$this->unschedule_expirator_event( $id );

			return;
		}

		$posttype = get_post_type( $id );

		if ( 'revision' == $posttype ) {
			return;
		}

		check_admin_referer( 'lsx_to_expirationdate_update_post_meta', '_to_expirationdate_update_post_meta_nonce' );

		$month  = (int) $_POST['lsx_to_expirationdate_month'];
		$day    = (int) $_POST['lsx_to_expirationdate_day'];
		$year   = (int) $_POST['lsx_to_expirationdate_year'];
		$hour   = (int) $_POST['lsx_to_expirationdate_hour'];
		$minute = (int) $_POST['lsx_to_expirationdate_minute'];

		$opts = array();
		$ts   = get_gmt_from_date( "$year-$month-$day $hour:$minute:0", 'U' );

		$opts['expiretype'] = sanitize_text_field( $_POST['lsx_to_expirationdate_expiretype'] );
		$opts['id']         = $id;

		$this->schedule_expirator_event( $id, $ts, $opts );
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

	/**
	 * Outputs the Expire Type Drop Down
	 *
	 * @param  $opts array
	 * @since 1.1.0
	 * @return string
	 */
	function post_expirator_expire_type( $opts ) {
		$return = false;
		if ( ! empty( $opts ) && isset( $opts['name'] ) ) {

			$opts = array_merge( array(
				'id'       => $opts['name'],
				'disabled' => false,
				'onchange' => '',
				'type'     => '',
			), $opts );

			$rv   = array();
			$rv[] = '<select name="' . $opts['name'] . '" id="' . $opts['id'] . '"' . ( true == $opts['disabled'] ? ' disabled="disabled"' : '' ) . ' onchange="' . $opts['onchange'] . '">';
			$rv[] = '<option value="draft" ' . ( 'draft' == $opts['selected'] ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Draft', 'tour-operator' ) . '</option>';
			$rv[] = '<option value="delete" ' . ( 'delete' == $opts['selected'] ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Delete', 'tour-operator' ) . '</option>';
			$rv[] = '<option value="private" ' . ( 'private' == $opts['selected'] ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Private', 'tour-operator' ) . '</option>';

			$rv[]   = '</select>';
			$return = implode( "<br/>/n", $rv );
		}

		return $return;
	}
}