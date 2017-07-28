<?php
/**
 * Map Marker Content
 *
 * @package 	tour-operator
 * @category	google-maps
 */
?>
<article <?php post_class(); ?>>
	<?php lsx_to_map_meta(); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
</article>
