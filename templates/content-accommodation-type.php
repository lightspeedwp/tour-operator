<?php
/**
 * Accommodation Brand Taxonomy Type Part
 * 
 * @package 	tour-operator
 * @category	accommodation-type
 */
?>

<?php
	$description = term_description();
	if ( ! empty( $description ) ) :
?>

	<section id="summary">
		<div class="row">
			<article class="hentry taxonomy-description">
				<div class="<?php echo to_has_team_member() ? 'col-sm-9' : 'col-sm-12' ?> entry-content">
					<?php echo wp_kses_post( $description ); ?>
				</div>

				<?php if ( to_has_team_member() ) : ?>
					<div class="col-sm-3">
						<div class="team-member-widget">
							<?php if ( to_has_team_member() ) to_team_member_panel( '<div class="team-member">', '</div>' ) ?>
							<?php to_enquire_modal() ?>
						</div>
					</div>
				<?php endif ?>
			</article>
		</div>
	</section>

<?php endif ?>