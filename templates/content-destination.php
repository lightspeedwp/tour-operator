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
			<div class="lsx-to-single-content">
				<h2 class="lsx-to-single-title"><?php esc_html_e( 'Summary' , 'tour-operator' ); ?></h2>
			</div>

			<div class="lsx-to-single-meta-data">
				<?php
					the_terms( get_the_ID(), 'travel-style', '<span class="lsx-to-meta-data lsx-to-meta-data-style">' . esc_html__( 'Travel Style', 'tour-operator' ) . ': ', ', ', '</span>' );
					if ( function_exists( 'lsx_to_connected_activities' ) ) {
						lsx_to_connected_activities( '<span class="lsx-to-meta-data lsx-to-meta-data-activities">' . esc_html__( 'Activities', 'tour-operator' ) . ': ', '</span>' );
					}
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
