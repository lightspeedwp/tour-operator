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
 	<?php if ( '1' !== $disable_placeholder && true !== $disable_placeholder ) { ?>
		<div class="thumb">
			<a href="<?php the_permalink(); ?>">
				<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
			</a>
		</div>
	<?php } ?>

	<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<?php lsx_to_tagline('<p class="tagline">','</p>'); ?>

	<div class="widget-content">
		<div class="meta info"><?php lsx_to_price('<span class="price">'.esc_html__('From price','tour-operator').': ','</span>'); lsx_to_duration('<span class="duration">'.esc_html__('Duration','tour-operator').': ','</span>'); ?></div>
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.esc_html__('Travel Style','tour-operator').': ', ', ', '</div>' ); ?>
		<?php lsx_to_connected_countries('<div class="meta destination">'.esc_html__('Destinations','tour-operator').': ','</div>'); ?>
		<?php if(function_exists('lsx_to_connected_activities')){ lsx_to_connected_activities('<div class="meta activities">'.esc_html__('Activities','tour-operator').': ','</div>'); } ?>
		<div class="view-more" style="text-align:center;">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary text-center"><?php esc_html_e('View Tour','tour-operator'); ?></a>
		</div>
	</div>
</article>
