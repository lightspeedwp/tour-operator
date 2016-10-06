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
 * @package 	lsx-tour-operator
 * @subpackage	template-tag
 * @category 	archive-header
 */
function lsx_tour_operator_archive_header() { ?>
	<header class="archive-header">
		<h1 class="archive-title">
			<?php the_archive_title(); ?>
		</h1>
		<?php lsx_tour_operator_tagline('<p class="tagline">','</p>'); ?>
	</header><!-- .archive-header -->
<?php
}

/**
 * Checks if a caldera form with your slug exists
 *
 * @package 	lsx-tour-operator
 * @subpackage	template-tag
 * @category 	single-header
 */
function lsx_tour_operator_single_header() { ?>
	<header class="page-header">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php lsx_tour_operator_tagline('<p class="tagline">','</p>'); ?>
	</header><!-- .entry-header -->	
<?php
}

/**
 * Banner Content
 *
 * @package 	lsx-tour-operator
 * @subpackage	template-tag
 * @category 	banner-content
 */
function lsx_tour_operator_banner_content() { 
	lsx_tour_operator_tagline('<p class="tagline">','</p>');
}

/**
 * Taglines
 *
 * @package 	lsx-tour-operator
 * @subpackage	template-tag
 * @category 	tagline
 */
function lsx_tour_operator_tagline($before='',$after='') {
	echo wp_kses_post( apply_filters('lsx_tour_operator_tagline','',$before,$after) );
}

/**
 * Archive Descriptions
 *
 * @package 	lsx-tour-operator
 * @subpackage	template-tag
 * @category 	description
 */
function lsx_tour_operator_archive_description() {
	echo wp_kses_post( apply_filters('lsx_tour_operator_archive_description','','<div class="row"><div class="col-sm-12"><article class="archive-description hentry">','</article></div></div>') );
}

/**
 * Checks if a caldera form with your slug exists
 *
 * @package 	lsx-tour-operator
 * @subpackage	setup
 * @category 	helper
 */
function lsx_tour_operator_content($slug, $name = null) {
	do_action('lsx_tour_operator_content',$slug, $name);
}

/**
 * outputs the sharing
 *
 * @package 	lsx-tour-operator
 * @subpackage	setup
 * @category 	helper
 */
