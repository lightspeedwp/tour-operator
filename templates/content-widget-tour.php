<?php
/**
 * Tours Widget Content Part
 * 
 * @package 	lsx-tour-operators
 * @category	tours
 * @subpackage	widget
 */
global $disable_placeholder;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
 	<?php if('1' !== $disable_placeholder && true !== $disable_placeholder) { ?>
		<div class="thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php lsx_thumbnail( 'lsx-thumbnail-wide' ); ?>
			</a>
		</div>
	<?php } ?>

	<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<?php lsx_tour_tagline('<p class="tagline">','</p>'); ?>
	
	<div class="widget-content">
		<div class="meta info"><?php lsx_tour_price('<span class="price">from ','</span>'); lsx_tour_duration('<span class="duration">','</span>'); ?></div>
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Travel Style','lsx-tour-operators').': ', ', ', '</div>' ); ?>
		<?php lsx_connected_destinations('<div class="meta destination">'.__('Destinations','lsx-tour-operators').': ','</div>'); ?>	
		<?php lsx_connected_activities('<div class="meta activities">'.__('Activites','lsx-tour-operators').': ','</div>'); ?>
		<div class="view-more" style="text-align:center;">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary text-center"><?php _esc_html_e('View Tour','lsx-tour-operators'); ?></a>
		</div>	
	</div>
	
</article>