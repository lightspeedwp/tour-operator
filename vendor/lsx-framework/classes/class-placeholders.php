<?php
/**
 * Placeholders.
 *
 * @package   Placeholders
 * @author    LightSpeed https://lsdev.biz
 * @license   GPL3
 * @link      
 */

/**
 * Plugin class.
 */
class LSX_Placeholders {

	/**
	 * The slug for this plugin
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'placeholders';

	/**
	 * The active post types
	 *
	 * @var      array
	 */
	protected $post_types = array();

	/**
	 * A default super placeholder
	 *
	 * @var      array
	 */
	protected $super_placeholder = false;

	/**
	 * Holds class isntance
	 *
	 * @var      object|Placeholders
	 */
	protected static $instance = null;

	/**
	 * Holds the check for thumb value
	 *
	 * @var      string
	 */
	protected $checking_for_thumb = false;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 */
	public function __construct($post_types=false) {

		if(false !== $post_types){ $this->post_types = $post_types; }

		$this->post_types[] = 'post';
		$this->post_types[] = 'page';

		add_action('lsx_framework_dashboard_tab_content',array($this,'dashboard_settings'),15);

		foreach($this->post_types as $post_type){
			add_action( 'lsx_framework_'.$post_type.'_tab_general_settings_top', array( $this, 'settings_page_html' ) );
		}
		
		if( !is_admin() ){
			add_filter( 'get_post_metadata', array($this,'default_post_thumbnail') , 11, 3 );
			add_filter( 'get_term_metadata', array($this,'default_term_thumbnail') , 11, 3 );

			add_filter( 'wp_get_attachment_image_src', array($this,'super_placeholder_filter') , 20, 4 );
			add_filter( 'wp_calculate_image_srcset_meta', array($this,'super_placeholder_srcset_filter') , 20, 4 );	
			add_filter( 'wp_calculate_image_srcset', array($this,'super_placeholder_calculate_image_srcset_filter') , 20, 5 );	
		}

		$this->super_placeholder = LSX_Placeholders::placeholder_url();
	}

	/**
	 * Returns the placeholder call.
	 */
	public static function placeholder_url($text_size = 24,$post_type='general',$size='lsx-thumbnail-wide'){
		$options = get_option('_lsx_lsx-settings',false);
		$holdit_width = '';
		switch($size){
			case 'thumbnail':
			case 'medium':
			case 'large':
				$width = get_option( "{$size}_size_w",150 );
				$height = get_option( "{$size}_size_h",150 );
				$holdit_width = '&w='.$width.'&h='.$height;
			break;	

			case 'lsx-single-thumbnail':
			case 'lsx-thumbnail-single':
				$holdit_width = '&w=750&h=350';
			break;

			case 'lsx-thumbnail-wide':
			default:
				$holdit_width = '&w=350&h=230';
			break;
		}

		$placeholder = 'https://placeholdit.imgix.net/~text?txtsize='.$text_size.'&txt='.urlencode(get_bloginfo('name')).$holdit_width;
		$placeholder_id = false;
		//First Check for a default, then check if there is one set by post type.
		if(isset($options['general']) 
		 && isset($options['general']['default_placeholder_id'])
		 && !empty( $options['general']['default_placeholder_id'] )){
			$placeholder_id = $options['general']['default_placeholder_id'];
		}
		if('general' !== $post_type){
			if('post' === $post_type){
				if(isset($options['general']) 
				 && isset($options['general']['posts_placeholder_id'])
				 && !empty( $options['general']['posts_placeholder_id'] )
				 && '' !== $options['general']['posts_placeholder_id']){
					$placeholder_id = $options['general']['posts_placeholder_id'];
				}
			}else{
				if(isset($options[$post_type]) 
				 && isset($options[$post_type]['featured_placeholder_id'])
				 && !empty( $options[$post_type]['featured_placeholder_id'] )
				 && '' !== $options[$post_type]['featured_placeholder_id']){
					$placeholder_id = $options[$post_type]['featured_placeholder_id'];
				}
			}
		}
		if(false !== $placeholder_id && '' !== $placeholder_id){
			$temp_src_array = wp_get_attachment_image_src($placeholder_id,$size);
			if(is_array($temp_src_array) && !empty($temp_src_array)){
				$placeholder = $temp_src_array[0];
			}
		}
		return $placeholder;
	}

