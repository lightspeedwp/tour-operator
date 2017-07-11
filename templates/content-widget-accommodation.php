<?php
/**
 * Accommodation Widget Content Part
 *
 * @package 	tour-operator
 * @category	accommodation
 * @subpackage	widget
 */

global $disable_placeholder, $disable_text, $post;

$has_single = ! lsx_to_is_single_disabled();
$permalink = '';

if ( $has_single ) {
	$permalink = get_the_permalink();
} elseif ( ! is_post_type_archive( 'accommodation' ) ) {
	$has_single = true;
	$permalink = get_post_type_archive_link( 'accommodation' ) . '#accommodation-' . $post->post_name;
}
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
				the_terms( get_the_ID(), 'travel-style', '<span class="' . $meta_class . 'style">' . esc_html__( 'Style', 'tour-operator' ) . ': ', ', ', '</span>' );
				the_terms( get_the_ID(), 'accommodation-brand', '<span class="' . $meta_class . 'brand">' . esc_html__( 'Brand', 'tour-operator' ) . ': ', ', ', '</span>' );
				lsx_to_connected_destinations( '<span class="' . $meta_class . 'destinations">' . esc_html__( 'Location', 'tour-operator' ) . ': ', '</span>' );
				lsx_to_accommodation_room_total( '<span class="' . $meta_class . 'rooms">' . esc_html__( 'Rooms', 'tour-operator' ) . ': ', '</span>' );
				lsx_to_accommodation_rating( '<span class="' . $meta_class . 'rating">' . esc_html__( 'Rating', 'tour-operator' ) . ': ', '</span>' );
			?>
		</div>

		<?php
			ob_start();
			the_excerpt();
			$excerpt = ob_get_clean();

			if ( empty( $disable_text ) && ! empty( $excerpt ) ) {
				echo wp_kses_post( $excerpt );
			} elseif ( $has_single ) { ?>
				<p><a href="<?php echo esc_url( $permalink ); ?>" class="moretag"><?php esc_html_e( 'View accommodation', 'tour-operator' ); ?></a></p>
			<?php }
		?>
	</div>
</article>
