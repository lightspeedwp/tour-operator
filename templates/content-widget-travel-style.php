<?php
/**
 * Travel Style Widget Content Part
 *
 * @package 	tour-operator
 * @category	travel-style
 * @subpackage	widget
 */
global $term, $taxonomy, $disable_placeholder;
?>
<article id="term-<?php echo esc_attr( $term->term_id ); ?>" class="term-<?php echo esc_attr( $term->term_id ); ?> <?php echo esc_attr( $taxonomy ); ?> type-<?php echo esc_attr( $taxonomy ); ?> status-publish hentry">
 	<?php if ( '1' !== $disable_placeholder && true !== $disable_placeholder ) { ?>
		<?php if ( lsx_to_has_term_thumbnail( $term->term_id ) ) : ?>
			<div class="lsx-to-widget-thumb">
				<a href="<?php echo esc_url( home_url( $taxonomy .'/'. $term->slug .'/' ) ); ?>">
					<?php lsx_to_term_thumbnail( $term->term_id, 'lsx-thumbnail-wide' ); ?>
				</a>
			</div>
		<?php else: ?>
			<div class="lsx-to-widget-thumb">
				<a href="<?php echo esc_url( home_url( $taxonomy .'/'. $term->slug .'/' ) ); ?>">
					<img alt="Placeholder" class="attachment-responsive wp-post-image lsx-responsive" src="<?php echo esc_attr( LSX_TO_Placeholders::placeholder_url() . ( parse_url( LSX_TO_Placeholders::placeholder_url(), PHP_URL_QUERY ) ? '&' : '?' ) ); ?>w=350&amp;h=230">
				</a>
			</div>
		<?php endif; ?>
	<?php } ?>

	<div class="lsx-to-widget-content">
		<h4 class="lsx-to-widget-title"><?php echo esc_html( apply_filters( 'the_title', $term->name ) ); ?></h4>
		<?php lsx_to_term_tagline( $term->term_id, '<p class="lsx-to-widget-tagline">', '</p>' ); ?>

		<p>
			<a href="<?php echo esc_url( home_url($taxonomy.'/'.$term->slug.'/') ); ?>" class="moretag"><?php esc_html_e( 'View more', 'tour-operator' ); ?></a>
		</p>
	</div>
</article>
