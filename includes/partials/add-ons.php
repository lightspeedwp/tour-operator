<?php
	$lsx_to_documentation = esc_url( 'https://tour-operator.lsdev.biz/documentation/' );
	$extensions_link      = esc_url( 'https://tour-operator.lsdev.biz/features/' );

	$to_essentials_bundle_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-essentials-bundle/' );
	$to_complete_bundle_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-complete-bundle/' );
	$tour_operator_link = esc_url( 'https://wordpress.org/plugins/tour-operator/' );
	$team_link          = esc_url( 'https://wordpress.org/plugins/tour-operator-team/' );
	$activities_link    = esc_url( 'https://wordpress.org/plugins/tour-operator-activities/' );
	$reviews_link       = esc_url( 'https://wordpress.org/plugins/tour-operator-reviews/' );
	$specials_link      = esc_url( 'https://wordpress.org/plugins/tour-operator-special-offers/' );
	$search_link        = esc_url( 'https://wordpress.org/plugins/tour-operator-search/' );
	$vehicles_link      = esc_url( 'https://wordpress.org/plugins/tour-operator-vehicles/' );
	$wetu_importer_link = esc_url( 'https://wordpress.org/plugins/lsx-importer-for-wetu/' );
?>

<div class="wrap about-wrap">
	<div class="row">
		<div class="col-md-12">
			<h1 class="small" style="margin-bottom: 13px;"><?php esc_html_e( 'Tour Operator Add-ons', 'tour-operator' ); ?></h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<a href="<?php echo wp_kses_post( $tour_operator_link ); ?>" target="_blank" title="<?php esc_html_e( 'Tour Operator Add-ons', 'tour-operator' ); ?>">
				<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-banner.png' ); ?>" alt="<?php esc_html_e( 'Tour Operator Add-ons', 'tour-operator' ); ?>">
			</a>

			<div class="box box-top-image enhance">
				<h2><?php esc_html_e( 'Enhance Tour Operator', 'tour-operator' ); ?></h2>
				<p><?php esc_html_e( 'Extend the functionality of the Tour Operator plugin with one of our many extensions!', 'tour-operator' ); ?></p>

				<!--<div class="more-button">
					<a href="<?php echo wp_kses_post( $extensions_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'View all extensions', 'tour-operator' ); ?>
					</a>
				</div>-->
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-3">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-specials.png' ); ?>">

			<div class="box box-top-image specials">
				<h3><?php esc_html_e( 'Specials', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'With the Special Offers extension you’re able to set up time-sensitive prices that you can use to price your accommodations, activities and tours. Set up booking validity dates, specials per person sharing/per person sharing/per person sharing per night, team members per special and more.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $specials_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-reviews.png' ); ?>">

			<div class="box box-top-image reviews">
				<h3><?php esc_html_e( 'Reviews', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'People want to be sure that they’re making the right choice with the the right company. Your “trustability” will set you apart from the herd. The Tour Operators Reviews extension allows you to add reviews written by your previous guests and display them across your site.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $reviews_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-team.png' ); ?>">

			<div class="box box-top-image team">
				<h3><?php esc_html_e( 'Team', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'Real peoples\' faces go a long way to building trust with your valued clients. The Tour Operator: Team extension allows your company\'s staff to be added as Team Members with their own profile which can be associated with specific destinations and tours.', 'tour-operator' ); ?></p>
				<br>
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $team_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-search.png' ); ?>">

			<div class="box box-top-image search">
				<h3><?php esc_html_e( 'Search', 'tour-operator' ); ?></h3>
				<p><?php esc_html_e( 'The Search extension for the Tour Operators plugin adds robust search functionality to your WordPress Tour Operator site. It requires that you also have the FacetWP plugin installed, as that allows for much of the filtering functionality that the plugin provides.', 'tour-operator' ); ?></p>
				<br>
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $search_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
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
				</div>
			</div>
		</div>
	</div>
</div>
