<?php
/**
 * Accommodation Single Template
 *
 * @package 	lsx-tour-operators
 * @category	accommodation
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">">

		<?php lsx_content_before(); ?>
		
		<main id="main" class="site-main" role="main">

		<?php lsx_content_top(); ?>
		
		<section class="accommodation-navigation">
			<div class="container">
				<ul class="scroll-easing">
					<li><a href="#summary"><?php esc_html_e('Summary','lsx-tour-operators');?></a></li>
					<?php if(lsx_accommodation_has_rooms()) { echo wp_kses_post( lsx_accommodation_units_nav_links('<li><a href="#{units}">','</a></li>') ); } ?>
					<?php
					$facilities = wp_get_object_terms(get_the_ID(),'facility');
					if ( ! empty( $facilities ) && ! is_wp_error( $facilities ) ) {					
					?>
						<li><a href="#facilities"><?php esc_html_e('Facilities','lsx-tour-operators');?></a></li>
					<?php } ?>					
					<?php if(lsx_has_map()){ ?>					
						<li><a href="#accommodation-map"><?php esc_html_e('Map','lsx-tour-operators');?></a></li>
					<?php } ?>
					<?php 
					$gallery_id = get_post_meta(get_the_ID(),'gallery',true);
					if(false !== $gallery_id && '' !== $gallery_id){ ?>
						<li><a href="#gallery"><?php esc_html_e('Gallery','lsx-tour-operators');?></a></li>
					<?php } ?>
					<?php 
					$videos = get_post_meta(get_the_ID(),'videos',true);
					if(false !== $videos && '' !== $videos){ ?>
						<li><a href="#videos"><?php esc_html_e('Videos','lsx-tour-operators');?></a></li>
					<?php } ?>	
					<li><a href="#related-accommodation"><?php esc_html_e('Accommodation','lsx-tour-operators');?></a></li>
					<?php
						$connected_tours = get_post_meta(get_the_ID(),'tour_to_accommodation',false);
						if(post_type_exists('tour') && is_array($connected_tours) && !empty($connected_tours) ) {
							?>					
							<li><a href="#related-tours"><?php esc_html_e('Tours','lsx-tour-operators');?></a></li>
						<?php
					} ?>										
				</ul>
			</div>
		</section>		
		
		
		<?php while ( have_posts() ) : the_post(); ?>
			<section id="summary">
				<div class="row">
					<?php lsx_tour_operator_content('content', 'accommodation'); ?>
				</div>
			</section>
			
		<?php endwhile; // end of the loop. ?>
		
		
		<?php lsx_accommodation_units('<section id="{units}"><h2 class="section-title">'.__('{units}','lsx-tour-operators').'</h2><div class="info row">','</div></section>'); ?>	
		
		<?php lsx_accommodation_facilities('<section id="facilities"><h2 class="section-title">'.__('Facilities','lsx-tour-operators').'</h2><div class="info row">','</div></section>'); ?>	

		<?php if(lsx_has_map()){ ?>
			<section id="accommodation-map">
				<h2 class="section-title"><?php esc_html_e('Map','lsx-tour-operators'); ?></h2>
				<?php lsx_map(); ?>
			</section>			
		<?php }	?>			
		
		<?php 
		$gallery_ids = get_post_meta(get_the_ID(),'gallery',false);
		if(false !== $gallery_ids && '' !== $gallery_ids && is_array($gallery_ids) && !empty($gallery_ids)){ ?>
			<section id="gallery">
				<h2 class="section-title"><?php esc_html_e('Gallery','lsx-tour-operators'); ?></h2>	
				<?php 
					if ( function_exists( 'envira_dynamic' ) ) {
						envira_dynamic( array( 'id' => 'custom', 'images' => implode(',',$gallery_ids), 'isotope' => false, 'pagination' => true ,'pagination_images_per_page' => 9 ) );
					} else {
						echo do_shortcode( '[gallery ids="'. implode(',',$gallery_ids) .'" type="square" size="medium" columns="4" link="file"]' );
					}
				?>
			</section>
		<?php }	?>	
		
		<?php lsx_tour_videos('<section id="videos"><h2 class="section-title">'.__('Videos','lsx-tour-operators').'</h2>','</section>'); ?>	

		<?php lsx_related_items('travel-style','<section id="related-items"><h2 class="section-title">'.__(lsx_get_post_type_section_title('accommodation', 'similar', 'Related Accommodation'),'lsx-tour-operators').'</h2>','</section>'); ?>		

		<?php
		$connected_tours = get_post_meta(get_the_ID(),'tour_to_accommodation',false); 
		if(lsx_accommodation_display_connected_tours() && post_type_exists('tour') && is_array($connected_tours) && !empty($connected_tours)){
			lsx_related_items($connected_tours,'<section id="related-items"><h2 class="section-title">'.__('Related Tours','lsx-tour-operators').'</h2>','</section>',true,'tour');
		}?>
		
		<?php lsx_content_bottom(); ?>

		</main><!-- #main -->			

		<?php lsx_content_after(); ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>	

<?php get_footer();