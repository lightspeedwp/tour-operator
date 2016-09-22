<?php
/**
 * Destination Single Template
 *
 * @package 	lsx-tour-operators
 * @category	destination
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo lsx_main_class(); ?>">

		<?php lsx_content_before(); ?>
		
		<main id="main" class="site-main" role="main">

			<?php 
			/**
			 * Hooked
			 * 
			 * - lsx_tour_operator_single_header() - 100
			 */
				lsx_content_top();
			?>
			
			<section class="destination-navigation">
				<div class="container">
					<ul class="scroll-easing">
						<li><a href="#summary">Summary</a></li>
						<?php
							if(lsx_item_has_children(get_the_ID(),'destination')) {
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
							if(!lsx_item_has_children(get_the_ID(),'destination')){
							$connected_accommodation = get_post_meta(get_the_ID(),'accommodation_to_destination',false);
							if(post_type_exists('accommodation') && is_array($connected_accommodation) && !empty($connected_accommodation) ) {
								?>					
								<li><a href="#accommodation">Accommodation</a></li>
							<?php
						}} ?>
						<?php
						if(!lsx_item_has_children(get_the_ID(),'destination')){
							$connected_activity = get_post_meta(get_the_ID(),'activity_to_destination',false);
							if(post_type_exists('activity') && is_array($connected_activity) && !empty($connected_activity) ) {
								?>					
								<li><a href="#activity">Activities</a></li>
							<?php
						}} ?>						
						<li><a href="#destination-map"><?php _e('Map','lsx-tour-operators');?></a></li>
						<?php 
						if(class_exists('Envira_Gallery')){
							$gallery_id = get_post_meta(get_the_ID(),'envira_to_destination',true);
						} else {
							$gallery_id = get_post_meta(get_the_ID(),'gallery',true);
						}
						if(false !== $gallery_id && '' !== $gallery_id){ ?>
							<li><a href="#gallery"><?php _e('Gallery','lsx-tour-operators');?></a></li>
						<?php } ?>
						<?php 
						$videos = get_post_meta(get_the_ID(),'videos',true);
						if(false !== $videos && '' !== $videos){ ?>
							<li><a href="#videos"><?php _e('Videos','lsx-tour-operators');?></a></li>
						<?php } ?>								
					</ul>
				</div>
			</section>			
			
			<?php while ( have_posts() ) : the_post(); ?>		
				<section id="summary">
					<div class="row">
						<?php lsx_tour_operator_content('content', get_post_type()); ?>
					</div>
				</section>
			<?php endwhile; // end of the loop. ?>
			
			<?php
			/**
			 * Hooked
			 *
			 *  - lsx_tour_country_regions() - 70
			 *  - lsx_tour_destination_tours() - 80
			 *  - lsx_tour_region_accommodation() - 90
			 */			
			lsx_content_bottom();
			?>
			
			<?php lsx_tour_destination_activities(); ?>
			
			<?php if(lsx_has_map()){ ?>
				<section id="destination-map">
					<h2 class="section-title"><?php _e('Map','lsx-tour-operators'); ?></h2>
					<?php lsx_map(); ?>
				</section>			
			<?php }	?>		
			
			<?php 
			if(class_exists('Envira_Gallery')){
				$gallery_id = get_post_meta(get_the_ID(),'envira_to_destination',true);
				$test = false !== $gallery_id && '' !== $gallery_id;
			} else {
				$gallery_id = get_post_meta(get_the_ID(),'gallery',false);
				$test = false !== $gallery_id && '' !== $gallery_id && is_array($gallery_id) && !empty($gallery_id);
			}
			if($test){
				?>
				<section id="gallery">
					<h2 class="section-title"><?php _e('Gallery','lsx-tour-operators'); ?></h2>	
					<?php 
					if ( function_exists( 'Envira_Gallery' ) ) {
						lsx_tour_operator_content('content', 'envira');
					} else {
						echo do_shortcode( '[gallery ids="'. implode(',',$gallery_id) .'" type="square" size="medium" columns="4" link="file"]' );
					}
				?>
				</section>
				<?php 
			}
			?>
			
			<?php lsx_tour_videos('<section id="videos"><h2 class="section-title">'.__('Videos','lsx-tour-operators').'</h2>','</section>'); ?>
			
		</main><!-- #main -->	

		<?php lsx_content_after();?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>
<?php get_footer();