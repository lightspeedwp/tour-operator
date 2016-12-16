<?php
/**
 * Tours Unit Query
 *
 * @package   LSX_TO_Unit_Query
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */


/**
 * Main plugin class.
 *
 * @package LSX_TO_Unit_Query
 * @author  LightSpeed
 */
class LSX_TO_Unit_Query {
	
	/**
	 * Holds class instance
	 *
	 * @since 1.0.0
	 *
	 * @var      object
	 */
	public $have_query = false;	
	
	/**
	 * Holds the array of items
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $queried_items = false;	

	/**
	 * Holds the array of section titles
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $titles = false;	
	
	/**
	 * Holds current queried item
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $query_item = false;	
	
	/**
	 * The Number of Queried Items
	 *
	 * @since 1.0.0
	 *
	 * @var      array
	 */
	public $count = 0;
	
	/**
	 * The Current Query Index
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
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct($type = false) {
		$this->post_id = get_the_ID();
		$this->queried_items = get_post_meta($this->post_id,'units',false);
		if(is_array($this->queried_items) && !empty($this->queried_items)){
			$this->have_query = true;
			$this->count = count($this->queried_items);

			foreach($this->queried_items as $item){
				$this->titles[$item['type']] = 1;
			}
		}	
	}
	
	/**
	 * A filter to set the content area to a small column on single
	 */
	public function have_query() {
		return $this->have_query;
	}
	
