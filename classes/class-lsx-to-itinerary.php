<?php
/**
 * Tours Itinerary Query
 *
 * @package   LSX_TO_Itinerary_Query
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Main plugin class.
 *
 * @package LSX_TO_Itinerary_Query
 * @author  LightSpeed
 */
class LSX_TO_Itinerary_Query {
	
	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object
	 */
	public $has_itinerary = false;	
	
	/**
	 * Holds the array of Itineraries
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $itineraries = false;	
	
	/**
	 * Holds current itinerary
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $itinerary = false;	
	
	/**
	 * The Number of Itinerary Items
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $count = 0;
	
	/**
	 * The Current Itinerary Index
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $index = 0;	
	
	/**
	 * Holds the current post_id
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $post_id = false;

	/**
	 * Holds the an array of gallery ids from each accommodations attached to the itinerary.
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $current_attachments = array();

	/**
	 * Holds the an array of attachment ids
	 *
	 * @since 1.0.0
	 *
	 * @var      string
	 */
	public $images_used = array();

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
	 * Pulls the current days accommodation and saves them for use incase an image has already been displayed.
     *
     * @param   $accommodation_id   | string
	 */
	public function register_current_gallery($accommodation_id = false) {
	    if(false !== $accommodation_id) {
            $gallery = get_post_meta($accommodation_id,'gallery',false);
            if(false !== $gallery && !empty($gallery)){
                $this->current_attachments[$accommodation_id] = $gallery;
            }
		}
	}

	/**
	 * Save the id of the images that have already been displayed.
     *
     * @param   $image_id   | string
	 */
	public function save_used_image($image_id = false) {
		if(false !== $image_id) {
            $this->images_used[] = $image_id;
		}
	}

	/**
	 * Check if the current image has been displayed already
	 *
	 * @param   $image_id   | string
     * @return  boolean
	 */
	public function is_image_used($image_id = false) {
		if(is_array($this->images_used) && in_array($image_id,$this->images_used)) {
			return true;
		}else{
		    return false;
        }
	}

	/**
	 * Finds another image from the accommodation gallery that hasnt been used.
	 *
     * @param   $accommodation_id   | string
	 * @return  boolean | string
	 */
	public function find_next_image($accommodation_id = false) {
	    $return = false;


	    if(false !== $accommodation_id && isset($this->current_attachments[$accommodation_id]) && !empty($this->current_attachments[$accommodation_id]) && !empty($this->images_used)){
			$images_left = array_diff($this->current_attachments[$accommodation_id],$this->images_used);
			if(is_array($images_left) && !empty($images_left)){
				$images_left = array_values($images_left);
			    $return = array_shift($images_left);
            }
        }
        return $return;
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
function lsx_to_has_itinerary() {
	global $tour_itinerary;
	$has_itinerary = false;
	if(null === $tour_itinerary){
		$tour_itinerary = new LSX_TO_Itinerary_Query();
	}
	if(is_object($tour_itinerary)){
		$has_itinerary = $tour_itinerary->has_itinerary();
	}
	return $has_itinerary;
}

/**
 * Runs the current itinerary loop, used in a "while" statement
 *
 * e.g  while(lsx_to_itinerary_loop()) {lsx_to_itinerary_loop_item();}
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function lsx_to_itinerary_loop() {
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
 * e.g  while(lsx_to_itinerary_loop()) {lsx_to_itinerary_loop_item();}
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	itinerary
 */
function lsx_to_itinerary_loop_item() {
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
function lsx_to_itinerary_loop_reset() {
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
function lsx_to_itinerary_title() {
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
function lsx_to_itinerary_slug() {
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
function lsx_to_itinerary_tagline() {
	global $tour_itinerary;
	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		if(isset($tour_itinerary->itinerary['tagline']) && false !== $tour_itinerary->itinerary['tagline']){
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
function lsx_to_itinerary_description() {
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
function lsx_to_itinerary_has_thumbnail() {
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

function lsx_to_itinerary_thumbnail() {
	global $tour_itinerary;

	if($tour_itinerary && $tour_itinerary->has_itinerary && false !== $tour_itinerary->itinerary) {
		$thumbnail_src = false;

		if(false !== $tour_itinerary->itinerary['featured_image'] && '' !== $tour_itinerary->itinerary['featured_image']){
			$tour_itinerary->save_used_image($tour_itinerary->itinerary['featured_image']);
			$thumbnail = wp_get_attachment_image_src($tour_itinerary->itinerary['featured_image'],'lsx-thumbnail-wide');
			if(is_array($thumbnail)){
				$thumbnail_src = $thumbnail[0];
			}
		}elseif(isset($tour_itinerary->itinerary['accommodation_to_tour']) && !empty($tour_itinerary->itinerary['accommodation_to_tour'])){
			$accommodation_images = false;

			foreach($tour_itinerary->itinerary['accommodation_to_tour'] as $accommodation_id){
				$tour_itinerary->register_current_gallery($accommodation_id);
                $current_image_id = false;

				//Try for a thumbnail first.
				$temp_id = get_post_thumbnail_id( $accommodation_id );
				if(false === $temp_id || $tour_itinerary->is_image_used($temp_id)){
					$current_image_id = $tour_itinerary->find_next_image($accommodation_id);
				}else{
					$current_image_id = $temp_id;
                }

                if(false !== $current_image_id) {
				    $tour_itinerary->save_used_image($current_image_id);
					$temp_src_array = wp_get_attachment_image_src($current_image_id, 'lsx-thumbnail-wide');
					if (is_array($temp_src_array)) {
						$accommodation_images[] = $temp_src_array[0];
					}
				}
			}

			if(false !== $accommodation_images){
				$thumbnail_src = $accommodation_images[0];
			}
		}

		$thumbnail_src = apply_filters('lsx_to_itinerary_thumbnail_src',$thumbnail_src,$tour_itinerary->index,$tour_itinerary->count);

		//Check weather or not to display the placeholder.
		if(false === $thumbnail_src || '' === $thumbnail_src){
			$thumbnail_src = LSX_TO_Placeholders::placeholder_url(null,'tour');
		}
		echo wp_kses_post(apply_filters( 'lsx_to_lazyload_filter_images', '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="'.$thumbnail_src.'" />' ));
	}
}
