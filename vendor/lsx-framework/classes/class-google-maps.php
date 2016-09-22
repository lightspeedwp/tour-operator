<?php
/**
 * LSX Framework
 *
 * @package		LSX Framework
 * @author		LightSpeed Team
 * @license		GPL-2.0+
 * @copyright	2015  LightSpeed Team
 */

/**
 * A class that modules can use and extend.
 * @package		LSX Maps
 * @subpackage	classes
 * @category	maps
 */
class LSX_Maps {
	/**
	 * Holds class the framework url includeing the class.
	 *
	 * @since 0.0.1
	 *
	 * @var      object|Lsx
	 */
	public $framework_url = null;

	/**
	 * Holds an array of the post types you can assign Map Markers to.
	 *
	 * @since 0.0.1
	 *
	 * @var      object|Lsx
	 */
	public $markers = false;
		
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 */
	public function __construct($framework_url=false,$post_types=array()) {	
		$this->framework_url = $framework_url;

		$this->options = get_option('_lsx_lsx-settings',false);
		if(!empty($post_types)){
			$this->post_types = $post_types;
		}else{
			$this->post_types = false;
		}

		if(false !== $this->options && isset($this->options['general']['googlemaps_key'])){
			$this->api_key = $this->options['general']['googlemaps_key'];

			$this->markers = new stdClass();
			if(isset($this->options['general']['googlemaps_marker']) && '' !== $this->options['general']['googlemaps_marker']){
				$this->markers->default_marker = $this->options['general']['googlemaps_marker'];
			}else{
				$this->markers->default_marker = $this->framework_url.'assets/svg/gmaps-mark.svg';
			}

			if(isset($this->options['general']['gmap_cluster_small']) && '' !== $this->options['general']['gmap_cluster_small']){
				$this->markers->cluster_small = $this->options['general']['gmap_cluster_small'];
			}else{
				$this->markers->cluster_small = $this->framework_url.'assets/img/m1.png';
			}

			if(isset($this->options['general']['gmap_cluster_medium']) && '' !== $this->options['general']['gmap_cluster_medium']){
				$this->markers->cluster_medium = $this->options['general']['gmap_cluster_medium'];
			}else{
				$this->markers->cluster_medium = $this->framework_url.'assets/img/m2.png';
			}

			if(isset($this->options['general']['gmap_cluster_large']) && '' !== $this->options['general']['gmap_cluster_large']){
				$this->markers->cluster_large = $this->options['general']['gmap_cluster_large'];
			}else{
				$this->markers->cluster_large = $this->framework_url.'assets/img/m3.png';
			}		

		}else{
			$this->api_key = false;
		}
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action('lsx_framework_dashboard_tab_content_api',array($this,'api_key_settings'),5);

		add_action('lsx_framework_dashboard_tab_content',array($this,'map_marker'),12);
		if(!empty($post_types)){
			foreach($this->post_types as $post_type){

				if(isset($this->options[$post_type]['googlemaps_marker']) && '' !== $this->options[$post_type]['googlemaps_marker']){
					$this->markers->post_types[$post_type] = $this->options[$post_type]['googlemaps_marker'];
				}else{
					$this->markers->post_types[$post_type] = $this->framework_url.'assets/img/'.$post_type.'-marker.png';
				}	

				add_action('lsx_framework_'.$post_type.'_tab_content',array($this,'map_marker'),10,1);
			}
		}

		$this->markers->start = $this->framework_url.'assets/img/start-marker.png';
		$this->markers->end = $this->framework_url.'assets/img/end-marker.png';
	}

