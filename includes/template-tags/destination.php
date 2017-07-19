<?php
/**
 * Template Tags
 *
 * @package   		tour-operator
 * @subpackage 		template-tags
 * @category 		destination
 * @license   		GPL3
 */

/**
 * Outputs the posts attached destinations
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_destination_posts() {
	global $lsx_to_archive;

	$args = array(
		'from'		=> 'post',
		'to'		=> 'destination',
		'column'	=> '3',
		'before'	=> '<section id="posts" class="lsx-to-section"><h2 class="lsx-to-section-title lsx-title">' . esc_html__( 'Featured Posts', 'tour-operator' ) . '</h2>',
		'after'		=> '</section>',
	);

	lsx_to_connected_panel_query( $args );
}

/**
 * Outputs the connected accommodation only on a "region"
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_region_accommodation() {
	global $lsx_to_archive;

	if ( post_type_exists( 'accommodation' ) && is_singular( 'destination' ) && ! lsx_to_item_has_children( get_the_ID(), 'destination' ) ) {
		$args = array(
			'from'		=> 'accommodation',
			'to'		=> 'destination',
			'column'	=> '3',
			'before'	=> '<section id="accommodation" class="lsx-to-section"><h2 class="lsx-to-section-title lsx-title">' . __( lsx_to_get_post_type_section_title( 'accommodation', '', esc_html__( 'Featured Accommodation', 'tour-operator' ) ), 'tour-operator' ) . '</h2>',
			'after'		=> '</section>',
		);

		lsx_to_connected_panel_query( $args );
	}
}

/**
 * Outputs the child destinations
 *
 * @param $args array
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_country_regions( $args = array() ) {
	global $lsx_to_archive, $wp_query;

	$defaults = array(
		'slider'  => true,
		'parent'  => get_the_ID(),
		'title'   => lsx_to_get_post_type_section_title( 'destination', 'regions', 'Regions' ),
		'exclude' => false,
	);

	$settings = wp_parse_args( $args, $defaults );

	if ( is_singular( 'destination' ) && ( lsx_to_item_has_children( get_the_ID(), 'destination' ) || isset( $args['parent'] ) ) ) {

		$region_args = array(
			'post_type'	=> 'destination',
			'post_status' => 'publish',
			'nopagin' => true,
			'posts_per_page' => '-1',
			'post_parent' => $settings['parent'],
			'orderby' => 'name',
			'order' => 'ASC',
		);

		if ( false !== $settings['exclude'] ) {
			$region_args['post__not_in'] = array( $settings['exclude'] );
		}

		$regions = new WP_Query( $region_args );
		$region_counter = 0;
		$total_counter = 0;

		if ( $regions->have_posts() ) : ?>
			<section id="regions" class="lsx-to-section">
				<h2 class="lsx-to-section-title lsx-title"><?php esc_html( $settings['title'] ); ?></h2>

				<div class="slider-container lsx-to-widget-items lsx-to-archive-template-grid">
					<div id="slider-<?php echo esc_attr( rand( 20, 20000 ) ); ?>" class="lsx-to-slider">
						<div class="lsx-to-slider-wrap">
							<div class="lsx-to-slider-inner <?php if ( false === $settings['slider'] ) { esc_attr( 'slider-disabled' ); } ?>" data-interval="6000" data-slick='{ "slidesToShow": 3, "slidesToScroll": 3 }'>

							<?php
								$lsx_to_archive = 1;
								$wp_query->is_single = 0;
								$wp_query->is_singular = 0;
								$wp_query->is_post_type_archive = 1;

								while ( $regions->have_posts() ) {
									$regions->the_post();

									echo '<div class="lsx-to-widget-item-wrap lsx-regions">';
									lsx_to_content( 'content-widget', 'destination' );
									echo '</div>';
								}

								$lsx_to_archive = 0;
								$wp_query->is_single = 1;
								$wp_query->is_singular = 1;
								$wp_query->is_post_type_archive = 0;
							?>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php
			wp_reset_postdata();
		endif;
	}
}

/**
 * Outputs the destinations attached tours
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_destination_tours() {
	global $lsx_to_archive, $wp_query;

	if ( post_type_exists( 'tour' ) && is_singular( 'destination' ) ) {
		$args = array(
			'from'		=> 'tour',
			'to'		=> 'destination',
			'column'	=> '3',
			'before'	=> '<section id="tours" class="lsx-to-section"><h2 class="lsx-to-section-title lsx-title">' . __( lsx_to_get_post_type_section_title( 'tour', '', esc_html__( 'Featured Tours', 'tour-operator' ) ), 'tour-operator' ) . '</h2>',
			'after'		=> '</section>',
		);

		lsx_to_connected_panel_query( $args );
	}
}

/**
 * Outputs the destinations attached activites
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_destination_activities() {
	global $lsx_to_archive;

	if ( post_type_exists( 'activity' ) && is_singular( 'destination' ) && ! lsx_to_item_has_children( get_the_ID(), 'destination' ) ) {
		$args = array(
			'from'			=> 'activity',
			'to'			=> 'destination',
			// 'content_part'	=>	'widget-activity',
			'column'		=> '3',
			'before'		=> '<section id="activities" class="lsx-to-section"><h2 class="lsx-to-section-title lsx-title">' . __( lsx_to_get_post_type_section_title( 'activity', '', esc_html__( 'Featured Activities', 'tour-operator' ) ), 'tour-operator' ) . '</h2>',
			'after'			=> '</section>',
		);

		lsx_to_connected_panel_query( $args );
	}
}

/**
 * Outputs the destination travel info
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_destination_travel_info() {
	$electricity 	= get_post_meta( get_the_ID(), 'electricity', true );
	$banking     	= get_post_meta( get_the_ID(), 'banking', true );
	$cuisine     	= get_post_meta( get_the_ID(), 'cuisine', true );
	$climate     	= get_post_meta( get_the_ID(), 'climate', true );
	$transport   	= get_post_meta( get_the_ID(), 'transport', true );
	$dress       	= get_post_meta( get_the_ID(), 'dress', true );
	$health       	= get_post_meta( get_the_ID(), 'health', true );
	$safety      	= get_post_meta( get_the_ID(), 'safety', true );
	$visa      		= get_post_meta( get_the_ID(), 'visa', true );
	$general       	= get_post_meta( get_the_ID(), 'additional_info', true );

	if ( ! empty( $electricity ) || ! empty( $banking ) || ! empty( $cuisine ) || ! empty( $climate ) || ! empty( $transport ) || ! empty( $dress ) || ! empty( $health ) || ! empty( $safety ) || ! empty( $visa ) || ! empty( $general ) ) :
		$limit_words = 30;
		$more_button = "\n\n" . '<a class="more-link more-link-remove-p" data-collapsed="true" href="#">Read More</a>' . "\n\n";

		$items = array(
			esc_html__( 'Electricity', 'tour-operator' ) 	=> $electricity,
			esc_html__( 'Banking', 'tour-operator' )     	=> $banking,
			esc_html__( 'Cuisine', 'tour-operator' )     	=> $cuisine,
			esc_html__( 'Climate', 'tour-operator' )     	=> $climate,
			esc_html__( 'Transport', 'tour-operator' ) 		=> $transport,
			esc_html__( 'Dress', 'tour-operator' )       	=> $dress,
			esc_html__( 'Health', 'tour-operator' )       	=> $health,
			esc_html__( 'Safety', 'tour-operator' )       	=> $safety,
			esc_html__( 'Visa', 'tour-operator' )       	=> $visa,
			esc_html__( 'General', 'tour-operator' )       	=> $general,
		);
		?>
		<section id="travel-info" class="lsx-to-section">
			<h2 class="lsx-to-section-title lsx-title"><?php esc_html_e( 'Travel Information', 'tour-operator' ); ?></h2>

			<div class="travel-info-wrapper row">
				<?php foreach ( $items as $key => $value ) : ?>
					<?php if ( ! empty( $value ) ) : ?>
						<div class="col-xs-12 col-sm-6">
							<article class="travel-info-content">
								<h3><?php echo esc_html( $key ); ?></h3>

								<div class="travel-info-entry-content hidden">
									<?php echo wp_kses_post( apply_filters( 'the_content', $value ) ); ?>
								</div>

								<div class="travel-info-entry-content">
									<?php
										if ( str_word_count( $value, 0 ) > $limit_words ) {
										$tokens       = array();
										$value_output = '';
										$has_more     = false;
										$count        = 0;

										preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $value, $tokens );

										foreach ( $tokens[0] as $token ) {
											if ( $count >= $limit_words ) {
												$value_output .= trim( $token );
												$has_more = true;
												break;
												}

											$count++;
											$value_output .= $token;
											}

										$value = trim( force_balance_tags( $value_output . '...' . $more_button ) );
										}

										echo wp_kses_post( apply_filters( 'the_content', $value ) );
									?>
								</div>
							</article>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	endif;
}

/**
 * Gets the current specials connected destinations
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @param       $parents| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_to_connected_destinations( $before = '', $after = '', $echo = true ) {
	lsx_to_connected_items_query( 'destination', get_post_type(), $before, $after, $echo );
}

/**
 * Gets the current connected countries
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @param       $parents| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_to_connected_countries( $before = '', $after = '', $echo = true ) {
	lsx_to_connected_items_query( 'destination', get_post_type(), $before, $after, $echo, true );
}
