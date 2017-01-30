<?php
/**
 * Accommodation Brand Taxonomy Content Part
 * 
 * @package 	tour-operator
 * @category	accommodation-brand
 */
?>

<?php
	$description = term_description();
	if ( ! empty( $description ) ) :
?>

	<section id="summary">
		<div class="row">
			<article class="hentry taxonomy-description">
				<div class="<?php echo lsx_to_has_enquiry_contact() ? 'col-sm-9' : 'col-sm-12' ?> entry-content">
					<?php echo wp_kses_post( $description ); ?>
				</div>

				<?php if ( lsx_to_has_enquiry_contact() ) : ?>
					<div class="col-sm-3">
						<div class="team-member-widget">
							<?php
								if ( function_exists( 'lsx_to_has_team_member' ) && lsx_to_has_team_member() ) {
									lsx_to_team_member_panel( '<div class="team-member">', '</div>' );
								} else {
									lsx_to_enquiry_contact( '<div class="team-member">', '</div>' );
								}

								lsx_to_enquire_modal();
							?>
						</div>
					</div>
				<?php endif ?>
			</article>
		</div>
	</section>

<?php endif ?>