	/**
	 * The post default placeholder call.
	 */
	public function default_post_thumbnail( $meta, $post_id, $meta_key ){
		$options = get_option('_lsx_lsx-settings',false);
		if($meta_key === '_thumbnail_id' && false !== $options){
			
			$post_type = get_post_field( 'post_type', $post_id );

			//If the post types posts placeholder has been disabled then skip.
			if('post' === $post_type && isset($options['general']) && isset($options['general']['disable_blog_placeholder'])){ return $meta; }

			//This ensures our "super" placeholder will always show.
			$placeholder = 'lsx-placeholder';

			//First Check for a default, then check if there is one set by post type.
			if(isset($options['general']) 
			 && isset($options['general']['default_placeholder_id'])
			 && !empty( $options['general']['default_placeholder_id'] )){
				$placeholder = $options['general']['default_placeholder_id'];
			}
			if('post' === $post_type){
				if(isset($options['general']) 
				 && isset($options['general']['posts_placeholder_id'])
				 && !empty( $options['general']['posts_placeholder_id'] )
				 && '' !== $options['general']['posts_placeholder_id']){
					$placeholder = $options['general']['posts_placeholder_id'];
				}
			}else{
				if(isset($options[$post_type]) 
				 && isset($options[$post_type]['featured_placeholder_id'])
				 && !empty( $options[$post_type]['featured_placeholder_id'] )
				 && '' !== $options[$post_type]['featured_placeholder_id']){
					$placeholder = $options[$post_type]['featured_placeholder_id'];
				}
			}
		}

		if( $meta_key === '_thumbnail_id' && false === $this->checking_for_thumb ){
			$this->checking_for_thumb = true;
			$image = get_post_meta( $post_id, '_thumbnail_id', true );
			$this->checking_for_thumb = false;
			if( !empty( $image ) ){
				return $meta;
			}
			// onlong but here it is. no ID

			return $placeholder;
		}				
		
		return $meta;
	}

	/**
	 * The term default placeholder call.
	 */
	public function default_term_thumbnail( $meta, $post_id, $meta_key ){

		if($meta_key === 'thumbnail'){
			$options = get_option('_lsx_lsx-settings',false);
			$placeholder = 'lsx-placeholder';

			//First Check for a default, then check if there is one set by post type.
			if(false !== $options
			 && isset($options['general']) 
			 && isset($options['general']['default_placeholder_id'])
			 && !empty( $options['general']['default_placeholder_id'] )){
				$placeholder = $options['general']['default_placeholder_id'];
			}

		}

		if( $meta_key === 'thumbnail' && false === $this->checking_for_thumb ){
			$this->checking_for_thumb = true;
			$image = get_term_meta( $post_id, 'thumbnail', true );
			$this->checking_for_thumb = false;
			if( false !== $image && '' !== $image && !empty( $image ) ){
				return $meta;
			}
			// onlong but here it is. no ID
			return $placeholder;
		}				
		
		return $meta;
	}	

	/**
	 * The term default placeholder call.
	 */
	public function super_placeholder_filter( $image, $attachment_id , $size , $icon ){

		if('lsx-placeholder' === $attachment_id){
			$image = array();

			switch($size){

				case 'thumbnail':
				case 'medium':
				case 'large':

					$width = get_option( "{$size}_size_w",150 );
					$height = get_option( "{$size}_size_h",150 );

					$image[] = $this->placeholder_url().'&w='.$width.'&h='.$height;
					$image[] = $width;
					$image[] = $height;
					$image[] = true;
				break;				

				case 'lsx-thumbnail-wide':
					$image[] = $this->placeholder_url().'&w=350&h=230';
					$image[] = 350;
					$image[] = 230;
					$image[] = true;
				break;

				case 'lsx-single-thumbnail':
				case 'lsx-thumbnail-single':
					$image[] = $this->placeholder_url().'&w=750&h=350';
					$image[] = 750;
					$image[] = 350;
					$image[] = false;
				break;

				default:
					if(is_array($size)){
						$image[] = $this->placeholder_url().'&w='.$size[0].'&h='.$size[1];
						$image[] = $size[0];
						$image[] = $size[1];
						$image[] = true;				
					}
				break;

			} 

			$image = apply_filters('lsx_placeholder_url',$image);

		}
		return $image;
	}

