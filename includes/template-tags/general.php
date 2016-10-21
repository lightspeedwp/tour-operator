<?php
/**
 * Template Tags
 *
 * @package   Lsx_Tour_Operators
 * @license   GPL3
 */

/**
 * Checks if a caldera form with your slug exists
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	header
 */
function to_global_header() { ?>
	<header class="archive-header">
		<h1 class="archive-title">
			<?php 
				if(is_archive()){
					the_archive_title();
				}else{
					the_title();
				}?>
		</h1>
		<?php to_tagline('<p class="tagline">','</p>'); ?>
	</header><!-- .archive-header -->
<?php
}

/**
 * Banner Content
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	banner-content
 */
function to_banner_content() { 
	to_tagline('<p class="tagline">','</p>');
}

/**
 * Taglines
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	tagline
 */
function to_tagline($before='',$after='',$echo=false) {
	echo wp_kses_post( apply_filters('to_tagline','',$before,$after) );
}

/**
 * Archive Descriptions
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	description
 */
function to_archive_description() {
	echo wp_kses_post( apply_filters('to_archive_description','','<div class="row"><div class="col-sm-12"><article class="archive-description hentry">','</article></div></div>') );
}

/**
 * Checks if a caldera form with your slug exists
 *
 * @package 	tour-operator
 * @subpackage	setup
 * @category 	helper
 */
function to_content($slug, $name = null) {
	do_action('to_content',$slug, $name);
}

/**
 * outputs the sharing
 *
 * @package 	tour-operator
 * @subpackage	setup
 * @category 	helper
 */
function to_sharing() { 
	echo '<section id="sharing">';
	if ( function_exists( 'sharing_display' ) ) {
		sharing_display( '', true );
	}
	
	if ( class_exists( 'Jetpack_Likes' ) ) {
		$custom_likes = new Jetpack_Likes;
		echo wp_kses_post( $custom_likes->post_likes( '' ) );
	}
	echo '</section>';
}

/**
 * Checks if a caldera form with your slug exists
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function to_widget_class($return=false){
	global $columns;
	$md_col_width = 12 / $columns;

	if('1' == $columns){
		$class = 'single col-sm-12';
	}else{
		$class = 'panel col-sm-'.$md_col_width;
	}
	if(false === $return){
		echo 'class="'.esc_attr($class).'"';
	}else{
		return 'class="'.$class.'"';
	}
}

/**
 * Checks if the current post_type is disabled
 * 
 * @param		$post_type | string
 * @return		boolean
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function to_is_single_disabled($post_type=false){
	global $tour_operator;
	if(false === $post_type) {$post_type = get_post_type(); }
	if(is_object($tour_operator) && isset($tour_operator->options[$post_type]) && isset($tour_operator->options[$post_type]['disable_single'])){
		return true;
	}else{
		return false;
	}
}

/**
 * Return post_type section title (lsx settings)
 * 
 * @param		$post_type | string
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function to_get_post_type_section_title($post_type=false,$section='',$default=''){
	$section_title = (!empty($section)) ? ($section.'_section_title') : 'section_title';
	global $tour_operator;
	if(false === $post_type) {$post_type = get_post_type(); }
	if(is_object($tour_operator) && isset($tour_operator->options[$post_type]) && isset($tour_operator->options[$post_type][$section_title]) && !empty($tour_operator->options[$post_type][$section_title]) && '' !== $tour_operator->options[$post_type][$section_title]){
		return $tour_operator->options[$post_type][$section_title];
	}else{
		return $default;
	}
}


/**
 * Outputs the TO Gallery
 * 
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	to-galleries
 * @subpackage	template-tags
 */
function to_envira_gallery($before="",$after="",$echo=true){
	$envira_gallery = get_post_meta(get_the_ID(),'envira_gallery',true);
	if(false !== $envira_gallery){ 
		ob_start();
		if(function_exists('envira_gallery')){envira_gallery( $envira_gallery );}
		$return = ob_get_clean();

		$return = $before.$return.$after;

		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}	
}

