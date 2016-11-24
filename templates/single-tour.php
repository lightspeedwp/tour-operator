<?php
/**
 * Tour Single Template
 *
 * @package 	tour-operator
 * @category	tour
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>
		
		<main id="main" class="site-main" role="main">

		<?php lsx_content_top(); ?>
		
		<section id="summary">
			<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php to_content('content', get_post_type()); ?>
				<?php endwhile; // end of the loop. ?>
			</div>
		</section>
		
		<?php lsx_content_bottom(); ?>

		</main><!-- #main -->			

		<?php lsx_content_after(); ?>

	</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>	

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>

<?php get_footer();