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
				<?php to_thumbnail( 'lsx-thumbnail-wide' ); ?>
			</a>
		</div>
	<?php } ?>

	<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

	<div class="widget-content">
		<?php to_price('<div class="meta info"><span class="price">from ','</span></div>'); ?>
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Accommodation Style','tour-operator').': ', ', ', '</div>' ); ?>
		<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">'.__('Brand','tour-operator').': ', ', ', '</div>' ); ?>
		<?php to_connected_destinations('<div class="meta destination">'.__('Location','tour-operator').': ','</div>'); ?>	
		<?php to_accommodation_room_total('<div class="meta rooms">'.__('Rooms','tour-operator').': <span>','</span></div>'); ?>
		<?php to_accommodation_rating('<div class="meta rating">'.__('Rating','tour-operator').': ','</div>'); ?>		
		<div class="view-more" style="text-align:center;">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary text-center"><?php esc_html_e('View Accommodation','tour-operator'); ?></a>
		</div>	
	</div>
	
</article>