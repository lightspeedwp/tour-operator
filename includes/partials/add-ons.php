<?php
	// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
	$to_essentials_bundle_link = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$to_complete_bundle_link = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$tour_operator_link = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$team_link          = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$activities_link    = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$reviews_link       = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$specials_link      = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$search_link        = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$vehicles_link      = esc_url( 'https://lightspeedwp.agency/solutions/tour-operators/' );
	$wetu_importer_link = esc_url( 'https://touroperator.solutions/plugins/wetu-content-importer/' );

	// Documentation.
	$team_link_doc          = esc_url( 'https://touroperator.solutions/docs/team/' );
	$activities_link_doc    = esc_url( 'https://touroperator.solutions/docs/' );
	$reviews_link_doc       = esc_url( 'https://touroperator.solutions/docs/reviews/' );
	$specials_link_doc      = esc_url( 'https://touroperator.solutions/docs/specials/' );
	$search_link_doc        = esc_url( 'https://touroperator.solutions/docs/' );
	$vehicles_link_doc      = esc_url( 'https://touroperator.solutions/docs/' );
	$wetu_importer_link_doc = esc_url( 'https://touroperator.solutions/docs-category/wetu-content-importer/' );
?>

<div class="wrap about-wrap">
	<div class="row">

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-specials.png' ); ?>">

			<div class="box box-top-image specials">
				<h3><?php esc_html_e( 'Specials', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'With the Special Offers extension you’re able to set up time-sensitive prices that you can use to price your accommodations, activities and tours. Set up booking validity dates, specials per person sharing/per person sharing/per person sharing per night, team members per special and more.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $specials_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
					<a href="<?php echo wp_kses_post( $specials_link_doc ); ?>" target="_blank" class="button button-secondary">
						<?php esc_html_e( 'Documentation', 'tour-operator' ); ?>
					</a>
					<br clear="both" />
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-reviews.png' ); ?>">

			<div class="box box-top-image reviews">
				<h3><?php esc_html_e( 'Reviews', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'People want to be sure that they’re making the right choice with the the right company. Your “trustability” will set you apart from the herd. The Tour Operators Reviews extension allows you to add reviews written by your previous guests and display them across your site.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $reviews_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
					<a href="<?php echo wp_kses_post( $reviews_link_doc ); ?>" target="_blank" class="button button-secondary">
						<?php esc_html_e( 'Documentation', 'tour-operator' ); ?>
					</a>
					<br clear="both" />
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-team.png' ); ?>">

			<div class="box box-top-image team">
				<h3><?php esc_html_e( 'Team', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'Real peoples\' faces go a long way to building trust with your valued clients. The Tour Operator: Team extension allows your company\'s staff to be added as Team Members with their own profile which can be associated with specific destinations and tours.', 'tour-operator' ); ?></p>
				<br>
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $team_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
					<a href="<?php echo wp_kses_post( $teams_link_doc ); ?>" target="_blank" class="button button-secondary">
						<?php esc_html_e( 'Documentation', 'tour-operator' ); ?>
					</a>
					<br clear="both" />
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-search.png' ); ?>">

			<div class="box box-top-image search">
				<h3><?php esc_html_e( 'Search', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'The Search extension for the Tour Operators plugin adds robust search functionality to your WordPress Tour Operator site. It requires that you also have the FacetWP plugin installed, as that allows for much of the filtering functionality that the plugin provides.', 'tour-operator' ); ?></p>
				<br>
				<br>
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $search_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
					<a href="<?php echo wp_kses_post( $search_link_doc ); ?>" target="_blank" class="button button-secondary">
						<?php esc_html_e( 'Documentation', 'tour-operator' ); ?>
					</a>
					<br clear="both" />
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-vehicles.png' ); ?>">

			<div class="box box-top-image vehicles">
				<h3><?php esc_html_e( 'Vehicles', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'To help convince travellers of their comfort and safety when traveling with you, we’ve created the Vehicles extension. Fill in your fleets’ specs and display your vehicles on connected tours and destinations. With a range of available options such as; type and number of gears, engine type (petrol/diesel), number of seats, vehicle code, and of course images and copy.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $vehicles_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
					<a href="<?php echo wp_kses_post( $vehicles_link_doc ); ?>" target="_blank" class="button button-secondary">
						<?php esc_html_e( 'Documentation', 'tour-operator' ); ?>
					</a>
					<br clear="both" />
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-activities.png' ); ?>">

			<div class="box box-top-image activities">
				<h3><?php esc_html_e( 'Activities', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'Get your visitors excited about what they’ll be doing when they travel with you, whether it’s river rafting, whale watching or sandboarding – use the Activities post type with beautiful imagery and well-crafted copy and then set the activities as connected to particular tours, destinations and accommodations.', 'tour-operator' ); ?></p>
				<br>
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $activities_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
					<a href="<?php echo wp_kses_post( $activities_link_doc ); ?>" target="_blank" class="button button-secondary">
						<?php esc_html_e( 'Documentation', 'tour-operator' ); ?>
					</a>
					<br clear="both" />
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/wetu-importer-full-width.png' ); ?>">

			<div class="box box-top-image wetu">
				<h3><?php esc_html_e( 'Wetu Importer', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'Quickly and easily import accommodation data as well as entire tour itineraries and associated images from the WETU database to use in your day-by-day tour listings.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $wetu_importer_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
					<a href="<?php echo wp_kses_post( $wetu_importer_link_doc ); ?>" target="_blank" class="button button-secondary">
						<?php esc_html_e( 'Documentation', 'tour-operator' ); ?>
					</a>
					<br clear="both" />
				</div>
			</div>
		</div>
	</div>
</div>
