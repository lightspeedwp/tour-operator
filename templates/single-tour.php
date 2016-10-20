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

		<?php 
		/**
		 * Hooked
		 * 
		 *  - to_global_header() - 100
		 */
			lsx_content_top();
		?>
		
		<section class="tour-navigation">
			<div class="container">
				<ul class="scroll-easing">
					<li><a href="#summary">Summary</a></li>
					<li><a href="#itinerary">Itinerary</a></li>
					<li><a href="#included-excluded">Included / Excluded</a></li>
					<?php if(function_exists('to_has_map') && to_has_map()){ ?>					
						<li><a href="#tour-map">Map</a></li>
					<?php } ?>
					<?php 
					if(class_exists('Envira_Gallery')){
						$gallery_id = get_post_meta(get_the_ID(),'envira_to_tour',true);
					} else {
						$gallery_id = get_post_meta(get_the_ID(),'gallery',true);
					}
					if(false !== $gallery_id && '' !== $gallery_id){ ?>
						<li><a href="#gallery"><?php esc_html_e('Gallery','tour-operator');?></a></li>
					<?php } ?>
					<?php 
					$videos = get_post_meta(get_the_ID(),'videos',true);
					if(false !== $videos && '' !== $videos){ ?>
						<li><a href="#videos"><?php esc_html_e('Videos','tour-operator');?></a></li>
					<?php } ?>					
				</ul>
			</div>
		</section>		
		
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