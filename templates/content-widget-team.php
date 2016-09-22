<?php
/**
 * Team Widget Content Part
 * 
 * @package 	lsx-tour-operators
 * @category	team
 * @subpackage	widget
 */
global $disable_placeholder;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 	<?php if('1' !== $disable_placeholder && true !== $disable_placeholder) { ?>
		<div class="thumbnail">
			<?php if(!lsx_is_single_disabled()){ ?>
				<a href="<?php the_permalink(); ?>">
			<?php } ?>
				<?php lsx_thumbnail( 'lsx-thumbnail-wide' ); ?>
			<?php if(!lsx_is_single_disabled()){ ?>
				</a>
			<?php } ?>
		</div>
	<?php } ?>

	<h4 class="title">
		<?php if(!lsx_is_single_disabled()){ ?>
			<a href="<?php the_permalink(); ?>">
		<?php } ?>
			<?php the_title(); ?>
		<?php if(!lsx_is_single_disabled()){ ?>
			</a>
		<?php } ?>
	</h4>
	<?php lsx_tour_team_role('<p class="tagline role">','</p>'); ?>
</article>