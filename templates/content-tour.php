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
			<div class="single-main-info">
				<h3><?php esc_html_e( 'Summary' , 'tour-operator' ); ?></h3>

				<div class="meta info">
					<?php
						lsx_to_price( '<span class="price">' . esc_html__( 'From price', 'tour-operator' ) . ': ', '</span>' );
						lsx_to_duration( '<span class="duration">' . esc_html__( 'Duration', 'tour-operator' ) . ': ', '</span>' );
					?>
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
