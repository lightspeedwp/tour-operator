<?php
	$to_documentation = esc_url('https://www.lsdev.biz/documentation/tour-operator-plugin/');
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
	$video_link = esc_url('https://www.lsdev.biz/product/tour-operator-videos/');
	$wetu_importer_link = esc_url('https://www.lsdev.biz/product/wetu-importer/');
?>

<div class="wrap about-wrap">
	<div class="row">
		<div class="col-md-12">
			<h1 class="small"><?php esc_html_e( 'Tour Operator Add-ons', 'tour-operator' ); ?></h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="thumbnail">
				<a href="<?php echo wp_kses_post( $tour_operator_link ); ?>" target="_blank" title="<?php esc_html_e( 'Tour Operator Add-ons', 'tour-operator' ); ?>">
					<img src="https://placeholdit.imgix.net/~text?txtsize=33&amp;txt=&amp;w=1920&amp;h=400&amp;bg=408AC9&amp;txtcolor=dddddd&amp;txt=Tour+Operator" alt="<?php esc_html_e( 'Tour Operator Add-ons', 'tour-operator' ); ?>">
				</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box enhance">
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
		<div class="col-md-4">
			<div class="box maps">
				<h3><?php esc_html_e( 'Maps', 'tour-operator' ); ?> - <span class="price">$79.00</span></h3>
				<p><?php esc_html_e( 'The Maps extension gives you the ability to connect maps with location-marking pins to your Accommodation, Destination and Tour pages. You can also display maps with clusters of markers, to display the set of Accommodations in each Destination. Use the extension to show a mapped out trip itinerary that connects the dots of the accommodations you stay in on your tours. Maps will also integrate with the Activities post type, if you have that extension installed.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $map_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="box specials">
				<h3><?php esc_html_e( 'Specials', 'tour-operator' ); ?> - <span class="price">$29.00</span></h3>
				<p><?php esc_html_e( 'With the Special Offers extension you’re able to set up time-sensitive prices that you can use to price your accommodations, activities and tours. Set up booking validity dates, specials per person sharing/per person sharing/per person sharing per night, team members per special and more.', 'tour-operator' ); ?></p>
			
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $specials_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="box reviews">
				<h3><?php esc_html_e( 'Reviews', 'tour-operator' ); ?> - <span class="price">$29.00</span></h3>
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
			<div class="box activities">
				<h3><?php esc_html_e( 'Activities', 'tour-operator' ); ?> - <span class="price">$29.00</span></h3>
				<p><?php esc_html_e( 'Get your visitors excited about what they’ll be doing when they travel with you, whether it’s river rafting, whale watching or sandboarding - use the Activities post type with beautiful imagery and well-crafted copy and then set the activities as connected to particular tours, destinations and accommodations.', 'tour-operator' ); ?></p>
			
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $activities_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="box search">
				<h3><?php esc_html_e( 'Search', 'tour-operator' ); ?> - <span class="price">$79.00</span></h3>
				<p><?php esc_html_e( 'The Search extension for the Tour Operators plugin adds robust search functionality to your WordPress Tour Operator site. It requires that you also have the FacetWP plugin installed, as that allows for much of the filtering functionality that the plugin provides.', 'tour-operator' ); ?></p>
			
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $search_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="box galleries">
				<h3><?php esc_html_e( 'Galleries', 'tour-operator' ); ?> - <span class="price">$19.00</span></h3>
				<p><?php esc_html_e( 'If you have the gallery extension installed you can easily include photo galleries in your Accommodation, Destination and Tour pages, as well as other post types included in our various extensions, such as vehicles and activities. The galleries are built via meta boxes that are added to Tour Operator type posts. ', 'tour-operator' ); ?></p>
				
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $galleries_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="box vehicles">
				<h3><?php esc_html_e( 'Vehicles', 'tour-operator' ); ?> - <span class="price">$29.00</span></h3>
				<p><?php esc_html_e( 'To help convince travelers of their comfort and safety when traveling with you, we’ve created the Vehicles extension so that you can fill in your fleets’ specs with details such as type and number of gears, engine type (petrol/diesel), number of seats, vehicle code, and of course images and copy.', 'tour-operator' ); ?></p>
				
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $vehicles_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="box team">
				<h3><?php esc_html_e( 'Team', 'tour-operator' ); ?> - <span class="price">$29.00</span></h3>
				<p><?php esc_html_e( 'Real peoples\' faces go a long way to building trust with your clients. The Team Extension allows your business\'s staff to be added as Team Members with their own profile which can be associated with specific destinations and tours.', 'tour-operator' ); ?></p>
				
				<div class="more-button">
					<a href="<?php echo wp_kses_post( $team_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box video">
				<h3><?php esc_html_e( 'Videos', 'tour-operator' ); ?> - <span class="price">$19.00</span></h3>
				<p><?php esc_html_e( 'With the Videos extension installed you’re able to display videos on all of your Tour Operator related post types. Whether you want to show a walk-through video of an accommodation or a highlights reel of a tour or destination, the videos extension takes care of all your video needs.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $video_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="box wetu">
				<h3><?php esc_html_e( 'Wetu Importer', 'tour-operator' ); ?> - <span class="price">$129.00</span></h3>
				<p><?php esc_html_e( 'Quickly and easily import accommodation data as well as entire tour itineraries and associated images from the WETU database to use in your day-by-day tour listings.', 'tour-operator' ); ?></p>

				<div class="more-button">
					<a href="<?php echo wp_kses_post( $wetu_importer_link ); ?>" target="_blank" class="button button-primary">
						<?php esc_html_e( 'Get this extension', 'tour-operator' ); ?>
					</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>
