<?php

/**
 * Template Tags for the LSX Framework
*
* @package   lsx-framework
* @author    LightSpeed
* @license   GPL3
* @link
* @copyright 2016 LightSpeed
*/

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
	echo 'class="'.implode(' ',$classes).'"';
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
	echo 'class="'.implode(' ',$classes).'"';
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