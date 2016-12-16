<?php
/**
 * Accommodation Single Template
 *
 * @package 	tour-operator
 * @category	accommodation
 */

get_header(); ?>

<?php lsx_content_wrap_before(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>
		
		<main id="main" class="site-main" role="main">

		<?php lsx_content_top(); ?>
		
		<?php while ( have_posts() ) : the_post(); ?>
			<section id="summary">
				<div class="row">
					<?php lsx_to_content('content', 'accommodation'); ?>
				</div>
			</section>
			
		<?php endwhile; // end of the loop. ?>
		
		<?php lsx_content_bottom(); ?>

		</main><!-- #main -->			

		<?php lsx_content_after(); ?>

	</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>	

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>	

<?php get_footer();