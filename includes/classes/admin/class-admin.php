<?php
/**
 * LSX Tour Operator - Admin Main Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

namespace lsx\admin;

/**
 * Class Admin
 *
 * @package lsx\admin
 */
class Admin {

	/**
	 * LSX Tour Operator Admin constructor.
	 */
	public function __construct() {
		add_filter( 'type_url_form_media', array( $this, 'change_attachment_field_button' ), 20, 1 );
		add_filter( 'plugin_action_links_' . plugin_basename( LSX_TO_CORE ), array( $this, 'add_action_links' ) );
	}

	/**
	 * Change the "Insert into Post" button text when media modal is used for
	 * feature images
	 */
	public function change_attachment_field_button( $html ) {
		// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['feature_image_text_button'] ) ) {
			$html = str_replace( 'value="Insert into Post"', sprintf( 'value="%s"', esc_html__( 'Select featured image', 'tour-operator' ) ), $html );
		}

		return $html;
	}

	/**
	 * Adds in the "settings" link for the plugins.php page
	 */
	public function add_action_links( $links ) {
		$mylinks = array(
			'<a href="' . admin_url( 'admin.php?page=lsx-to-settings' ) . '">' . esc_html__( 'Settings', 'tour-operator' ) . '</a>',
			'<a href="https://www.lsdev.biz/lsx/documentation/lsx-tour-operator/" target="_blank">' . esc_html__( 'Documentation', 'tour-operator' ) . '</a>',
			'<a href="https://www.lsdev.biz/lsx/support/" target="_blank">' . esc_html__( 'Support', 'tour-operator' ) . '</a>',
		);

		return array_merge( $links, $mylinks );
	}
}
