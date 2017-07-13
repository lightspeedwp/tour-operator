<?php
/**
 * Tour Content Part
 *
 * @package  tour-operator
 * @category tour
 */

global $lsx_to_archive, $post;

if ( 1 !== $lsx_to_archive ) {
	$lsx_to_archive = false;
}
?>

<?php lsx_entry_before(); ?>

<article id="tour-<?php echo esc_attr( $post->post_name ); ?>" <?php post_class( 'lsx-to-archive-container' ); ?>>
	<?php lsx_entry_top(); ?>

	<?php if ( is_single() && false === $lsx_to_archive ) { ?>

		<div <?php lsx_to_entry_class( 'entry-content' ); ?>>
			<div class="lsx-to-summary">
				<h2 class="lsx-to-summary-title"><?php esc_html_e( 'Summary' , 'tour-operator' ); ?></h2>

				<div class="lsx-to-summary-meta-data">
					<?php
						$meta_class = 'lsx-to-meta-data lsx-to-meta-data-';

						lsx_to_price( '<span class="' . $meta_class . 'price">' . esc_html__( 'From price', 'tour-operator' ) . ': ', '</span>' );
						lsx_to_duration( '<span class="' . $meta_class . 'duration">' . esc_html__( 'Duration', 'tour-operator' ) . ': ', '</span>' );
					?>
				</div>
			</div>

			<?php the_content(); ?>
			<?php lsx_to_sharing(); ?>
		</div>

	<?php } elseif ( is_search() || empty( tour_operator()->options[ get_post_type() ]['disable_entry_text'] ) ) { ?>

		<div <?php lsx_to_entry_class( 'entry-content' ); ?>>
			<?php the_excerpt(); ?>
		</div>

	<?php } ?>

	<?php lsx_entry_bottom(); ?>

</article><!-- #post-## -->

<?php lsx_entry_after();
