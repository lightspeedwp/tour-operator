<?php
/**
 * Accommodation Widget Content Part
 * 
 * @package 	tour-operator
 * @category	accommodation
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

	<div class="widget-content">
		<?php lsx_to_price('<div class="meta info"><span class="price">from ','</span></div>'); ?>
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.esc_html_e('Accommodation Style','tour-operator').': ', ', ', '</div>' ); ?>
		<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">'.esc_html_e('Brand','tour-operator').': ', ', ', '</div>' ); ?>
		<?php lsx_to_connected_destinations('<div class="meta destination">'.esc_html_e('Location','tour-operator').': ','</div>'); ?>
		<?php lsx_to_accommodation_room_total('<div class="meta rooms">'.esc_html_e('Rooms','tour-operator').': <span>','</span></div>'); ?>
		<?php lsx_to_accommodation_rating('<div class="meta rating">'.esc_html_e('Rating','tour-operator').': ','</div>'); ?>
		<div class="view-more" style="text-align:center;">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary text-center"><?php esc_html_e('View Accommodation','tour-operator'); ?></a>
		</div>	
	</div>
	
</article>