<?php
/**
 * Generic (post, page, ...) Widget Content Part
 *
 * @package  tour-operator
 */

global $disable_placeholder, $disable_text;

?>
<article <?php post_class(); ?>>
	 <?php if ( empty( $disable_placeholder ) ) { ?>
		<div class="lsx-to-widget-thumb">
			<?php if ( $has_single ) { ?><a href="<?php the_permalink(); ?>"><?php } ?>
				<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
			<?php if ( $has_single ) { ?></a><?php } ?>
		</div>
	<?php } ?>

	<div class="lsx-to-widget-content">
		<h4 class="lsx-to-widget-title text-center">
			<?php if ( $has_single ) { ?><a href="<?php the_permalink(); ?>"><?php } ?>
				<?php the_title(); ?>
			<?php if ( $has_single ) { ?></a><?php } ?>
		</h4>

		<?php
			if ( empty( $disable_text ) ) {
				lsx_to_tagline( '<p class="lsx-to-widget-tagline text-center">', '</p>' );
			}
		?>

		<p><a href="<?php the_permalink(); ?>" class="moretag"><?php esc_html_e( 'View more', 'tour-operator' ); ?></a></p>
	</div>
</article>
