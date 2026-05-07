<?php
/**
 * Tour Operator - Meta REST API Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-3.0+
 */

namespace lsx\admin;

/**
 * Class Meta_Rest_API
 *
 * Provides REST API endpoint for managing visibility meta
 *
 * @since 2.1.0
 * @package lsx\admin
 */
class Meta_Rest_API {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register REST API routes
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			'tour-operator/v1',
			'/meta/(?P<id>\d+)/(?P<key>[a-zA-Z0-9_-]+)',
			[
				'methods'             => 'DELETE',
				'callback'            => [ $this, 'delete_meta' ],
				'permission_callback' => [ $this, 'check_permissions' ],
				'args'                => [
					'id'  => [
						'validate_callback' => function ( $param ) {
							return is_numeric( $param );
						},
					],
					'key' => [
						'validate_callback' => function ( $param ) {
							return preg_match( '/^[a-zA-Z0-9_-]+$/', $param );
						},
					],
				],
			]
		);
	}

	/**
	 * Delete post meta
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function delete_meta( $request ) {
		$post_id = (int) $request['id'];
		$meta_key = sanitize_key( $request['key'] );

		// Additional security: only allow specific meta keys
		$allowed_keys = [ 'lsx_to_hide_from_listings' ];
		if ( ! in_array( $meta_key, $allowed_keys, true ) ) {
			return new \WP_REST_Response(
				[ 'error' => 'Invalid meta key' ],
				403
			);
		}

		$deleted = delete_post_meta( $post_id, $meta_key );

		if ( $deleted ) {
			return new \WP_REST_Response(
				[
					'success' => true,
					'message' => 'Meta deleted successfully',
				],
				200
			);
		}

		return new \WP_REST_Response(
			[
				'success' => false,
				'message' => 'Meta not found or already deleted',
			],
			200
		);
	}

	/**
	 * Check permissions for the request
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return bool
	 */
	public function check_permissions( $request ) {
		$post_id = (int) $request['id'];

		// User must be able to edit the post
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		return true;
	}
}
