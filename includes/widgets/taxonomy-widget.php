<?php
/**
 * @package   TO_Taxonomy_Widget
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeed
 *
 **/

class TO_Taxonomy_Widget extends WP_Widget {	
	
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'lsx-widget',
			'description' => 'TO Taxonomy',
		);
		parent::__construct( 'TO_Taxonomy_Widget', 'TO Taxonomies', $widget_ops );
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
		if (isset($instance['taxonomy'])) {
			$taxonomy = $instance['taxonomy'];
		} else {
			$taxonomy = false;
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
              
        
        
        if ( false != $title ) {
        	$title = $before_title . $link_open . $title . $link_close . $after_title;
        	echo wp_kses_post(apply_filters('to_taxonomy_widget_title', $title));
        }  
        if ( false != $tagline ) {
        	echo wp_kses_post('<p class="tagline">'.$tagline.'</p>');
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
			'taxonomy' => $taxonomy,
			'class' => $class,
			'interval' => $interval,
			'indicators' => $indicators,
		);
		                

		$args['carousel'] = $carousel;               
		              
		echo wp_kses_post($this->output($args));                 

        echo wp_kses_post($after_widget);    
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['tagline'] = strip_tags( $new_instance['tagline'] );
    $instance['title_link'] = strip_tags( $new_instance['title_link'] );
    $instance['columns'] = strip_tags( $new_instance['columns'] );
    $instance['orderby'] = strip_tags( $new_instance['orderby'] );
    $instance['order'] = strip_tags( $new_instance['order'] );
    $instance['limit'] = strip_tags( $new_instance['limit'] );
    $instance['include'] = strip_tags( $new_instance['include'] );
    $instance['size'] = strip_tags( $new_instance['size'] );
    $instance['disable_placeholder'] = strip_tags( $new_instance['disable_placeholder'] );
    $instance['buttons'] = strip_tags( $new_instance['buttons'] );
    $instance['button_text'] = strip_tags( $new_instance['button_text'] );
    $instance['responsive'] = strip_tags( $new_instance['responsive'] );
    $instance['carousel'] = strip_tags( $new_instance['carousel'] );
    $instance['taxonomy'] = strip_tags( $new_instance['taxonomy'] );
    $instance['class'] = strip_tags( $new_instance['class'] );
    $instance['interval'] = strip_tags( $new_instance['interval'] );
    $instance['indicators'] = strip_tags( $new_instance['indicators'] );
    
    return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
    
        $defaults = array( 
            'title' => '',
            'title_link' => '',
        	'tagline' => '',
            'columns' => '1', 
            'orderby' => 'date',
            'order' => 'DESC',
            'limit' => '',
            'include' => '',
            'size' => '100', 
            'disable_placeholder' => false,
            'buttons' => false,   
        	'button_text' => false,
            'responsive' => 1,
        	'taxonomy' => '',
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
        $button_text= esc_attr($instance['button_text']);
        $responsive = esc_attr($instance['responsive']);
        $taxonomy = esc_attr($instance['taxonomy']);
        $class = esc_attr($instance['class']);
        $interval = esc_attr($instance['interval']);    
        $carousel = esc_attr($instance['carousel']);
        $interval = esc_attr($instance['interval']);
        $indicators = esc_attr($instance['indicators']);
        	      

        ?>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('title')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('title')); ?>" type="text"
				value="<?php echo wp_kses_post($title); ?>" />
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('title_link')); ?>"><?php esc_attr_e( 'Title Link:' ); ?></label>
			<input class="widefat"
				id="<?php echo wp_kses_post($this->get_field_id('title_link')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('title_link')); ?>" type="text"
				value="<?php echo wp_kses_post($title_link); ?>" /> <small>Link the widget title to
				a URL</small>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('tagline')); ?>"><?php esc_attr_e('Tagline:'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('tagline')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('tagline')); ?>" type="text"
				value="<?php echo wp_kses_post($tagline); ?>" />
		</p>
		
		<h4 class="widget-title" style="border-top: 1px solid #e5e5e5;padding-top:10px;"><?php esc_attr_e('Query','lsx-framework');?></h4>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('taxonomy')); ?>"><?php esc_attr_e( 'Taxonomy:', 'lsx-framework' ); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('taxonomy')); ?>" id="<?php echo wp_kses_post($this->get_field_id('taxonomy')); ?>"	class="widefat layout">
	            <?php
	            $options = array();	            
	            $options = to_get_taxonomies();
	            if(empty($options)){
	            	$options['none'] = esc_attr__('None','tour-operator');
	            }

	            foreach ($options as $key => $name) {
	            	$selected = ($taxonomy == $key) ? ' selected="selected"' : '';
	                ?><option value="<?php echo wp_kses_post($key); ?>" id="<?php echo wp_kses_post($key); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($name); ?></option><?php 		                
	            }
	            ?>
		    </select>
		</p>		
		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('orderby')); ?>"><?php esc_attr_e('Order By:','lsx-framework'); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('orderby')); ?>"
				id="<?php echo wp_kses_post($this->get_field_id('orderby')); ?>" class="widefat">
		            <?php
		            $options = array(
		                'Name' => 'name', 
		                'Slug' => 'slug',
		                'ID' => 'term_id',
		                'Count' => 'count',
		                'Admin (custom order)' => 'none'
		                );
		            foreach ($options as $name=>$value) {
		            	$selected = ($orderby == $value) ? ' selected="selected"' : '';
		                ?><option value="<?php echo wp_kses_post($value); ?>" id="<?php echo wp_kses_post($value); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($name); ?></option><?php 			            	
		            }
		            ?>
		            </select>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('order')); ?>"><?php esc_attr_e('Order:','lsx-framework'); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('order')); ?>"
				id="<?php echo wp_kses_post($this->get_field_id('order')); ?>" class="widefat">
		            <?php
		            $options = array(
		                'Ascending' => 'ASC', 
		                'Descending' => 'DESC'
		                );
		            foreach ($options as $name=>$value) {
		            	$selected = ($orderby == $value) ? ' selected="selected"' : '';
		                ?><option value="<?php echo wp_kses_post($value); ?>" id="<?php echo wp_kses_post($value); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($name); ?></option><?php
		            }
		            ?>
		    </select>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('limit')); ?>"><?php esc_attr_e('Maximum amount:','lsx-framework'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('limit')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('limit')); ?>" type="text"
				value="<?php echo wp_kses_post($limit); ?>" /> <small><?php esc_attr_e('Leave empty to display all','lsx-framework'); ?></small>
		</p>
		
		<p class="bs-tourism-specify">
			<label for="<?php echo wp_kses_post($this->get_field_id('include')); ?>"><?php esc_attr_e('Specify by ID:','lsx-framework'); ?></label>
			<input class="widefat"
				id="<?php echo wp_kses_post($this->get_field_id('include')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('include')); ?>" type="text"
				value="<?php echo wp_kses_post($include); ?>" /> <small><?php esc_attr_e('Comma separated list, overrides limit setting','lsx-framework'); ?></small>
		</p>
		
						
		
		<h4 class="widget-title" style="border-top: 1px solid #e5e5e5;padding-top:10px;"><?php esc_attr_e('Layout','lsx-framework');?></h4>		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('columns')); ?>"><?php esc_attr_e('Columns:','lsx-framework'); ?></label>
			<select name="<?php echo wp_kses_post($this->get_field_name('columns')); ?>"
				id="<?php echo wp_kses_post($this->get_field_id('columns')); ?>"
				class="widefat layout">
		            <?php
		            $options = array('1', '2', '3', '4', '5', '6');
		            foreach ($options as $option) {
		            	$key = lcfirst($option);
		            	$selected = ($columns == $key) ? ' selected="selected"' : '';
		                ?><option value="<?php echo wp_kses_post($key); ?>" id="<?php echo wp_kses_post($key); ?>" <?php echo wp_kses_post($selected); ?>><?php echo wp_kses_post($option); ?></option><?php		            	
		            }
		            ?>
		     </select>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('class')); ?>"><?php esc_attr_e('Class:','lsx-framework'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('class')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('class')); ?>" type="text"
				value="<?php echo wp_kses_post($class); ?>" />
			<small>Add your own class to the opening element of the widget</small>	
		</p>
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('disable_placeholder')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('disable_placeholder')); ?>" type="checkbox"
				value="1" <?php checked( '1', $disable_placeholder ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('disable_placeholder')); ?>"><?php esc_attr_e('Disable Featured Image'); ?></label>
		</p>		
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('size')); ?>"><?php esc_attr_e('Thumbnail size:','lsx-framework'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('size')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('size')); ?>" type="text"
				value="<?php echo wp_kses_post($size); ?>" />
		</p>
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('buttons')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('buttons')); ?>" type="checkbox"
				value="1" <?php checked( '1', $buttons ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('buttons')); ?>"><?php esc_attr_e('Display Button','lsx-framework'); ?></label>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('button_text')); ?>"><?php esc_attr_e('Button Text:','lsx-framework'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('button_text')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('button_text')); ?>" type="text"
				value="<?php echo wp_kses_post($button_text); ?>" />
		</p>		
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('responsive')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('responsive')); ?>"
				type="checkbox" value="1" <?php checked( '1', $responsive ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('responsive')); ?>"><?php esc_attr_e('Responsive Images'); ?></label>
		</p>		
		
		<h4 class="widget-title" style="border-top: 1px solid #e5e5e5;padding-top:10px;"><?php esc_attr_e('Slider','lsx-framework');?></h4>
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('carousel')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('carousel')); ?>"
				type="checkbox" value="1" <?php checked( '1', $carousel ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('carousel')); ?>"><?php esc_attr_e('Enable Carousel','lsx-framework'); ?></label>
		</p>
		<p>
			<label for="<?php echo wp_kses_post($this->get_field_id('interval')); ?>"><?php esc_attr_e('Slide Interval:','lsx-framework'); ?></label>
			<input class="widefat" id="<?php echo wp_kses_post($this->get_field_id('size')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('interval')); ?>" type="text"
				value="<?php echo wp_kses_post($interval); ?>" />
			<small>Type "false" to disable.</small>				
		</p>
		<p>
			<input id="<?php echo wp_kses_post($this->get_field_id('indicators')); ?>"
				name="<?php echo wp_kses_post($this->get_field_name('indicators')); ?>" type="checkbox"
				value="1" <?php checked( '1', $indicators ); ?> /> <label
				for="<?php echo wp_kses_post($this->get_field_id('indicators')); ?>"><?php esc_attr_e('Show Indicators','lsx-framework'); ?></label>
		</p>
		<?php
        
    }
    
    public function output( $atts )
    {
    	global $columns,$term,$taxonomy,$disable_placeholder;
    	extract( shortcode_atts( array(
    	'tag' => 'h3',
    	'tagline' => '',
    	'columns' => 1,
    	'orderby' => 'date',
    	'order' => 'DESC',
    	'limit' => '-1',
    	'include' => '',
    	'size' => 100,
    	'disable_placeholder' => false,
    	'link' => false,
    	'buttons' => false,
    	'button_text' => false,
    	'responsive' => true,
    	'carousel' => false,
    	'layout' => 'standard',
    	'taxonomy' => '',
    	'interval' => '7000',
    	'indicators' => 1
    	), $atts ) );
    
    	$output = "";
    
    	if ( 'true' == $responsive ) {
    		$responsive = 'img-responsive';
    	} else {
    		$responsive = '';
    	}
    
    	if ( '' != $include ) {
    		$include = explode( ',', $include );
    		$args = array(
    				'number' => $limit,
					'include' => $include,
					'orderby' => 'include',
					'order' => $order,
    				'hide_empty' => 0
			);
		} else {
			$args = array (
					'number' => $limit,
					'orderby' => $orderby,
					'order' => $order,
    				'hide_empty' => 0 
			);
		}

		if('none' !== $orderby){
			$args['suppress_filters'] = true;
		}
		
		$widget_query = get_terms( $taxonomy,$args );

		if ( ! empty( $widget_query ) && ! is_wp_error( $widget_query ) ){
			$count = 1;
			$this->before_while($columns,$carousel,$taxonomy,count($widget_query));
			
			foreach ( $widget_query as $term ) {
				$this->loop_start($columns,$carousel,$taxonomy,count($widget_query),$count,$interval);
				echo wp_kses_post('<div '.to_widget_class(true).'>');
				$this->content_part('content','widget-'.$taxonomy);
				echo wp_kses_post('</div>');
				$this->loop_end($columns,$carousel,$taxonomy,count($widget_query),$count);
				
				$count++;
			}
			$this->after_while($columns,$carousel,$taxonomy,count($widget_query));
			
			if(false !== $buttons && false != $link){
				echo wp_kses_post('
									<div class="view-more">
									<a href="'.$link.'" class="btn">'.$button_text.'</a>
									</div>
								');
			}			
		}
		return $output;
	}

	/**
	 * Runs just after the if and before the while statement in $this->output()
	 */
	public function before_while($columns = 1,$carousel = 0,$taxonomy='',$post_count = 0,$interval='false') {
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
			$output .= "<div class='row lsx-{$taxonomy}'>";
		}
		echo wp_kses_post($output);
	}
	
	/**
	 * Runs at the very end of the loop before it runs again.
	 */
	public function loop_start($columns = 1,$carousel = 0,$taxonomy='',$post_count = 0,$count = 0){
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
				$output .= "<div class='lsx-{$taxonomy}'>";

				$i = 0;
				while ( $i < $pages ) {
					$this->pagination .= "<li data-target='#slider-{$this->carousel_id}' data-slide-to='{$i}' class='". ( 0 == $i ? 'active' : '' ) ."'></li>";
					$i++;
				}
			}
		} else {
			if (1 == $count) {
				$output .= "<div class='row lsx-{$taxonomy}'>";
			}
		}
		
		echo wp_kses_post($output);
	}
	
	/**
	 * Runs at the very end of the loop before it runs again.
	 */
	public function loop_end($columns = 1,$carousel = 0,$taxonomy='',$post_count = 0,$count = 0){
		$output = '';
		// Close the current slide panel
		if (0 == $count % $columns || $count === $post_count) {
			if ($carousel) {
				$output .= "</div></div>";
				if ($count < $post_count) {
					$output .= "<div class='item row'><div class='lsx-{$taxonomy}'>";
				}
			} else {
				$output .= "</div>";
				if ($count < $post_count) {
					$output .= "<div class='row lsx-{$taxonomy}'>";
				}
			}
		}
		echo wp_kses_post($output);
	}
	
	/**
	 * Runs just after the if and before the while statement in $this->output()
	 */
	public function after_while($columns = 1,$carousel = 0,$taxonomy='',$post_count = 0) {
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
		global $taxonomy;
		
		$template = array();
		$name = (string) $name;
		if ( '' !== $name ){
			$template = "{$slug}-{$name}.php";
		}else{
			$template = "{$slug}.php";
		}
		$original_name = $template;
		$path = apply_filters('to_widget_path','',$taxonomy);

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