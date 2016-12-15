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
		<?php if(is_single() && false === $to_archive) { ?>
			<div class="single-main-info">
				<h3><?php esc_html_e('Summary','tour-operator');?></h3>
				<div class="meta info"><?php to_price('<span class="price">from ','</span>'); to_duration('<span class="duration">','</span>'); ?></div>
				<div class="meta taxonomies">
					<?php to_departure_point('<div class="meta departure destination">'.esc_html_e('Departs from','tour-operator').': ','</div>'); ?>
					<?php to_end_point('<div class="meta end-point destination">'.esc_html_e('Ends in','tour-operator').': ','</div>'); ?>
					<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.esc_html_e('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>
					<?php to_connected_destinations('<div class="meta destination">'.esc_html_e('Destinations','tour-operator').': ','</div>'); ?>
					<?php if(function_exists('lsx_to_connected_activities')){ to_connected_activities('<div class="meta activities">'.esc_html_e('Activities','tour-operator').': ','</div>'); } ?>
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