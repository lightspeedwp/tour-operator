<?php
	$lsx_to_documentation = esc_url( 'https://tour-operator.lsdev.biz/documentation/' );
	$extensions_link      = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/' );
	$version              = esc_html( LSX_TO_VER );

	// Product Urls.
	$tour_operator_link = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/' );
	$team_link          = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/team/' );
	$activities_link    = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/activities/' );
	$reviews_link       = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/reviews/' );
	$specials_link      = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/specials/' );
	$search_link        = esc_url( 'https://www.lsdev.biz/lsx/extensions/search/' );
	$vehicles_link      = esc_url( 'https://www.lsdev.biz/lsx/extensions/tour-operator/vehicles/' );
	$wetu_importer_link = esc_url( 'https://www.lsdev.biz/lsx/extensions/wetu-importer/' );

	// Documentation.
	$team_link_doc          = esc_url( 'https://tour-operator.lsdev.biz/documentation/extension/team/' );
	$activities_link_doc    = esc_url( 'https://tour-operator.lsdev.biz/documentation/extension/activities/' );
	$reviews_link_doc       = esc_url( 'https://tour-operator.lsdev.biz/documentation/extension/reviews/' );
	$specials_link_doc      = esc_url( 'https://tour-operator.lsdev.biz/documentation/extension/specials/' );
	$search_link_doc        = esc_url( 'https://tour-operator.lsdev.biz/documentation/extension/search/' );
	$vehicles_link_doc      = esc_url( 'https://tour-operator.lsdev.biz/documentation/extension/tour-operator-vehicles/' );
	$wetu_importer_link_doc = esc_url( 'https://tour-operator.lsdev.biz/documentation/extension/wetu-importer/' );
?>

<div class="wrap about-wrap">
	<div class="row">
		<div class="col-md-12 top-header">
			<h1 class="small"><?php esc_html_e( 'LightSpeed’s LSX Tour Operator Plugin', 'tour-operator' ); ?></h1>
			<p><?php esc_html_e( 'Thank you for using the LSX Tour Operator plugin. All of us here at LightSpeed appreciate your ongoing support and we can\'t wait to see what people create with the plugin. We\'re committed to ensuring you have all the help you need to make the most of the plugin.', 'tour-operator' ); ?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="box support">
						<h2><?php esc_html_e( 'Getting Support', 'tour-operator' ); ?></h2>
						<p><?php esc_html_e( 'Our website\'s', 'tour-operator' ); ?> <a href="<?php echo wp_kses_post( $lsx_to_documentation ); ?>" target="_blank"><?php esc_html_e( 'documentation', 'tour-operator' ); ?></a> <?php esc_html_e( 'page is a great place to start to learn how to configure and customize our plugin and its extensions. Here are some links to some of the key settings and modules:', 'tour-operator' ); ?></p>

						<ul>
							<li><strong><?php esc_html_e( 'General settings:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Configure the general settings of the plugin as well as some settings per-module.', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Destinations:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Create and configure your Destination single posts and archives', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Accommodations:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Create and configure your Accommodation single posts and archives', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Tours:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'Create and configure your Tours single posts and archives', 'tour-operator' ); ?></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="box documentation">
						<h2 class="help-title"><?php esc_html_e( 'Documentation for Extensions', 'tour-operator' ); ?></h2>

						<ul>
							<li><a href="<?php echo wp_kses_post( $team_link_doc ); ?>" target="_blank"><strong><?php esc_html_e( 'Team:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Configure the Team extension to show off the people who make your Tour offerings possible.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post( $activities_link_doc ); ?>" target="_blank"><strong><?php esc_html_e( 'Activities:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Create and configure your Activity listings which can then be set to display on Destinations, Accommodations and Tours.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post( $reviews_link_doc ); ?>" target="_blank"><strong><?php esc_html_e( 'Reviews:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Gather reviews from your past clients and use this extension to display them proudly throughout your website. Associate the reviews with specific Accommodations and Tours to have them display on specific pages.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post( $specials_link_doc ); ?>" target="_blank"><strong><?php esc_html_e( 'Specials:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Use the Specials module to specify time-sensitive special prices for your tour packages.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post( $search_link_doc ); ?>" target="_blank"><strong><?php esc_html_e( 'Search:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Learn how to make the best use of the Search extension, which depends on the Facet WP extension and allows you to provide filterable search fields on your LSX Tour Operator website.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post( $vehicles_link_doc ); ?>" target="_blank"><strong><?php esc_html_e( 'Vehicles:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Specify your fleet\'s specifications with details such as type and number of gears, engine type (petrol/diesel), number of seats, vehicle code, and of course images and copy.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post( $wetu_importer_link_doc ); ?>" target="_blank"><strong><?php esc_html_e( 'Wetu Importer:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Import accommodation data and entire tour itineraries from the WETU database to use in your day-by-day tour listings.', 'tour-operator' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="box info">
						<h2><?php esc_html_e( 'LSX Tour Operator', 'tour-operator' ); ?></h2>

						<ul>
							<li><strong><?php esc_html_e( 'Latest Version:', 'tour-operator' ); ?></strong> <?php echo esc_attr( $version ); ?></li>
							<li><strong><?php esc_html_e( 'Requires:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'WordPress 5.0+', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Tested up to:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'WordPress 5.0', 'tour-operator' ); ?></li>
						</ul>

						<div class="more-button">
							<a href="<?php echo wp_kses_post( $tour_operator_link ); ?>" target="_blank" class="button button-primary">
								<?php esc_html_e( 'Visit plugin website', 'tour-operator' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="box news">
						<h3><?php esc_html_e( 'Support', 'tour-operator' ); ?></h3>
						<p><?php esc_html_e( 'If the documentation is not getting you where you need to be, you can contact us directly for support and assistance.', 'tour-operator' ); ?></p>
						<p><?php esc_html_e( 'You can contact us for support at', 'tour-operator' ); ?> <a href="mailto:support@lsdev.biz"><?php esc_html_e( 'support@lsdev.biz.', 'tour-operator' ); ?></a></p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="box premium">
						<h3><?php esc_html_e( 'LSX Tour Operator Add-Ons', 'tour-operator' ); ?></h3>

						<ul>
							<li><a href="<?php echo wp_kses_post( $team_link ); ?>" target="_blank"><?php esc_html_e( 'Team', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post( $activities_link ); ?>" target="_blank"><?php esc_html_e( 'Activities', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post( $reviews_link ); ?>" target="_blank"><?php esc_html_e( 'Reviews', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post( $specials_link ); ?>" target="_blank"><?php esc_html_e( 'Specials', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post( $search_link ); ?>" target="_blank"><?php esc_html_e( 'Search', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post( $vehicles_link ); ?>" target="_blank"><?php esc_html_e( 'Vehicles', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post( $wetu_importer_link ); ?>" target="_blank"><?php esc_html_e( 'Wetu Importer', 'tour-operator' ); ?></a></li>
						</ul>

						<div class="more-button">
							<a href="<?php echo wp_kses_post( $extensions_link ); ?>" target="_blank" class="button button-primary">
								<?php esc_html_e( 'View all extensions', 'tour-operator' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
