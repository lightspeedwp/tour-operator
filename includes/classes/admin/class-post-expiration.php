<?php
/**
 * Tour Operator - Tour Expiration
 */

namespace lsx\admin;

/**
 * Registers our Custom Fields
 *
 * @package lsx
 * @author  LightSpeed
 */
class Post_Expiration {

	/**
	 * Initialize the class
	 *
	 * @access private
	 */
	public function __construct() {
		add_action( 'save_post_tour', [ $this, 'maybe_schedule_tour_expiration' ], 10, 1 );
		add_action( 'lsx_to_expire_tour', array( $this, 'expire_tour' ), 10, 2 );
	}

	/**
	 * Register our expiration if the post has a date and does not already have an action.
	 *
	 * @param int $post_id
	 * @return void
	 */
	public function maybe_schedule_tour_expiration( $post_id ) {
		if ( ! function_exists( 'as_schedule_single_action' ) ) {
			return;
		}

		$expire_post = get_post_meta( $post_id, 'expire_post', true );
		$action_id   = get_post_meta( $post_id, 'to_expiration_id', true );
		
		// Nothing to do
		if ( 'on' !== $expire_post && false === $action_id ) {
			return;
		}

		// delete the scheduled action.
		if ( 'on' !== $expire_post && ( false !== $action_id && '' !== $action_id ) ) {
			try {
				\ActionScheduler::store()->cancel_action( $action_id );
				delete_post_meta( $post_id, 'to_expiration_id' );
			} catch ( \Exception $exception ) {
				\ActionScheduler::logger()->log(
					$action_id,
					sprintf(
						/* translators: %1$s is the name of the hook to be cancelled, %2$s is the exception message. */
						__( 'Caught exception while cancelling action "%1$s": %2$s', 'action-scheduler' ),
						'lsx_to_expire_tour',
						$exception->getMessage()
					)
				);

				$action_id = null;
			}
			
			return;
		}
		
		// Schedule the action and save the meta.
		$expire_date = get_post_meta( $post_id, 'booking_validity_end', true );
		if ( false === $expire_date ) {
			return;
		}

		// Register our action
		$action_id = as_schedule_single_action(
			$expire_date,
			'lsx_to_expire_tour',
			array(
				'post_id' => $post_id,
			),
			'tour-operator'
		);
		update_post_meta( $post_id, 'to_expiration_id', $action_id );
	}

	public function expire_tour( $post_id ) {
		$args = [
			'ID'          => $post_id,
			'post_status' => 'draft',
		];
		$updated = wp_update_post( $args );

		delete_post_meta( $post_id, 'to_expiration_id' );
		delete_post_meta( $post_id, 'expire_post' );
		return $updated;
	}
}