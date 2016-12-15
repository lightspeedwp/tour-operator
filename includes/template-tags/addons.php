<?php
/**
 * Template Tags
 *
 * @package   		tour-operator
 * @subpackage 		template-tags
 * @category 		helpers
 * @license   		GPL3
 */

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
function lsx_to_connected_reviews($before="",$after="",$echo=true){
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
function lsx_to_connected_team($before="",$after="",$echo=true){
	to_connected_items_query('team',get_post_type(),$before,$after,$echo);
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
function lsx_to_connected_vehicles($before="",$after="",$echo=true){
	to_connected_items_query('vehicle',get_post_type(),$before,$after,$echo);
}