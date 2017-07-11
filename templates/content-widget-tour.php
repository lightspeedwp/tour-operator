<?php
/**
 * Tours Widget Content Part
 *
 * @package 	tour-operator
 * @category	tours
 * @subpackage	widget
 */

global $disable_placeholder, $disable_text, $post;

$has_single = ! lsx_to_is_single_disabled();
$permalink = '';

if ( $has_single ) {
	$permalink = get_the_permalink();
} elseif ( ! is_post_type_archive( 'tour' ) ) {
	$has_single = true;
	$permalink = get_post_type_archive_link( 'tour' ) . '#tour-' . $post->post_name;
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

		<div class="lsx-to-widget-meta-data">
			<?php
				$meta_class = 'lsx-to-meta-data lsx-to-meta-data-';

				lsx_to_price( '<span class="' . $meta_class . 'price">' . esc_html__( 'From price', 'tour-operator' ) . ': ', '</span>' );
				lsx_to_duration( '<span class="' . $meta_class . 'duration">' . esc_html__( 'Duration', 'tour-operator' ) . ': ', '</span>' );
				the_terms( get_the_ID(), 'travel-style', '<span class="' . $meta_class . 'style">' . esc_html__( 'Travel Style', 'tour-operator' ) . ': ', ', ', '</span>' );
				lsx_to_connected_countries( '<span class="' . $meta_class . 'destinations">' . esc_html__( 'Destinations', 'tour-operator' ) . ': ', '</span>' );

				if ( function_exists( 'lsx_to_connected_activities' ) ) {
					lsx_to_connected_activities( '<span class="' . $meta_class . 'activities">' . esc_html__( 'Activities', 'tour-operator' ) . ': ', '</span>' );
				}
			?>
		</div>

		<?php
			ob_start();
			the_excerpt();
			$excerpt = ob_get_clean();

			if ( empty( $disable_text ) && ! empty( $excerpt ) ) {
				echo wp_kses_post( $excerpt );
			} elseif ( $has_single ) { ?>
				<p><a href="<?php echo esc_url( $permalink ); ?>" class="moretag"><?php esc_html_e( 'View tour', 'tour-operator' ); ?></a></p>
			<?php }
		?>
	</div>
</article>
