<?php
/**
 * Accommodation Brand Archive.
 *
 * @package  tour-operator
 * @category accommodation-brand
 */

get_header(); ?>

	<?php lsx_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>

		<main id="main" class="site-main" role="main">

			<?php lsx_content_top(); ?>

			<?php lsx_to_content( 'content', get_queried_object()->taxonomy ) ?>

			<?php if ( have_posts() ) : ?>

				<div class="row">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="<?php echo esc_attr( lsx_to_archive_class( 'accommodation-brand-archive-item panel' ) ); ?>">
							<?php lsx_to_content( 'content', get_post_type() ); ?>
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
