<?php
/**
 * Accommodation Widget Content Part
 * 
 * @package 	lsx-tour-operators
 * @category	accommodation-type
 * @subpackage	widget
 */
global $term,$taxonomy,$disable_placeholder;
?>
<article id="term-<?php echo $term->term_id; ?>" class="term-<?php echo $term->term_id; ?> <?php echo $taxonomy; ?> type-<?php echo $taxonomy; ?> status-publish hentry">
 	<?php if('1' !== $disable_placeholder && true !== $disable_placeholder) { ?>
		<?php if ( lsx_has_term_thumbnail($term->term_id) ) : ?>
			<div class="thumbnail">
				<a href="<?php echo home_url($taxonomy.'/'.$term->slug.'/'); ?>">
					<?php lsx_term_thumbnail( $term->term_id,'lsx-thumbnail-wide' ); ?>
				</a>
			</div>	
		<?php else: ?>	
			<div class="thumbnail">
				<a href="<?php echo home_url($taxonomy.'/'.$term->slug.'/'); ?>">
					<img alt="Placeholder" class="attachment-responsive wp-post-image lsx-responsive" src="<?php echo LSX_Placeholders::placeholder_url(); ?>&w=350&h=230">
				</a>	
			</div>				
		<?php endif; ?>	
	<?php } ?>
	
	<h4 class="title"><a href="<?php echo home_url($taxonomy.'/'.$term->slug.'/'); ?>"><?php echo apply_filters('the_title', $term->name); ?></a></h4>
</article>