/**
 * Outputs the Envira Video Gallery
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_envira_videos($before="",$after="",$echo=true){
	global $content_width;
	$envira_video = get_post_meta(get_the_ID(),'envira_video',true);
	$return = false;

	if(false !== $envira_video && '' !== $envira_video){
		$return = do_shortcode('[envira-gallery id="'.$envira_video.'"]');
		$return = $before.$return.$after;
		$temp_width = $content_width;
		$content_width = $temp_width;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}		
	}
}

/* ================  Accommodation =========================== */
/**
 * Outputs the current accommodations room total
 * 
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_accommodation_room_total($before="",$after="",$echo=true){
	to_custom_field_query('number_of_rooms',$before,$after,$echo);
}

/**
 * Gets the current accommodations rating
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @param		$post_id	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_accommodation_rating($before="",$after="",$echo=true,$post_id=false){
	to_custom_field_query('rating',$before,$after,$echo,$post_id);
}

/**
 * Outputs the accommodations facilities
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_has_facilities(){
	// Get any existing copy of our transient data
	if ( false === ( $facilities = get_transient( get_the_ID().'_facilities' ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		
		$facilities = wp_get_object_terms(get_the_ID(),'facility');
		$main_facilities = false;
		$child_facilities = false;
		$return = false;
		if ( ! empty( $facilities ) && ! is_wp_error( $facilities ) ) {
			foreach( $facilities as $facility ) {
				if(0 === $facility->parent){
					$main_facilities[] = $facility;
				}else{
					$child_facilities[$facility->parent][] = $facility;
				}
			}


			set_transient( get_the_ID().'_facilities', $location, 30 );
		}


	}else{
		return false;
	}	
}

/**
 * Outputs the accommodations facilities
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_accommodation_facilities($before="",$after="",$echo=true){
	$facilities = wp_get_object_terms(get_the_ID(),'facility');
	$main_facilities = false;
	$child_facilities = false;
	$return = false;
	if ( ! empty( $facilities ) && ! is_wp_error( $facilities ) ) {
		foreach( $facilities as $facility ) {
			if(0 === $facility->parent){
				$main_facilities[] = $facility;
			}else{
				$child_facilities[$facility->parent][] = $facility;
			}
		}

		//Output in the order we want
		foreach($main_facilities as $heading){
			$return .= '<div class="'.$heading->slug.' col-sm-6"><div class="facilities-content"><h3><a href="'.get_term_link( $heading->slug, 'facility' ).'">'.esc_html( $heading->name ).'</a></h3>';
			
			if(is_array($child_facilities) && isset($child_facilities[$heading->term_id])){
				$return .= '<ul class="row">';
					foreach($child_facilities[$heading->term_id] as $child_facility){
						$return .= '<li class="col-sm-4"><a href="'.get_term_link( $child_facility->slug, 'facility' ).'">'.esc_html( $child_facility->name ).'</a></li>';
					}
				$return .= '</ul>';
			}
			$return .= '</div></div>';
		}
		
		$return = $before.$return.$after;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}		
	}else{
		return false;
	}
}

/**
 * Outputs the Spoken Languages HTML
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_accommodation_spoken_languages($before="",$after="",$echo=true){
	$spoken_languages = get_post_meta( get_the_ID(), 'spoken_languages', true );
	if ( is_string( $spoken_languages ) && ! empty( $spoken_languages ) ) $spoken_languages = array( $spoken_languages );
	$return = '';

	if ( ! empty( $spoken_languages ) && ! is_wp_error( $spoken_languages ) ) {
		$return .= '<span class="values">';

		foreach ( $spoken_languages as $i => $spoken_language ) {
			$return .= ucwords( str_replace( '_', ' / ', str_replace( '-', ' ', str_replace( '-and-', ' & ', $spoken_language ) ) ) );

			if ( ( $i + 1 ) < count( $spoken_languages ) ) {
				$return .= ', ';
			}
		}

		$return .= '</span>';
		$return = $before.$return.$after;

		if ( $echo ) {
			echo wp_kses_post( $return );
		} else {
			return $return;
		}		
	} else {
		return false;
	}
}

/**
 * Outputs the Special Interests HTML
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_accommodation_special_interests($before="",$after="",$echo=true,$post_id=false){
	if(false === $post_id){
		$post_id = get_the_ID();
	}
	$special_interests = get_post_meta( $post_id, 'special_interests', true );
	if ( is_string( $special_interests ) && ! empty( $special_interests ) ) $special_interests = array( $special_interests );
	$return = '';

	if ( ! empty( $special_interests ) && ! is_wp_error( $special_interests ) ) {
		$return .= '<span class="values">';

		foreach ( $special_interests as $i => $special_interest ) {
			$return .= ucwords( str_replace( '_', ' / ', str_replace( '-', ' ', str_replace( '-and-', ' & ', $special_interest ) ) ) );

			if ( ( $i + 1 ) < count( $special_interests ) ) {
				$return .= ', ';
			}
		}

		$return .= '</span>';
		$return = $before.$return.$after;

		if ( $echo ) {
			echo wp_kses_post( $return );
		} else {
			return $return;
		}		
	} else {
		return false;
	}
}

/**
 * Outputs the Friendly HTML
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 * @category 	activity
 */
function to_accommodation_activity_friendly($before="",$after="",$echo=true){
	$friendly = get_post_meta( get_the_ID(), 'suggested_visitor_types', true );
	if ( is_string( $friendly ) && ! empty( $friendly ) ) $friendly = array( $friendly );
	$return = '';

	if ( ! empty( $friendly ) && ! is_wp_error( $friendly ) ) {
		$return .= '<span class="values">';

		foreach ( $friendly as $i => $friendly_item ) {
			$return .= ucwords( str_replace( '_', ' / ', str_replace( '-', ' ', str_replace( '-and-', ' & ', $friendly_item ) ) ) );

			if ( ( $i + 1 ) < count( $friendly ) ) {
				$return .= ', ';
			}
		}

		$return .= '</span>';
		$return = $before.$return.$after;

		if ( $echo ) {
			echo wp_kses_post( $return );
		} else {
			return $return;
		}		
	} else {
		return false;
	}
}

