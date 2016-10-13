<?php
/**
 * Tour Archive
 *
 * @package 	tour-operator
 * @category	tour
 */

get_header(); ?>

	<?php to_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>

		<main id="main" class="site-main" role="main">

		<?php 
		/**
		 * Hooked
		 * 
		 *  - to_archive_header() - 100
		 *  - to_archive_description() - 100
		 */
			lsx_content_top();
		?>

		<?php if ( have_posts() ) : ?>
			
			<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="panel col-sm-12">
						<?php to_content( 'content', get_post_type() ); ?>
					</div>
				<?php endwhile; ?>
			</div>
			<?php //to_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		<?php lsx_content_bottom(); ?>
		
		<?php to_sharing(); ?>

		</main><!-- #main -->

		<?php lsx_content_after(); ?>
		
	</section><!-- #primary -->

<?php to_content_wrap_after(); ?>	

<?php get_sidebar(); ?>

<?php get_footer();