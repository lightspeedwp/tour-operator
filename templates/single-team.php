<?php
/**
 * Team Single Template
 *
 * @package 	tour-operator
 * @category	team
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
		
		<section class="team-navigation">
			<div class="container">
				<ul class="scroll-easing">
					<li><a href="#summary">Summary</a></li>					
					<?php
						$connected_accommodation = get_post_meta(get_the_ID(),'accommodation_to_team',false);
						if(post_type_exists('accommodation') && is_array($connected_accommodation) && !empty($connected_accommodation) ) {
							?>					
							<li><a href="#accommodation">Accommodation</a></li>
						<?php
					} ?>
					<?php
						$connected_tour = get_post_meta(get_the_ID(),'tour_to_team',false);
						if(post_type_exists('tour') && is_array($connected_tour) && !empty($connected_tour) ) {
							?>					
							<li><a href="#tours">Tours</a></li>
						<?php
					} ?>					
					<?php 
					if(class_exists('Envira_Gallery')){
						$gallery_id = get_post_meta(get_the_ID(),'envira_to_team',true);
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
					<?php to_content('content', 'team'); ?>
				</div>
			</section>
		<?php endwhile; // end of the loop. ?>
		
		<?php to_team_accommodation(); ?>
		
		<?php to_team_tours(); ?>		
		
		<?php 
		if(class_exists('Envira_Gallery')){
			$gallery_id = get_post_meta(get_the_ID(),'envira_to_team',true);
			$test = false !== $gallery_id && '' !== $gallery_id;
		} else {
			$gallery_id = get_post_meta(get_the_ID(),'gallery',false);
			$test = false !== $gallery_id && '' !== $gallery_id && is_array($gallery_id) && !empty($gallery_id);
		}
		if($test){
			?>
			<section id="gallery">
				<h2 class="section-title"><?php esc_html_e('Gallery','tour-operator'); ?></h2>	
				<?php 
					if ( function_exists( 'Envira_Gallery' ) ) {
						to_content('content', 'envira');
					} else {
						echo do_shortcode( '[gallery ids="'. implode(',',$gallery_id) .'" type="square" size="medium" columns="4" link="file"]' );
					}
				?>
			</section>
			<?php 
		}
		?>		
		
		<?php to_videos('<section id="videos"><h2 class="section-title">'.__('Videos','tour-operator').'</h2>','</section>'); ?>
		
		<?php to_content_bottom(); ?>

		</main><!-- #main -->			

		<?php to_content_after(); ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>

<?php get_footer();