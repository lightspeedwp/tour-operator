<?php
/**
 * Accommodation Content Part
 *
 * @package  tour-operator
 * @category accommodation
 */

global $lsx_to_archive;

if ( 1 !== $lsx_to_archive ) {
	$lsx_to_archive = false;
}
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php lsx_entry_top(); ?>

	<?php if ( is_single() && false === $lsx_to_archive ) { ?>

		<div <?php lsx_to_entry_class( 'entry-content' ); ?>>
			<div class="lsx-to-single-content">
				<h2 class="lsx-to-single-title"><?php esc_html_e( 'Summary' , 'tour-operator' ); ?></h2>

				<?php lsx_to_price( '<span class="lsx-to-meta-data lsx-to-meta-data-price">' . esc_html__( 'From price', 'tour-operator' ) . ': ', '</span>' ); ?>
			</div>

			<div class="meta taxonomies">
				<?php
					$meta_class = 'lsx-to-meta-data lsx-to-meta-data-';

					lsx_to_accommodation_room_total( '<span class="' . $meta_class . 'rooms">' . esc_html__( 'Rooms', 'tour-operator' ) . ': ', '</span>' );
					lsx_to_accommodation_rating( '<span class="' . $meta_class . 'rating">' . esc_html__( 'Rating', 'tour-operator' ) . ': ', '</span>' );
					the_terms( get_the_ID(), 'accommodation-brand', '<span class="' . $meta_class . 'brand">' . esc_html__( 'Brand', 'tour-operator' ) . ': ', ', ', '</span>' );
					the_terms( get_the_ID(), 'travel-style', '<span class="' . $meta_class . 'style">' . esc_html__( 'Accommodation Style', 'tour-operator' ) . ': ', ', ', '</span>' );
					the_terms( get_the_ID(), 'accommodation-type', '<span class="' . $meta_class . 'type">' . esc_html__( 'Type', 'tour-operator' ) . ': ', ', ', '</span>' );
					lsx_to_accommodation_spoken_languages( '<span class="' . $meta_class . 'languages">' . esc_html__( 'Spoken Languages', 'tour-operator' ) . ': ', '</span>' );
					lsx_to_accommodation_activity_friendly( '<span class="' . $meta_class . 'friendly">' . esc_html__( 'Friendly', 'tour-operator' ) . ': ', '</span>' );
					lsx_to_accommodation_special_interests( '<span class="' . $meta_class . 'special">' . esc_html__( 'Special Interests', 'tour-operator' ) . ': ', '</span>' );

					if ( function_exists( 'lsx_to_connected_activities' ) ) {
						lsx_to_connected_activities( '<span class="' . $meta_class . 'activities">' . esc_html__( 'Activities', 'tour-operator' ) . ': ', '</span>' );
					}

					lsx_to_connected_destinations( '<span class="' . $meta_class . 'destinations">' . esc_html__( 'Location', 'tour-operator' ) . ': ', '</span>' );
				?>
			</div>

			<?php the_content(); ?>
			<?php lsx_to_sharing(); ?>
		</div>

	<?php } elseif ( empty( tour_operator()->options[ get_post_type() ]['disable_entry_text'] ) ) { ?>

		<div <?php lsx_to_entry_class( 'entry-content' ); ?>>
			<?php the_excerpt(); ?>
		</div>

	<?php } ?>

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php lsx_entry_after();
