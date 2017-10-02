<?php
/**
 * Modal Content
 *
 * @package 	tour-operator
 * @category	modals
 */
?>
<article class="lsx-to-modal-content-area content-area">
	<div class="lsx-to-modal-thumb text-center">
		<a href="<?php the_permalink(); ?>">
			<?php lsx_thumbnail( 'lsx-thumbnail-single' ); ?>
		</a>
	</div>

	<h4 class="lsx-to-modal-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

	<div class="lsx-to-modal-meta-data"><?php lsx_to_modal_meta(); ?></div>

	<div class="entry-content">
		<?php
			ob_start();
			the_excerpt();
			$excerpt = ob_get_clean();
			$excerpt = str_replace( 'moretag', 'moretag btn', $excerpt );
			echo wp_kses_post( $excerpt );
		?>
	</div>
</article>
