<?php
/**
 * Generic (post, page, ...) Content Part (required on search results)
 *
 * @package  tour-operator
 */
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$image_arr = wp_get_attachment_image_src( $thumbnail_id, 'lsx-thumbnail-single' );

		if ( is_array( $image_arr ) ) {
			$image_src = $image_arr[0];
		}
	?>

	<div class="lsx-to-archive-thumb">
		<a href="<?php the_permalink(); ?>" style="background-image: url('<?php echo esc_url( $image_src ); ?>')">
			<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
		</a>
	</div>

	<div class="lsx-to-archive-wrapper">
		<div class="lsx-to-archive-content">
			<?php the_title( '<h3 class="lsx-to-archive-content-title"><a href="' . get_permalink() . '" title="' . esc_html__( 'Read more', 'tour-operator' ) . '">', '</a></h3>' ); ?>

			<div <?php lsx_to_entry_class( 'entry-content' ); ?>>
				<?php the_excerpt(); ?>
			</div>
		</div>
	</div>

	<?php if ( 'grid' === tour_operator()->archive_layout ) : ?>
		<a href="<?php the_permalink(); ?>" class="moretag"><?php esc_html_e( 'Continue reading', 'tour-operator' ); ?></a>
	<?php endif; ?>

</article><!-- #post-## -->

<?php lsx_entry_after();
