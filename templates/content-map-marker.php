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
		<?php
		if ( empty( $connection ) || '' === $connection || 'undefined' === $connection ) {
			$connection = '';
		}
		$excerpt = get_the_excerpt( $connection );
		if ( empty( $excerpt ) || '' === $excerpt ) {
			$tooltip = apply_filters( 'get_the_excerpt', get_the_content() );
			$tooltip = strip_tags( $tooltip );
			echo wp_kses_post( wpautop( $tooltip ) );
		} else {
			echo wp_kses_post( $excerpt );
		}
		?>
	</div>
</article>
