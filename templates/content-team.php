<?php
/**
 * Team Content Part
 * 
 * @package 	lsx-tour-operators
 * @category	team
 */
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php lsx_entry_top(); ?>

	<?php if(is_archive()) { ?>
		<div class="col-sm-3">
			<div class="thumbnail">
				<?php if(!lsx_is_single_disabled()){ ?>
					<a href="<?php the_permalink(); ?>">
				<?php } ?>				
					<?php lsx_thumbnail( 'lsx-thumbnail-wide' ); ?>
				<?php if(!lsx_is_single_disabled()){ ?>
					</a>
				<?php } ?>
			</div>
		</div>				

	<div class="col-sm-9">
		<div class="col-sm-8">
				<header class="page-header">
					<h3 class="page-title">
						<?php if(!lsx_is_single_disabled()){ ?>
							<a href="<?php the_permalink(); ?>">
						<?php } ?>
							<?php the_title(); ?>
						<?php if(!lsx_is_single_disabled()){ ?>
							</a>
						<?php } ?>
					</h3>
					<?php lsx_tour_team_tagline('<p class="tagline">','</p>'); ?>
					
				</header><!-- .entry-header -->				
	<?php }	?>	
		
			<div <?php lsx_entry_class('entry-content'); ?>>
				<?php if(is_single() || lsx_is_single_disabled()) { ?>
					<div class="single-main-info">
						<h3><?php _esc_html_e('Summary','lsx-tour-operators');?></h3>
						<div class="meta taxonomies">
							<?php lsx_tour_team_role('<div class="meta role">'.__('Role','lsx-tour-operators').': ','</div>'); ?>
							<?php lsx_connected_tours('<div class="meta tours">'.__('Tours','lsx-tour-operators').': ','</div>'); ?>
							<?php lsx_connected_accommodation('<div class="meta accommodation">'.__('Accommodation','lsx-tour-operators').': ','</div>'); ?>						
							<?php lsx_connected_destinations('<div class="meta destination">'.__('Location','lsx-tour-operators').': ','</div>'); ?>	
						</div>
						<?php lsx_tour_sharing(); ?>
					</div>
					<?php the_content(); ?>
				<?php }else{ ?>
					<?php the_excerpt(); ?>
				<?php } ?>
			</div><!-- .entry-content -->
			
	<?php if(is_singular()) { ?>
	
		<div class="col-sm-3">
			<div class="team-member-widget">
				<div class="team-member">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="thumbnail">
							<?php if(!lsx_is_single_disabled()){ ?>
								<a href="<?php the_permalink(); ?>">
							<?php } ?>				
								<?php lsx_thumbnail( 'lsx-thumbnail-wide' ); ?>
							<?php if(!lsx_is_single_disabled()){ ?>
								</a>
							<?php } ?>
						</div>
						<div class="team-details">
							<?php lsx_tour_team_contact_number('<div class="meta contact-number"><i class="fa fa-phone orange"></i> ','</div>'); ?>
							<?php lsx_tour_team_contact_email('<div class="meta email"><i class="fa fa-envelope orange"></i> ','</div>'); ?>
							<?php lsx_tour_team_social_profiles('<div class="social-links">','</div>'); ?>
						</div>
					</article>
				</div>
			</div>
		</div>

	<?php }?>			
			
	<?php if(is_archive()) { ?>		
		</div>
		<div class="col-sm-4">
			<div class="team-details">
				<?php lsx_tour_team_role('<div class="meta role">'.__('Role','lsx-tour-operators').': ','</div>'); ?>
				<?php lsx_tour_team_contact_number('<div class="meta contact-number"><i class="fa fa-phone orange"></i> ','</div>'); ?>
				<?php lsx_tour_team_contact_email('<div class="meta email"><i class="fa fa-envelope orange"></i> ','</div>'); ?>
				<?php lsx_tour_team_social_profiles('<div class="social-links">','</div>'); ?>		    
			</div>
		</div>
	</div>
	<?php }	?>

	<?php lsx_entry_bottom(); ?>
	
</article><!-- #post-## -->

<?php lsx_entry_after();