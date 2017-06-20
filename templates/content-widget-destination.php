<?php
/**
 * Activity Widget Content Part
 *
 * @package 	tour-operator
 * @category	activity
 * @subpackage	widget
 */

global $disable_placeholder, $disable_text;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( empty( $disable_placeholder ) ) { ?>
		<div class="lsx-to-widget-thumb">
			<a href="<?php the_permalink(); ?>">
				<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
			</a>
		</div>
	<?php } ?>

	<div class="lsx-to-widget-content">
		<h4 class="lsx-to-widget-title text-center"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

		<?php
			if ( empty( $disable_text ) ) {
				the_excerpt();
			} else { ?>
				<p>
					<a href="<?php the_permalink(); ?>" class="moretag"><?php esc_html_e( 'View destination', 'tour-operator' ); ?></a>
				</p>
			<?php }
		?>
	</div>
</article>
