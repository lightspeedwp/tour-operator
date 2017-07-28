<?php
/**
 * Accommodation Widget Content Part
 *
 * @package 	tour-operator
 * @category	accommodation-type
 * @subpackage	widget
 */

global $term, $taxonomy, $disable_placeholder, $disable_text;

$title_link = esc_url( get_term_link( $term, $taxonomy ) );
?>
<article class="term-<?php echo esc_attr( $term->term_id ); ?> <?php echo esc_attr( $taxonomy ); ?> type-<?php echo esc_attr( $taxonomy ); ?> status-publish hentry">
	<?php if ( empty( $disable_placeholder ) ) { ?>
		<?php if ( lsx_to_has_term_thumbnail( $term->term_id ) ) : ?>
			<div class="lsx-to-widget-thumb">
				<a href="<?php echo esc_url( $title_link ); ?>">
					<?php lsx_to_term_thumbnail( $term->term_id, 'lsx-thumbnail-single' ); ?>
				</a>
			</div>
		<?php else : ?>
			<div class="lsx-to-widget-thumb">
				<a href="<?php echo esc_url( $title_link ); ?>">
					<img alt="Placeholder" class="attachment-responsive wp-post-image lsx-responsive" src="<?php echo esc_attr( lsx\legacy\Placeholders::placeholder_url( null, null, array( 750, 350 ) ) ); ?>">
				</a>
			</div>
		<?php endif; ?>
	<?php } ?>

	<div class="lsx-to-widget-content">
		<h4 class="lsx-to-widget-title text-center"><a href="<?php echo esc_url( $title_link ); ?>"><?php echo esc_html( apply_filters( 'the_title', $term->name ) ); ?></a></h4>

		<?php
			// if ( empty( $disable_text ) ) {
			// 	lsx_to_term_tagline( $term->term_id, '<p class="lsx-to-widget-tagline text-center">', '</p>' );
			// }
		?>

		<?php if ( empty( $disable_text ) && ! empty( $term->description ) ) { ?>
			<p class="lsx-to-widget-description">
				<?php echo wp_kses_post( $term->description ); ?>
			</p>
		<?php } ?>

		<p>
			<a href="<?php echo esc_url( $title_link ); ?>" class="moretag"><?php esc_html_e( 'View accommodation', 'tour-operator' ); ?></a>
		</p>
	</div>
</article>
