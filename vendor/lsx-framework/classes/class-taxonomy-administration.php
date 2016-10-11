<?php
/**
 * Module Template.
 *
 * @package   TO_Taxonomy_Admin
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

/**
 * Adds in the Featured Image, the Tagline and the Select and Expert field
 *
 * @package TO_Taxonomy_Admin
 * @author  LightSpeed
 */
class TO_Taxonomy_Admin {

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct($taxonomies=false) {
		add_action('init',array($this,'init'));
		$this->taxonomies = $taxonomies;
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->taxonomies = apply_filters('to_taxonomy_admin_taxonomies',$this->taxonomies);
		add_filter('to_taxonomy_widget_taxonomies', array( $this, 'widget_taxonomies' ),10,1 );

		//die('hello2');

		if(false !== $this->taxonomies){
			add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
			add_action( 'edit_term',   array( $this, 'save_meta' ), 10, 2 );
			foreach($this->taxonomies as $taxonomy){
				//add_action( "{$taxonomy}_add_form_fields",  array( $this, 'add_thumbnail_form_field'  ),3 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_thumbnail_form_field' ),3,1 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_tagline_form_field' ),3,1 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_expert_form_field' ),3,1 );
				
			}			
		}		
	}	
	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function widget_taxonomies($taxonomies) {
		if(false !== $this->taxonomies){ $taxonomies = array_merge($taxonomies,$this->taxonomies); }
		return $taxonomies;
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_thumbnail_form_field($term = false) {
	
		if(is_object($term)){
			$value = get_term_meta( $term->term_id, 'thumbnail', true );
			$image_preview = wp_get_attachment_image_src($value,'thumbnail');
			if(is_array($image_preview)){
				$image_preview = '<img src="'.$image_preview[0].'" width="'.$image_preview[1].'" height="'.$image_preview[2].'" class="alignnone size-thumbnail wp-image-'.$value.'" />';
			}
		}else{
			$image_preview = false;
			$value = false;
		}
		?>
		<tr class="form-field form-required term-thumbnail-wrap">
			<th scope="row"><label for="thumbnail"><?php _e('Featured Image','tour-operator');?></label></th>
			<td>
				<input style="display:none;" name="thumbnail" id="thumbnail" type="text" value="<?php echo $value; ?>" size="40" aria-required="true">
				<div class="thumbnail-preview">
					<?php echo $image_preview; ?>
				</div>				

				<a style="<?php if('' !== $value && false !== $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-add"><?php _e('Choose Image','tour-operator');?></a>				
				<a style="<?php if('' === $value || false === $value) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-remove"><?php _e('Remove Image','tour-operator');?></a>
			</td>
		</tr>
		
		<script type="text/javascript">
			(function( $ ) {
				$( '.lsx-thumbnail-image-add' ).on( 'click', function() {
					tb_show('Choose a Featured Image', 'media-upload.php?type=image&TB_iframe=1');
					var image_thumbnail = '';
					window.send_to_editor = function( html ) 
					{
						var image_thumbnail = $( 'img',html ).html();
						$( '.thumbnail-preview' ).append(html);
						var imgClasses = $( 'img',html ).attr( 'class' );
						imgClasses = imgClasses.split('wp-image-');
						$( '#thumbnail' ).val(imgClasses[1]);
						tb_remove();
					}
					$( this ).hide();
					$( '.lsx-thumbnail-image-remove' ).show();
					
					return false;
				});

				$( '.lsx-thumbnail-image-remove' ).on( 'click', function() {
					$( '.thumbnail-preview' ).html('');
					$( '#thumbnail' ).val('');
					$( this ).hide();
					$( '.lsx-thumbnail-image-add' ).show();					
					return false;
				});	
			})(jQuery);
		</script>		
		<?php
	}
	/**
	 * Saves the Taxnomy term banner image
	 *
	 * @since 0.1.0
	 *
	 * @param  int     $term_id
	 * @param  string  $taxonomy
	 */
	public function save_meta( $term_id = 0, $taxonomy = '' ) {
		$thumbnail_meta = ! empty( $_POST[ 'thumbnail' ] ) ? $_POST[ 'thumbnail' ]	: '';
		if ( empty( $thumbnail_meta ) ) {
			delete_term_meta( $term_id, 'thumbnail' );
		} else {
			update_term_meta( $term_id, 'thumbnail', $thumbnail_meta );
		}
		
		$meta = ! empty( $_POST[ 'tagline' ] ) ? $_POST[ 'tagline' ] : '';
		if ( empty( $meta ) ) {
			delete_term_meta( $term_id, 'tagline' );
		} else {
			update_term_meta( $term_id, 'tagline', $meta );
		}
		
		$meta = ! empty( $_POST[ 'expert' ] ) ? $_POST[ 'expert' ] : '';
		if ( empty( $meta ) ) {
			delete_term_meta( $term_id, 'expert' );
		} else {
			update_term_meta( $term_id, 'expert', $meta );
		}
	}
	
	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_tagline_form_field($term = false) {
		if(is_object($term)){
			$value = get_term_meta( $term->term_id, 'tagline', true );
		}else{
			$value = false;
		}
		?>
		<tr class="form-field form-required term-tagline-wrap">
			<th scope="row"><label for="tagline"><?php _e('Tagline','tour-operator');?></label></th>
			<td>
				<input name="tagline" id="tagline" type="text" value="<?php echo $value; ?>" size="40" aria-required="true">
			</td>
		</tr>
		<?php
	}
	
	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_expert_form_field( $term = false ) {
		if ( is_object( $term ) ) {
			$value = get_term_meta( $term->term_id, 'expert', true );
		} else {
			$value = false;
		}

		$experts = get_posts(
			array(
				'post_type' => 'team',
				'posts_per_page' => -1,
				'orderby' => 'menu_order',
				'order' => 'ASC',
			)
		);
		?>

		<tr class="form-field form-required term-expert-wrap">
			<th scope="row">
				<label for="expert"><?php _e( 'Expert','tour-operator' ) ?></label>
			</th>

			<td>
				<select name="expert" id="expert" aria-required="true">
					<option value=""><?php _e( 'None','tour-operator' ) ?></option>

					<?php
						foreach ( $experts as $expert ) {
							echo '<option value="'. $expert->ID .'"'. selected( $value, $expert->ID, FALSE ) .'>'. $expert->post_title .'</option>';
						}
					?>
				</select>
			</td>
		</tr>

		<?php
	}
}
/**
 * Checks if the current term has a thumbnail
 *
 * @param	$term_id
 */
function to_has_term_thumbnail($term_id = false) {
	if(false !== $term_id){
		$term_thumbnail = get_term_meta($term_id, 'thumbnail', true);
		if(false !== $term_thumbnail && '' !== $term_thumbnail){
			return true;
		}
	}
	return false;
}

/**
 * Outputs the current terms thumbnail
 *
 * @param	$term_id string
 */
function to_term_thumbnail($term_id = false,$size='lsx-thumbnail-wide') {
	if(false !== $term_id){
		echo to_get_term_thumbnail($term_id,$size);
	}
}

/**
 * Outputs the current terms thumbnail
 *
 * @param	$term_id string
 */
function to_get_term_thumbnail($term_id = false,$size='lsx-thumbnail-wide') {
	if(false !== $term_id){
		$term_thumbnail_id = get_term_meta($term_id, 'thumbnail', true);
		$img = wp_get_attachment_image_src($term_thumbnail_id,$size);
		return apply_filters( 'to_lazyload_filter_images', '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="'.$img[0].'" />' );
	}
}