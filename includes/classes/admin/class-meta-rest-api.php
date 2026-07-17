<?php
/**
 * Tour Operator - Meta REST API Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-3.0+
 */

namespace lsx\admin;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
				[
					'methods'             => 'POST',
					'callback'            => [ $this, 'update_meta' ],
					'permission_callback' => [ $this, 'check_permissions' ],
					'args'                => [
						'id'    => [
							'validate_callback' => function ( $param ) {
								return is_numeric( $param );
							},
						],
						'key'   => [
							'validate_callback' => function ( $param ) {
								return preg_match( '/^[a-zA-Z0-9_-]+$/', $param );
							},
						],
						'value' => [
							'required' => true,
						],
					],
				],
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
				],
			]
		);
	}

	/**
	 * Update post meta
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function update_meta( $request ) {
		$post_id   = (int) $request['id'];
		$meta_key  = sanitize_key( $request['key'] );

		// Additional security: only allow specific meta keys
		$allowed_keys = [ 'lsx_to_hide_from_listings', 'featured' ];
		if ( ! in_array( $meta_key, $allowed_keys, true ) ) {
			return new \WP_REST_Response(
				[ 'error' => 'Invalid meta key' ],
				403
			);
		}

		// Both allowed keys are boolean flags; store a canonical 0/1 rather than
		// the raw request value (which arrived unsanitised).
		$meta_value = (int) rest_sanitize_boolean( $request['value'] );

		// update_post_meta() returns false both on real failure and when the new
		// value equals the stored one, so treat an unchanged value as success and
		// only report an error on an actual write failure.
		$current = (int) get_post_meta( $post_id, $meta_key, true );
		if ( $current === $meta_value ) {
			$updated = true;
		} else {
			$updated = update_post_meta( $post_id, $meta_key, $meta_value );
		}

		if ( false === $updated ) {
			return new \WP_REST_Response(
				[ 'error' => 'Failed to update meta' ],
				500
			);
		}

		return new \WP_REST_Response(
			[
				'success' => true,
				'message' => 'Meta updated successfully',
				'value'   => $meta_value,
			],
			200
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
		$allowed_keys = [ 'lsx_to_hide_from_listings', 'featured' ];
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