	/**
	 * The term default placeholder call.
	 */
	public function super_placeholder_srcset_filter( $image_meta, $size_array, $image_src, $attachment_id ){

		if('lsx-placeholder' === $attachment_id){

			$width = '750';
			$height = '350';

			$sizes = array(
				'thumbnail' => array(
					'file'	=> $this->placeholder_url().'&w='.get_option( "thumbnail_size_w",150 ).'&h='.get_option( "thumbnail_size_h",150 ),
					'width'	=> get_option( "thumbnail_size_w",150 ),
					'height'	=> get_option( "thumbnail_size_h",150 ),
					'mime-type'	=> 'image/jpeg',
				),	
				'medium' => array(
					'file'	=> $this->placeholder_url().'&w='.get_option( "medium_size_w",300 ).'&h='.get_option( "medium_size_h",300 ),
					'width'	=> get_option( "medium_size_w",300 ),
					'height'	=> get_option( "medium_size_h",300 ),
					'mime-type'	=> 'image/jpeg',
				),	
				'large' => array(
					'file'	=> $this->placeholder_url().'&w='.get_option( "large_size_w",1024 ).'&h='.get_option( "large_size_h",1024 ),
					'width'	=> get_option( "large_size_w",1024 ),
					'height'	=> get_option( "large_size_h",1024 ),
					'mime-type'	=> 'image/jpeg',
				),											
				'lsx-thumbnail-single' => array(
					'file'	=> $this->placeholder_url().'&w=750&h=350',
					'width'	=> '750',
					'height'	=> '350',
					'mime-type'	=> 'image/jpeg',
				),				
			);

			$image_meta = array(
				'width' => $width,
				'height' => $height,
				'file' => $this->placeholder_url().'&w=750&h=350',
				'sizes' => $sizes
			);

		}
		return $image_meta;
	}

	/**
	 * Overwrites the sources call 
	 */
	public function super_placeholder_calculate_image_srcset_filter( $sources, $size_array, $image_src, $image_meta, $attachment_id ){

		if('lsx-placeholder' === $attachment_id){

			$sources = array(
				'1920' => array(
					'url' 			=> $this->super_placeholder.'&w=750&h=350',
					'descriptor' 	=> 'w',
					'value' 		=> '1920',
				),
				'300' => array(
					'url' 			=> $this->super_placeholder.'&w=350&h=230',
					'descriptor' 	=> 'w',
					'value' 		=> '300',
				),
				'768' => array(
					'url' 			=> $this->super_placeholder.'&w=750&h=350',
					'descriptor' 	=> 'w',
					'value' 		=> '768',
				),
				'1024' => array(
					'url' 			=> $this->super_placeholder.'&w=750&h=350',
					'descriptor' 	=> 'w',
					'value' 		=> '1024',
				),												
			);

		}
		return $sources;
	}	

