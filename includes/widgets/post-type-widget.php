<?php
/**
 * @package   TO_Widget
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeed
 *
 **/

class TO_Widget extends WP_Widget {
	
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'lsx-widget',
			'description' => esc_html__('TO','tour-operator'),
		);
		parent::__construct( 'TO_Widget', 'TO Post Types', $widget_ops );
	}
 
    /** @see WP_Widget::widget -- do not rename this */
    public function widget( $args, $instance ) { 
        
    	if (isset($instance['title'])) {
			$title = apply_filters('widget_title', $instance['title']);
		} else {
			$title = false;
		}

		if (isset($instance['title_link'])) {
			$title_link = $instance['title_link'];
		} else {
			$title_link = false;
		}
		if (isset($instance['tagline'])) {
			$tagline = $instance['tagline'];
		} else {
			$tagline = false;
		}
		if (isset($instance['columns'])) {
			$columns = $instance['columns'];
		} else {
			$columns = false;
		}

		if (isset($instance['orderby'])) {
			$orderby = $instance['orderby'];
		} else {
			$orderby = false;
		}
		if (isset($instance['order'])) {
			$order = $instance['order'];
		} else {
			$order = false;
		}
		if (isset($instance['limit'])) {
			$limit = $instance['limit'];
		} else {
			$limit = '-1';
		}

		if (isset($instance['group'])) {
			$group = $instance['group'];
		} else {
			$group = false;
		}

		if (isset($instance['include'])) {
			$include = $instance['include'];
		} else {
			$include = false;
		}
		if (isset($instance['size'])) {
			$size = $instance['size'];
		} else {
			$size = false;
		}
		if (isset($instance['disable_placeholder'])) {
			$disable_placeholder = $instance['disable_placeholder'];
		} else {
			$disable_placeholder = false;
		}		
		if (isset($instance['buttons'])) {
			$buttons = $instance['buttons'];
		} else {
			$buttons = false;
		}
		if (isset($instance['button_text'])) {
			$button_text = $instance['button_text'];
		} else {
			$button_text = false;
		}		
		if (isset($instance['responsive'])) {
			$responsive = $instance['responsive'];
		} else {
			$responsive = false;
		}
		if (isset($instance['carousel'])) {
			$carousel = $instance['carousel'];
		} else {
			$carousel = false;
		}
		if (isset($instance['featured'])) {
			$featured = $instance['featured'];
		} else {
			$featured = false;
		}
		if (isset($instance['post_type'])) {
			$post_type = $instance['post_type'];
		} else {
			$post_type = false;
		}
		if (isset($instance['class'])) {
			$class = $instance['class'];
		} else {
			$class = false;
		}
		if (isset($instance['interval'])) {
			$interval = $instance['interval'];
		} else {
			$interval = false;
		}
		if (isset($instance['indicators'])) {
			$indicators = $instance['indicators'];
		} else {
			$indicators = false;
		}

		//arguments
		if (isset($args['before_widget'])) {
			$before_widget = $args['before_widget'];
		} else {
			$before_widget = '';
		}                                                     
		if (isset($args['after_widget'])) {
			$after_widget = $args['after_widget'];
		} else {
			$after_widget = '';
		}
		if (isset($args['before_title'])) {
			$before_title = $args['before_title'];
		} else {
			$before_title = '';
		}
		if (isset($args['after_title'])) {
			$after_title = $args['after_title'];
		} else {
			$after_title = '';
		}				
        
        // Disregard specific ID setting if specific group is defined
        if ( 'all' != $group ) {
            $include = '';
        } else {
            $group = '';
        }
        
        if ( '' != $include ) $limit = "-1";
              
        if ( '1' == $responsive )
            $responsive = true;
        else
            $responsive = false;

        if ( '1' == $buttons )
            $buttons = true;
        else
            $buttons = false;
                
        if ( $title_link ) {
            $link_open = "<a href='$title_link'>";
            $link_close = "</a>";
        } else {
            $link_open = "";
            $link_close = "";
        }

        $class = 'class="'.$class.' ';
        echo wp_kses_post(str_replace('class="',$class,$before_widget));  
              
        
        if(post_type_exists($post_type)){
	        if ( false != $title ) {
	        
	        	if ('video' != $post_type) {
	        		$title = $before_title . $link_open . $title . $link_close . $after_title;
	        		echo wp_kses_post(apply_filters('to_post_type_widget_title', $title));
	        	}
	        	if ( false != $tagline ) {
	        		echo wp_kses_post('<p class="tagline">'.$tagline.'</p>');
	        	}	        	
	        }   
	
			$args = array( 
				'title'  => $title,
				'tagline' => $tagline,  
				'link' => $title_link,                                                                                                     
				'columns' => $columns,
				'orderby' => $orderby,
				'order' => $order,
				'limit' => $limit,
				'group' => $group,
				'include' => $include,                                    
				'size' => $size,
				'disable_placeholder' => $disable_placeholder,
				'buttons' => $buttons,
				'button_text' => $button_text,
				'responsive' => $responsive,
				'featured' => $featured,
				'post_type' => $post_type,
				'class' => $class,
				'interval' => $interval,
				'indicators' => $indicators,
			);
			                
	
			$args['carousel'] = $carousel;  
			echo wp_kses_post($this->output($args));  
		}else{
		 	echo wp_kses_post('<p>'.esc_html__('That post type does not exist.','tour-operator').'</p>');
		}

        echo wp_kses_post($after_widget);    
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
	    $instance = $old_instance;
	    $instance['title'] = strip_tags( $new_instance['title'] );
	    $instance['title_link'] = strip_tags( $new_instance['title_link'] );
	    $instance['tagline'] = strip_tags( $new_instance['tagline'] );
	    $instance['columns'] = strip_tags( $new_instance['columns'] );
	    $instance['orderby'] = strip_tags( $new_instance['orderby'] );
	    $instance['order'] = strip_tags( $new_instance['order'] );
	    $instance['limit'] = strip_tags( $new_instance['limit'] );
	    $instance['include'] = strip_tags( $new_instance['include'] );
	    $instance['size'] = strip_tags( $new_instance['size'] );
	    $instance['disable_placeholder'] = strip_tags( $new_instance['disable_placeholder'] );
	    $instance['buttons'] = strip_tags( $new_instance['buttons'] );
	    $instance['button_text'] = $new_instance['button_text'];
	    $instance['responsive'] = strip_tags( $new_instance['responsive'] );
	    $instance['carousel'] = strip_tags( $new_instance['carousel'] );
	    $instance['featured'] = strip_tags( $new_instance['featured'] );
	    $instance['post_type'] = strip_tags( $new_instance['post_type'] );
	    $instance['class'] = strip_tags( $new_instance['class'] );
	    $instance['interval'] = strip_tags( $new_instance['interval'] );
	    $instance['indicators'] = strip_tags( $new_instance['indicators'] );
    return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
    
        $defaults = array( 
            'title' => 'Featured',
            'title_link' => '',
            'tagline' => '',
            'columns' => '1', 
            'orderby' => 'date',
            'order' => 'DESC',
            'limit' => '',
            'include' => '',
            'size' => '100', 
            'disable_placeholder' => 0,
            'buttons' => 1,
        	'button_text' => 'See All',
            'responsive' => 1,
        	'featured' => 0,
        	'post_type' => 'accommodation',
        	'class' => '',
        	'interval' => '7000',
        	'indicators' => 1	
        );
        
        $defaults['carousel'] = 0;
        
        $instance = wp_parse_args( (array) $instance, $defaults );   

        $title    = esc_attr($instance['title']);
        $title_link    = esc_attr($instance['title_link']);
        $tagline    = esc_attr($instance['tagline']);
        $columns  = esc_attr($instance['columns']);
        $orderby  = esc_attr($instance['orderby']);
        $order  = esc_attr($instance['order']);
        $limit  = esc_attr($instance['limit']);
        $include  = esc_attr($instance['include']);
        $size  = esc_attr($instance['size']);
        $disable_placeholder  = esc_attr($instance['disable_placeholder']);
        $buttons = esc_attr($instance['buttons']);
        $button_text = esc_attr($instance['button_text']);
        $responsive = esc_attr($instance['responsive']);
        $featured = esc_attr($instance['featured']);
        $post_type = esc_attr($instance['post_type']);
        $class = esc_attr($instance['class']);
        $interval = esc_attr($instance['interval']);    
        $carousel = esc_attr($instance['carousel']);
        $interval = esc_attr($instance['interval']);
        $indicators = esc_attr($instance['indicators']);
        	      

        ?>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','tour-operator'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('title')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('title')); ?>" type="text"
				value="<?php echo wp_kses_post($title); ?>" />
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('title_link')); ?>"><?php esc_html_e( 'Title Link:','tour-operator' ); ?></label>
			<input class="widefat"
				id="<?php echo wp_kses_post($this->get_field_id('title_link')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('title_link')); ?>" type="text"
				value="<?php echo wp_kses_post($title_link); ?>" /> <small><?php esc_html_e( 'Link the widget title to
				a URL','tour-operator' ); ?></small>
		</p>		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('tagline')); ?>"><?php esc_html_e('Tagline:','tour-operator'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('tagline')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('tagline')); ?>" type="text"
				value="<?php echo wp_kses_post($tagline); ?>" />
		</p>		

		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('columns')); ?>"><?php esc_html_e('Columns:','tour-operator'); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('columns')); ?>"
				id="<?php echo wp_kses_post($this->get_field_id('columns')); ?>"
				class="widefat layout">
		            <?php
		            $options = array('1', '2', '3', '4', '5', '6');
		            foreach ($options as $option) {
		            	$key = lcfirst($option);
		            	$selected = ($columns == $key) ? ' selected="selected"' : '';
		                ?><option value="<?php echo wp_kses_post($key); ?>" id="<?php echo wp_kses_post($option); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($option); ?></option><?php 
		            }
		            ?>
		            </select>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('orderby')); ?>"><?php esc_html_e('Order By:','tour-operator'); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('orderby')); ?>"
				id="<?php echo wp_kses_post($this->get_field_id('orderby')); ?>" class="widefat">
		            <?php
		            $options = array(
		                'None' => 'none', 
		                'ID' => 'ID',
		                'Name' => 'name', 
		                'Date' => 'date',
		                'Modified Date' => 'modified',
		                'Random' => 'rand',
		                'Admin (custom order)' => 'menu_order'
		                );
		            foreach ($options as $name=>$value) {
		            	$selected = ($orderby == $value) ? ' selected="selected"' : '';
		                ?><option value="<?php echo wp_kses_post($value); ?>" id="<?php echo wp_kses_post($value); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($name); ?></option><?php 		                
		            }
		            ?>
		            </select>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('order')); ?>"><?php esc_html_e('Order:','tour-operator'); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('order')); ?>"
				id="<?php echo wp_kses_post($this->get_field_id('order')); ?>" class="widefat">
		            <?php
		            $options = array(
		                'Ascending' => 'ASC', 
		                'Descending' => 'DESC'
		                );
		            foreach ($options as $name=>$value) {
		            	$selected = ($order == $value) ? ' selected="selected"' : '';
		                ?><option value="<?php echo wp_kses_post($value); ?>" id="<?php echo wp_kses_post($value); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($name); ?></option><?php 				                
		            }
		            ?>
		    </select>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('limit')); ?>"><?php esc_html_e('Maximum amount:','tour-operator'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('limit')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('limit')); ?>" type="text"
				value="<?php echo wp_kses_post($limit); ?>" /> <small><?php esc_html_e('Leave empty to display all','tour-operator'); ?></small>
		</p>
		
		<p class="bs-tourism-specify">
			<label for="<?php echo wp_kses_post($this->get_field_id('include')); ?>"><?php esc_html_e('Specify Tours by ID:','tour-operator'); ?></label>
			<input class="widefat"
				id="<?php echo wp_kses_post($this->get_field_id('include')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('include')); ?>" type="text"
				value="<?php echo wp_kses_post($include); ?>" /> <small><?php esc_html_e('Comma separated list, overrides limit setting','tour-operator'); ?></small>
		</p>
		
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('featured')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('featured')); ?>"
				type="checkbox" value="1" <?php checked( '1', $featured ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('featured')); ?>"><?php esc_html_e('Featured Items','tour-operator'); ?></label>
		</p>
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('disable_placeholder')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('disable_placeholder')); ?>" type="checkbox"
				value="1" <?php checked( '1', $disable_placeholder ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('disable_placeholder')); ?>"><?php esc_html_e('Disable Featured Image','tour-operator'); ?></label>
		</p>		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('size')); ?>"><?php esc_html_e('Icon size:','tour-operator'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('size')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('size')); ?>" type="text"
				value="<?php echo wp_kses_post($size); ?>" />
		</p>
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('buttons')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('buttons')); ?>" type="checkbox"
				value="1" <?php checked( '1', $buttons ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('buttons')); ?>"><?php esc_html_e('Display Button','tour-operator'); ?></label>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('button_text')); ?>"><?php esc_html_e('Button Text:','tour-operator'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('button_text')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('button_text')); ?>" type="text"
				value="<?php echo wp_kses_post($button_text); ?>" />
		</p>		
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('responsive')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('responsive')); ?>"
				type="checkbox" value="1" <?php checked( '1', $responsive ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('responsive')); ?>"><?php esc_html_e('Responsive Images','tour-operator'); ?></label>
		</p>

		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('carousel')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('carousel')); ?>"
				type="checkbox" value="1" <?php checked( '1', $carousel ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('carousel')); ?>"><?php esc_html_e('Enable Carousel','tour-operator'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('interval')); ?>"><?php esc_html_e('Slide Interval:','tour-operator'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('size')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('interval')); ?>" type="text"
				value="<?php echo wp_kses_post($interval); ?>" />
			<small>Type "false" to disable.</small>				
		</p>
		
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('indicators')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('indicators')); ?>" type="checkbox"
				value="1" <?php checked( '1', $indicators ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('indicators')); ?>"><?php esc_html_e('Show Indicators','tour-operator'); ?></label>
		</p>			
		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('post_type')); ?>"><?php esc_html_e( 'Post Type:', 'tour-operator' ); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('post_type')); ?>" id="<?php echo wp_kses_post($this->get_field_id('post_type')); ?>"	class="widefat layout">
	            <?php
	            $options = to_get_post_types();
	            foreach ($options as $value => $name) {
	            	$selected = ($post_type == $value) ? ' selected="selected"' : '';
	                ?><option value="<?php echo wp_kses_post($value); ?>" id="<?php echo wp_kses_post($value); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($name); ?></option><?php 			                
	            }
	            ?>
		    </select>
		</p>
		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('class')); ?>"><?php esc_html_e('Class:','tour-operator'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('class')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('class')); ?>" type="text"
				value="<?php echo wp_kses_post($class); ?>" />
			<small><?php esc_html_e('Add your own class to the opening element of the widget','tour-operator'); ?></small>
		</p>		
		
		<script>
		        jQuery(document).ready(function($) {
		            var valueSelected = $("#widget-bs_tourism_widget-2-group :selected").val();
		
		            if ( valueSelected == 'all' ) {
		                $('.bs-tourism-specify').show();                
		            } else {
		                $('.bs-tourism-specify').hide();
		            }
		            $("#widget-bs_tours_widget-2-group").change(function() {
		                var valueSelected = this.value;
		
		                if ( valueSelected == 'all' ) {
		                    $('.bs-tourism-specify').show();                
		                } else {
		                    $('.bs-tourism-specify').hide();
		                }
		            });
		        });
		        </script>
		<?php
        
    }
    
    public function output( $atts )
    {
    	global $columns,$disable_placeholder;
    	
    	extract( shortcode_atts( array(
    	'tag' => 'h3',
    	'tagline' => '',
    	'columns' => 1,
    	'orderby' => 'date',
    	'link'	=> false,
    	'order' => 'DESC',
    	'limit' => '-1',
    	'include' => '',
    	'size' => 100,
    	'disable_placeholder' => false,
    	'buttons' => false,
    	'button_text' => false,
    	'responsive' => true,
    	'carousel' => false,
    	'layout' => 'standard',
    	'featured' => false,
    	'post_type' => 'accommodation',
    	'interval' => '7000',
    	'indicators' => 1
    	), $atts ) );
    
    	$output = "";
    
    	if ( 'true'  == $responsive) {
    		$responsive = 'img-responsive';
    	} else {
    		$responsive = '';
    	}
    	$paper = 'paper';
    	if('video' == $post_type){
			$post_type = 'destination';
			$paper = '';
		}
    
    	if ( '' != $include ) {
    		$include = explode( ',', $include );
    		$args = array(
    				'post_type' => $post_type,
    				'posts_per_page' => $limit,
					'post__in' => $include,
					'orderby' => 'post__in',
					'order' => $order 
			);
		} else {
			$args = array (
					'post_type' => $post_type,
					'posts_per_page' => $limit,
					'orderby' => $orderby,
					'order' => $order 
			);
		}
		
		if ($featured) {
			$args ['meta_key'] = 'featured';
			$args ['meta_value'] = 1;
		}		

		if('none' !== $orderby){
			$args['disabled_custom_post_order'] = true;
		}

		$widget_query = new WP_Query( $args );
		if ($widget_query->have_posts()) {

			if('review' === $post_type){
				add_filter('to_placeholder_url', array($this,'placeholder') , 10 , 1 );
			}
			
			$count = 1;
			
			//output the opening boostrap row divs
			$this->before_while($columns,$carousel,$post_type,$widget_query->post_count);
			
			while ( $widget_query->have_posts() ) {
				$widget_query->the_post();
				
				$this->loop_start($columns,$carousel,$post_type,$widget_query->post_count,$count,$interval);
				echo wp_kses_post('<div '.to_widget_class(true).'>');
				$this->content_part('content','widget-'.$post_type);
				echo wp_kses_post('</div>');
				$this->loop_end($columns,$carousel,$post_type,$widget_query->post_count,$count);
				
				$count++;
			}
			
			//output the closing boostrap row divs
			$this->after_while($columns,$carousel,$post_type,$widget_query->post_count);	
			
			if(false !== $buttons && false !== $link){
				
				echo wp_kses_post('
									<div class="view-more">
									<a href="'.$link.'" class="btn">'.$button_text.'</a>
									</div>
								');
			}
			
			wp_reset_query();
			wp_reset_postdata();

			if('review' === $post_type){
				remove_filter('to_placeholder_url', array($this,'placeholder') , 10 , 1 );
			}				
		}
	}

	/**
	 * Replaces the widget with Mystery Man
	 */
	public function placeholder($image){
		$url = plugin_dir_url( __FILE__ );
		$url = str_replace('/includes','/assets/img',$url).'/mystery-man-wide.png';
		$image = array(
			$url,
			350,
			230,
			true
		);
		return $image;
	}	
	
	/**
	 * Runs just after the if and before the while statement in $this->output()
	 */
	public function before_while($columns = 1,$carousel = 0,$post_type='',$post_count = 0,$interval='false') {
		$output = '';
		// Carousel Output Opening
		if ($carousel) {
			$landing_image = '';	
			$this->carousel_id = rand ( 20, 20000 );
		
			$output .= "<div class='slider-container'>";
			$output .= "<div id='slider-{$this->carousel_id}' class='carousel slide' data-interval='{$interval}'>";
			$output .= '<div class="carousel-wrap">';
			$output .= '<div class="carousel-inner" role="listbox">';
		
			$this->pagination = '';
		} else {
			$output .= "<div class='row lsx-{$post_type}'>";
		}
		echo wp_kses_post($output);
	}
	
	/**
	 * Runs at the very end of the loop before it runs again.
	 */
	public function loop_start($columns = 1,$carousel = 0,$post_type='',$post_count = 0,$count = 0){
		$output = '';
		// Get the call for the active slide
		if ($carousel) {
			if (1 == $count) {
				$slide_active = 'active';
			} else {
				$slide_active = '';
			}
			
			$pages = ceil( $post_count / $columns );
	
			if (1 == $count) {
				$output .= "<div class='item $slide_active row'>";
				$output .= "<div class='lsx-{$post_type}'>";
				
				$i = 0;
				while ( $i < $pages ) {
					$this->pagination .= "<li data-target='#slider-{$this->carousel_id}' data-slide-to='{$i}' class='". ( 0 == $i ? 'active' : '' ) ."'></li>";
					$i++;
				}
			}
		} else {
			if ( 1 == $count) {
				$output .= "<div class='row lsx-{$post_type}'>";
			}
		}
		
		echo wp_kses_post($output);
	}
	
	/**
	 * Runs at the very end of the loop before it runs again.
	 */
	public function loop_end($columns = 1,$carousel = 0,$post_type='',$post_count = 0,$count = 0){
		$output = '';
		// Close the current slide panel
		if (0 == $count % $columns || $count === $post_count) {
			if ($carousel) {
				$output .= "</div></div>";
				if ($count < $post_count) {
					$output .= "<div class='item row'><div class='lsx-{$post_type}'>";
				}
			} else {
				$output .= "</div>";
				if ($count < $post_count) {
					$output .= "<div class='row lsx-{$post_type}'>";
				}
			}
		}
		echo wp_kses_post($output);
	}
	
	/**
	 * Runs just after the if and before the while statement in $this->output()
	 */
	public function after_while($columns = 1,$carousel = 0,$post_type='',$post_count = 0) {
		$output = '';
		// Carousel output Closing
		if ($carousel) {
			$pages = ceil( $post_count / $columns );
			
			$output .= "</div>";

			if ( $pages > 1 ) {
				$output .= '<a class="left carousel-control" href="#slider-'.$this->carousel_id.'" role="button" data-slide="prev">';
				$output .= '<span class="fa fa-chevron-left" aria-hidden="true"></span>';
				$output .= '<span class="sr-only">'.__('Previous','tour-operator').'</span>';
				$output .= '</a>';
				$output .= '<a class="right carousel-control" href="#slider-'.$this->carousel_id.'" role="button" data-slide="next">';
				$output .= '<span class="fa fa-chevron-right" aria-hidden="true"></span>';
				$output .= '<span class="sr-only">'.__('Next','tour-operator').'</span>';
				$output .= '</a>';
			}

			$output .= "</div>";

			if ( $pages > 1 ) {
				$output .= '<ol class="carousel-indicators">'.$this->pagination.'</ol>';
			}

			$output .= "</div>";
			$output .= "</div>";
		} else {
			$output .= "</div>";
		}
		
		echo wp_kses_post($output);
	}	
	
	/**
	 * Redirect wordpress to the single template located in the plugin
	 *
	 * @param	$template
	 *
	 * @return	$template
	 */
	public function content_part($slug, $name = null) {
		$template = array();
		$name = (string) $name;
		if ( '' !== $name ){
			$template = "{$slug}-{$name}.php";
		}else{
			$template = "{$slug}.php";
		}
		$original_name = $template;
		$path = apply_filters('to_widget_path','',get_post_type());
		
		if ( '' == locate_template( array( $template ) ) && file_exists( $path.'templates/'.$template) ) {
			$template = $path.'templates/'.$template;
		}elseif(file_exists( get_stylesheet_directory().'/'.$template)){
			$template = get_stylesheet_directory().'/'.$template;
		}else{
			$template = false;
		}
		
		if(false !== $template){
			load_template( $template, false );
		}else {
			echo wp_kses_post('<p>No '.$original_name.' can be found.</p>');
		}
	}	
}
?>