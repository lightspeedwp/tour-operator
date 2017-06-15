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
 * Outputs the connected accommodation only on a "region"
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_region_accommodation(){
	global $lsx_to_archive;
	if(post_type_exists('accommodation') && is_singular('destination') && !lsx_to_item_has_children(get_the_ID(),'destination')) {
		$args = array(
			'from'			=>	'accommodation',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="accommodation"><h2 class="section-title">'.__(lsx_to_get_post_type_section_title('accommodation', '', esc_html__('Featured Accommodation','tour-operator')),'tour-operator').'</h2>',
			'after'			=>	'</section>'
		);
		lsx_to_connected_panel_query($args);
	}
}
/**
 * Outputs the child destinations
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_country_regions(){
	global $lsx_to_archive,$wp_query;
	if(is_singular('destination') && lsx_to_item_has_children(get_the_ID(),'destination')) {
		$region_args = array(
			'post_type'	=>	'destination',
			'post_status' => 'publish',
			'nopagin' => true,
			'posts_per_page' => '-1',
			'post_parent' => get_the_ID(),
			'orderby' => 'name',
			'order' => 'ASC'
		);
		$regions = new WP_Query($region_args);
		$region_counter = 0;
		$total_counter = 0;
		if ( $regions->have_posts() ): ?>
			<section id="regions">
				<h2 class="section-title"><?php esc_html_e(lsx_to_get_post_type_section_title('destination', 'regions', 'Regions'),'tour-operator'); ?></h2>
				<div class="row">
					<?php
						$lsx_to_archive = 1;
						$wp_query->is_single = 0;
						$wp_query->is_singular = 0;
						$wp_query->is_post_type_archive = 1;
					?>
					<?php while ( $regions->have_posts() ) : $regions->the_post(); ?>
						<div class="panel col-sm-12">
							<?php lsx_to_content('content','destination'); ?>
						</div>
					<?php endwhile; // end of the loop. ?>
					<?php
						$lsx_to_archive = 0;
						$wp_query->is_single = 1;
						$wp_query->is_singular = 1;
						$wp_query->is_post_type_archive = 0;
					?>
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
function lsx_to_destination_tours(){
	global $lsx_to_archive,$wp_query;
	if(post_type_exists('tour') && is_singular('destination')){
		$args = array(
			'from'			=>	'tour',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="tours"><h2 class="section-title">'.__(lsx_to_get_post_type_section_title('tour', '', esc_html__('Featured Tours','tour-operator')),'tour-operator').'</h2>',
			'after'			=>	'</section>'
		);
		lsx_to_connected_panel_query($args);
	}
}

/**
 * Outputs the destinations attached activites
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_to_destination_activities(){
	global $lsx_to_archive;
	if(post_type_exists('activity') && is_singular('destination') && !lsx_to_item_has_children(get_the_ID(),'destination')){
		$args = array(
			'from'			=>	'activity',
			'to'			=>	'destination',
			'content_part'	=>	'widget-activity',
			'column'		=>	'4',
			'before'		=>	'<section id="activities"><h2 class="section-title">'.__(lsx_to_get_post_type_section_title('activity', '', esc_html__('Featured Activities','tour-operator')),'tour-operator').'</h2>',
			'after'			=>	'</section>',
		);
		lsx_to_connected_panel_query($args);
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
	$electricity = get_post_meta( get_the_ID(), 'electricity', true );
	$banking     = get_post_meta( get_the_ID(), 'banking', true );
	$cuisine     = get_post_meta( get_the_ID(), 'cuisine', true );
	$climate     = get_post_meta( get_the_ID(), 'climate', true );
	$transport   = get_post_meta( get_the_ID(), 'transport', true );
	$dress       = get_post_meta( get_the_ID(), 'dress', true );
	$health       = get_post_meta( get_the_ID(), 'health', true );
	$safety      = get_post_meta( get_the_ID(), 'safety', true );
	$visa      = get_post_meta( get_the_ID(), 'visa', true );
	$general       = get_post_meta( get_the_ID(), 'additional_info', true );


	if ( ! empty( $electricity ) || ! empty( $banking ) || ! empty( $cuisine ) || ! empty( $climate ) || ! empty( $transport ) || ! empty( $dress ) || ! empty( $health ) || ! empty( $safety ) || ! empty( $visa ) || ! empty( $general ) ) :
		$limit_words = 30;
		$more_button = "\n\n" . '<a class="btn btn-default more-link more-link-remove-p" data-collapsed="true" href="#">Read More</a>' . "\n\n";

		$items = array(
			esc_html__( 'Electricity', 'tour-operator' ) => $electricity,
			esc_html__( 'Banking', 'tour-operator' )     => $banking,
			esc_html__( 'Cuisine', 'tour-operator' )     => $cuisine,
			esc_html__( 'Climate', 'tour-operator' )     => $climate,
			esc_html__( 'Transport', 'tour-operator' )   => $transport,
			esc_html__( 'Dress', 'tour-operator' )       => $dress,
			esc_html__( 'Health', 'tour-operator' )       => $health,
			esc_html__( 'Safety', 'tour-operator' )       => $safety,
			esc_html__( 'Visa', 'tour-operator' )       => $visa,
			esc_html__( 'General', 'tour-operator' )       => $general,
		);
		?>
		<section id="travel-info">
			<h2 class="section-title"><?php esc_html_e( 'Travel Information', 'tour-operator' ); ?></h2>
			<div class="travel-info-content row">
				<?php foreach ( $items as $key => $value ) : ?>
					<?php if ( ! empty( $value ) ) : ?>
						<div class="panel col-sm-6">
							<article class="unit type-unit">
								<div class="col-sm-12">
									<div class="unit-info">
										<h3><?php echo esc_html( $key ); ?></h3>
										<div class="entry-content"><?php
											if ( str_word_count( $value, 0 ) > $limit_words ) {
												$words = str_word_count( $value, 2 );
												$pos   = array_keys( $words );
												$value = substr_replace( $value, $more_button, $pos[ $limit_words ], 0 );
											}
											echo wp_kses_post( apply_filters( 'the_content', $value ) );
										?></div>
									</div>
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
function lsx_to_connected_destinations($before="",$after="",$echo=true){
	lsx_to_connected_items_query('destination',get_post_type(),$before,$after,$echo);
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
function lsx_to_connected_countries($before="",$after="",$echo=true){
	lsx_to_connected_items_query('destination',get_post_type(),$before,$after,$echo,true);
}
