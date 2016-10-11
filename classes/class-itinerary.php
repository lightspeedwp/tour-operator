<?php
/**
 * Tours Itinerary Query
 *
 * @package   Lsx_Itinerary_Query
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package Lsx_Itinerary_Query
 * @author  LightSpeed
 */
class Lsx_Itinerary_Query {
	
	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object|Lsx_Itinerary_Query
	 */
	public $has_itinerary = false;	
	
	/**
	 * Holds the array of Itineraries
	 *
	 * @since 1.0.0
	 *
	 * @var      array|Lsx_Itinerary_Query
	 */
	public $itineraries = false;	
	
	/**
	 * Holds current itinerary
	 *
	 * @since 1.0.0
	 *
	 * @var      array|Lsx_Itinerary_Query
	 */
	public $itinerary = false;	
	
	/**
	 * The Number of Itinerary Items
	 *
	 * @since 1.0.0
	 *
	 * @var      array|Lsx_Itinerary_Query
	 */
	public $count = 0;
	
	/**
	 * The Current Itinerary Index
	 *
	 * @since 1.0.0
	 *
	 * @var      array|Lsx_Itinerary_Query
	 */
	public $index = 0;	
	
	/**
	 * Holds the current post_id
	 *
	 * @since 1.0.0
	 *
	 * @var      string|Lsx_Itinerary_Query
	 */
	public $post_id = false;	

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->post_id = get_the_ID();
		$this->itineraries = get_post_meta($this->post_id,'itinerary',false);
		if(is_array($this->itineraries) && !empty($this->itineraries)){
			$this->has_itinerary = true;
			$this->count = count($this->itineraries);
		}		
	}
	
	/**
	 * A filter to set the content area to a small column on single
	 */
	public function has_itinerary( ) {
		return $this->has_itinerary;
	}
	
	/**
	 * Used in the While loop to cycle through the field array
	 */	
	public function while_itinerary() {
		if($this->index < $this->count){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Sets the current itinerary item
	 */	
	public function current_itinerary_item() {
		$this->itinerary = $this->itineraries[$this->index];
		$this->index++;
	}
	
	/**
	 * Sets the current itinerary item
	 */
	public function reset_loop() {
		$this->index = 0;
	}
	
}
/**
 * Checks if the current tour has an itinerary
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_has_itinerary() {
	global $tour_itinerary;
	$has_itinerary = false;
	if(null === $tour_itinerary){
		$tour_itinerary = new Lsx_Itinerary_Query();
	}
	if(is_object($tour_itinerary)){
		$has_itinerary = $tour_itinerary->has_itinerary();
	}
	return $has_itinerary;
}

/**
 * Runs the current itinerary loop, used in a "while" statement
 * 
 * e.g  while(to_itinerary_loop()) {to_itinerary_loop_item();}
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_loop() {
	global $tour_itinerary;
	if(is_object($tour_itinerary)){
		return $tour_itinerary->while_itinerary();
	}else{
		return false;
	}
}

/**
 * Sets up the current itinerary itinerary
 * 
 * e.g  while(to_itinerary_loop()) {to_itinerary_loop_item();}
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_loop_item() {
	global $tour_itinerary;
	if(is_object($tour_itinerary)){
		$tour_itinerary->current_itinerary_item();
	}
}

/**
 * resets the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_loop_reset() {
	global $tour_itinerary;
	if(is_object($tour_itinerary)){
		$tour_itinerary->reset_loop();
	}
}

/**
 * Outputs The current Itinerary title, can only be used in the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_title() {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(false !== $tour_itinerary->itinerary['title']){
			$title = apply_filters('the_title',$tour_itinerary->itinerary['title']);
			echo wp_kses_post($title);
		}
	}
}

/**
 * Outputs The current Itinerary slug, can only be used in the itinerary loop as an ID.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_slug() {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(false !== $tour_itinerary->itinerary['title']){
			echo wp_kses_post(sanitize_title($tour_itinerary->itinerary['title']));
		}
	}
}

/**
 * Outputs The current Itinerary Tagline, can only be used in the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_tagline() {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(false !== $tour_itinerary->itinerary['tagline']){
			echo wp_kses_post(apply_filters('the_title',$tour_itinerary->itinerary['tagline']));
		}
	}
}

/**
 * Outputs The current Itinerary description, can only be used in the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_description() {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(false !== $tour_itinerary->itinerary['description']){
			echo wp_kses_post(apply_filters('the_content',$tour_itinerary->itinerary['description']));
		}
	}
}
/**
 * Checks if the current itinerary item has a thumbnail.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_has_thumbnail() {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary) {
		return true;
	}
}
/**
 * Outputs The current Itinerary thumbnail, can only be used in the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_thumbnail() {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		$thumbnail_src = false;

		if(false !== $tour_itinerary->itinerary['featured_image'] && '' !== $tour_itinerary->itinerary['featured_image']){
			$thumbnail = wp_get_attachment_image_src($tour_itinerary->itinerary['featured_image'],'lsx-thumbnail-wide');
			if(is_array($thumbnail)){
				$thumbnail_src = $thumbnail[0];
			}
		}elseif(isset($tour_itinerary->itinerary['accommodation_to_tour']) && !empty($tour_itinerary->itinerary['accommodation_to_tour'])){
			$accommodation_images = false;
			foreach($tour_itinerary->itinerary['accommodation_to_tour'] as $accommodation_id){
				$temp_id = get_post_thumbnail_id( $accommodation_id );
				if(false !== $temp_id){
					$temp_src_array = wp_get_attachment_image_src($temp_id,'lsx-thumbnail-wide');
					if(is_array($temp_src_array)){
						$accommodation_images[] = $temp_src_array[0];
					}
				}
			}
			if(false !== $accommodation_images){
				$thumbnail_src = $accommodation_images[0];
			}
		}
		if(false === $thumbnail_src || '' === $thumbnail_src){
			$thumbnail_src = TO_Placeholders::placeholder_url(null,'tour');
		}
		echo wp_kses_post(apply_filters( 'to_lazyload_filter_images', '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="'.$thumbnail_src.'" />' ));
	}
}

/**
 * Outputs The current Itinerary connected destinations, can only be used in the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_destinations($before='',$after='') {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(is_array($tour_itinerary->itinerary['destination_to_tour']) && !empty($tour_itinerary->itinerary['destination_to_tour'])){
			echo wp_kses_post($before.to_connected_list($tour_itinerary->itinerary['destination_to_tour'],'destination',true,', ').$after);
		}
	}	
}

/**
 * Outputs The current Itinerary connected accommodation, can only be used in the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_accommodation($before='',$after='') {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(is_array($tour_itinerary->itinerary['accommodation_to_tour']) && !empty($tour_itinerary->itinerary['accommodation_to_tour'])){
			echo wp_kses_post($before.to_connected_list($tour_itinerary->itinerary['accommodation_to_tour'],'accommodation',true,', ').$after);
		}

		//display the additional accommodation information.
		foreach($tour_itinerary->itinerary['accommodation_to_tour'] as $accommodation){
			to_accommodation_rating('<div class="meta rating">'.__('Rating','tour-operator').': ','</div>',$accommodation);
			the_terms( $accommodation, 'accommodation-type', '<div class="meta accommodation-type">'.__('Type','tour-operator').': ', ', ', '</div>' );
			to_accommodation_special_interests('<div class="meta special_interests">'.__('Special Interests','tour-operator').': <span>','</span></div>',$accommodation);
		}
	}
}

/**
 * Outputs The current Itinerary connected activities, can only be used in the itinerary loop.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_activities($before='',$after='') {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(isset($tour_itinerary->itinerary['activity_to_tour']) && is_array($tour_itinerary->itinerary['activity_to_tour']) && !empty($tour_itinerary->itinerary['activity_to_tour'])){
			echo wp_kses_post($before.to_connected_list($tour_itinerary->itinerary['activity_to_tour'],'activity',true,', ').$after);
		}
	}
}

/**
 * Outputs the 'itinerary' class.
 *
 * @param	$classes string or array
 *  
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_class($classes = false) {
	global $post;

	if(false !== $classes){
		if(!is_array($classes)) {
			$classes = explode(' ',$classes);
		}
		$classes = apply_filters( 'to_itinerary_class', $classes, $post->ID );
	}
	echo 'class="'.esc_attr(implode(' ',$classes)).'"';
}


/**
 * Outputs the 'read more' button if needed.
 *  
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_read_more(){
	if(to_itinerary_needs_read_more($label=__('Read More','tour-operator'))){ ?>
		<div class="view-more aligncenter">
			<a href="#" class="btn"><?php echo esc_html_e($label,'tour-operator'); ?></a>
		</div>		
	<?php
	}
}

/**
 * checks if the read more should be outputted
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function to_itinerary_needs_read_more(){
	return apply_filters('to_itinerary_needs_read_more',false);
}