	/**
	 * Register and enqueue front-specific style sheet.
	 *
	 * @since 1.0.0
	 *
	 * @return    null
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('googlemaps_api', 'https://maps.googleapis.com/maps/api/js?key='.$this->api_key.'&libraries=places', array('jquery'), null, true);
		wp_enqueue_script('googlemaps_api_markercluster', $this->framework_url . '/assets/js/google-markerCluster.js', array('googlemaps_api'), null, true);
		wp_enqueue_script('lsx_maps', $this->framework_url . '/assets/js/lsx-maps.js', array('jquery','googlemaps_api','googlemaps_api_markercluster'), null, true);
		wp_localize_script( 'lsx_maps', 'lsx_maps_params', array(
			'apiKey' => $this->api_key,
			'start_marker' => $this->markers->start,
			'end_marker' => $this->markers->end,
		) );			
	}
	
	/**
	 * Output the Map
	 *
	 * @since 1.0.0
	 *
	 * @return    null
	 */
	public function map_output($post_ID=false,$args=array()) {
		$defaults = array(
			'lat' => '-33.914482',
			'long' => '18.3758789',				
			'zoom' => 14,
			'width' => '100%',
			'height' => '400px',
			'type' => 'single',
			'search' => false,
			'connections' => false,
			'link' => true,
			'selector' => '.lsx-map-preview',
			'icon' => false,
			'content' => 'address',
			'kml'	=> false,
			'cluster_small'		=> $this->markers->cluster_small,
			'cluster_medium'	=> $this->markers->cluster_medium,
			'cluster_large'		=> $this->markers->cluster_large,
		);
		$args = wp_parse_args($args,$defaults);
		extract($args);
		
		$thumbnail='';

		if(false === $icon){
			$icon = $this->set_icon($post_ID);
		}
		
		if(false !== $search || 'cluster' === $type || 'route' === $type ){
			
			$map = '<div class="lsx-map" data-icon="'.$icon.'" data-type="'.$type.'" data-class="'.$selector.'"';
			if('route' === $type && false !== $args['kml']){
				$map .=' data-kml="'.$kml.'"';
			}
			$map .=' data-lat="'.$lat.'" data-long="'.$long.'" data-zoom="'.$zoom.'"';

			$map .=' data-cluster-small="'.$cluster_small.'" data-cluster-medium="'.$cluster_medium.'" data-cluster-large="'.$cluster_large.'"';

			$map .= '>';
			$map .= '<div class="lsx-map-preview" style="width:'.$width.';height:'.$height.';"></div>';
			
			$map .= '<div class="lsx-map-markers" style="display:none;">';
			
				if('single' === $type){ 
					$thumbnail = get_the_post_thumbnail_url($post_ID,array(100,100));
					$tooltip = $search;
					if('excerpt' === $content){ 
						$tooltip = strip_tags(get_the_excerpt( $post_ID ));
					}			
					$icon = $this->set_icon($post_ID);		
					$map .= '<div class="map-data" data-icon="'.$icon.'" data-id="'.$post_ID.'" data-long="'.$long.'" data-lat="'.$lat.'" data-thumbnail="'.$thumbnail.'" data-title="'.get_the_title($post_ID).'">
							<p style="line-height: 20px;">'.$tooltip.'</p>
						</div>';					
				}elseif(('cluster' === $type || 'route' === $type) && false !== $connections){
					if(!is_array($connections)){ $connections = array($connections); }

					foreach($connections as $connection){
						
						$location = get_post_meta($connection,'location',true);
						if(false !== $location && '' !== $location && is_array($location)){
							$thumbnail = '';
							if(''!==$location['long'] && ''!==$location['lat']){
								$thumbnail = get_the_post_thumbnail_url($connection,array(100,100));

								$tooltip = $location['address'];
								if('excerpt' === $content){ 
									$tooltip = strip_tags(get_the_excerpt( $connection ));
								}

								$icon = $this->set_icon($connection);
								
								$map .= '<div class="map-data" data-icon="'.$icon.'" data-id="'.$connection.'" data-long="'.$location['long'].'" data-lat="'.$location['lat'].'" data-link="'.get_permalink($connection).'" data-thumbnail="'.$thumbnail.'" data-title="'.get_the_title($connection).'">';

								ob_start();
									lsx_tour_operator_content( 'content', 'map-marker');
								$tooltip = ob_get_clean();

								$map .= $tooltip;
								$map .= '</div>';
							}
						}
					}
				}

			$map .= '</div>';				
			
			$map .= '</div>';
			return $map;
		}
	}

	/**
	 * outputs the genral tabs settings
	 */
	public function set_icon($post_id=false) {
		$icon = $this->markers->default_marker;
		if(false !== $post_id){
			$connection_type = get_post_type($post_id);


			if(in_array($connection_type,$this->post_types)){
				if(isset($this->markers->post_types[$connection_type])){
					$icon = $this->markers->post_types[$connection_type];
				}
			}else{
				$icon = apply_filters('lsx_default_map_marker',$this->markers->default_marker);
			}

		}
		return $icon;	
	}	

