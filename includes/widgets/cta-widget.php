<?php
/**
 * @package   TO_CTA_Widget
 * @author    LightSpeed
 * @license   GPL3
 * @link      
 * @copyright 2016 LightSpeed
 *
 **/

class TO_CTA_Widget extends WP_Widget {	
	
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'lsx-widget',
			'description' => 'Displays a nifty call to action.',
		);
		parent::__construct( 'TO_CTA_Widget', 'LSX CTA', $widget_ops );
        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
    }

    /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    public function widget( $args, $instance ) {
        extract( $args );

		if (isset($instance['class'])) {
			$class = $instance['class'];
		} else {
			$class = false;
		}
        
    	if (isset($instance['title'])) {
			$title = apply_filters('widget_title', $instance['title']);
		} else {
			$title = false;
		}

		$widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';

		$styletag = '';
    	if (isset($instance['image']) && ! empty($instance['image'])) {
			$styletag .= 'background-image:url('.$instance['image'].');background-position-x:'.$instance['pos_x'].';background-position-y:'.$instance['pos_y'].';background-size:'.$instance['size'].';background-repeat:'.$instance['repeat'].';background-color:#'.$instance['color'].';';
		}	
		$styletag .= '';

		$before_widget = str_replace('lsx-widget"', 'lsx-widget image-'.$instance['pos_x'].'"', $before_widget);
        $class = 'class="'.$class.' ';

        echo str_replace('class="',$class,$before_widget);
        
        if ( false != $title ) {
        	$title = $before_title . $title . $after_title;
        	echo apply_filters('to_cta_widget_title', $title);
        }    

        if ( false != $widget_text ) {
        	$text = apply_filters( 'widget_text', $widget_text, $instance, $this );
        	?>
        	<div class="textwidget">
				<div class="lsx-full-width-alt" style="<?php echo $styletag; ?>">
					<div class="lsx-hero-unit">        	
        				<?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
        			</div>
        		</div>
        	</div> 
        	<?php  
        }
                    

        echo $after_widget;    
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
    	$instance = $old_instance;
    	$instance['title'] = strip_tags( $new_instance['title'] );
    	$instance['image'] = $new_instance['image'];
    	$instance['class'] = strip_tags( $new_instance['class'] );
    	$instance['pos_x'] = $new_instance['pos_x'];
    	$instance['pos_y'] = $new_instance['pos_y'];
    	$instance['size'] = $new_instance['size'];
    	$instance['repeat'] = $new_instance['repeat'];
    	$instance['color'] = $new_instance['color'];
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = wp_kses_post( stripslashes( $new_instance['text'] ) );    	
    	return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
    
        $defaults = array( 
            'title' => '',
            'image' => false,
        	'class' => '',
            'pos_x' => 'center',
            'pos_y' => 'center',
            'size' => 'contain',
            'repeat' => 'no-repeat',
            'color' => 'no-repeat',
            'text' => '#333333',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );   
        extract( $instance );
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>" type="text"
				value="<?php echo $title; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea></p>		
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Background Image:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>"
				name="<?php echo $this->get_field_name('image'); ?>" type="text"
				value="<?php echo $image; ?>" />
			<input class="upload_image_button button button-primary" type="button" value="Upload Image" />	
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Class:','lsx-framework'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('class'); ?>"
				name="<?php echo $this->get_field_name('class'); ?>" type="text"
				value="<?php echo $class; ?>" />
			<small>Add your own class to the opening element of the widget</small>	
		</p>	
		
		<h4 class="widget-title" style="border-top: 1px solid #e5e5e5;padding-top:10px;"><?php _e('Background CSS','lsx-framework');?></h4>
		<p>
			<label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Colour:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('color'); ?>"
				name="<?php echo $this->get_field_name('color'); ?>" type="text"
				value="<?php echo $color; ?>" />
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id('pos_x'); ?>"><?php _e('Position X:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('pos_x'); ?>"
				name="<?php echo $this->get_field_name('pos_x'); ?>" type="text"
				value="<?php echo $pos_x; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('pos_y'); ?>"><?php _e('Position Y:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('pos_y'); ?>"
				name="<?php echo $this->get_field_name('pos_y'); ?>" type="text"
				value="<?php echo $pos_y; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:','lsx-framework'); ?></label>
			<select name="<?php echo $this->get_field_name('size'); ?>"
				id="<?php echo $this->get_field_id('size'); ?>" class="widefat">
		            <?php
		            $options = array(
		                'Contain' => 'contain', 
		                'Cover' => 'cover'
		                );
		            foreach ($options as $name=>$value) {
		                echo '<option value="' . $value . '" id="' . $value . '"', $size == $value ? ' selected="selected"' : '', '>', $name, '</option>';
		            }
		            ?>
		    </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('repeat'); ?>"><?php _e('Repeat:','lsx-framework'); ?></label>
			<select name="<?php echo $this->get_field_name('repeat'); ?>"
				id="<?php echo $this->get_field_id('repeat'); ?>" class="widefat">
		            <?php
		            $options = array(
		                'No Repeat' => 'no-repeat', 
		                'Repeat X' => 'repeat-x',
		                'Repeat Y' => 'repeat-y'
		                );
		            foreach ($options as $name=>$value) {
		                echo '<option value="' . $value . '" id="' . $value . '"', $size == $value ? ' selected="selected"' : '', '>', $name, '</option>';
		            }
		            ?>
		    </select>
		</p>		

		<script>
			jQuery(document).ready(function($) {
			    $(document).on("click", ".upload_image_button", function() {
			        jQuery.data(document.body, 'prevElement', $(this).prev());
			        var prevElement = $(this).prev();

			        window.send_to_editor = function(html) {
			            var imgurl = $(html).find('img').attr('src');
			            var inputText = jQuery.data(document.body, 'prevElement');

			            if(inputText != undefined && inputText != '')
			            {
			                inputText.val(imgurl);
			            }
			            tb_remove();
			        };

			        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
			        return false;
			    });
			});		
		</script>	

		<?php
        
    }	
}
?>