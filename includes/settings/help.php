<?php
	$lsx_to_documentation = esc_url('https://www.lsdev.biz/documentation/tour-operator-plugin/');
	$extensions_link = esc_url('https://www.lsdev.biz/product-category/tour-operator-extensions/');

	//Product Urls
	$tour_operator_link = esc_url('https://www.lsdev.biz/product/tour-operator-plugin/');
	$map_link = esc_url('https://www.lsdev.biz/product/tour-operator-maps/');
	$galleries_link = esc_url('https://www.lsdev.biz/product/tour-operator-galleries/');
	$team_link = esc_url('https://www.lsdev.biz/product/tour-operators-team/');
	$activities_link = esc_url('https://www.lsdev.biz/product/tour-operators-activities/');
	$reviews_link = esc_url('https://www.lsdev.biz/product/tour-operator-reviews/');
	$specials_link = esc_url('https://www.lsdev.biz/product/tour-operator-specials/');
	$search_link = esc_url('https://www.lsdev.biz/product/tour-operators-search/');
	$vehicles_link = esc_url('https://www.lsdev.biz/product/tour-operator-vehicles/');
	$videos_link = esc_url('https://www.lsdev.biz/product/tour-operator-videos/');
	$wetu_importer_link = esc_url('https://www.lsdev.biz/product/wetu-importer/');

	//Documentation
	$map_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-maps/');
	$galleries_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-galleries/');
	$team_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-team/');
	$activities_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-activities/');
	$reviews_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-reviews/');
	$specials_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-specials/');
	$search_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operators-search/');
	$vehicles_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-vehicles/');
	$wetu_importer_link_doc = esc_url('https://www.lsdev.biz/documentation/wetu-importer/');
	$videos_link_doc = esc_url('https://www.lsdev.biz/documentation/tour-operator-videos/');
?>

<div class="wrap about-wrap">
	<div class="row">
		<div class="col-md-12 top-header">
			<h1 class="small"><?php esc_html_e( 'LightSpeed’s Tour Operator Plugin', 'tour-operator' ); ?></h1>
			<p><?php esc_html_e( 'Thank you for using the Tour Operator plugin. All of us here at LightSpeed appreciate your ongoing support and we can\'t wait to see what people create with the plugin. We\'re committed to ensuring you have all the help you need to make the most of the plugin.', 'tour-operator' ); ?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="box support">
						<h2><?php esc_html_e( 'Getting Support', 'tour-operator' ); ?></h2>
						<p><?php esc_html_e( 'Our website\'s','tour-operator' ); ?> <a href="<?php echo wp_kses_post($lsx_to_documentation); ?>" target="_blank"><?php esc_html_e( 'documentation','tour-operator' ); ?></a> <?php esc_html_e( 'page is a great place to start to learn how to configure and customize our plugin and its extensions. Here are some links to some of the key settings and modules:', 'tour-operator' ); ?></p>
						
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
							<li><a href="<?php echo wp_kses_post($map_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Maps:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Integrate Google Map embeds into your site to specify the location of Destinations, Accommodations and points of Tours.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($galleries_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Galleries:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Configure the way galleries display on singles and archives.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($team_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Team:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Configure the Team extension to show off the people who make your Tour offerings possible.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($activities_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Activities:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Create and configure your Activity listings which can then be set to display on Destinations, Accommodations and Tours.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($reviews_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Reviews:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Gather reviews from your past clients and use this extension to display them proudly throughout your website. Associate the reviews with specific Accommodations and Tours to have them display on specific pages.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($specials_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Specials:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Use the Specials module to specify time-sensitive special prices for your tour packages.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($search_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Search:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Learn how to make the best use of the Search extension, which depends on the Facet WP extension and allows you to provide filterable search fields on your Tour Operator website.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($vehicles_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Vehicles:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Specify your fleet\'s specifications with details such as type and number of gears, engine type (petrol/diesel), number of seats, vehicle code, and of course images and copy.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($videos_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Videos:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'With the Videos extension installed you’re able to display videos on all of your Tour Operator related post types.', 'tour-operator' ); ?></li>
							<li><a href="<?php echo wp_kses_post($wetu_importer_link_doc); ?>" target="_blank"><strong><?php esc_html_e( 'Wetu Importer:', 'tour-operator' ); ?></strong></a> <?php esc_html_e( 'Import accommodation data and entire tour itineraries from the WETU database to use in your day-by-day tour listings.', 'tour-operator' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="box info">
						<h2><?php esc_html_e( 'Tour Operator', 'tour-operator' ); ?></h2>

						<ul>
							<li><strong><?php esc_html_e( 'Latest Version:', 'tour-operator' ); ?></strong> <?php esc_html_e( '1.0', 'tour-operator' ); ?></li>
							<li><strong><?php esc_html_e( 'Requires:', 'tour-operator' ); ?></strong> <?php esc_html_e( 'WordPress 3.9+', 'tour-operator' ); ?></li>
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
						<p><?php esc_html_e( 'Please view our support policy', 'tour-operator' ); ?> <a href="https://www.lsdev.biz/plugin-support-policy/" target="_blank"><?php esc_html_e( 'here.', 'tour-operator' ); ?></a></p>
						<p><?php esc_html_e( 'You can contact us for support at', 'tour-operator' ); ?> <a href="mailto:<?php echo esc_url('support@lsdev.biz');?> "><?php esc_html_e( 'support@lsdev.biz.', 'tour-operator' ); ?></a></p>
						<p><?php esc_html_e( 'Support from the LightSpeed Team is only provided to user who have purchased one of our', 'tour-operator' ); ?> <strong><?php esc_html_e( 'Premium Add-ons', 'tour-operator' ); ?></strong></p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="box premium">
						<h3><?php esc_html_e( 'Premium Add-Ons', 'tour-operator' ); ?></h3>
						
						<ul>
							<li><a href="<?php echo wp_kses_post($map_link);?>" target="_blank"><?php esc_html_e( 'Maps', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($galleries_link);?>" target="_blank"><?php esc_html_e( 'Galleries', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($team_link);?>" target="_blank"><?php esc_html_e( 'Team', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($activities_link);?>" target="_blank"><?php esc_html_e( 'Activities', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($reviews_link);?>" target="_blank"><?php esc_html_e( 'Reviews', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($specials_link);?>" target="_blank"><?php esc_html_e( 'Specials', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($search_link);?>" target="_blank"><?php esc_html_e( 'Search', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($vehicles_link);?>" target="_blank"><?php esc_html_e( 'Vehicles', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($videos_link);?>" target="_blank"><?php esc_html_e( 'Videos', 'tour-operator' ); ?></a></li>
							<li><a href="<?php echo wp_kses_post($wetu_importer_link);?>" target="_blank"><?php esc_html_e( 'Wetu Importer', 'tour-operator' ); ?></a></li>
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