	/**
	 * The placeholder settings that output on the frameworks tabs.
	 */
	public function dashboard_settings() { ?>
		<th class="" style="padding-bottom:0px;" scope="row" colspan="2">
			<label><h3 style="margin-bottom:0px;"> Placeholders</h3></label>			
		</th>

		<?php if(class_exists('LSX_Banners')) { ?>
			<tr class="form-field banner-placeholder-wrap">
				<th scope="row">
					<label for="banner"> Banner Placeholder</label>
				</th>
				<td>
					<input type="hidden" {{#if banner_placeholder_id}} value="{{banner_placeholder_id}}" {{/if}} name="banner_placeholder_id" />
					<input type="hidden" {{#if banner_placeholder}} value="{{banner_placeholder}}" {{/if}} name="banner_placeholder" />
					<div class="thumbnail-preview">
						{{#if banner_placeholder}}<img src="{{banner_placeholder}}" width="300" height="150" />{{/if}}	
					</div>

					<a {{#if banner_placeholder}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="banner_placeholder">Choose Image</a>

					<a {{#unless banner_placeholder}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="banner_placeholder">Delete</a>
					
				</td>
			</tr>
		<?php } ?>
		<tr class="form-field">
			<th scope="row">
				<label for="banner"> Featured Placeholder</label>
			</th>
			<td>
				<input type="hidden" {{#if default_placeholder_id}} value="{{default_placeholder_id}}" {{/if}} name="default_placeholder_id" />
				<input type="hidden" {{#if default_placeholder}} value="{{default_placeholder}}" {{/if}} name="default_placeholder" />
				<div class="thumbnail-preview">
					{{#if default_placeholder}}<img src="{{default_placeholder}}" width="150" height="150" />{{/if}}	
				</div>

				<a {{#if default_placeholder}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="default_placeholder">Choose Image</a>

				<a {{#unless default_placeholder}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="default_placeholder">Delete</a>
				
			</td>
		</tr>
		{{#unless disable_blog_placeholder}}
			<tr class="form-field">
				<th scope="row">
					<label for="posts_placeholder"> Blog Placeholder</label>
				</th>
				<td>
					<input type="hidden" {{#if posts_placeholder_id}} value="{{posts_placeholder_id}}" {{/if}} name="posts_placeholder_id" />
					<input type="hidden" {{#if posts_placeholder}} value="{{posts_placeholder}}" {{/if}} name="posts_placeholder" />
					<div class="thumbnail-preview">
						{{#if posts_placeholder}}<img src="{{posts_placeholder}}" width="150" height="150" />{{/if}}	
					</div>

					<a {{#if posts_placeholder}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="posts_placeholder">Choose Image</a>

					<a {{#unless posts_placeholder}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="posts_placeholder">Delete</a>
					
				</td>
			</tr>	
		{{/unless}}	
		<tr class="form-field">
			<th scope="row">
				<label for="description">Disable Placeholder on Blog Posts</label>
			</th>
			<td>
				<input type="checkbox" {{#if disable_blog_placeholder}} checked="checked" {{/if}} name="disable_blog_placeholder" />
				<small>This disables the placeholder on blog posts.</small>
			</td>
		</tr>
				
	<?php 
	}

	/**
	 * The placeholder settings that output on the frameworks tabs.
	 */
	public function settings_page_html() { ?>
		<?php if(class_exists('LSX_Banners')) { ?>
			<tr class="form-field banner-placeholder-wrap">
				<th scope="row">
					<label for="banner"> Banner Placeholder</label>
				</th>
				<td>
					<input type="hidden" {{#if banner_placeholder_id}} value="{{banner_placeholder_id}}" {{/if}} name="banner_placeholder_id" />
					<input type="hidden" {{#if banner_placeholder}} value="{{banner_placeholder}}" {{/if}} name="banner_placeholder" />
					<div class="thumbnail-preview">
						{{#if banner_placeholder}}<img src="{{banner_placeholder}}" width="300" height="150" />{{/if}}	
					</div>

					<a {{#if banner_placeholder}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="banner_placeholder">Choose Image</a>

					<a {{#unless banner_placeholder}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="banner_placeholder">Delete</a>
					
				</td>
			</tr>	
		<?php } ?>
		
		<tr class="form-field featured-placeholder-wrap">
			<th scope="row">
				<label for="featured_placeholder">Featured Image</label>
			</th>
			<td>
				<input type="hidden" {{#if featured_placeholder_id}} value="{{featured_placeholder_id}}" {{/if}} name="featured_placeholder_id" />
				<input type="hidden" {{#if featured_placeholder}} value="{{featured_placeholder}}" {{/if}} name="featured_placeholder" />
				<div class="thumbnail-preview">
					{{#if featured_placeholder}}<img src="{{featured_placeholder}}" width="150" height="150" />{{/if}}	
				</div>

				<a {{#if featured_placeholder}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="featured_placeholder">Choose Image</a>

				<a {{#unless featured_placeholder}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="featured_placeholder">Delete</a>
				
			</td>
		</tr>
	<?php
	}
}