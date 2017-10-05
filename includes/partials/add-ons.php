<?php
	$lsx_to_documentation = esc_url( 'https://www.lsdev.biz/documentation/tour-operator-plugin/' );
	$extensions_link = esc_url( 'https://www.lsdev.biz/product-category/tour-operator-extensions/' );

	$to_essentials_bundle_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-essentials-bundle/' );
	$to_complete_bundle_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-complete-bundle/' );
	$tour_operator_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-plugin/' );
	$map_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-maps/' );
	$team_link = esc_url( 'https://www.lsdev.biz/product/tour-operators-team/' );
	$reviews_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-reviews/' );
	$specials_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-specials/' );
	$search_link = esc_url( 'https://www.lsdev.biz/product/tour-operators-search/' );
	$video_link = esc_url( 'https://www.lsdev.biz/product/tour-operator-videos/' );
	$wetu_importer_link = esc_url( 'https://www.lsdev.biz/product/wetu-importer/' );
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
		<div class="col-md-6">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-essentials.png' ); ?>">

			<div class="box box-top-image maps">
				<h3><?php esc_html_e( 'Tour Operator Essentials Bundle', 'tour-operator' ); ?> - <span class="price">from $99.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'The Tour Operator Essentials Bundle comes with a select few extensions for LSX theme and the Tour Operator plug in, allowing you to expand the look, feel and functionality of your website.', 'tour-operator' ); ?></p>
				<p><?php echo wp_kses_post( 'Included in this bundle:<br>LSX Extensions: Sharing and Banners.<br>Tour Operator Extensions: Reviews, Team and Videos.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $to_essentials_bundle_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get the bundle', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-complete.png' ); ?>">

			<div class="box box-top-image specials">
				<h3><?php esc_html_e( 'Tour Operator Complete Bundle', 'tour-operator' ); ?> - <span class="price">from $249.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'The Complete bundle gives you complete control of your LSX-powered Tour Operator website. Expand LSX with the Sharing, Banners, Currencies, Customizer, Mega Menus and Blog Customizer extensions. Expand the Tour Operator plugin with the Reviews, Team, Videos, Specials, Maps and Search extensions.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $to_complete_bundle_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get the bundle', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-maps.png' ); ?>">

			<div class="box box-top-image maps">
				<h3><?php esc_html_e( 'Maps', 'tour-operator' ); ?> - <span class="price">from $79.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'Connect maps with location-marking pins to your Accommodation, Destination and Tour pages. Display maps with clusters of markers to display the set of Accommodations in each Destination. Show a mapped out trip itinerary that connects the dots of the accommodations visited in a tour package.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $map_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-specials.png' ); ?>">

			<div class="box box-top-image specials">
				<h3><?php esc_html_e( 'Specials', 'tour-operator' ); ?> - <span class="price">from $29.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'With the Special Offers extension you’re able to set up time-sensitive prices that you can use to price your accommodations, activities and tours. Set up booking validity dates, specials per person sharing/per person sharing/per person sharing per night, team members per special and more.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $specials_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-reviews.png' ); ?>">

			<div class="box box-top-image reviews">
				<h3><?php esc_html_e( 'Reviews', 'tour-operator' ); ?> - <span class="price">from $29.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'People want to be sure that they’re making the right choice with the the right company. Your “trustability” will set you apart from the herd. The Tour Operators Reviews extension allows you to add reviews written by your previous guests and display them across your site.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $reviews_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-team.png' ); ?>">

			<div class="box box-top-image team">
				<h3><?php esc_html_e( 'Team', 'tour-operator' ); ?> - <span class="price">from $29.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'Real peoples\' faces go a long way to building trust with your valued clients. The Tour Operator: Team extension allows your company\'s staff to be added as Team Members with their own profile which can be associated with specific destinations and tours.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $team_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-videos.png' ); ?>">

			<div class="box box-top-image videos">
				<h3><?php esc_html_e( 'Videos', 'tour-operator' ); ?> - <span class="price">from $19.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'With the Videos extension installed you’re able to display videos on all of your Tour Operator related post types. Whether you want to show a walk-through video of an accommodation or a highlights reel of a tour or destination, the videos extension takes care of all your video needs.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $video_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<img src="<?php echo esc_url( LSX_TO_URL . 'assets/img/tour-operators-search.png' ); ?>">

			<div class="box box-top-image search">
				<h3><?php esc_html_e( 'Search', 'tour-operator' ); ?> - <span class="price">from $79.00 per yearly license</span></h3>
				<p><?php esc_html_e( 'The Search extension for the Tour Operators plugin adds robust search functionality to your WordPress Tour Operator site. It requires that you also have the FacetWP plugin installed, as that allows for much of the filtering functionality that the plugin provides.', 'tour-operator' ); ?></p>

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
				<h3><?php esc_html_e( 'Wetu Importer', 'tour-operator' ); ?> - <span class="price">from $129.00 per yearly license</span></h3>
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
