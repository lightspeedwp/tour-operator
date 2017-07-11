<?php
/**
 * Activity Widget Content Part
 *
 * @package 	tour-operator
 * @category	activity
 * @subpackage	widget
 */

global $disable_placeholder, $disable_text, $post;

$has_single = ! lsx_to_is_single_disabled();
$permalink = '';

if ( $has_single ) {
	$permalink = get_the_permalink();
} elseif ( ! is_post_type_archive( 'destination' ) ) {
	$has_single = true;
	$permalink = get_post_type_archive_link( 'destination' ) . '#destination-' . $post->post_name;
};
?>
<article <?php post_class(); ?>>
	<?php if ( empty( $disable_placeholder ) ) { ?>
		<div class="lsx-to-widget-thumb">
			<?php if ( $has_single ) { ?><a href="<?php echo esc_url( $permalink ); ?>"><?php } ?>
				<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
			<?php if ( $has_single ) { ?></a><?php } ?>
		</div>
	<?php } ?>

	<div class="lsx-to-widget-content">
		<h4 class="lsx-to-widget-title text-center">
			<?php if ( $has_single ) { ?><a href="<?php echo esc_url( $permalink ); ?>"><?php } ?>
				<?php the_title(); ?>
			<?php if ( $has_single ) { ?></a><?php } ?>
		</h4>

		<?php
			// if ( empty( $disable_text ) ) {
			// 	lsx_to_tagline( '<p class="lsx-to-widget-tagline text-center">', '</p>' );
			// }
		?>

		<?php
			ob_start();
			the_excerpt();
			$excerpt = ob_get_clean();

			if ( empty( $disable_text ) && ! empty( $excerpt ) ) {
				echo wp_kses_post( $excerpt );
			} elseif ( $has_single ) { ?>
				<p><a href="<?php echo esc_url( $permalink ); ?>" class="moretag"><?php esc_html_e( 'View destination', 'tour-operator' ); ?></a></p>
			<?php }
		?>
	</div>
</article>
