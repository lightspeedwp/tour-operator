<?php
/**
 * Map Marker Content
 * 
 * @package 	tour-operator
 * @category	google-maps
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 0px;">

	<?php to_map_meta(); ?>		

	<div class="entry-content">
			<?php the_excerpt(); ?>
	</div><!-- .entry-content -->					
	
</article><!-- #post-## -->