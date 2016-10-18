<?php
/**
 * Accommodation Single Template
 *
 * @package 	tour-operator
 * @category	accommodation
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo esc_attr( lsx_main_class() ); ?>">

		<?php lsx_content_before(); ?>
		
		<main id="main" class="site-main" role="main">

		<?php lsx_content_top(); ?>
		
		<section class="accommodation-navigation">
			<div class="container">
				<ul class="scroll-easing">
					<li><a href="#summary"><?php esc_html_e('Summary','tour-operator');?></a></li>
					<?php if(to_accommodation_has_rooms()) { echo wp_kses_post( to_accommodation_units_nav_links('<li><a href="#{units}">','</a></li>') ); } ?>
					<?php
					$facilities = wp_get_object_terms(get_the_ID(),'facility');
					if ( ! empty( $facilities ) && ! is_wp_error( $facilities ) ) {					
					?>
						<li><a href="#facilities"><?php esc_html_e('Facilities','tour-operator');?></a></li>
					<?php } ?>					
					<?php if(function_exists('to_has_map') && to_has_map()){ ?>					
						<li><a href="#accommodation-map"><?php esc_html_e('Map','tour-operator');?></a></li>
					<?php } ?>
					<?php 
					$gallery_id = get_post_meta(get_the_ID(),'gallery',true);
					if(false !== $gallery_id && '' !== $gallery_id){ ?>
						<li><a href="#gallery"><?php esc_html_e('Gallery','tour-operator');?></a></li>
					<?php } ?>
					<?php 
					$videos = get_post_meta(get_the_ID(),'videos',true);
					if(false !== $videos && '' !== $videos){ ?>
						<li><a href="#videos"><?php esc_html_e('Videos','tour-operator');?></a></li>
					<?php } ?>	
					<li><a href="#related-accommodation"><?php esc_html_e('Accommodation','tour-operator');?></a></li>
					<?php
						$connected_tours = get_post_meta(get_the_ID(),'tour_to_accommodation',false);
						if(post_type_exists('tour') && is_array($connected_tours) && !empty($connected_tours) ) {
							?>					
							<li><a href="#related-tours"><?php esc_html_e('Tours','tour-operator');?></a></li>
						<?php
					} ?>										
				</ul>
			</div>
		</section>		
		
		
		<?php while ( have_posts() ) : the_post(); ?>
			<section id="summary">
				<div class="row">
					<?php to_content('content', 'accommodation'); ?>
				</div>
			</section>
			
		<?php endwhile; // end of the loop. ?>
		
		<?php lsx_content_bottom(); ?>

		</main><!-- #main -->			

		<?php lsx_content_after(); ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>	

<?php get_footer();