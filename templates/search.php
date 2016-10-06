<?php
/**
 * Search results
 *
 * @package 	lsx-tour-operators
 * @category	search
 */

get_header(); 
?>

	<?php lsx_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">">

		<?php lsx_content_before(); ?>

			<main id="main" class="site-main" role="main">

				<?php 
				/**
				 * Hooked
				 * 
				 *  - lsx_tour_operator_archive_header() - 100
				 *  - lsx_tour_operator_archive_description() - 100
				 */
					lsx_content_top();
					global $lsx_archive;
					$lsx_archive = 1;
					?>

					<?php if ( have_posts() ) : ?>

						<div class="row">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="panel col-sm-12">
									<?php lsx_tour_operator_content( 'content', get_post_type() ); ?>
								</div>
							<?php endwhile; ?>
						</div>

					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>
					
					<?php $lsx_archive = 0; ?>

				<?php lsx_content_bottom(); ?>
				
				<?php lsx_tour_sharing(); ?>

			</main><!-- #main -->

		<?php lsx_content_after(); ?>
		
	</section><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php get_footer();