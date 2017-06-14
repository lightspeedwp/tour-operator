<?php
/**
 * Tours Widget Content Part
 *
 * @package 	tour-operator
 * @category	tours
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
		<h4 class="lsx-to-widget-title text-center"><?php the_title(); ?></h4>

		<?php lsx_to_tagline( '<p class="lsx-to-widget-tagline text-center">', '</p>' ); ?>

		<div class="lsx-to-widget-meta-data">
			<?php
				$meta_class = 'lsx-to-widget-meta lsx-to-widget-meta-';

				lsx_to_price( '<span class="'. $meta_class .'price">'. esc_html__( 'From price', 'tour-operator' ) .': ', '</span>' );
				lsx_to_duration( '<span class="'. $meta_class .'duration">'. esc_html__( 'Duration', 'tour-operator' ) .': ', '</span>' );
				the_terms( get_the_ID(), 'travel-style', '<span class="'. $meta_class .'style">'. esc_html__( 'Travel Style', 'tour-operator' ) .': ', ', ', '</span>' );
				lsx_to_connected_countries( '<span class="'. $meta_class .'destinations">'. esc_html__( 'Destinations', 'tour-operator' ) .': ', '</span>' );

				if ( function_exists( 'lsx_to_connected_activities' ) ) {
					lsx_to_connected_activities( '<span class="'. $meta_class .'activities">'. esc_html__( 'Activities', 'tour-operator' ) .': ', '</span>' );
				}
			?>
		</div>

		<p>
			<a href="<?php the_permalink(); ?>" class="moretag"><?php esc_html_e('View tour','tour-operator'); ?></a>
		</p>
	</div>
</article>
