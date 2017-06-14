<?php
/**
 * Activity Widget Content Part
 *
 * @package 	tour-operator
 * @category	activity
 * @subpackage	widget
 */
global $disable_placeholder;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( '1' !== $disable_placeholder && true !== $disable_placeholder ) { ?>
		<div class="lsx-to-widget-thumb">
			<a href="<?php the_permalink(); ?>">
				<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
			</a>
		</div>
	<?php } ?>

	<div class="lsx-to-widget-content">
		<h4 class="lsx-to-widget-title"><?php the_title(); ?></h4>
		<?php the_excerpt(); ?>
	</div>
</article>
