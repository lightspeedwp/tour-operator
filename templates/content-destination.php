<?php
/**
 * Destination Content Part
 * 
 * @package 	tour-operator
 * @category	destination
 */
global $to_archive;
if(1 !== $to_archive){$to_archive = false;}
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php lsx_entry_top(); ?>
	
	<?php if(is_archive() || is_post_type_archive('destination') || $to_archive) { ?>
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
	
		<?php if(is_single() && false === $to_archive) { ?>
			<div class="single-main-info">
				<h3><?php esc_html_e('Summary','tour-operator');?></h3>
				<div class="meta taxonomies">
					<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>
					<?php to_connected_activities('<div class="meta activities">'.__('Activites','tour-operator').': ','</div>'); ?>	
				</div>
				<?php to_sharing(); ?>
			</div>
			<?php the_content(); ?>
		<?php }else{ ?>
			<?php the_excerpt(); ?>
		<?php } ?>
		
	</div><!-- .entry-content -->

	<?php if(is_singular() && false === $to_archive) { ?>
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
			<div class="destination-details">
				<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>				
				<?php to_connected_activities('<div class="meta activities">'.__('Activites','tour-operator').': ','</div>'); ?>				
			</div>
		</div>
	</div>
	<?php }	?>		
	
	<?php lsx_entry_bottom(); ?>
	
</article><!-- #post-## -->

<?php lsx_entry_after();