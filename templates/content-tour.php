<?php
/**
 * Tour Content Part
 *
 * @package  tour-operator
 * @category tour
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

				<div class="lsx-to-single-meta">
					<?php
						lsx_to_price( '<span class="lsx-to-meta-data lsx-to-meta-data-price">' . esc_html__( 'From price', 'tour-operator' ) . ': ', '</span>' );
						lsx_to_duration( '<span class="lsx-to-meta-data lsx-to-meta-data-duration">' . esc_html__( 'Duration', 'tour-operator' ) . ': ', '</span>' );
					?>
				</div>
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
