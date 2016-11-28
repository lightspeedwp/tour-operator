<?php
/**
 * Template Tags
 *
 * @package   		tour-operator
 * @subpackage 		template-tags
 * @category 		general
 * @license   		GPL3
 */

/* ==================   LAYOUT  ================== */

/**
 * Outputs the CSS class for the widget panels
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	class
 */
function to_widget_class($return=false){
	global $columns;
	$md_col_width = 12 / $columns;

	if('1' == $columns){
		$class = 'single col-sm-12';
	}else{
		$class = 'panel col-sm-'.$md_col_width;
	}
	if(false === $return){
		echo 'class="'.esc_attr($class).'"';
	}else{
		return 'class="'.$class.'"';
	}
}

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
	echo wp_kses_post('class="'.implode(' ',$classes).'"');
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
	echo wp_kses_post('class="'.implode(' ',$classes).'"');
}


/* ==================   HEADER   ================== */

/**
 * Checks if a caldera form with your slug exists
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	header
 */
function to_global_header() { ?>
	<header class="archive-header">
		<h1 class="archive-title">
			<?php 
				if(is_archive()){
					the_archive_title();
				}else{
					the_title();
				}?>
		</h1>
		<?php to_tagline('<p class="tagline">','</p>'); ?>
	</header><!-- .archive-header -->
<?php
}

/**
 * Taglines
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	header
 */
function to_tagline($before='',$after='',$echo=false) {
	echo wp_kses_post( apply_filters('to_tagline','',$before,$after) );
}

/**
 * Adds the tagline to the banner content
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	banner
 */
function to_banner_content() { 
	to_tagline('<p class="tagline">','</p>');
}

/* ==================    BODY    ================== */

/**
 * Outputs the tour Content
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	content
 */
function to_content($slug, $name = null) {
	do_action('to_content',$slug, $name);
}

/* ==================   ARCHIVE   ================== */

/**
 * Archive Descriptions
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	description
 */
function to_archive_description() {
	echo wp_kses_post( apply_filters('to_archive_description','','<div class="row"><div class="col-sm-12"><article class="archive-description hentry">','</article></div></div>') );
}


/* ==================   SINGLE   ================== */

/**
 * Outputs the Single pages navigation
 *
 * @param $echo
 * @return string
 *
 * @package 	tour-operator
 * @subpackage	template-tag
 * @category 	navigation
 */
function to_page_navigation($echo = true) {
	$page_links = array();
	if(is_singular()) {
		$page_links['summary'] = esc_html__('Summary', 'tour-operator');
	}
	$page_links = apply_filters('to_page_navigation',$page_links);

	if(!empty($page_links)) {
		$return = '<section class="' . get_post_type() . '-navigation">
					<div class="container">
						<ul class="scroll-easing">';

		if (!empty($page_links)) {
			foreach ($page_links as $link_slug => $link_value) {
				$return .= '<li><a href="#' . $link_slug . '">' . $link_value . '</a></li>';
			}
		}

		$return .= '		</ul>
					</div>
				</section>';

		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}
}

/**
 * outputs the sharing
 *
 * @package 	tour-operator
 * @subpackage	setup
 * @category 	helper
 */
function to_sharing() { 
	echo '<section id="sharing">';
	if ( function_exists( 'sharing_display' ) ) {
		sharing_display( '', true );
	}
	
	if ( class_exists( 'Jetpack_Likes' ) ) {
		$custom_likes = new Jetpack_Likes;
		echo wp_kses_post( $custom_likes->post_likes( '' ) );
	}
	echo '</section>';
}

/**
 * Outputs the TO Gallery
 * 
 * @param		$before	| string
 * @param		$after	| string
 * @param		$echo	| boolean
 * @return		string
 *
 * @package 	to-galleries
 * @subpackage	template-tags
 */
function to_envira_gallery($before="",$after="",$echo=true){
	$envira_gallery = get_post_meta(get_the_ID(),'envira_gallery',true);
	if(false !== $envira_gallery && '' !== $envira_gallery && false === to_enable_envira_banner()){
		ob_start();
		if(function_exists('envira_gallery')){envira_gallery( $envira_gallery );}
		$return = ob_get_clean();

		$return = $before.$return.$after;

		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}
	}	
}

/**
 * Outputs the Envira Video Gallery
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
function to_envira_videos($before="",$after="",$echo=true){
	global $content_width;
	$envira_video = get_post_meta(get_the_ID(),'envira_video',true);
	$return = false;

	if(false !== $envira_video && '' !== $envira_video){
		$return = do_shortcode('[envira-gallery id="'.$envira_video.'"]');
		$return = $before.$return.$after;
		$temp_width = $content_width;
		$content_width = $temp_width;
		if($echo){
			echo wp_kses_post( $return );
		}else{
			return $return;
		}		
	}
}

/* ==================  TAXONOMIES  ================== */

