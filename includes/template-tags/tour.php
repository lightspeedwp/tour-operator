<?php
/**
 * Template Tags
 *
 * @package   		tour-operator
 * @subpackage 		template-tags
 * @category 		tour
 * @license   		GPL3
 */

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
function lsx_to_price($before="",$after="",$echo=true){
	lsx_to_custom_field_query('price',$before,$after,$echo);
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
function lsx_to_duration($before="",$after="",$echo=true){
	lsx_to_custom_field_query('duration',$before,$after,$echo);
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
function lsx_to_included($before="",$after="",$echo=true){
	return lsx_to_custom_field_query('included',$before,$after,$echo);
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
function lsx_to_not_included($before="",$after="",$echo=true){
	return lsx_to_custom_field_query('not_included',$before,$after,$echo);
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
function lsx_to_departure_point($before="",$after="",$echo=true){
	$departs_from = get_post_meta(get_the_ID(),'departs_from',false);
	if(false !== $departs_from && '' !== $departs_from){
		if(!is_array($departs_from)){
			$departs_from = array($departs_from);
		}
		$return = $before.lsx_to_connected_list($departs_from,'destination',true,', ').$after;
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
function lsx_to_end_point($before="",$after="",$echo=true){
	$end_point = get_post_meta(get_the_ID(),'ends_in',false);
	if(false !== $end_point && '' !== $end_point){
		if(!is_array($end_point)){
			$end_point = array($end_point);
		}
		$return = $before.lsx_to_connected_list($end_point,'destination',true,', ').$after;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}
}

/**
 * Outputs the tours included / not included block
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	tour
 */
function lsx_to_included_block(){

	$tour_included = lsx_to_included('','',false);
	$tour_not_included = lsx_to_not_included('','',false);
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
					<h2 class="section-title"><?php esc_html_e('Not Included','tour-operator'); ?></h2>
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
function lsx_to_highlights($before="",$after="",$echo=true){
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
function lsx_to_best_time_to_visit($before="",$after="",$echo=true){
	$best_time_to_visit = get_post_meta(get_the_ID(),'best_time_to_visit',true);
	if(false !== $best_time_to_visit && '' !== $best_time_to_visit && is_array($best_time_to_visit) && !empty($best_time_to_visit)){
		
		$this_year = array(
			'january' => esc_html__('January','tour-operator'),
			'february' => esc_html__('February','tour-operator'),
			'march' => esc_html__('March','tour-operator'),
			'april' => esc_html__('April','tour-operator'),
			'may' => esc_html__('May','tour-operator'),
			'june' => esc_html__('June','tour-operator'),
			'july' => esc_html__('July','tour-operator'),
			'august' => esc_html__('August','tour-operator'),
			'september' => esc_html__('September','tour-operator'),
			'october' => esc_html__('October','tour-operator'),
			'november' => esc_html__('November','tour-operator'),
			'december' => esc_html__('December','tour-operator')
		);

		foreach($this_year as $month => $label){
			$checked = '';
			if(in_array($month,$best_time_to_visit)){
				$checked = '<i class="fa fa-check" aria-hidden="true"></i>';
			}
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
function lsx_to_connected_tours($before="",$after="",$echo=true){
	lsx_to_connected_items_query('tour',get_post_type(),$before,$after,$echo);
}