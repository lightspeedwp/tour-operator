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
		
		<div <?php to_entry_class('entry-content'); ?>>
			<?php if(is_singular() && !$to_archive) { ?>
				<div class="single-main-info">
					<h3><?php esc_html_e('Summary','tour-operator');?></h3>
					<?php to_price('<div class="meta info"><span class="price">from ','</span></div>'); ?>
					<div class="meta taxonomies">
						<?php to_accommodation_room_total('<div class="meta rooms">'.esc_html_e('Rooms','tour-operator').': <span>','</span></div>'); ?>
						<?php to_accommodation_rating('<div class="meta rating">'.esc_html_e('Rating','tour-operator').': ','</div>'); ?>
						<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">'.esc_html_e('Brand','tour-operator').': ', ', ', '</div>' ); ?>
						<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.esc_html_e('Accommodation Style','tour-operator').': ', ', ', '</div>' ); ?>
						<?php the_terms( get_the_ID(), 'accommodation-type', '<div class="meta accommodation-type">'.esc_html_e('Type','tour-operator').': ', ', ', '</div>' ); ?>
						<?php to_accommodation_spoken_languages('<div class="meta spoken_languages">'.esc_html_e('Spoken Languages','tour-operator').': <span>','</span></div>'); ?>
						<?php to_accommodation_activity_friendly('<div class="meta friendly">'.esc_html_e('Friendly','tour-operator').': <span>','</span></div>'); ?>
						<?php to_accommodation_special_interests('<div class="meta special_interests">'.esc_html_e('Special Interests','tour-operator').': <span>','</span></div>'); ?>
						<?php if(function_exists('to_connected_activities')) { to_connected_activities('<div class="meta activity">'.esc_html_e('Activities','tour-operator').': ','</div>'); } ?>
						<?php to_connected_destinations('<div class="meta destination">'.esc_html_e('Location','tour-operator').': ','</div>'); ?>
					</div>
					<?php to_sharing(); ?>
				</div>
				<?php the_content(); ?>
				
			<?php }else{ ?>
			
				<?php the_excerpt(); ?>
				
			<?php } ?>

		</div><!-- .entry-content -->		
		
	<?php lsx_entry_bottom(); ?>			
	
</article><!-- #post-## -->

<?php lsx_entry_after();