<?php
/**
 * Destination Single Template
 *
 * @package 	tour-operator
 * @category	destination
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
			 * - to_single_header() - 100
			 */
				lsx_content_top();
			?>
			
			<section class="destination-navigation">
				<div class="container">
					<ul class="scroll-easing">
						<li><a href="#summary">Summary</a></li>
						<?php
							if(to_item_has_children(get_the_ID(),'destination')) {
								?>					
								<li><a href="#regions">Regions</a></li>
							<?php
						} ?>						
						<?php
							$connected_tours = get_post_meta(get_the_ID(),'tour_to_destination',false);
							if(post_type_exists('tour') && is_array($connected_tours) && !empty($connected_tours) ) {
								?>					
								<li><a href="#tours">Tours</a></li>
							<?php
						} ?>
						<?php
							if(!to_item_has_children(get_the_ID(),'destination')){
							$connected_accommodation = get_post_meta(get_the_ID(),'accommodation_to_destination',false);
							if(post_type_exists('accommodation') && is_array($connected_accommodation) && !empty($connected_accommodation) ) {
								?>					
								<li><a href="#accommodation">Accommodation</a></li>
							<?php
						}} ?>
						<?php
						if(!to_item_has_children(get_the_ID(),'destination')){
							$connected_activity = get_post_meta(get_the_ID(),'activity_to_destination',false);
							if(post_type_exists('activity') && is_array($connected_activity) && !empty($connected_activity) ) {
								?>					
								<li><a href="#activity">Activities</a></li>
							<?php
						}} ?>						
						<li><a href="#destination-map"><?php esc_html_e('Map','tour-operator');?></a></li>
						<?php 
						if(class_exists('Envira_Gallery')){
							$gallery_id = get_post_meta(get_the_ID(),'envira_to_destination',true);
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
			
			<?php while ( have_posts() ) : the_post(); ?>		
				<section id="summary">
					<div class="row">
						<?php to_content('content', get_post_type()); ?>
					</div>
				</section>
			<?php endwhile; // end of the loop. ?>
			
			<?php
			/**
			 * Hooked
			 *
			 *  - to_country_regions() - 70
			 *  - to_destination_tours() - 80
			 *  - to_region_accommodation() - 90
			 */			
			lsx_content_bottom(); ?>
			
		</main><!-- #main -->	

		<?php lsx_content_after();?>

	</div><!-- #primary -->

<?php lsx_content_wrap_after(); ?>	

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>
<?php get_footer();