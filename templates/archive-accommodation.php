<?php
/**
 * Accommodation Archive
 *
 * @package 	tour-operator
 * @category	accommodation
 */

get_header(); ?>

	<?php lsx_content_wrap_before(); ?>

	<section id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>

		<main id="main" class="site-main" role="main">

		<?php 
		/**
		 * Hooked
		 * 
		 *  - lsx_to_global_header() - 100
		 *  - lsx_to_archive_description() - 100
		 */
			lsx_content_top();
		?>
		
		<?php if ( have_posts() ) : ?>

			<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="panel col-sm-12">
					<?php lsx_to_content( 'content', 'accommodation' ); ?>
				</div>
			<?php endwhile; ?>
			</div>
			<?php //lsx_to_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		<?php lsx_content_bottom(); ?>
		
		<?php lsx_to_safari_brands('<section id="safari-brands"><h2 class="section-title">'.__(lsx_to_get_post_type_section_title('accommodation', 'brands', 'Accommodation Brands'),'tour-operator').'</h2>','</section>');?>
		
		<?php lsx_to_sharing(); ?>

		</main><!-- #main -->

		<?php lsx_content_after(); ?>
		
	</section><!-- #primary -->

<?php lsx_content_wrap_after(); ?>

<?php get_sidebar(); ?>

<?php get_footer();