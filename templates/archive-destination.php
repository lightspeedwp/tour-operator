<?php
/**
 * Destination Archive
 *
 * @package  tour-operator
 * @category destination
 */

get_header(); ?>

	<?php lsx_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>

		<main id="main" class="site-main" role="main">

			<?php lsx_content_top(); ?>

			<?php if ( have_posts() ) : ?>

				<div class="row">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="<?php echo esc_attr( lsx_to_archive_class( 'destination-archive-item panel' ) ); ?>">
							<?php lsx_to_content( 'content', 'destination' ); ?>
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
