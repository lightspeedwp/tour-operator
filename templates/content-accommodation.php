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
			<div class="single-main-info">
				<h3><?php esc_html_e( 'Summary' , 'tour-operator' ); ?></h3>

				<?php lsx_to_price( '<div class="meta info"><span class="price">' . esc_html__( 'From price', 'tour-operator' ) . ': ', '</span></div>' ); ?>

				<div class="meta taxonomies">
					<?php lsx_to_accommodation_room_total( '<div class="meta rooms">' . esc_html__( 'Rooms', 'tour-operator' ) . ': <span>', '</span></div>' ); ?>
					<?php lsx_to_accommodation_rating( '<div class="meta rating">' . esc_html__( 'Rating', 'tour-operator' ) . ': ', '</div>' ); ?>
					<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">' . esc_html__( 'Brand', 'tour-operator' ) . ': ', ', ', '</div>' ); ?>
					<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">' . esc_html__( 'Accommodation Style', 'tour-operator' ) . ': ', ', ', '</div>' ); ?>
					<?php the_terms( get_the_ID(), 'accommodation-type', '<div class="meta accommodation-type">' . esc_html__( 'Type', 'tour-operator' ) . ': ', ', ', '</div>' ); ?>
					<?php lsx_to_accommodation_spoken_languages( '<div class="meta spoken_languages">' . esc_html__( 'Spoken Languages', 'tour-operator' ) . ': <span>', '</span></div>' ); ?>
					<?php lsx_to_accommodation_activity_friendly( '<div class="meta friendly">' . esc_html__( 'Friendly', 'tour-operator' ) . ': <span>', '</span></div>' ); ?>
					<?php lsx_to_accommodation_special_interests( '<div class="meta special_interests">' . esc_html__( 'Special Interests', 'tour-operator' ) . ': <span>', '</span></div>' ); ?>
					<?php if ( function_exists( 'lsx_to_connected_activities' ) ) { lsx_to_connected_activities( '<div class="meta activity">' . esc_html__( 'Activities', 'tour-operator' ) . ': ', '</div>' ); } ?>
					<?php lsx_to_connected_destinations( '<div class="meta destination">' . esc_html__( 'Location', 'tour-operator' ) . ': ', '</div>' ); ?>
				</div>

				<?php lsx_to_sharing(); ?>
			</div>

			<?php the_content(); ?>
		</div>

	<?php } elseif ( empty( tour_operator()->options[ get_post_type() ]['disable_entry_text'] ) ) { ?>

		<div <?php lsx_to_entry_class( 'entry-content' ); ?>>
			<?php the_excerpt(); ?>
		</div>

	<?php } ?>

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php lsx_entry_after();