	/**
	 * Used in the While loop to cycle through the field array
	 */	
	public function while_query() {
		if($this->index < $this->count){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Sets the current itinerary item
	 */	
	public function current_queried_item($type=false) {
		$return = false;
		if(false === $type || $type === $this->queried_items[$this->index]['type']){
			$this->query_item = $this->queried_items[$this->index];
			$return = true;
		}
		$this->index++;
		return $return;
	}
	
	/**
	 * Sets the current itinerary item
	 */
	public function reset_loop() {
		$this->index = 0;
	}

	/**
	 * Checks if the current type provided exists
	 */
	public function check_type($type = false) {
		if(false !== $type && false !== $this->titles && isset($this->titles[$type])){
			return true;
		}else{
			return false;
		}
	}	
	
	/**
	 * Outputs the current items "title" field
	 */
	public function item_title($before="",$after="",$echo=false) {
		if($this->have_query && false !== $this->query_item) {
			if(false !== $this->query_item['title']){
				$return = $before.apply_filters('the_title',$this->query_item['title']).$after;
				if($echo){
					echo wp_kses_post( $return );
				}else{
					return $return;
				}
			}
		}
	}
	
	/**
	 * Outputs the current items "description" field
	 */
	public function item_description($before="",$after="",$echo=false) {
		if($this->have_query && false !== $this->query_item) {
			if(false !== $this->query_item['description']){
				$return = $before.apply_filters('the_content',$this->query_item['description']).$after;
				if($echo){
					echo wp_kses_post( $return );
				}else{
					return $return;
				}				
			}
		}
	}
	
	/**
	 * Outputs the current items "description" field
	 */
	public function item_thumbnail($before="",$after="",$echo=false) {
		if($this->have_query && false !== $this->query_item) {
			$thumbnail_src = false;
			$thumbnail_src = apply_filters('lsx_to_accommodation_room_thumbnail',$thumbnail_src);
			if(false !== $this->query_item['gallery']){
				$images = array_values($this->query_item['gallery']);
				$thumbnail = wp_get_attachment_image_src($images[0],'lsx-thumbnail-wide');
				if(is_array($thumbnail)){
					$thumbnail_src = $thumbnail[0];
				}
			}
			if(false === $thumbnail_src || '' === $thumbnail_src){
				$thumbnail_src = LSX_TO_Placeholders::placeholder_url(null,'accommodation');
			}			
			if(false !== $thumbnail_src){
				$return = $before.apply_filters( 'lsx_to_lazyload_filter_images', '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="'.$thumbnail_src.'" />' ).$after;
				if($echo){
					echo wp_kses_post( $return );
				}else{
					return $return;
				}				
			}
		}
	}	
}
/**
 * Checks if the current accommodation has rooms
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_to_accommodation_has_rooms() {
	global $rooms;
	$have_rooms = false;
	if(null === $rooms){
		$rooms = new LSX_TO_Unit_Query();
	}
	if(is_object($rooms)){
		$have_rooms = $rooms->have_query();
	}
	return $have_rooms;
}

/**
 * Runs the current room loop, used in a "while" statement
 *
 * e.g  while(lsx_to_accommodation_room_loop()) {lsx_to_accommodation_room_loop_item();}
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_room_loop() {
	global $rooms;
	if(is_object($rooms)){
		return $rooms->while_query();
	}else{
		return false;
	}
}

/**
 * Sets up the current room
 *
 * e.g  while(lsx_to_accommodation_room_loop()) {lsx_to_accommodation_room_loop_item();}
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_room_loop_item($type=false) {
	global $rooms;
	if(is_object($rooms)){
		return $rooms->current_queried_item($type);
	}else{
		return false;
	}
}

/**
 * Outputs The current Rooms title
 * 
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_room_title($before="",$after="",$echo=true) {
	global $rooms;
	if(is_object($rooms)){
		$rooms->item_title($before,$after,$echo);	
	}
}
/**
 * Outputs The current Rooms Description
 *
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_room_description($before="",$after="",$echo=true) {
	global $rooms;
	if(is_object($rooms)){
		$rooms->item_description($before,$after,$echo);
	}
}

/**
 * Checks if the current room item has a thumbnail.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_room_has_thumbnail() {
	global $rooms;
	if($rooms && $rooms->have_query) {
		return true;
	}
}
/**
 * Outputs The current Room thumbnail
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_room_thumbnail($before="",$after="",$echo=true) {
	global $rooms;
	if(is_object($rooms)){
		$rooms->item_thumbnail($before,$after,$echo);
	}
}

/**
 * Checks if the current type has units.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_check_type($type=false) {
	global $rooms;
	return $rooms->check_type($type);
}

/**
 * Resets the loop
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	room
 */
function lsx_to_accommodation_reset_units_loop() {
	global $rooms;
	return $rooms->reset_loop();
}

/**
 * Outputs various units attached to the accommodation
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	unit
 */
function lsx_to_accommodation_units($before="",$after=""){
	global $rooms;

	if(lsx_to_accommodation_has_rooms()) { 

		$unit_types = array(
			'chalet' => esc_html__('Chalet','tour-operator'),
			'room' => esc_html__('Room','tour-operator'),
			'spa' => esc_html__('Spa','tour-operator'),
			'tent' => esc_html__('Tent','tour-operator'),
			'villa' => esc_html__('Villa','tour-operator')
		);
		foreach($unit_types as $type_key => $type_label){
			if(lsx_to_accommodation_check_type($type_key)){
			?>
				<section id="<?php echo esc_attr( $type_key ); ?>s">
					<h2 class="section-title"><?php esc_html_e(lsx_to_get_post_type_section_title('accommodation', $type_key.'s', $type_label.'s'),'tour-operator');?></h2>
					<div class="<?php echo esc_attr( $type_key ); ?>s-content rooms-content row">		
					<?php while(lsx_to_accommodation_room_loop()){ ?>

						<?php if(!lsx_to_accommodation_room_loop_item($type_key)) { continue; } ?>
							
						<div class="panel col-sm-6">
							<article class="unit type-unit">
								<div class="col-sm-4">
									<?php if(lsx_to_accommodation_room_has_thumbnail()) { ?>
										<div class="thumbnail">
											<?php lsx_to_accommodation_room_thumbnail(); ?>
										</div>							
									<?php } ?>	
								</div>
								<div class="col-sm-8">					
									<div class="unit-info">
										<?php lsx_to_accommodation_room_title('<h3>','</h3>'); ?>
										<?php lsx_to_accommodation_room_description('<div class="entry-content">','</div>'); ?>
									</div>
								</div>
							</article>
						</div>						
							
					<?php } lsx_to_accommodation_reset_units_loop(); ?>
					</div>
				</section>
		<?php }
		}
	}
}
