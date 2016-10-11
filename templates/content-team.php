<?php
/**
 * Team Content Part
 * 
 * @package 	tour-operator
 * @category	team
 */
?>

<?php to_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php to_entry_top(); ?>

	<?php if(is_archive()) { ?>
		<div class="col-sm-3">
			<div class="thumbnail">
				<?php if(!to_is_single_disabled()){ ?>
					<a href="<?php the_permalink(); ?>">
				<?php } ?>				
					<?php to_thumbnail( 'lsx-thumbnail-wide' ); ?>
				<?php if(!to_is_single_disabled()){ ?>
					</a>
				<?php } ?>
			</div>
		</div>				

	<div class="col-sm-9">
		<div class="col-sm-8">
				<header class="page-header">
					<h3 class="page-title">
						<?php if(!to_is_single_disabled()){ ?>
							<a href="<?php the_permalink(); ?>">
						<?php } ?>
							<?php the_title(); ?>
						<?php if(!to_is_single_disabled()){ ?>
							</a>
						<?php } ?>
					</h3>
					<?php to_team_tagline('<p class="tagline">','</p>'); ?>
					
				</header><!-- .entry-header -->				
	<?php }	?>	
		
			<div <?php to_entry_class('entry-content'); ?>>
				<?php if(is_single() || to_is_single_disabled()) { ?>
					<div class="single-main-info">
						<h3><?php esc_html_e('Summary','tour-operator');?></h3>
						<div class="meta taxonomies">
							<?php to_team_role('<div class="meta role">'.__('Role','tour-operator').': ','</div>'); ?>
							<?php to_connected_tours('<div class="meta tours">'.__('Tours','tour-operator').': ','</div>'); ?>
							<?php to_connected_accommodation('<div class="meta accommodation">'.__('Accommodation','tour-operator').': ','</div>'); ?>						
							<?php to_connected_destinations('<div class="meta destination">'.__('Location','tour-operator').': ','</div>'); ?>	
						</div>
						<?php to_sharing(); ?>
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
							<?php if(!to_is_single_disabled()){ ?>
								<a href="<?php the_permalink(); ?>">
							<?php } ?>				
								<?php to_thumbnail( 'lsx-thumbnail-wide' ); ?>
							<?php if(!to_is_single_disabled()){ ?>
								</a>
							<?php } ?>
						</div>
						<div class="team-details">
							<?php to_team_contact_number('<div class="meta contact-number"><i class="fa fa-phone orange"></i> ','</div>'); ?>
							<?php to_team_contact_email('<div class="meta email"><i class="fa fa-envelope orange"></i> ','</div>'); ?>
							<?php to_team_social_profiles('<div class="social-links">','</div>'); ?>
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
				<?php to_team_role('<div class="meta role">'.__('Role','tour-operator').': ','</div>'); ?>
				<?php to_team_contact_number('<div class="meta contact-number"><i class="fa fa-phone orange"></i> ','</div>'); ?>
				<?php to_team_contact_email('<div class="meta email"><i class="fa fa-envelope orange"></i> ','</div>'); ?>
				<?php to_team_social_profiles('<div class="social-links">','</div>'); ?>		    
			</div>
		</div>
	</div>
	<?php }	?>

	<?php to_entry_bottom(); ?>
	
</article><!-- #post-## -->

<?php to_entry_after();