<?php
/**
 * Accommodation Widget Content Part
 * 
 * @package 	lsx-tour-operators
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
		<?php lsx_tour_price('<div class="meta info"><span class="price">from ','</span></div>'); ?>
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Accommodation Style','lsx-tour-operators').': ', ', ', '</div>' ); ?>
		<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">'.__('Brand','lsx-tour-operators').': ', ', ', '</div>' ); ?>
		<?php lsx_connected_destinations('<div class="meta destination">'.__('Location','lsx-tour-operators').': ','</div>'); ?>	
		<?php lsx_accommodation_room_total('<div class="meta rooms">'.__('Rooms','lsx-tour-operators').': <span>','</span></div>'); ?>
		<?php lsx_accommodation_rating('<div class="meta rating">'.__('Rating','lsx-tour-operators').': ','</div>'); ?>		
		<div class="view-more" style="text-align:center;">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary text-center"><?php _e('View Accommodation','lsx-tour-operators'); ?></a>
		</div>	
	</div>
	
</article>