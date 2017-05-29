<?php
/**
 * Tour Content Part
 * 
 * @package 	tour-operator
 * @category	tour
 */
global $lsx_to_archive;
if(1 !== $lsx_to_archive){
	$lsx_to_archive = false;
}
?>

<?php lsx_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php lsx_entry_top(); ?>
		
	<div <?php lsx_to_entry_class('entry-content'); ?>>
		<?php if(is_single() && false === $lsx_to_archive) { ?>
			<div class="single-main-info">
				<h3><?php esc_html_e('Summary','tour-operator');?></h3>
				<div class="meta info"><?php lsx_to_price('<span class="price">'.esc_html__('From price','tour-operator').': ','</span>'); lsx_to_duration('<span class="duration">'.esc_html__('Duration','tour-operator').': ','</span>'); ?></div>
				<div class="meta taxonomies">
					<?php lsx_to_departure_point('<div class="meta departure destination">'.esc_html__('Departs from','tour-operator').': ','</div>'); ?>
					<?php lsx_to_end_point('<div class="meta end-point destination">'.esc_html__('Ends in','tour-operator').': ','</div>'); ?>
					<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.esc_html__('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>
					<?php lsx_to_connected_countries('<div class="meta destination">'.esc_html__('Destinations','tour-operator').': ','</div>'); ?>
					<?php if(function_exists('lsx_to_connected_activities')){ lsx_to_connected_activities('<div class="meta activities">'.esc_html__('Activities','tour-operator').': ','</div>'); } ?>
				</div>
				<?php lsx_to_sharing(); ?>
			</div>
			<?php the_content(); ?>
				
		<?php }else{ ?>
		
			<?php the_excerpt(); ?>
			
		<?php } ?>

	</div><!-- .entry-content -->
	
	<?php lsx_entry_bottom(); ?>
</article><!-- #post-## -->

<?php lsx_entry_after();