/**
 * Outputs the accommodation meta
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_accommodation_meta(){ 
	if('accommodation' === get_post_type()){
	?>
	<div class="accommodation-details meta taxonomies">
		<?php to_price('<div class="meta info"><span class="price">from ','</span></div>'); ?>
		<?php to_accommodation_room_total('<div class="meta rooms">'.__('Rooms','tour-operator').': <span>','</span></div>'); ?>	
		<?php to_accommodation_rating('<div class="meta rating">'.__('Rating','tour-operator').': ','</div>'); ?>			
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Accommodation Style','tour-operator').': ', ', ', '</div>' ); ?>
		<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">'.__('Brand','tour-operator').': ', ', ', '</div>' ); ?>
		<?php the_terms( get_the_ID(), 'accommodation-type', '<div class="meta accommodation-type">'.__('Type','tour-operator').': ', ', ', '</div>' ); ?>
		<?php to_accommodation_spoken_languages('<div class="meta spoken_languages">'.__('Spoken Languages','tour-operator').': <span>','</span></div>'); ?>
		<?php to_accommodation_activity_friendly('<div class="meta friendly">'.__('Friendly','tour-operator').': <span>','</span></div>'); ?>
		<?php to_accommodation_special_interests('<div class="meta special_interests">'.__('Special Interests','tour-operator').': <span>','</span></div>'); ?>
		<?php to_connected_destinations('<div class="meta destination">'.__('Location','tour-operator').': ','</div>'); ?>		
	</div>	
<?php } }

/**
 * Checks weather or not the conencted tours should display.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function to_accommodation_display_connected_tours(){
	global $tour_operator;
	$return = false;
	if(isset($tour_operator->options['accommodation']['display_connected_tours']) && 'on' === $tour_operator->options['accommodation']['display_connected_tours']){
		$return = true;
	}
	return $return;
 }

/* ================  Tours =========================== */

/**
 * Gets the current tours price
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_price($before="",$after="",$echo=true){
	to_custom_field_query('price',$before,$after,$echo);
}

/**
 * Gets the current tours duration
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_duration($before="",$after="",$echo=true){
	to_custom_field_query('duration',$before,$after,$echo);
}

/**
 * Gets the current tours included pricing field
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_included($before="",$after="",$echo=true){
	return to_custom_field_query('included',$before,$after,$echo);
}

/**
 * Gets the current tours not included pricing field
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_not_included($before="",$after="",$echo=true){
	return to_custom_field_query('not_included',$before,$after,$echo);
}

/**
 * Gets the current tours departure points
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_departure_point($before="",$after="",$echo=true){
	$departs_from = get_post_meta(get_the_ID(),'departs_from',false);
	if(false !== $departs_from && '' !== $departs_from){
		if(!is_array($departs_from)){
			$departs_from = array($departs_from);
		}
		$return = $before.to_connected_list($departs_from,'destination',true,', ').$after;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}
}

/**
 * Gets the current tours end points
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_end_point($before="",$after="",$echo=true){
	$end_point = get_post_meta(get_the_ID(),'ends_in',false);
	if(false !== $end_point && '' !== $end_point){
		if(!is_array($end_point)){
			$end_point = array($end_point);
		}
		$return = $before.to_connected_list($end_point,'destination',true,', ').$after;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}
}

/**
 * Outputs the tours pricing block
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_pricing_block(){

	$tour_included = to_included('','',false);
	$tour_not_included = to_not_included('','',false);
	if(null !== $tour_included || null !== $tour_not_included) { 
	
	$class="col-sm-6";
	if((null === $tour_included && null !== $tour_not_included) || (null !== $tour_included && null === $tour_not_included)){ 
		$class="col-sm-12";
	}
	?>
	<section id="included-excluded">
		<div class="row">
			<?php if(null !== $tour_included) { ?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<h2 class="section-title"><?php esc_html_e('Included','tour-operator'); ?></h2>
					<div class="entry-content">
						<?php echo wp_kses_post( apply_filters('the_content',wpautop($tour_included)) ); ?>
					</div>
				</div>
			<?php } ?>
			<?php if(null !== $tour_not_included) { ?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<h2 class="section-title"><?php esc_html_e('Excluded','tour-operator'); ?></h2>
					<div class="entry-content">
						<?php echo wp_kses_post( apply_filters('the_content',wpautop($tour_not_included)) ); ?>
					</div>
				</div>	
			<?php } ?>			
		</div>
	</section>
	<?php
	}
}

/**
 * Outputs the Tour Highlights
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_highlights($before="",$after="",$echo=true){
	$highlights = get_post_meta(get_the_ID(),'hightlights',true);
	if(false !== $highlights && '' !== $highlights){
		$return = $before.'<div class="entry-content">'.apply_filters('the_content',wpautop($highlights)).'</div>'.$after;
		if($echo){
			echo wp_kses_post($return);
		}else{
			return $return;
		}
	}
}

/**
 * Outputs the Best Time to Visit HTML
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_best_time_to_visit($before="",$after="",$echo=true){
	$best_time_to_visit = get_post_meta(get_the_ID(),'best_time_to_visit',true);
	if(false !== $best_time_to_visit && '' !== $best_time_to_visit && is_array($best_time_to_visit) && !empty($best_time_to_visit)){
		
		$this_year = array(
			'january' => 'January',
			'february' => 'February',
			'march' => 'March',
			'april' => 'April',
			'may' => 'May',
			'june' => 'June',
			'july' => 'July',
			'august' => 'August',
			'september' => 'September',
			'october' => 'October',
			'november' => 'November',
			'december' => 'December'
		);

		foreach($this_year as $month => $label){
			$checked = '';
			if(in_array($month,$best_time_to_visit)){ $checked = '<i class="fa fa-check" aria-hidden="true"></i>'; }
			$shortname = str_split($label,3);
			$best_times[] = '<div class="col-sm-2"><small>'.$shortname[0].'</small><br />'.$checked.'</div>';
		};
		$return = $before.implode($best_times).$after;		
		if($echo){
			echo wp_kses_post($return);
		}else{
			return $return;
		}
	}
}

/* ================  Destinations =========================== */
/**
 * Outputs the connected accommodation only on a "region"
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	destination
 */