/**
 * Outputs the widget with some styling
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_safari_brands($before="",$after="",$echo=true) {
	$args = array(
			'name' => 'Home',
			'id' => 'sidebar-home',
			'description' => '',
			'class' => '',
			'before_widget' => '<aside id="to_taxonomy_widget-6" class="widget lsx-widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'to_taxonomy_widget-6',
			'widget_name' => 'LSX Taxonomies',
	);
	$instance = array(
			'title' => '',
			'title_link' =>'',
			'columns' => '4',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'limit' => '100',
			'include' =>'',
			'size' => '100',
			'buttons' =>'',
			'button_text' =>'',
			'responsive' => '1',
			'carousel' =>'1',
			'taxonomy' => 'accommodation-brand',
			'class' =>'',
			'interval' => '7000',
			'indicators' => '1'
	);
	$safari_brands = new TO_Taxonomy_Widget();
	ob_start();
	$safari_brands->widget($args, $instance);
	$return = ob_get_clean();
	$return = $before.$return.$after;
	if($echo){
		echo wp_kses_post( $return );
	}else{
		return $return;
	}	
}

/**
 * Outputs the travel styles widget with some styling
 *
 * @package 	tour-operator
 * @subpackage	template-tags
 * @category 	helper
 */
function to_travel_styles($before="",$after="",$echo=true) {
	$args = array(
			'name' => 'Home',
			'id' => 'sidebar-home',
			'description' => '',
			'class' => '',
			'before_widget' => '<aside id="to_taxonomy_widget-6" class="widget lsx-widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'widget_id' => 'to_taxonomy_widget-6',
			'widget_name' => 'LSX Taxonomies',
	);
	$instance = array(
			'title' => '',
			'title_link' =>'',
			'columns' => '3',
			'orderby' => 'rand',
			'order' => 'DESC',
			'limit' => '100',
			'include' =>'',
			'size' => '100',
			'buttons' =>'',
			'button_text' =>'',
			'responsive' => '1',
			'carousel' =>'1',
			'taxonomy' => 'travel-style',
			'class' =>'',
			'interval' => '7000',
			'indicators' => '1'
	);
	$travel_styles = new TO_Taxonomy_Widget();
	ob_start();
	$travel_styles->widget($args, $instance);
	$return = ob_get_clean();
	$return = $before.$return.$after;
	if($echo){
		echo wp_kses_post( $return );
	}else{
		return $return;
	}	
}

/* ==================  MODALS  ================== */
/**
 * Outputs the Enquire Modal
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
function to_enquire_modal($before="",$after="",$echo=true){ 
	global $tour_operator;

	$form_id = 'false';
	// First set the general form
	if(isset($tour_operator->options['general']) && isset($tour_operator->options['general']['enquiry']) && '' !== $tour_operator->options['general']['enquiry']){
		$form_id = $tour_operator->options['general']['enquiry'];
	}

	if(is_singular($tour_operator->active_post_types)){		
		if(isset($tour_operator->options[get_post_type()]) && isset($tour_operator->options[get_post_type()]['enquiry']) && '' !== $tour_operator->options[get_post_type()]['enquiry']){
			$form_id = $tour_operator->options[get_post_type()]['enquiry'];
		}
	}

	$disable_modal = false;
	$link = '#';

	if(isset($tour_operator->options['general']) && isset($tour_operator->options['general']['disable_enquire_modal']) && 'on' === $tour_operator->options['general']['disable_enquire_modal']){
		$disable_modal = true;

		if(isset($tour_operator->options['general']['enquire_link']) && '' !== $tour_operator->options['general']['enquire_link']){
			$link = $tour_operator->options['general']['enquire_link'];
		}
	}

	if(is_singular($tour_operator->active_post_types)){		
		if(isset($tour_operator->options[get_post_type()]) && isset($tour_operator->options[get_post_type()]['disable_enquire_modal']) && 'on' === $tour_operator->options[get_post_type()]['disable_enquire_modal']){
			$disable_modal = true;

			if(isset($tour_operator->options[get_post_type()]['enquire_link']) && '' !== $tour_operator->options[get_post_type()]['enquire_link']){
				$link = $tour_operator->options[get_post_type()]['enquire_link'];
			}
		}
	}	


	if(false !== $form_id){

	?>
	<div class="enquire-form">
		<p class="aligncenter" style="text-align:center;"><a href="<?php echo esc_url( $link ); ?>" class="btn cta-btn" <?php if(false === $disable_modal){ ?>data-toggle="modal" data-target="#lsx-enquire-modal"<?php } ?> >Enquire</a></p>
		
		<?php 
		if(false === $disable_modal){
		add_action( 'wp_footer', function( $arg ) use ( $form_id ) { ?>
		
		<div class="modal fade" id="lsx-enquire-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Enquire</h4>
		      </div>
		      <div class="modal-body">
		        <?php 
					if(class_exists('Ninja_Forms')){
						echo do_shortcode('[ninja_form id="'.$form_id.'"]');
					}elseif(class_exists('GFForms')){
						echo do_shortcode('[gravityform id="'.$form_id.'" title="false" description="false" ajax="true"]');
					}elseif(class_exists('Caldera_Forms_Forms')) {
						echo do_shortcode('[caldera_form id="'.$form_id.'"]');
					}else{
						echo wp_kses_post( apply_filters('the_content',$form_id) );
					}
		        ?>
		      </div>
		    </div>
		  </div>
		</div>

		<?php } ); } ?>

	</div>
<?php } }
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