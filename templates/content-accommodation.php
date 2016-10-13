<?php
/**
 * Tour Content Part
 * 
 * @package 	tour-operator
 * @category	tour
 */
global $to_archive;
if(1 !== $to_archive){$to_archive = false;}
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php lsx_entry_top(); ?>
	
	<?php if(is_archive() || $to_archive) { ?>
		<div class="col-sm-3">
			<div class="thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php lsx_thumbnail( 'lsx-thumbnail-wide' ); ?>
				</a>
			</div>
		</div>				

		<div class="col-sm-9">
			<div class="col-sm-8">
			
				<header class="page-header">
					<?php the_title( '<h3 class="page-title"><a href="'.get_permalink().'" title="'.__('Read more','tour-operator').'">', '</a></h3>' ); ?>
					<?php to_tagline('<p class="tagline">','</p>'); ?>
				</header><!-- .entry-header -->				
		<?php }	?>
		
			<div <?php to_entry_class('entry-content'); ?>>
				<?php if(is_singular() && !$to_archive) { ?>
					<div class="single-main-info">
						<h3><?php esc_html_e('Summary','tour-operator');?></h3>
						<?php to_price('<div class="meta info"><span class="price">from ','</span></div>'); ?>
						<div class="meta taxonomies">
							<?php to_accommodation_room_total('<div class="meta rooms">'.__('Rooms','tour-operator').': <span>','</span></div>'); ?>
							<?php to_accommodation_rating('<div class="meta rating">'.__('Rating','tour-operator').': ','</div>'); ?>	
							<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">'.__('Brand','tour-operator').': ', ', ', '</div>' ); ?>				
							<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Accommodation Style','tour-operator').': ', ', ', '</div>' ); ?>
							<?php the_terms( get_the_ID(), 'accommodation-type', '<div class="meta accommodation-type">'.__('Type','tour-operator').': ', ', ', '</div>' ); ?>
							<?php to_accommodation_spoken_languages('<div class="meta spoken_languages">'.__('Spoken Languages','tour-operator').': <span>','</span></div>'); ?>
							<?php to_accommodation_activity_friendly('<div class="meta friendly">'.__('Friendly','tour-operator').': <span>','</span></div>'); ?>
							<?php to_accommodation_special_interests('<div class="meta special_interests">'.__('Special Interests','tour-operator').': <span>','</span></div>'); ?>
							<?php to_connected_destinations('<div class="meta destination">'.__('Location','tour-operator').': ','</div>'); ?>	
						</div>
						<?php to_sharing(); ?>
					</div>
					<?php the_content(); ?>
					
				<?php }else{ ?>
				
					<?php the_excerpt(); ?>
					
				<?php } ?>
	
			</div><!-- .entry-content -->
	
			<?php if(is_singular() && !$to_archive && to_has_team_member()) { ?>
				<div class="col-sm-3">
					<div class="team-member-widget">
						<?php if ( to_has_team_member() ) to_team_member_panel( '<div class="team-member">', '</div>' ) ?>
						<?php to_enquire_modal() ?>
					</div>
				</div>
			<?php }?>		
			
			<?php if(is_archive() || $to_archive) { ?>		
				</div>
				<div class="col-sm-4">
					<?php to_accommodation_meta(); ?>
				</div>
			</div>
			<?php }	?>	
			
		<?php lsx_entry_bottom(); ?>			
	
</article><!-- #post-## -->

<?php lsx_entry_after();