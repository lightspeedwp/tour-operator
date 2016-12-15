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
	global $to_archive;
	if(post_type_exists('accommodation') && is_singular('destination') && !to_item_has_children(get_the_ID(),'destination')) { 
		$args = array(
			'from'			=>	'accommodation',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="accommodation"><h2 class="section-title">'.__(to_get_post_type_section_title('accommodation', '', esc_html__('Featured Accommodation','tour-operator')),'tour-operator').'</h2>',
			'after'			=>	'</section>'
		);
		to_connected_panel_query($args);
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
	global $to_archive,$wp_query;
	if(is_singular('destination') && to_item_has_children(get_the_ID(),'destination')) {
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
				<h2 class="section-title"><?php esc_html_e(to_get_post_type_section_title('destination', 'regions', 'Regions'),'tour-operator'); ?></h2>		
				<div class="row">		
					<?php $to_archive = 1; $wp_query->is_single = 0;$wp_query->is_singular = 0;$wp_query->is_post_type_archive = 1;?>
					<?php while ( $regions->have_posts() ) : $regions->the_post(); ?>
						<div class="panel col-sm-12">
							<?php to_content('content','destination'); ?>
						</div>
					<?php endwhile; // end of the loop. ?>
					<?php $to_archive = 0; $wp_query->is_single = 1;$wp_query->is_singular = 1;$wp_query->is_post_type_archive = 0;?>
				</div>
			</section>		
			<?php
			wp_reset_query();
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
	global $to_archive,$wp_query;
	if(post_type_exists('tour') && is_singular('destination')){
		$args = array(
			'from'			=>	'tour',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="tours"><h2 class="section-title">'.__(to_get_post_type_section_title('tour', '', esc_html__('Featured Tours','tour-operator')),'tour-operator').'</h2>',
			'after'			=>	'</section>'
		);
		to_connected_panel_query($args);
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
	global $to_archive;
	if(post_type_exists('activity') && is_singular('destination') && !to_item_has_children(get_the_ID(),'destination')){
		$args = array(
			'from'			=>	'activity',
			'to'			=>	'destination',
			'content_part'	=>	'widget-activity',
			'column'		=>	'4',				
			'before'		=>	'<section id="activities"><h2 class="section-title">'.__(to_get_post_type_section_title('activity', '', esc_html__('Featured Activities','tour-operator')),'tour-operator').'</h2>',
			'after'			=>	'</section>',
		);
		to_connected_panel_query($args);
	}
}

/**
 * Gets the current specials connected destinations
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_to_connected_destinations($before="",$after="",$echo=true){
	to_connected_items_query('destination',get_post_type(),$before,$after,$echo);
}