function to_region_accommodation(){
	global $to_archive;
	if(post_type_exists('accommodation') && is_singular('destination') && !to_item_has_children(get_the_ID(),'destination')) { 
		$args = array(
			'from'			=>	'accommodation',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="accommodation"><h2 class="section-title">'.__(to_get_post_type_section_title('accommodation', '', 'Featured Accommodations'),'tour-operator').'</h2>',
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
function to_country_regions(){
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
function to_destination_tours(){
	global $to_archive,$wp_query;
	if(post_type_exists('tour') && is_singular('destination')){
		$args = array(
			'from'			=>	'tour',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="tours"><h2 class="section-title">'.__(to_get_post_type_section_title('tour', '', 'Featured Tours'),'tour-operator').'</h2>',
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
function to_destination_activities(){
	global $to_archive;
	if(post_type_exists('activity') && is_singular('destination') && !to_item_has_children(get_the_ID(),'destination')){
		$args = array(
			'from'			=>	'activity',
			'to'			=>	'destination',
			'content_part'	=>	'widget-activity',
			'column'		=>	'4',				
			'before'		=>	'<section id="activities"><h2 class="section-title">'.__(to_get_post_type_section_title('activity', '', 'Featured Activities'),'tour-operator').'</h2>',
			'after'			=>	'</section>',
		);
		to_connected_panel_query($args);
	}
}

/* ================  SPECIALS =========================== */
/**
 * Gets the current specials tagline
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	specials
 */
function to_special_tagline($before="",$after="",$echo=true){
	to_tagline($before,$after,$echo);
}

/**
 * Gets the current specials terms and conditions
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	specials
 */
function to_specials_terms_conditions($before="",$after="",$echo=true){
	to_custom_field_query('terms_conditions',$before,$after,$echo);
}


/**
 * Outputs the specials validity
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	specials
 */
function to_specials_validity($before="",$after="",$echo=true){
	$valid_from = get_the_date( 'd M Y', get_the_ID() );
	$valid_to = get_post_meta(get_the_ID(),'_expiration-date',true);
	if(false !== $valid_to && '' !== $valid_to){
		$valid_from .= ' - '.date('d M Y',$valid_to);
	}
	if(false !== $valid_from && '' !== $valid_from){
		$return = $before.$valid_from.$after;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}
}

/**
 * Outputs the travel dates
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	specials
 */
function to_travel_dates($before="",$after="",$echo=true){
	$valid_from = get_post_meta(get_the_ID(),'travel_dates_start',true);
	$valid_to = get_post_meta(get_the_ID(),'travel_dates_end',true);
	if(false !== $valid_from && '' !== $valid_from){
		$valid_from = date('d M Y',strtotime($valid_from));
	}	
	if(false !== $valid_to && '' !== $valid_to){
		$valid_from .= ' - '.date('d M Y',strtotime($valid_to));
	}
	if(false !== $valid_from && '' !== $valid_from){
		$return = $before.$valid_from.$after;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}
}

/* ================  GLOBAL FUNCTIONS =========================== */
/**
 * Outputs the Enquire Modal
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_enquire_modal($before="",$after="",$echo=true){ 
	global $tour_operator;

	$form_id = 'false';
	// First set the general form
	if(isset($tour_operator->options['general']) && isset($tour_operator->options['general']['enquiry']) && '' !== $tour_operator->options['general']['enquiry']){
		$form_id = $tour_operator->options['general']['enquiry'];
	}

	if(is_singular($tour_operator->active_post_types)){		
		if(isset($tour_operator->options[get_post_type()]) && isset($tour_operator->options[get_post_type()]['enquiry']) && '' !== $tour_operator->options[get_post_type()]['enquiry']){
			$form_id = $tour_operator->options[get_post_type()]['enquiry'];
		}
	}

	$disable_modal = false;
	$link = '#';

	if(isset($tour_operator->options['general']) && isset($tour_operator->options['general']['disable_enquire_modal']) && 'on' === $tour_operator->options['general']['disable_enquire_modal']){
		$disable_modal = true;

		if('' !== $tour_operator->options['general']['enquire_link']){
			$link = $tour_operator->options['general']['enquire_link'];
		}
	}

	if(is_singular($tour_operator->active_post_types)){		
		if(isset($tour_operator->options[get_post_type()]) && isset($tour_operator->options[get_post_type()]['disable_enquire_modal']) && 'on' === $tour_operator->options[get_post_type()]['disable_enquire_modal']){
			$disable_modal = true;

			if('' !== $tour_operator->options[get_post_type()]['enquire_link']){
				$link = $tour_operator->options[get_post_type()]['enquire_link'];
			}
		}
	}	


	if(false !== $form_id){

	?>
	<div class="enquire-form">
		<p class="aligncenter" style="text-align:center;"><a href="<?php echo esc_url( $link ); ?>" class="btn cta-btn" <?php if(false === $disable_modal){ ?>data-toggle="modal" data-target="#lsx-enquire-modal"<?php } ?> >Enquire</a></p>
		
		<?php 
		if(false === $disable_modal){
		add_action( 'wp_footer', function( $arg ) use ( $form_id ) { ?>
		
		<div class="modal fade" id="lsx-enquire-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Enquire</h4>
		      </div>
		      <div class="modal-body">
		        <?php 
					if(class_exists('Ninja_Forms')){
						echo do_shortcode('[ninja_form id="'.$form_id.'"]');
					}elseif(class_exists('GFForms')){
						echo do_shortcode('[gravityform id="'.$form_id.'" title="false" description="false" ajax="true"]');
					}elseif(class_exists('Caldera_Forms_Forms')) {
						echo do_shortcode('[caldera_form id="'.$form_id.'"]');
					}else{
						echo wp_kses_post( apply_filters('the_content',$form_id) );
					}
		        ?>
		      </div>
		    </div>
		  </div>
		</div>

		<?php } ); } ?>

	</div>
<?php } }

/* ================  Taxonomies =========================== */

/**
 * Gets the current connected team member panel
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function to_term_tagline($term_id=false,$before="",$after="",$echo=true){
	if(false !== $term_id){
		$taxonomy_tagline = get_term_meta($term_id, 'tagline', true);
		if(false !== $taxonomy_tagline && '' !== $taxonomy_tagline){
			$return = $before.$taxonomy_tagline.$after;
			if($echo){
				echo wp_kses_post( $return );
			}else{
				return $return;
			}		
		}
	}
}

/* ================  CONNECTED POSTS =========================== */
/**
 * Gets the current specials connected accommodation
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
function to_connected_accommodation($before="",$after="",$echo=true){
	to_connected_items_query('accommodation',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected activities
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
function to_connected_activities($before="",$after="",$echo=true){
	to_connected_items_query('activity',get_post_type(),$before,$after,$echo);
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
function to_connected_destinations($before="",$after="",$echo=true){
	to_connected_items_query('destination',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected reviews
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
function to_connected_reviews($before="",$after="",$echo=true){
	to_connected_items_query('review',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected team member
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
function to_connected_team($before="",$after="",$echo=true){
	to_connected_items_query('team',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected tours
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
function to_connected_tours($before="",$after="",$echo=true){
	to_connected_items_query('tour',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected vehicles
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
function to_connected_vehicles($before="",$after="",$echo=true){
	to_connected_items_query('vehicle',get_post_type(),$before,$after,$echo);
}



/* ================  REUSED =========================== */

/**
 * Checks if a custom field query exists, and set a transient for it, so we dont have to query it again later.
 *
 * @param		$meta_key	| string
 * @param		$single		| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_has_custom_field_query( $meta_key = false, $id = false, $is_tax = false ) {
	if ( false !== $meta_key ) {
		if ( false === ( $custom_field = get_transient( $id .'_'. $meta_key ) ) ) {
			if ( $is_tax ) {
				$custom_field = get_term_meta( $id, $meta_key, true );
			} else {
				$custom_field = get_post_meta( $id, $meta_key, true );
			}
			
			if ( false !== $custom_field && '' !== $custom_field ) {
				set_transient( $id .'_'. $meta_key, $custom_field, 30 );
				return true;
			}
		} else {
			return true;
		}
	}

	return false;
}

/**
 * Queries a basic custom field
 *
 * @param		$meta_key	| string
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_custom_field_query($meta_key=false,$before="",$after="",$echo=false,$post_id=false){
	if(false !== $meta_key){
		//Check to see if we already have a transient set for this.
		// TODO Need to move this to enclose the entire function and change to a !==,  that way you have to set up the custom field via the to_has_{custom_field} function
		if(false === $post_id){
			$post_id = get_the_ID();
		}
		
		if ( false === ( $value = get_transient( $post_id.'_'.$meta_key ) ) ) {
			$value = get_post_meta($post_id,$meta_key,true);
		}
		if(false !== $value && '' !== $value){
			$return_html = $before.'<span class="values">'.$value.'</span>'.$after;
			$return = apply_filters('to_custom_field_query',$return_html,$meta_key,$value,$before,$after);
			if($echo){
				echo wp_kses_post( $return );
			}else{
				return $return;
			}
		}	
	}
}

/**
 * Gets the list of connections requested
 *
 * @param		$from	| string
 * @param		$to		| string
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_connected_items_query($from=false,$to=false,$before="",$after="",$echo=false){
	if(post_type_exists($from) && post_type_exists($to)){
		$connected_ids = get_post_meta(get_the_ID(),$from.'_to_'.$to,false);
		if(false !== $connected_ids && '' !== $connected_ids && !empty($connected_ids)){
			if(!is_array($connected_ids)){
				$connected_ids = array($connected_ids);
			}
			$return = $before.to_connected_list($connected_ids,$from,true,', ').$after;
			if($echo){
				echo wp_kses_post( $return );
			}else{
				return $return;
			}
		}else{
			return false;
		}
	}
}

/**
 * Gets the list of connections items, and displays them using the the specified content part.
 *
 * @param		$from				| string
 * @param		$to					| string
 * @param		$content_part		| string
 * @param		$before				| string
 * @param		$after				| string
 * @param		$echo				| boolean
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_connected_panel_query($args=false){
	global $to_archive;
	if(false !== $args && is_array($args)){
		$defaults = array(
			'from'			=>	false,
			'to'			=>	false,
			'content_part'	=>	false,
			'id'			=>	false,
			'column'		=>	false,
			'before'		=>	'',
			'after'			=>	'',
			'echo'			=>	true,
		);
		$args = wp_parse_args($args,$defaults);
		$return = false;
		
		if(false === $args['content_part']){$args['content_part'] = $args['from']; }
		
		$items_array = get_post_meta(get_the_ID(),$args['from'].'_to_'.$args['to'],false);
		
		if(false !== $items_array && is_array($items_array) && !empty($items_array)){
			$items_query_args = array(
					'post_type'	=>	$args['from'],
					'post_status' => 'publish',
					'post__in' => $items_array
			);
			$items = new WP_Query($items_query_args);
			if ( $items->have_posts() ): 
				$to_archive = 1;
				ob_start();
				echo wp_kses_post( $args['before'] ).'<div class="row">'; 
				while ( $items->have_posts() ) : $items->the_post();
					echo '<div class="panel col-sm-'.esc_attr($args['column']).'">';
					to_content('content',$args['content_part']);
					echo '</div>';
				endwhile;
				echo '</div>'.wp_kses_post( $args['after'] );
				$return = ob_get_clean();
				$to_archive = 0;
				wp_reset_query();
				wp_reset_postdata();
			endif; // end of the loop. 
		}
		if($args['echo']){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}		
	}		
}

/**
 * Returns items tagged in the same terms for the taxonomy you select.
 *
 * @param		$taxonomy	| string
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_related_items($taxonomy=false,$before="",$after="",$echo=true,$post_type=false) {
	if(false !== $taxonomy){
		$return = false;
		$filters = array();

		if(false === $post_type){
			$post_type = get_post_type();
		}
		$filters['post_type'] = $post_type;

		if(is_array($taxonomy)){
			$filters['post__in'] = $taxonomy;
			
		} else {
			//Get the settings from the customizer options
			$filters['posts_per_page'] = 15;
			//Exclude the current post
			$filters['post__not_in'] = array(get_the_ID());
			//if its set to related then we need to check by the type.
			$filters['orderby'] = 'rand';
			$terms = wp_get_object_terms(get_the_ID(), $taxonomy);

			//only allow relation by 1 property type term
			if(is_array($terms) && !empty($terms)){
				foreach($terms as $term){
					$filters[$taxonomy] = $term->slug;
				}
			}
		}
			
		$related_query = new WP_Query( $filters );
		if ( $related_query->have_posts() ):
		global $wp_query,$columns;$wp_query->is_single = 0;$wp_query->is_singular = 0;$wp_query->is_post_type_archive = 1;$columns = 3;

		ob_start();
		
		//Setting some carousel variables
		$count = 1;
		$landing_image = '';	
		$carousel_id = rand ( 20, 20000 );
		$interval = '5000';
		$pagination = '';
		$pages = ceil( $related_query->post_count / $columns );
		$post_type = get_post_type();
		$carousel = false;

		if($related_query->post_count > 3){
			$carousel = true;
		}

		//generate the pagination
		$i = 0;
		while ( $i < $pages ) {
			$pagination .= '<li data-target="#slider-'.esc_attr($carousel_id).'" data-slide-to="'.esc_attr($i).'" class="'. esc_attr( 0 == $i ? 'active' : '' ) .'"></li>';
			$i++;
		}			
	
		//The start of the carousel output
		if($carousel){
			echo '<div class="slider-container">';
			echo '<div id="slider-'.esc_attr($carousel_id).'" class="carousel slide" data-interval="'.esc_attr($interval).'">';
			echo '<div class="carousel-wrap">';
			echo '<div class="carousel-inner" role="listbox">';
		}

			while ( $related_query->have_posts() ):
				$related_query->the_post();

				//The opening of the carousel
				if (1 === $count) {
					if ($carousel) {
						echo '<div class="item active row">';
						echo '<div class="lsx-'.esc_attr($post_type).'">';					
					} else {
						echo '<div class="row lsx-'.esc_attr($post_type).'">';
					}

				}				

				echo '<div class="panel col-sm-4">';

				to_content('content','widget-'.get_post_type());

				echo '</div>';

				//Closing carousel loop inner
				if (0 == $count % $columns || $count === $related_query->post_count) {
					if ($carousel) {
						echo "</div></div>";
						if ($count < $related_query->post_count) {
							echo '<div class="item row"><div class="lsx-'.esc_attr($post_type).'">';
						}
					} else {
						echo "</div>";
						if ($count < $related_query->post_count) {
							echo '<div class="row lsx-'.esc_attr($post_type).'">';
						}
					}
				}
				$count++;
			endwhile;

		//This is the closing carousel output.
		if ($carousel) {
			echo "</div>";
			if ( $pages > 1 ) {
				echo '<a class="left carousel-control" href="#slider-'.esc_attr($carousel_id).'" role="button" data-slide="prev">';
				echo '<span class="fa fa-chevron-left" aria-hidden="true"></span>';
				echo '<span class="sr-only">'.esc_html__('Previous','tour-operator').'</span>';
				echo '</a>';
				echo '<a class="right carousel-control" href="#slider-'.esc_attr($carousel_id).'" role="button" data-slide="next">';
				echo '<span class="fa fa-chevron-right" aria-hidden="true"></span>';
				echo '<span class="sr-only">'.esc_html__('Next','tour-operator').'</span>';
				echo '</a>';
			}
			echo "</div>";
			if ( $pages > 1 ) {
				echo '<ol class="carousel-indicators">'.wp_kses_post($pagination).'</ol>';
			}
			echo "</div>";
			echo "</div>";			
		}
		
		$return = ob_get_clean();
			
		$wp_query->is_single = 1;$wp_query->is_singular = 1;$wp_query->is_post_type_archive = 0;
		wp_reset_query();
		wp_reset_postdata();
		
		$return = $before.$return.$after;
		endif;
		
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}
}

/**
 * Outputs the widget with some styling
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_safari_brands($before="",$after="",$echo=true) {
	$args = array(
			'name' => 'Home',
			'id' => 'sidebar-home',
			'description' => '',
			'class' => '',
			'before_widget' => '<aside id="to_taxonomy_widget-6" class="widget lsx-widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'to_taxonomy_widget-6',
			'widget_name' => 'LSX Taxonomies',
	);
	$instance = array(
			'title' => '',
			'title_link' =>'',
			'columns' => '4',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'limit' => '100',
			'include' =>'',
			'size' => '100',
			'buttons' =>'',
			'button_text' =>'',
			'responsive' => '1',
			'carousel' =>'1',
			'taxonomy' => 'accommodation-brand',
			'class' =>'',
			'interval' => '7000',
			'indicators' => '1'
	);
	$safari_brands = new TO_Taxonomy_Widget();
	ob_start();
	$safari_brands->widget($args, $instance);
	$return = ob_get_clean();
	$return = $before.$return.$after;
	if($echo){
		echo wp_kses_post( $return );
	}else{
		return $return;
	}	
}

/**
 * Outputs the travel styles widget with some styling
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_travel_styles($before="",$after="",$echo=true) {
	$args = array(
			'name' => 'Home',
			'id' => 'sidebar-home',
			'description' => '',
			'class' => '',
			'before_widget' => '<aside id="to_taxonomy_widget-6" class="widget lsx-widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'to_taxonomy_widget-6',
			'widget_name' => 'LSX Taxonomies',
	);
	$instance = array(
			'title' => '',
			'title_link' =>'',
			'columns' => '3',
			'orderby' => 'rand',
			'order' => 'DESC',
			'limit' => '100',
			'include' =>'',
			'size' => '100',
			'buttons' =>'',
			'button_text' =>'',
			'responsive' => '1',
			'carousel' =>'1',
			'taxonomy' => 'travel-style',
			'class' =>'',
			'interval' => '7000',
			'indicators' => '1'
	);
	$travel_styles = new TO_Taxonomy_Widget();
	ob_start();
	$travel_styles->widget($args, $instance);
	$return = ob_get_clean();
	$return = $before.$return.$after;
	if($echo){
		echo wp_kses_post( $return );
	}else{
		return $return;
	}	
}

/**
 * Remove Default Gallery Styling
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/* =============  Taxonomy Meta Fields ===============*/
/**
 * Checks if the current term has a thumbnail
 *
 * @param	$term_id
 */
if(!function_exists('to_has_term_thumbnail')){
	function to_has_term_thumbnail($term_id = false) {
		if(false !== $term_id){
			$term_thumbnail = get_term_meta($term_id, 'thumbnail', true);
			if(false !== $term_thumbnail && '' !== $term_thumbnail){
				return true;
			}
		}
		return false;
	}
}

/**
 * Outputs the current terms thumbnail
 *
 * @param	$term_id string
 */
if(!function_exists('to_term_thumbnail')){
	function to_term_thumbnail($term_id = false,$size='lsx-thumbnail-wide') {
		if(false !== $term_id){
			echo wp_kses_post(to_get_term_thumbnail($term_id,$size));
		}
	}
}
/**
 * Outputs the current terms thumbnail
 *
 * @param	$term_id string
 */
if(!function_exists('to_get_term_thumbnail')){
	function to_get_term_thumbnail($term_id = false,$size='lsx-thumbnail-wide') {
		if(false !== $term_id){
			$term_thumbnail_id = get_term_meta($term_id, 'thumbnail', true);
			$img = wp_get_attachment_image_src($term_thumbnail_id,$size);
			return apply_filters( 'to_lazyload_filter_images', '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="'.$img[0].'" />' );
		}
	}
}

/**
 * Outputs the 'content' class.
 *
 * @param	$classes string or array
 */
function to_entry_class($classes = false) {
	global $post;

	if(false !== $classes){
		if(!is_array($classes)) {
			$classes = explode(' ',$classes);
		}
		$classes = apply_filters( 'to_entry_class', $classes, $post->ID );
	}
	echo wp_kses_post('class="'.implode(' ',$classes).'"');
}

/**
 * Outputs the 'content' class.
 *
 * @param	$classes string or array
 */
function to_column_class($classes = false) {
	global $post;

	if(false !== $classes){
		if(!is_array($classes)) {
			$classes = explode(' ',$classes);
		}
		$classes = apply_filters( 'to_column_class', $classes, $post->ID );
	}
	echo wp_kses_post('class="'.implode(' ',$classes).'"');
}

/**
 * Check if the current item has child pages or if its a parent ""
 *
 * @param	$post_id string
 * @param	$post_type string
 */
function to_item_has_children($post_id = false,$post_type = false) {
	global $wpdb;
	if(false == $post_id){return false;}
	if(false == $post_type){$post_type = 'page';}
	$children = $wpdb->get_results(
			$wpdb->prepare(
					"
					SELECT ID
					FROM {$wpdb->posts}
					WHERE (post_type = %s AND post_status = 'publish')
					AND post_parent = %d
					LIMIT 1
					",
					$post_type,$post_id
			)
			);

	if(count($children) > 0){
		return $children;
	}else{
		return false;
	}
}

/**
 * Outputs a list of the ids you give it
 * 
 * @param		$connected_ids | array() | the array of ids
 * @param		$type | string | the post type
 * @param		$link | boolean | link the items or not
 * @param		$seperator | string | what to seperate the items by.
 *
 * @package 	lsx-framework
 * @subpackage	template-tags
 * @category 	helper
 */
function to_connected_list($connected_ids = false,$type = false,$link = true,$seperator=', ',$parent=false) {

	if(false === $connected_ids || false === $type){
		return false;
	}else{

		if(!is_array($connected_ids)){
			$connected_ids = explode(',',$connected_ids);
		}

		$filters = array(
				'post_type' => $type,
				'post_status' => 'publish',
				'post__in'	=> $connected_ids
		);
		if(false !== $parent){
			$filters['post_parent']=$parent;
		}
		$connected_query = get_posts( $filters );

		if(is_array($connected_query)){
			$connected_list = array();
			foreach($connected_query as $cp){

				$html = '';
				if($link){
					$html .= '<a href="'.get_the_permalink($cp->ID).'">';
				}

				$html .= get_the_title($cp->ID);

				if($link){
					$html .= '</a>';
				}				
				$html = apply_filters('to_connected_list_item',$html,$cp->ID,$link);
				$connected_list[] = $html;

			}
				
			return implode($seperator,$connected_list);
		}
	}
}

/**
 * Outputs a list of the ids you give it
 *
 * @package 	lsx-framework
 * @subpackage	hook
 * @category 	modal
 */
function to_modal_meta(){
	do_action('to_modal_meta');
}

/**
 * Outputs a list of the ids you give it
 *
 * @package 	lsx-framework
 * @subpackage	hook
 * @category 	modal
 */
function to_envira_banner(){
	global $tour_operator;
	if(isset($tour_operator->options) && isset($tour_operator->options['display']) && isset($tour_operator->options['display']['enable_galleries_in_banner'])){
		return true;
	}else{
		return false;
	}
}
