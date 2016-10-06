<?php
/**
 * Tour Single Template
 *
 * @package 	lsx-tour-operators
 * @category	tour
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">">

		<?php lsx_content_before(); ?>
		
		<main id="main" class="site-main" role="main">

		<?php 
		/**
		 * Hooked
		 * 
		 *  - Lsx_Tour_Operators::lsx_tour_operator_single_header() - 100
		 */
			lsx_content_top();
		?>
		
		<section class="tour-navigation">
			<div class="container">
				<ul class="scroll-easing">
					<li><a href="#summary">Summary</a></li>
					<li><a href="#itinerary">Itinerary</a></li>
					<li><a href="#included-excluded">Included / Excluded</a></li>
					<?php if(lsx_has_map()){ ?>					
						<li><a href="#tour-map">Map</a></li>
					<?php } ?>
					<?php 
					if(class_exists('Envira_Gallery')){
						$gallery_id = get_post_meta(get_the_ID(),'envira_to_tour',true);
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
		
		<section id="summary">
			<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php lsx_tour_operator_content('content', get_post_type()); ?>
				<?php endwhile; // end of the loop. ?>
			</div>
		</section>

		<section id="highlights">
			<div class="row">
				<div class="col-sm-6">
					<?php lsx_tour_highlights('<div class="highlights"><h2 class="section-title">'.__('Highlights','lsx-tour-operators').'</h2>','</div>'); ?>
				</div>
				<div class="col-sm-6">
					<?php lsx_tour_best_time_to_visit('<div class="best-time-to-visit"><h2 class="section-title">'.__('Best time to visit','lsx-tour-operators').'</h2><div class="best-time-to-visit-content">','</div></div>'); ?>
				</div>	
			</div>				
		</section>
		
		<?php if(lsx_tour_has_itinerary()){ ?>
			<section id="itinerary">
				<h2 class="section-title"><?php _e('Full Day by Day Itinerary','lsx-tour-operators');?></h2>
				<?php while(lsx_tour_itinerary_loop()){ ?>
					<?php lsx_tour_itinerary_loop_item(); ?>
					<div <?php lsx_itinerary_class('itinerary-item'); ?>>
						<div class="row">
							<div class="panel col-sm-12">
								<div class="itinerary-inner">
									<?php if(lsx_tour_itinerary_has_thumbnail()) { ?>
										<div class="itinerary-image col-sm-3">
											<div class="thumbnail">
												<?php lsx_tour_itinerary_thumbnail(); ?>
											</div>
										</div>
									<?php } ?>
									<div class="itinerary-content col-sm-<?php if(lsx_tour_itinerary_has_thumbnail()) { ?>9<?php }else{?>12<?php }?>">
										<div class="col-sm-8">
											<h3><?php lsx_tour_itinerary_title(); ?></h3>
											<strong><small><?php lsx_tour_itinerary_tagline() ?></small></strong>
											<div class="entry-content">
												<?php lsx_tour_itinerary_description(); ?>
											</div>
										</div>
										<div class="col-sm-4">
											<?php lsx_tour_itinerary_destinations('<div class="meta destination">'.__('Destination','lsx-tour-operators').': ','</div>'); ?>
											<?php lsx_tour_itinerary_accommodation('<div class="meta accommodation">'.__('Accommodation','lsx-tour-operators').': ','</div>'); ?>
											<?php lsx_tour_itinerary_activities('<div class="meta activities">'.__('Activites','lsx-tour-operators').': ','</div>'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
				<?php } ?>
				<?php lsx_itinerary_read_more(); ?>
			</section>
		<?php } ?>
		
		<?php lsx_tour_pricing_block(); ?>

		<?php if(lsx_has_map()){ ?>
			<section id="tour-map">
				<h2 class="section-title"><?php _e('Map','lsx-tour-operators'); ?></h2>
				<?php lsx_map(); ?>
			</section>			
		<?php }	?>			
		
		<?php 
		if(class_exists('Envira_Gallery')){
			$gallery_id = get_post_meta(get_the_ID(),'envira_to_tour',true);
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
		
		<?php lsx_tour_videos('<div id="videos"><h2 class="section-title">'.__('Videos','lsx-tour-operators').'</h2>','</div>'); ?>
		
		<?php lsx_related_items('travel-style','<section id="related-items"><h2 class="section-title">'.__(lsx_get_post_type_section_title('tour', 'related', 'Related Tours'),'lsx-tour-operators').'</h2>','</section>'); ?>		
		
		<?php lsx_content_bottom(); ?>

		</main><!-- #main -->			

		<?php lsx_content_after(); ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>

<?php get_footer();