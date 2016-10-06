<?php
/**
 * Envira Gallery Content Part
 * 
 * @package 	lsx-tour-operators
 * @category	team
 */
$gallery_id = get_post_meta(get_the_ID(),'envira_to_'.get_post_type(),true);
if(false !== $gallery_id && '' !== $gallery_id){
	if ( function_exists( 'envira_gallery' ) ) {
		envira_gallery( $gallery_id );
	}
}