function lsx_tour_sharing() { 
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_widget_class($return=false){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_is_single_disabled($post_type=false){
	global $lsx_tour_operators;
	if(false === $post_type) {$post_type = get_post_type(); }
	if(is_object($lsx_tour_operators) && isset($lsx_tour_operators->options[$post_type]) && isset($lsx_tour_operators->options[$post_type]['disable_single'])){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_get_post_type_section_title($post_type=false,$section='',$default=''){
	$section_title = (!empty($section)) ? ($section.'_section_title') : 'section_title';
	global $lsx_tour_operators;
	if(false === $post_type) {$post_type = get_post_type(); }
	if(is_object($lsx_tour_operators) && isset($lsx_tour_operators->options[$post_type]) && isset($lsx_tour_operators->options[$post_type][$section_title]) && !empty($lsx_tour_operators->options[$post_type][$section_title]) && '' !== $lsx_tour_operators->options[$post_type][$section_title]){
		return $lsx_tour_operators->options[$post_type][$section_title];
	}else{
		return $default;
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_accommodation_room_total($before="",$after="",$echo=true){
	lsx_custom_field_query('number_of_rooms',$before,$after,$echo);
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_accommodation_rating($before="",$after="",$echo=true,$post_id=false){
	lsx_custom_field_query('rating',$before,$after,$echo,$post_id);
}

/**
 * Outputs the accommodations facilities
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_has_facilities(){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_accommodation_facilities($before="",$after="",$echo=true){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_accommodation_spoken_languages($before="",$after="",$echo=true){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_accommodation_special_interests($before="",$after="",$echo=true,$post_id=false){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 * @category 	activity
 */
function lsx_accommodation_activity_friendly($before="",$after="",$echo=true){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_accommodation_meta(){ 
	if('accommodation' === get_post_type()){
	?>
	<div class="accommodation-details meta taxonomies">
		<?php lsx_tour_price('<div class="meta info"><span class="price">from ','</span></div>'); ?>
		<?php lsx_accommodation_room_total('<div class="meta rooms">'.__('Rooms','lsx-tour-operators').': <span>','</span></div>'); ?>	
		<?php lsx_accommodation_rating('<div class="meta rating">'.__('Rating','lsx-tour-operators').': ','</div>'); ?>			
		<?php the_terms( get_the_ID(), 'travel-style', '<div class="meta travel-style">'.__('Accommodation Style','lsx-tour-operators').': ', ', ', '</div>' ); ?>
		<?php the_terms( get_the_ID(), 'accommodation-brand', '<div class="meta accommodation-brand">'.__('Brand','lsx-tour-operators').': ', ', ', '</div>' ); ?>
		<?php the_terms( get_the_ID(), 'accommodation-type', '<div class="meta accommodation-type">'.__('Type','lsx-tour-operators').': ', ', ', '</div>' ); ?>
		<?php lsx_accommodation_spoken_languages('<div class="meta spoken_languages">'.__('Spoken Languages','lsx-tour-operators').': <span>','</span></div>'); ?>
		<?php lsx_accommodation_activity_friendly('<div class="meta friendly">'.__('Friendly','lsx-tour-operators').': <span>','</span></div>'); ?>
		<?php lsx_accommodation_special_interests('<div class="meta special_interests">'.__('Special Interests','lsx-tour-operators').': <span>','</span></div>'); ?>
		<?php lsx_connected_destinations('<div class="meta destination">'.__('Location','lsx-tour-operators').': ','</div>'); ?>		
	</div>	
<?php } }

/**
 * Checks weather or not the conencted tours should display.
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_accommodation_display_connected_tours(){
	global $lsx_tour_operators;
	$return = false;
	if(isset($lsx_tour_operators->options['accommodation']['display_connected_tours']) && 'on' === $lsx_tour_operators->options['accommodation']['display_connected_tours']){
		$return = true;
	}
	return $return;
 }

/* ================  Tours =========================== */

/**
 * Gets the current items tagline
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_tagline($before="",$after="",$echo=true){
	lsx_custom_field_query('tagline',$before,$after,$echo);
}

/**
 * Gets the current tours price
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_price($before="",$after="",$echo=true){
	lsx_custom_field_query('price',$before,$after,$echo);
}

/**
 * Gets the current tours duration
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_duration($before="",$after="",$echo=true){
	lsx_custom_field_query('duration',$before,$after,$echo);
}

/**
 * Gets the current tours included pricing field
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_included($before="",$after="",$echo=true){
	return lsx_custom_field_query('included',$before,$after,$echo);
}

/**
 * Gets the current tours not included pricing field
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_not_included($before="",$after="",$echo=true){
	return lsx_custom_field_query('not_included',$before,$after,$echo);
}

/**
 * Gets the current tours departure points
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_departure_point($before="",$after="",$echo=true){
	$departs_from = get_post_meta(get_the_ID(),'departs_from',false);
	if(false !== $departs_from && '' !== $departs_from){
		if(!is_array($departs_from)){
			$departs_from = array($departs_from);
		}
		$return = $before.lsx_connected_list($departs_from,'destination',true,', ').$after;
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_end_point($before="",$after="",$echo=true){
	$end_point = get_post_meta(get_the_ID(),'ends_in',false);
	if(false !== $end_point && '' !== $end_point){
		if(!is_array($end_point)){
			$end_point = array($end_point);
		}
		$return = $before.lsx_connected_list($end_point,'destination',true,', ').$after;
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_pricing_block(){

	$tour_included = lsx_tour_included('','',false);
	$tour_not_included = lsx_tour_not_included('','',false);
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
					<h2 class="section-title"><?php esc_html_e('Included','lsx-tour-operators'); ?></h2>
					<div class="entry-content">
						<?php echo wp_kses_post( apply_filters('the_content',wpautop($tour_included)) ); ?>
					</div>
				</div>
			<?php } ?>
			<?php if(null !== $tour_not_included) { ?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<h2 class="section-title"><?php esc_html_e('Excluded','lsx-tour-operators'); ?></h2>
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_highlights($before="",$after="",$echo=true){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_best_time_to_visit($before="",$after="",$echo=true){
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

/**
 * Outputs the Tours Videos
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_tour_videos($before="",$after="",$echo=true){
	global $content_width;

	$videos = get_post_meta(get_the_ID(),'videos',false);
	if(false !== $videos && '' !== $videos && is_array($videos) && !empty($videos)){
		$temp_width = $content_width;
		$content_width = '350';		
		$video_count = count($videos);

		$carousel = false;
		if($video_count > 3){
			$carousel = true;
		}

		$columns = 3;
		$class=12/$columns;

		$count = 1;
		$video_array = '';		

		//Set some carousel values
		if(true === $carousel){
			$carousel_id = rand ( 20, 20000 );
			$interval = '5000';
			$pagination = '';
			$pages = ceil( $video_count / $columns );	

			//generate the pagination
			$i = 0;
			while ( $i < $pages ) {
				$pagination .= '<li data-target="#slider-'.esc_attr($carousel_id).'" data-slide-to="'.esc_attr($i).'" class="'. esc_attr( 0 == $i ? 'active' : '' ) .'"></li>';
				$i++;
			}

			$video_array .= '<div class="slider-container">';
			$video_array .= '<div id="slider-'.esc_attr($carousel_id).'" class="carousel slide" data-interval="'.esc_attr($interval).'">';
			$video_array .= '<div class="carousel-wrap">';
			$video_array .= '<div class="carousel-inner" role="listbox">';
		}

		foreach($videos as $video){

			//The opening of the carousel
			if (1 === $count) {
				if (true === $carousel) {
					$video_array .= '<div class="item active row">';
					$video_array .= '<div class="lsx-video">';							
				} else {
					$video_array .= '<div class="row lsx-video">';
				}

			}
			
			$video_array .= '<div class="panel col-sm-'.$class.'">';

			$video_array .= '<article class="video type-video">';
			if(isset($video['url']) && ''!==$video['url']){
				//$video_array .= '<div class="video thumbnail">'.apply_filters('the_content',$video['url']).'</div>';
				$video_array .= wp_oembed_get($video['url']);
						
				if(isset($video['title']) && ''!==$video['title']){ 
					$video_array .= '<h3>'.$video['title'].'</h3>';
				}
				if(isset($video['description']) && ''!==$video['description']){
					$video_array .= '<div class="entry-content">'.apply_filters('the_content',$video['description']).'</div>';


				}	
			}
			$video_array .= '</article></div>';

			//Closing carousel loop inner
			if (0 == $count % $columns || $count === $video_count) {
				if (true === $carousel) {
					$video_array .= "</div></div>";
					if ($count < $video_count) {
						$video_array .= "<div class='item row'><div class='lsx-video'>";
					}
				} else {
					$video_array .= "</div>";
					if ($count < $video_count) {
						$video_array .= "<div class='row lsx-video'>";
					}
				}
			}
			$count++;
		}

		//This is the closing carousel output.
		if (true === $carousel) {
			$video_array .= "</div>";
			if ( $pages > 1 ) {
				$video_array .= '<a class="left carousel-control" href="#slider-'.$carousel_id.'" role="button" data-slide="prev">';
				$video_array .= '<span class="fa fa-chevron-left" aria-hidden="true"></span>';
				$video_array .= '<span class="sr-only">'.__('Previous','lsx-tour-operators').'</span>';
				$video_array .= '</a>';
				$video_array .= '<a class="right carousel-control" href="#slider-'.$carousel_id.'" role="button" data-slide="next">';
				$video_array .= '<span class="fa fa-chevron-right" aria-hidden="true"></span>';
				$video_array .= '<span class="sr-only">'.__('Next','lsx-tour-operators').'</span>';
				$video_array .= '</a>';
			}
			$video_array .= "</div>";
			if ( $pages > 1 ) {
				$video_array .= '<ol class="carousel-indicators">'.$pagination.'</ol>';
			}
			$video_array .= "</div>";
			$video_array .= "</div>";			
		}
		
		$return = $before.$video_array.$after;
		$temp_width = $content_width;
		$content_width = $temp_width;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}		
	}
}


/* ================  Destinations =========================== */
/**
 * Outputs the connected accommodation only on a "region"
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_tour_region_accommodation(){
	global $lsx_archive;
	if(post_type_exists('accommodation') && is_singular('destination') && !lsx_item_has_children(get_the_ID(),'destination')) { 
		$args = array(
			'from'			=>	'accommodation',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="accommodation"><h2 class="section-title">'.__(lsx_get_post_type_section_title('accommodation', '', 'Featured Accommodations'),'lsx-tour-operators').'</h2>',
			'after'			=>	'</section>'
		);
		lsx_connected_panel_query($args);
	}
}
/**
 * Outputs the child destinations
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_tour_country_regions(){
	global $lsx_archive,$wp_query;
	if(is_singular('destination') && lsx_item_has_children(get_the_ID(),'destination')) {
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
				<h2 class="section-title"><?php esc_html_e(lsx_get_post_type_section_title('destination', 'regions', 'Regions'),'lsx-tour-operators'); ?></h2>		
				<div class="row">		
					<?php $lsx_archive = 1; $wp_query->is_single = 0;$wp_query->is_singular = 0;$wp_query->is_post_type_archive = 1;?>
					<?php while ( $regions->have_posts() ) : $regions->the_post(); ?>
						<div class="panel col-sm-12">
							<?php lsx_tour_operator_content('content','destination'); ?>
						</div>
					<?php endwhile; // end of the loop. ?>
					<?php $lsx_archive = 0; $wp_query->is_single = 1;$wp_query->is_singular = 1;$wp_query->is_post_type_archive = 0;?>
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_tour_destination_tours(){
	global $lsx_archive,$wp_query;
	if(post_type_exists('tour') && is_singular('destination')){
		$args = array(
			'from'			=>	'tour',
			'to'			=>	'destination',
			'column'		=>	'12',
			'before'		=>	'<section id="tours"><h2 class="section-title">'.__(lsx_get_post_type_section_title('tour', '', 'Featured Tours'),'lsx-tour-operators').'</h2>',
			'after'			=>	'</section>'
		);
		lsx_connected_panel_query($args);
	}
}

/**
 * Outputs the destinations attached activites
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_tour_destination_activities(){
	global $lsx_archive;
	if(post_type_exists('activity') && is_singular('destination') && !lsx_item_has_children(get_the_ID(),'destination')){
		$args = array(
			'from'			=>	'activity',
			'to'			=>	'destination',
			'content_part'	=>	'widget-activity',
			'column'		=>	'4',				
			'before'		=>	'<section id="activities"><h2 class="section-title">'.__(lsx_get_post_type_section_title('activity', '', 'Featured Activities'),'lsx-tour-operators').'</h2>',
			'after'			=>	'</section>',
		);
		lsx_connected_panel_query($args);
	}
}

/**
 * Outputs the destinations attached activites
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	destination
 */
function lsx_has_destination_banner_map(){
	$temp = get_option('_lsx_lsx-settings',false);
	if(false !== $temp && isset($temp['destination']) && !empty($temp['destination'])){
		if(isset($temp['destination']['enable_banner_map'])){
			return true;
		}else{
			return false;
		}			
	}
}


/* ================  TEAM =========================== */
/**
 * Outputs the current team members role, must be used in a loop.
 * 
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_tour_team_role($before="",$after="",$echo=true){
	lsx_custom_field_query('role',$before,$after,$echo);
}

/**
 * Outputs the current team members role, must be used in a loop.
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_tour_team_contact_number($before="",$after="",$echo=true){
	$contact_number = get_post_meta(get_the_ID(),'contact_number',true);
	if(false !== $contact_number && '' !== $contact_number){
		$contact_html = $before.'<a href="tel:+'.$contact_number.'">'.$contact_number.'</a>'.$after;
		if($echo){
			echo wp_kses_post( $contact_html );
		}else{
			return $contact_html;
		}
	}
}

/**
 * Outputs the current team members role, must be used in a loop.
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_tour_team_contact_email($before="",$after="",$echo=true){
	$contact_email = get_post_meta(get_the_ID(),'contact_email',true);
	if(false !== $contact_email && '' !== $contact_email){
		$contact_html = $before.'<a href="mailto:'.$contact_email.'">'.$contact_email.'</a>'.$after;
		if($echo){
			echo wp_kses_post( $contact_html );
		}else{
			return $contact_html;
		}
	}
}

/**
 * Outputs the current team members social profiles, must be used in a loop.
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_tour_team_social_profiles($before="",$after="",$echo=true){
	$social_profiles = array('facebook','twitter','googleplus','linkedin','pinterest','skype');
	$social_profile_html = false;
	foreach($social_profiles as $meta_key){
		$meta_value = get_post_meta(get_the_ID(),$meta_key,true);
		if(false !== $meta_value && '' !== $meta_value){
			$icon_class = '';
			switch($meta_key){
				case 'facebook':
					$icon_class = 'facebook';
				break;
				
				case 'twitter':
					$icon_class = 'twitter';
				break;
				
				case 'googleplus':
					$icon_class = 'googleplus';
				break;
				
				case 'linkedin':
					$icon_class = 'linkedin-alt';
				break;
				
				case 'pinterest':
					$icon_class = 'pinterest-alt';
				break;							
				
				default:
				break;
			}
			$social_profile_html .= '<a target="_blank" href="'.$meta_value.'"><span class="genericon genericon-'.$icon_class.'"></span></a>';
		}
	}
	if(false !== $social_profile_html && '' !== $social_profile_html){
		$social_profile_html = $before.$social_profile_html.$after;
		if($echo){
			echo wp_kses_post( $social_profile_html );
		}else{
			return $social_profile_html;
		}
	}
}

/**
 * Gets the current teams tagline
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_tour_team_tagline($before="",$after="",$echo=true){
	lsx_tour_tagline($before,$after,$echo);
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	specials
 */
function lsx_tour_special_tagline($before="",$after="",$echo=true){
	lsx_tour_tagline($before,$after,$echo);
}

/**
 * Gets the current specials terms and conditions
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	specials
 */
function lsx_specials_terms_conditions($before="",$after="",$echo=true){
	lsx_custom_field_query('terms_conditions',$before,$after,$echo);
}


/**
 * Outputs the specials validity
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	specials
 */
function lsx_specials_validity($before="",$after="",$echo=true){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	specials
 */
function lsx_travel_dates($before="",$after="",$echo=true){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_enquire_modal($before="",$after="",$echo=true){ 
	global $lsx_tour_operators;

	$form_id = 'false';
	// First set the general form
	if(isset($lsx_tour_operators->options['general']) && isset($lsx_tour_operators->options['general']['enquiry']) && '' !== $lsx_tour_operators->options['general']['enquiry']){
		$form_id = $lsx_tour_operators->options['general']['enquiry'];
	}

	if(is_singular($lsx_tour_operators->active_post_types)){		
		if(isset($lsx_tour_operators->options[get_post_type()]) && isset($lsx_tour_operators->options[get_post_type()]['enquiry']) && '' !== $lsx_tour_operators->options[get_post_type()]['enquiry']){
			$form_id = $lsx_tour_operators->options[get_post_type()]['enquiry'];
		}
	}

	$disable_modal = false;
	$link = '#';

	if(isset($lsx_tour_operators->options['general']) && isset($lsx_tour_operators->options['general']['disable_enquire_modal']) && 'on' === $lsx_tour_operators->options['general']['disable_enquire_modal']){
		$disable_modal = true;

		if('' !== $lsx_tour_operators->options['general']['enquire_link']){
			$link = $lsx_tour_operators->options['general']['enquire_link'];
		}
	}

	if(is_singular($lsx_tour_operators->active_post_types)){		
		if(isset($lsx_tour_operators->options[get_post_type()]) && isset($lsx_tour_operators->options[get_post_type()]['disable_enquire_modal']) && 'on' === $lsx_tour_operators->options[get_post_type()]['disable_enquire_modal']){
			$disable_modal = true;

			if('' !== $lsx_tour_operators->options[get_post_type()]['enquire_link']){
				$link = $lsx_tour_operators->options[get_post_type()]['enquire_link'];
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

/**
 * Checks if the current item has a map
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	general
 */
function lsx_has_map(){
	// Get any existing copy of our transient data
	if ( false === ( $location = get_transient( get_the_ID().'_location' ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		
		$kml = false;

		if(is_post_type_archive('destination')){
			$location = array('lat'=>true);
		}elseif(is_singular('tour')){


			$file_id = get_post_meta(get_the_ID(),'itinerary_kml',true);
			if(false !== $file_id){
				$kml = wp_get_attachment_url( $file_id );
			}
			$location = false;

			$accommodation_connected = get_post_meta(get_the_ID(),'accommodation_to_tour');
			if(is_array($accommodation_connected) && !empty($accommodation_connected)){
				$location = array('lat'=>true,'connections'=>$accommodation_connected);
			}
			
		}else{
			$location = get_post_meta(get_the_ID(),'location',true);
		}

		if(false !== $location && '' !== $location && is_array($location) && isset($location['lat']) && '' !== $location['lat']){
				set_transient( get_the_ID().'_location', $location, 30 );
				return true;
		}elseif(false !== $kml){
				set_transient( get_the_ID().'_location', array('kml'=>$kml), 30 );
				return true;
		}else{
			return false;
		}

	}elseif(is_array($location) && ((isset($location['lat']) && '' !== $location['lat']) || (isset($location['kml']) && '' !== $location['kml']))){
		return true;
	}else{

		return false;

	}
}

/**
 * Outputs the current destination map
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_map($before="",$after="",$echo=true){
	global $lsx_tour_operators;
	if ( false !== ( $location = get_transient( get_the_ID().'_location' ) ) ) {
		$zoom = 15;
		if(is_array($location) && isset($location['zoom'])){$zoom = $location['zoom']; }
		
		$zoom = apply_filters('lsx_map_zoom',$zoom);
			
		if(is_post_type_archive('destination')){

			if(is_post_type_archive('destination')){
					$region_args = array(
							'post_type'	=>	'destination',
							'post_status' => 'publish',
							'nopagin' => true,
							'posts_per_page' => '-1',
							//'post_parent__not_in' => array(0),
							'fields' => 'ids'
					);
					$regions = new WP_Query($region_args);

					if(isset($regions->posts) && !empty($regions->posts)){
						$connections = $regions->posts;
					}	
					if(lsx_has_destination_banner_map()) {
						$args['selector'] = '#lsx-banner .page-banner';		
					}

					$args['content'] = 'excerpt';
			}/*else{
				if(lsx_item_has_children(get_the_ID(),'destination')){
					$region_args = array(
							'post_type'	=>	'destination',
							'post_status' => 'publish',
							'nopagin' => true,
							'posts_per_page' => '-1',
							'post_parent' => get_the_ID(),
							'fields' => 'ids'
					);
					$regions = new WP_Query($region_args);
					if(isset($regions->posts) && !empty($regions->posts)){
						$connections = $regions->posts;
					}

				}else{
					$tours = get_post_meta(get_the_ID(),'tour_to_destination',false);
					if(false !== $tours && !empty($tours)){
						$connections = $tours;
					}
				}				
			}*/

			if(false !== $connections && '' !== $connections){
				$args['connections'] = $connections;
				$args['type'] = 'cluster';
			}
		}elseif(is_singular('tour')){

			$args = array(
					'zoom' => $zoom,
					'width' => '100%',
					'height' => '500px',
					'type' => 'route'
			);			
			if(isset($location['kml'])){
				$args['kml'] = $location['kml'];
			}elseif(isset($location['connections'])){
				$args['connections'] = $location['connections'];
			}
		}else{
			$args = array(
					'long' => $location['long'],
					'lat' => $location['lat'],
					'zoom' => $zoom,
					'search' => $location['address'],
					'width' => '100%',
					'height' => '500px',
			);			
		}
		echo wp_kses_post( $lsx_tour_operators->framework->maps->map_output(get_the_ID(),$args) );
	}
}

/* ================  Taxonomies =========================== */

/**
 * Gets the current connected team member panel
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_term_tagline($term_id=false,$before="",$after="",$echo=true){
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
/* ================  Team =========================== */
/**
 * Gets the current connected team member panel
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_has_team_member() {
	$has_team = false;

	if ( is_tax() ) {
		$has_team = lsx_has_custom_field_query( 'expert', get_queried_object()->term_id, true );
	} else {
		$has_team = lsx_has_custom_field_query( 'team_to_'. get_post_type(), get_the_ID() );
	}

	if ( false === $has_team ) {
		global $lsx_tour_operators;
		$tab = 'team';
		$start_with = 'expert-';
		
		if ( is_object( $lsx_tour_operators ) && isset( $lsx_tour_operators->options[$tab] ) && is_array( $lsx_tour_operators->options[$tab] ) ) {
			foreach ( $lsx_tour_operators->options[$tab] as $key => $value ) {
				if ( substr( $key, 0, strlen( $start_with ) ) === $start_with ) {
					$has_team = true;
					break;
				}
			}
		}
	}
	return $has_team;
}

/**
 * Gets the current connected team member panel
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_team_member_panel($before="",$after=""){
	$team_id = false;

	if ( is_tax() ) {
		$meta_key = 'expert';
		$team_id = get_transient( get_queried_object()->term_id .'_'. $meta_key );
	} else {
		$meta_key = 'team_to_'. get_post_type();
		$team_id = get_transient( get_the_ID() .'_'. $meta_key );
	}

	if ( false === $team_id ) {
		global $lsx_tour_operators;
		$tab = 'team';
		$start_with = 'expert-';
		$team_ids = array();
		
		if ( is_object( $lsx_tour_operators ) && isset( $lsx_tour_operators->options[$tab] ) && is_array( $lsx_tour_operators->options[$tab] ) ) {
			foreach ( $lsx_tour_operators->options[$tab] as $key => $value ) {
				if ( substr( $key, 0, strlen( $start_with ) ) === $start_with ) {
					$team_ids[] = $value;
				}
			}
		}

		if ( count( $team_ids ) > 0 ) {
			$team_id = $team_ids[ array_rand( $team_ids ) ];
		}
	}
	
	if ( false !== $team_id ) {
		$team_args = array(
			'post_type'	=>	'team',
			'post_status' => 'publish',
			'p' => $team_id
		);

		$team = new WP_Query($team_args);

		if ( $team->have_posts() ):
			echo wp_kses_post( $before );
			while($team->have_posts()):
				$team->the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="thumbnail">
						<?php if(!lsx_is_single_disabled()){ ?>
							<a href="<?php the_permalink(); ?>">
						<?php } ?>
							<?php lsx_thumbnail( 'lsx-thumbnail-wide' ); ?>
						<?php if(!lsx_is_single_disabled()){ ?>
							</a>
						<?php } ?>
					</div>

					<h4 class="title">
						<?php if(!lsx_is_single_disabled()){ ?>
							<a href="<?php the_permalink(); ?>">
						<?php } ?>
							<?php the_title(); ?>
						<?php if(!lsx_is_single_disabled()){ ?>
							</a>
						<?php } ?>
					</h4>
					<div class="team-details">
						<?php lsx_tour_team_contact_number('<div class="meta contact-number"><i class="fa fa-phone orange"></i> ','</div>'); ?>
						<?php lsx_tour_team_contact_email('<div class="meta email"><i class="fa fa-envelope orange"></i> ','</div>'); ?> 
					</div>
				</article>
				<?php			
			endwhile;
			
			echo wp_kses_post( $after );
			
			wp_reset_query();
			wp_reset_postdata();
		endif;		
	}
}

/**
 * Outputs the connected accommodation for a team member
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_team_accommodation(){
	global $lsx_archive;
	if(post_type_exists('accommodation') && is_singular('team')) {
		$args = array(
				'from'			=>	'accommodation',
				'to'			=>	'team',
				'column'		=>	'12',
				'before'		=>	'<section id="accommodation"><h2 class="section-title">'.__(lsx_get_post_type_section_title('accommodation', '', 'Featured Accommodations'),'lsx-tour-operators').'</h2>',
				'after'			=>	'</section>'
		);
		lsx_connected_panel_query($args);
	}
}

/**
 * Outputs the connected tour for a team member
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	team
 */
function lsx_team_tours(){
	global $lsx_archive;
	if(post_type_exists('tour') && is_singular('team')) {
		$args = array(
				'from'			=>	'tour',
				'to'			=>	'team',
				'column'		=>	'12',
				'before'		=>	'<section id="tours"><h2 class="section-title">'.__(lsx_get_post_type_section_title('tour', '', 'Featured Tours'),'lsx-tour-operators').'</h2>',
				'after'			=>	'</section>'
		);
		lsx_connected_panel_query($args);
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_connected_accommodation($before="",$after="",$echo=true){
	lsx_connected_items_query('accommodation',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected activities
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_connected_activities($before="",$after="",$echo=true){
	lsx_connected_items_query('activity',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected destinations
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_connected_destinations($before="",$after="",$echo=true){
	lsx_connected_items_query('destination',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected reviews
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_connected_reviews($before="",$after="",$echo=true){
	lsx_connected_items_query('review',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected team member
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_connected_team($before="",$after="",$echo=true){
	lsx_connected_items_query('team',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected tours
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_connected_tours($before="",$after="",$echo=true){
	lsx_connected_items_query('tour',get_post_type(),$before,$after,$echo);
}

/**
 * Gets the current specials connected vehicles
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	connections
 */
function lsx_connected_vehicles($before="",$after="",$echo=true){
	lsx_connected_items_query('vehicle',get_post_type(),$before,$after,$echo);
}



/* ================  REUSED =========================== */

/**
 * Checks if a custom field query exists, and set a transient for it, so we dont have to query it again later.
 *
 * @param		$meta_key	| string
 * @param		$single		| boolean
 * @return		string
 *
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_has_custom_field_query( $meta_key = false, $id = false, $is_tax = false ) {
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_custom_field_query($meta_key=false,$before="",$after="",$echo=false,$post_id=false){
	if(false !== $meta_key){
		//Check to see if we already have a transient set for this.
		// TODO Need to move this to enclose the entire function and change to a !==,  that way you have to set up the custom field via the lsx_has_{custom_field} function
		if(false === $post_id){
			$post_id = get_the_ID();
		}
		
		if ( false === ( $value = get_transient( $post_id.'_'.$meta_key ) ) ) {
			$value = get_post_meta($post_id,$meta_key,true);
		}
		if(false !== $value && '' !== $value){
			$return_html = $before.'<span class="values">'.$value.'</span>'.$after;
			$return = apply_filters('lsx_custom_field_query',$return_html,$meta_key,$value,$before,$after);
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_connected_items_query($from=false,$to=false,$before="",$after="",$echo=false){
	if(post_type_exists($from) && post_type_exists($to)){
		$connected_ids = get_post_meta(get_the_ID(),$from.'_to_'.$to,false);
		if(false !== $connected_ids && '' !== $connected_ids && !empty($connected_ids)){
			if(!is_array($connected_ids)){
				$connected_ids = array($connected_ids);
			}
			$return = $before.lsx_connected_list($connected_ids,$from,true,', ').$after;
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_connected_panel_query($args=false){
	global $lsx_archive;
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
		extract($args);
		$return = false;
		
		if(false === $content_part){$content_part = $from; }
		
		$items_array = get_post_meta(get_the_ID(),$from.'_to_'.$to,false);
		
		if(false !== $items_array && is_array($items_array) && !empty($items_array)){
			$items_query_args = array(
					'post_type'	=>	$from,
					'post_status' => 'publish',
					'post__in' => $items_array
			);
			$items = new WP_Query($items_query_args);
			if ( $items->have_posts() ): 
				$lsx_archive = 1;
				ob_start();
				echo wp_kses_post( $before ).'<div class="row">'; 
				while ( $items->have_posts() ) : $items->the_post();
					echo '<div class="panel col-sm-'.esc_attr($column).'">';
					lsx_tour_operator_content('content',$content_part);
					echo '</div>';
				endwhile;
				echo '</div>'.wp_kses_post( $after );
				$return = ob_get_clean();
				$lsx_archive = 0;
				wp_reset_query();
				wp_reset_postdata();
			endif; // end of the loop. 
		}
		if($echo){
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_related_items($taxonomy=false,$before="",$after="",$echo=true,$post_type=false) {
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

				lsx_tour_operator_content('content','widget-'.get_post_type());

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
				echo '<span class="sr-only">'.esc_html__('Previous','lsx-tour-operators').'</span>';
				echo '</a>';
				echo '<a class="right carousel-control" href="#slider-'.esc_attr($carousel_id).'" role="button" data-slide="next">';
				echo '<span class="fa fa-chevron-right" aria-hidden="true"></span>';
				echo '<span class="sr-only">'.esc_html__('Next','lsx-tour-operators').'</span>';
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_safari_brands($before="",$after="",$echo=true) {
	$args = array(
			'name' => 'Home',
			'id' => 'sidebar-home',
			'description' => '',
			'class' => '',
			'before_widget' => '<aside id="lsx_taxonomy_widget-6" class="widget lsx-widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'lsx_taxonomy_widget-6',
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
	$safari_brands = new LSX_Taxonomy_Widget();
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	helper
 */
function lsx_travel_styles($before="",$after="",$echo=true) {
	$args = array(
			'name' => 'Home',
			'id' => 'sidebar-home',
			'description' => '',
			'class' => '',
			'before_widget' => '<aside id="lsx_taxonomy_widget-6" class="widget lsx-widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'lsx_taxonomy_widget-6',
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
	$travel_styles = new LSX_Taxonomy_Widget();
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
 * @package 	lsx-tour-operators
 * @subpackage	template-tags
 * @category 	gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );
