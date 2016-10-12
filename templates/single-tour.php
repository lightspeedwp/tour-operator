<?php
/**
 * Tour Single Template
 *
 * @package 	tour-operator
 * @category	tour
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( to_main_class() ); ?>">

		<?php to_content_before(); ?>
		
		<main id="main" class="site-main" role="main">

		<?php 
		/**
		 * Hooked
		 * 
		 *  - Lsx_Tour_Operators::to_single_header() - 100
		 */
			to_content_top();
		?>
		
		<section class="tour-navigation">
			<div class="container">
				<ul class="scroll-easing">
					<li><a href="#summary">Summary</a></li>
					<li><a href="#itinerary">Itinerary</a></li>
					<li><a href="#included-excluded">Included / Excluded</a></li>
					<?php if(to_has_map()){ ?>					
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

		<section id="highlights">
			<div class="row">
				<div class="col-sm-6">
					<?php to_highlights('<div class="highlights"><h2 class="section-title">'.__('Highlights','tour-operator').'</h2>','</div>'); ?>
				</div>
				<div class="col-sm-6">
					<?php to_best_time_to_visit('<div class="best-time-to-visit"><h2 class="section-title">'.__('Best time to visit','tour-operator').'</h2><div class="best-time-to-visit-content">','</div></div>'); ?>
				</div>	
			</div>				
		</section>
		
		<?php if(to_has_itinerary()){ ?>
			<section id="itinerary">
				<h2 class="section-title"><?php esc_html_e('Full Day by Day Itinerary','tour-operator');?></h2>
				<?php while(to_itinerary_loop()){ ?>
					<?php to_itinerary_loop_item(); ?>
					<div <?php to_itinerary_class('itinerary-item'); ?>>
						<div class="row">
							<div class="panel col-sm-12">
								<div class="itinerary-inner">
									<?php if(to_itinerary_has_thumbnail()) { ?>
										<div class="itinerary-image col-sm-3">
											<div class="thumbnail">
												<?php to_itinerary_thumbnail(); ?>
											</div>
										</div>
									<?php } ?>
									<div class="itinerary-content col-sm-<?php if(to_itinerary_has_thumbnail()) { ?>9<?php }else{?>12<?php }?>">
										<div class="col-sm-8">
											<h3><?php to_itinerary_title(); ?></h3>
											<strong><small><?php to_itinerary_tagline() ?></small></strong>
											<div class="entry-content">
												<?php to_itinerary_description(); ?>
											</div>
										</div>
										<div class="col-sm-4">
											<?php to_itinerary_destinations('<div class="meta destination">'.__('Destination','tour-operator').': ','</div>'); ?>
											<?php to_itinerary_accommodation('<div class="meta accommodation">'.__('Accommodation','tour-operator').': ','</div>'); ?>
											<?php to_itinerary_activities('<div class="meta activities">'.__('Activites','tour-operator').': ','</div>'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
				<?php } ?>
				<?php to_itinerary_read_more(); ?>
			</section>
		<?php } ?>
		
		<?php to_pricing_block(); ?>

		<?php if(to_has_map()){ ?>
			<section id="tour-map">
				<h2 class="section-title"><?php esc_html_e('Map','tour-operator'); ?></h2>
				<?php to_map(); ?>
			</section>			
		<?php }	?>			
		
		<?php if(function_exists('to_gallery')) { to_gallery('<section id="gallery"><h2 class="section-title">'.__('Gallery','tour-operator').'</h2>','</section>'); } ?>	
		
		<?php to_videos('<div id="videos"><h2 class="section-title">'.__('Videos','tour-operator').'</h2>','</div>'); ?>
		
		<?php to_related_items('travel-style','<section id="related-items"><h2 class="section-title">'.__(to_get_post_type_section_title('tour', 'related', 'Related Tours'),'tour-operator').'</h2>','</section>'); ?>		
		
		<?php to_content_bottom(); ?>

		</main><!-- #main -->			

		<?php to_content_after(); ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>

<?php get_footer();