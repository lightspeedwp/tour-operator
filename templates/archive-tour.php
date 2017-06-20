<?php
/**
 * Tour Archive
 *
 * @package  tour-operator
 * @category tour
 */

$tour_operator = tour_operator();
$layout = '';

if ( isset( $tour_operator->options[ $post_type ] ) && isset( $tour_operator->options[ $post_type ]['core_archive_layout'] ) ) {
    $layout = $tour_operator->options[ $post_type ]['core_archive_layout'];
}

if ( '' === $layout ) {
	$layout = 'list';
}

get_header(); ?>

	<?php lsx_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>

		<main id="main" class="site-main" role="main">

			<?php lsx_content_top(); ?>

			<?php if ( have_posts() ) : ?>

				<div class="row lsx-to-archive-template-<?php echo $layout; ?>">

					<?php while ( have_posts() ) : the_post(); ?>

						<div class="<?php echo esc_attr( lsx_to_archive_class( 'lsx-to-archive-item' ) ); ?>">

							<?php lsx_to_content( 'content', 'tour' ); ?>

						</div>

					<?php endwhile; ?>

				</div>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			<?php lsx_content_bottom(); ?>

		</main><!-- #main -->

		<?php lsx_content_after(); ?>

	</section><!-- #primary -->

	<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php get_footer();
