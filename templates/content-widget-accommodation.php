<?php
/**
 * Accommodation Widget Content Part
 *
 * @package 	tour-operator
 * @category	accommodation
 * @subpackage	widget
 */

global $disable_placeholder;
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

		<div class="lsx-to-widget-meta-data">
			<?php
				$meta_class = 'lsx-to-meta-data lsx-to-meta-data-';

				lsx_to_price( '<span class="'. $meta_class .'price">'. esc_html__( 'From price', 'tour-operator' ) .': ', '</span>' );
				the_terms( get_the_ID(), 'travel-style', '<span class="'. $meta_class .'style">'. esc_html__( 'Style', 'tour-operator' ) .': ', ', ', '</span>' );
				the_terms( get_the_ID(), 'accommodation-brand', '<span class="'. $meta_class .'brand">' .esc_html__( 'Brand', 'tour-operator' ) .': ', ', ', '</span>' );
				lsx_to_connected_destinations('<span class="'. $meta_class .'destinations">'. esc_html__( 'Location', 'tour-operator' ) .': ', '</span>' );
				lsx_to_accommodation_room_total('<span class="'. $meta_class .'rooms">' .esc_html__( 'Rooms', 'tour-operator' ) .': ', '</span>' );
				lsx_to_accommodation_rating('<span class="'. $meta_class .'rating">'. esc_html__( 'Rating', 'tour-operator' ) .': ', '</span>' );
			?>
		</div>

		<p>
			<a href="<?php the_permalink(); ?>" class="moretag"><?php esc_html_e( 'View accommodation', 'tour-operator' ); ?></a>
		</p>
	</div>
</article>
