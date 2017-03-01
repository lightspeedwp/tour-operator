<?php
/**
 * Template Tags
 *
 * @package   		tour-operator
 * @subpackage 		template-tags
 * @category 		helpers
 * @license   		GPL3
 */

/* ================== CONDITIONAL ================== */

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
function lsx_to_is_single_disabled($post_type=false){
	global $tour_operator;
	if(false === $post_type) {
		$post_type = get_post_type();
	}
	if(is_object($tour_operator) && isset($tour_operator->options[$post_type]) && isset($tour_operator->options[$post_type]['disable_single'])){
		return true;
	}else{
		return false;
	}
}

/**
 * Output the envira gallery in the 
 *
 * @package 	lsx-framework
 * @subpackage	hook
 * @category 	modal
 */
function lsx_to_enable_envira_banner(){
	global $tour_operator;
	if(isset($tour_operator->options) && isset($tour_operator->options['display']) && isset($tour_operator->options['display']['enable_galleries_in_banner'])){
		return true;
	}else{
		return false;
	}
}

/**
 * Checks weather or not the conencted tours should display.
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	accommodation
 */
function lsx_to_accommodation_display_connected_tours(){
	global $tour_operator;
	$return = false;
	if(isset($tour_operator->options['accommodation']['display_connected_tours']) && 'on' === $tour_operator->options['accommodation']['display_connected_tours']){
		$return = true;
	}
	return $return;
 }

/**
 * Check if the current item has child pages or if its a parent ""
 *
 * @param	$post_id string
 * @param	$post_type string
 */
function lsx_to_item_has_children($post_id = false,$post_type = false) {
	global $wpdb;
	if(false == $post_id){
		return false;
	}
	if(false == $post_type){
		$post_type = 'page';
	}
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


/* ==================   HOOKED   ================== */

/**
 * Return post_type section title from the settings page
 * 
 * @param		$post_type | string
 * @return		string
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function lsx_to_get_post_type_section_title($post_type=false,$section='',$default=''){
	$section_title = (!empty($section)) ? ($section.'_section_title') : 'section_title';
	global $tour_operator;
	if(false === $post_type) {
		$post_type = get_post_type();
	}
	if(is_object($tour_operator) && isset($tour_operator->options[$post_type]) && isset($tour_operator->options[$post_type][$section_title]) && !empty($tour_operator->options[$post_type][$section_title]) && '' !== $tour_operator->options[$post_type][$section_title]){
		return $tour_operator->options[$post_type][$section_title];
	}else{
		return $default;
	}
}

/* ================== TAXONOMY ================== */
/**
 * Checks if the current term has a thumbnail
 *
 * @param	$term_id
 */
if(!function_exists('lsx_to_has_term_thumbnail')){
	function lsx_to_has_term_thumbnail($term_id = false) {
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
if(!function_exists('lsx_to_term_thumbnail')){
	function lsx_to_term_thumbnail($term_id = false,$size='lsx-thumbnail-wide') {
		if(false !== $term_id){
			echo wp_kses_post(lsx_to_get_term_thumbnail($term_id,$size));
		}
	}
}
/**
 * Outputs the current terms thumbnail
 *
 * @param	$term_id string
 */
if(!function_exists('lsx_to_get_term_thumbnail')){
	function lsx_to_get_term_thumbnail($term_id = false,$size='lsx-thumbnail-wide') {
		if(false !== $term_id){
			$term_thumbnail_id = get_term_meta($term_id, 'thumbnail', true);
			$img = wp_get_attachment_image_src($term_thumbnail_id,$size);
			return apply_filters( 'lsx_to_lazyload_filter_images', '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="'.$img[0].'" />' );
		}
	}
}
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
function lsx_to_term_tagline($term_id=false,$before="",$after="",$echo=true){
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

/* ==================   QUERY    ================== */

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
function lsx_to_has_custom_field_query( $meta_key = false, $id = false, $is_tax = false ) {
	if ( false !== $meta_key ) {
		$custom_field = get_transient( $id .'_'. $meta_key );
		if ( false === $custom_field ) {
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
function lsx_to_custom_field_query($meta_key=false,$before="",$after="",$echo=false,$post_id=false){
	if(false !== $meta_key){
		//Check to see if we already have a transient set for this.
		// TODO Need to move this to enclose the entire function and change to a !==,  that way you have to set up the custom field via the lsx_to_has_{custom_field} function
		if(false === $post_id){
			$post_id = get_the_ID();
		}
		$value = get_transient( $post_id.'_'.$meta_key );
		if ( false === $value ) {
			$value = get_post_meta($post_id,$meta_key,true);
		}
		if(false !== $value && '' !== $value){
			$return_html = $before.'<span class="values">'.$value.'</span>'.$after;
			$return = apply_filters('lsx_to_custom_field_query',$return_html,$meta_key,$value,$before,$after);
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
function lsx_to_connected_items_query($from=false,$to=false,$before="",$after="",$echo=false){
	if(post_type_exists($from) && post_type_exists($to)){
		$connected_ids = get_post_meta(get_the_ID(),$from.'_to_'.$to,false);
		if(false !== $connected_ids && '' !== $connected_ids && !empty($connected_ids)){
			if(!is_array($connected_ids)){
				$connected_ids = array($connected_ids);
			}
			$return = $before.lsx_to_connected_list($connected_ids,$from,true,', ').$after;
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
function lsx_to_connected_panel_query($args=false){
	global $lsx_to_archive;
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
		
		if(false === $args['content_part']){
			$args['content_part'] = $args['from'];
		}
		
		$items_array = get_post_meta(get_the_ID(),$args['from'].'_to_'.$args['to'],false);
		
		if(false !== $items_array && is_array($items_array) && !empty($items_array)){
			$items_query_args = array(
					'post_type'	=>	$args['from'],
					'post_status' => 'publish',
					'post__in' => $items_array
			);
			$items = new WP_Query($items_query_args);
			if ( $items->have_posts() ): 
				$lsx_to_archive = 1;
				ob_start();
				echo wp_kses_post( $args['before'] ).'<div class="row">'; 
				while ( $items->have_posts() ) : $items->the_post();
					echo '<div class="panel col-sm-'.esc_attr($args['column']).'">';
					lsx_to_content('content',$args['content_part']);
					echo '</div>';
				endwhile;
				echo '</div>'.wp_kses_post( $args['after'] );
				$return = ob_get_clean();
				$lsx_to_archive = 0;
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
function lsx_to_related_items($taxonomy=false,$before="",$after="",$echo=true,$post_type=false) {
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
			echo '<div id="slider-'.esc_attr($carousel_id).'" class="lsx-to-slider carousel slide" data-interval="'.esc_attr($interval).'">';
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

				lsx_to_content('content','widget-'.get_post_type());

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
function lsx_to_connected_list($connected_ids = false,$type = false,$link = true,$seperator=', ',$parent=false) {

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
				$html = apply_filters('lsx_to_connected_list_item',$html,$cp->ID,$link);
				$connected_list[] = $html;

			}
				
			return implode($seperator,$connected_list);
		}
	}
}