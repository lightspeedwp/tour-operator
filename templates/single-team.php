<?php
/**
 * Team Single Template
 *
 * @package 	lsx-tour-operators
 * @category	team
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
					<?php lsx_tour_operator_content('content', 'team'); ?>
				</div>
			</section>
		<?php endwhile; // end of the loop. ?>
		
		<?php lsx_team_accommodation(); ?>
		
		<?php lsx_team_tours(); ?>		
		
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
		
		<?php lsx_content_bottom(); ?>

		</main><!-- #main -->			

		<?php lsx_content_after(); ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar( 'alt' ); ?>

<?php get_footer();