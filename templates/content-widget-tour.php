<?php
/**
 * Tours Widget Content Part
 * 
 * @package 	tour-operator
 * @category	tours
 * @subpackage	widget
 */
global $disable_placeholder;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
 	<?php if('1' !== $disable_placeholder && true !== $disable_placeholder) { ?>
		<div class="thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php to_thumbnail( 'lsx-thumbnail-wide' ); ?>
			</a>
		</div>
	<?php } ?>

	<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<?php to_tagline('<p class="tagline">','</p>'); ?>
	
	<div class="widget-content">
		<div class="meta info"><?php to_price('<span class="price">from ','</span>'); to_duration('<span class="duration">','</span>'); ?></div>
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>
		<?php to_connected_destinations('<div class="meta destination">'.__('Destinations','tour-operator').': ','</div>'); ?>	
		<?php to_connected_activities('<div class="meta activities">'.__('Activites','tour-operator').': ','</div>'); ?>
		<div class="view-more" style="text-align:center;">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary text-center"><?php esc_html_e('View Tour','tour-operator'); ?></a>
		</div>	
	</div>
	
</article>