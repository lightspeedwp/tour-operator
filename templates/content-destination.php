<?php
/**
 * Destination Content Part
 *
 * @package  tour-operator
 * @category destination
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

				<div class="meta taxonomies">
					<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">' . esc_html__( 'Travel Style', 'tour-operator' ) . ': ', ', ', '</div>' ); ?>
					<?php if ( function_exists( 'lsx_to_connected_activities' ) ) { lsx_to_connected_activities( '<div class="meta activities">' . esc_html__( 'Activities', 'tour-operator' ) . ': ', '</div>' ); } ?>
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
