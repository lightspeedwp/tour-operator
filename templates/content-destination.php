<?php
/**
 * Destination Content Part
 * 
 * @package 	lsx-tour-operators
 * @category	destination
 */
global $lsx_archive;
if(1 !== $lsx_archive){$lsx_archive = false;}
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php lsx_entry_top(); ?>
	
	<?php if(is_archive() || is_post_type_archive('destination') || $lsx_archive) { ?>
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
				<?php the_title( '<h3 class="page-title"><a href="'.get_permalink().'" title="'.__('Read more','lsx-tour-operators').'">', '</a></h3>' ); ?>
				<?php lsx_tour_tagline('<p class="tagline">','</p>'); ?>
			</header><!-- .entry-header -->					
	<?php }	?>
	
	<div <?php lsx_entry_class('entry-content'); ?>>																
	
		<?php if(is_single() && false === $lsx_archive) { ?>
			<div class="single-main-info">
				<h3><?php _esc_html_e('Summary','lsx-tour-operators');?></h3>
				<div class="meta taxonomies">
					<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Travel Style','lsx-tour-operators').': ', ', ', '</div>' ); ?>
					<?php lsx_connected_activities('<div class="meta activities">'.__('Activites','lsx-tour-operators').': ','</div>'); ?>	
				</div>
				<?php lsx_tour_sharing(); ?>
			</div>
			<?php the_content(); ?>
		<?php }else{ ?>
			<?php the_excerpt(); ?>
		<?php } ?>
		
	</div><!-- .entry-content -->

	<?php if(is_singular() && false === $lsx_archive) { ?>
		<div class="col-sm-3">
			<div class="team-member-widget">
				<?php if ( lsx_has_team_member() ) lsx_team_member_panel( '<div class="team-member">', '</div>' ) ?>
				<?php lsx_enquire_modal() ?>
			</div>
		</div>	
	<?php }?>
	
	<?php if(is_archive() || $lsx_archive) { ?>		
		</div>
		<div class="col-sm-4">
			<div class="destination-details">
				<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Travel Style','lsx-tour-operators').': ', ', ', '</div>' ); ?>				
				<?php lsx_connected_activities('<div class="meta activities">'.__('Activites','lsx-tour-operators').': ','</div>'); ?>				
			</div>
		</div>
	</div>
	<?php }	?>		
	
	<?php lsx_entry_bottom(); ?>
	
</article><!-- #post-## -->

<?php lsx_entry_after();