	/**
	 * outputs the genral tabs settings
	 */
	public function api_key_settings() { ?>
		<tr class="form-field-wrap">
			<th class="lsx-tour-operators_table_heading" style="padding-bottom:0px;" scope="row" colspan="2">
				<h4 style="margin-bottom:0px;"><span>Google Maps API</span></h4>
			</th>
		</tr>	
		<tr class="form-field">
			<th scope="row">
				<i class="dashicons-before dashicons-admin-network"></i><label for="title"> Key</label>
			</th>
			<td>
				<input type="text" {{#if googlemaps_key}} value="{{googlemaps_key}}" {{/if}} name="googlemaps_key" />
			</td>
		</tr>		
	<?php 	
	}

	/**
	 * outputs the genral tabs settings
	 */
	public function map_marker($tab = 'general') { ?>
		<th class="" style="padding-bottom:0px;" scope="row" colspan="2">
			<label><h3 style="margin-bottom:0px;"> Google Maps</h3></label>			
		</th>	
		<tr class="form-field">
			<th scope="row">
				<label for="title"> Choose a default marker</label>
			</th>
			<td>
				<input type="hidden" {{#if googlemaps_marker_id}} value="{{googlemaps_marker_id}}" {{/if}} name="googlemaps_marker_id" />
				<input type="hidden" {{#if googlemaps_marker}} value="{{googlemaps_marker}}" {{/if}} name="googlemaps_marker" />
				<div class="thumbnail-preview">
					{{#if googlemaps_marker}}<img src="{{googlemaps_marker}}" width="48" style="color:black;" />{{/if}}	
				</div>

				<a {{#if googlemaps_marker}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="googlemaps_marker">Choose Image</a>

				<a {{#unless googlemaps_marker}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="googlemaps_marker">Delete</a>	
			</td>
		</tr>	

		<?php if('general' === $tab) { ?>
			<tr class="form-field">
				<th scope="row">
					<label for="title"> Choose a cluster marker</label>
				</th>
				<td>
					<input type="hidden" {{#if gmap_cluster_small_id}} value="{{gmap_cluster_small_id}}" {{/if}} name="gmap_cluster_small_id" />
					<input type="hidden" {{#if gmap_cluster_small}} value="{{gmap_cluster_small}}" {{/if}} name="gmap_cluster_small" />
					<div class="thumbnail-preview">
						{{#if gmap_cluster_small}}<img src="{{gmap_cluster_small}}" width="48" style="color:black;" />{{/if}}	
					</div>

					<a {{#if gmap_cluster_small}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="gmap_cluster_small">Choose Image</a>

					<a {{#unless gmap_cluster_small}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="gmap_cluster_small">Delete</a>				
				</td>
			</tr>	
		<?php } ?>
		<?php /*
		<tr class="form-field">
			<th scope="row">
				<label for="title"> Cluster Marker Medium</label>
			</th>
			<td>
				<input type="hidden" {{#if gmap_cluster_medium_id}} value="{{gmap_cluster_medium_id}}" {{/if}} name="gmap_cluster_medium_id" />
				<input type="hidden" {{#if gmap_cluster_medium}} value="{{gmap_cluster_medium}}" {{/if}} name="gmap_cluster_medium" />
				<div class="thumbnail-preview">
					{{#if gmap_cluster_medium}}<img src="{{gmap_cluster_medium}}" width="48" style="color:black;" />{{/if}}	
				</div>

				<a {{#if gmap_cluster_medium}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="gmap_cluster_medium">Choose Image</a>

				<a {{#unless gmap_cluster_medium}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="gmap_cluster_medium">Delete</a>			
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="title"> Cluster Marker Large</label>
			</th>
			<td>
				<input type="hidden" {{#if gmap_cluster_large_id}} value="{{gmap_cluster_large_id}}" {{/if}} name="gmap_cluster_large_id" />
				<input type="hidden" {{#if gmap_cluster_large}} value="{{gmap_cluster_large}}" {{/if}} name="gmap_cluster_large" />
				<div class="thumbnail-preview">
					{{#if gmap_cluster_large}}<img src="{{gmap_cluster_large}}" width="48" style="color:black;" />{{/if}}	
				</div>

				<a {{#if gmap_cluster_large}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add" data-slug="gmap_cluster_large">Choose Image</a>

				<a {{#unless gmap_cluster_large}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete" data-slug="gmap_cluster_large">Delete</a>				
			</td>
		</tr>	
		*/ ?>			
	<?php 	
	}	
}

/**
 * Outputs the map meta
 */
function lsx_map_meta(){
	do_action('lsx_map_meta');
}