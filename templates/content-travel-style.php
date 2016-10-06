<?php
/**
 * Travel Style Taxonomy Content Part
 * 
 * @package 	lsx-tour-operators
 * @category	travel-style
 */
?>

<?php
	$description = term_description();
	if ( ! empty( $description ) ) :
?>

	<section id="summary">
		<div class="row">
			<article class="hentry taxonomy-description">
				<div class="<?php echo lsx_has_team_member() ? 'col-sm-9' : 'col-sm-12' ?> entry-content">
					<?php echo wp_kses_post( $description ); ?>
				</div>

				<?php if ( lsx_has_team_member() ) : ?>
					<div class="col-sm-3">
						<div class="team-member-widget">
							<?php if ( lsx_has_team_member() ) lsx_team_member_panel( '<div class="team-member">', '</div>' ) ?>
							<?php lsx_enquire_modal() ?>
						</div>
					</div>
				<?php endif ?>
			</article>
		</div>
	</section>

<?php endif ?>