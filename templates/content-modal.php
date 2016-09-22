<?php
/**
 * Modal Content
 * 
 * @package 	lsx-tour-operators
 * @category	modals
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 0px;">

	<div class="thumbnail">	
		<a href="<?php the_permalink(); ?>">
			<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
		</a>
	</div>

	<h4 style="margin-top: 0px;" class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>	

	<div class="entry-content">

		<?php lsx_modal_meta(); ?>

		<?php 
			ob_start();
			the_excerpt();
			$excerpt = ob_get_clean();
			$excerpt = str_replace('moretag','moretag btn cta-btn',$excerpt);
			echo $excerpt;
		?>
	</div><!-- .entry-content -->					
	
</article><!-- #post-## -->