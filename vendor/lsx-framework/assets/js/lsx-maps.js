var map;
var infowindow;

'use strict';
var $gmap = '';
var gmap_markers = [];
var icons = [];
var LSX_MAPS = {

    initThis: function(){
        var $map = jQuery('.lsx-map:eq(0)');
        var lat = Number($map.attr('data-lat'));
        var lng = Number($map.attr('data-long'));
        var zoom = Number($map.attr('data-zoom'));
        var type = $map.attr('data-type');
        this.type = type;

        var height = Number($map.attr('data-height'));
        var banner_class = $map.attr('data-class');
        var icon_url = jQuery('.lsx-map').attr('data-icon');
        var framework_url = jQuery('.lsx-map').attr('data-url');

        var cluster_small = jQuery('.lsx-map').attr('data-cluster-small');
        var cluster_medium = jQuery('.lsx-map').attr('data-cluster-medium');
        var cluster_large = jQuery('.lsx-map').attr('data-cluster-large');

        this.cluster_small = cluster_small;
        this.cluster_medium = cluster_medium;
        this.cluster_large = cluster_large;

        var container_html = '';
        var kml = false;

        //Sets the Framework URL
        this.framework_url = framework_url;

        //Create new LatLong Coordinates
        this.latlng = new google.maps.LatLng(lat, lng);

        //Set the Icon URL
        this.icon_url = new google.maps.MarkerImage(
            icon_url,
            null,
            null,
            null, 
            new google.maps.Size(32, 32)
        );        

        this.bounds = [];

        var $footerMap = jQuery(banner_class+':eq(0)');
        if('cluster' === type){
            height = $footerMap.css('height');
            container_html = $footerMap.find('.container').html();
        }else if('route' === type && undefined !== $map.attr('data-kml')){
            kml = $map.attr('data-kml');
        }else{
            $footerMap.css('height',height);
        }

        var $container = null;
        if('.lsx-map-preview' != banner_class){
            jQuery('.lsx-map').parent('section').hide();
            jQuery(banner_class).addClass('gmap-banner');

            if (jQuery(banner_class).children('.container').length == 1) {
                $container = jQuery(banner_class).children('.container').clone(true, true);
            }
        }
        
        var styledMap = new google.maps.StyledMapType([
            {
                stylers: [
                    { lightness: 0 },
                    { saturation: 50 }
                ]
            }
        ], {name: "Styled Map"});

        this.mapObj = new google.maps.Map($footerMap[0], {
            zoom: zoom,
            maxZoom: 21,
            minZoom: 1,
            center: this.latlng,
            scrollwheel: false,
            draggable: true,
            mapTypeControl: false,
            overviewMapControl: false,
            panControl: false,
            rotateControl: false,
            mapTypeId: google.maps.MapTypeId.TERRAIN,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.TERRAIN, 'map_style']
            }
        });

        this.mapObj.mapTypes.set('map_style', styledMap);
        this.mapObj.setMapTypeId('map_style');

        //Decide which method to draw on the map.
        if(false != kml){
            this.addRoute();
        }else{
            this.refreshMarkers();
            if('route' == type && false == kml){
                this.drawRoute();
            }            
        }

        //Do we fit to the screen or center the view.
        if('cluster' == type || ('route' == type && false == kml)){
            this.setBounds(); 
            $footerMap.css('height',height);
        }else{
           this.setCenter(); 
        }
        //this.addFusionLayer();
    	this.resizeThis();

        /*if('cluster' === type){
            $footerMap.append(container_html);
            console.log($footerMap.find('.gm-style'));
        }*/

        if ($container !== null) {
            jQuery(banner_class).append($container);
        }
    	
        $gmap = this.mapObj;
    },

    resizeThis: function(){
        if(google && google.maps){
            google.maps.event.trigger(this.mapObj, "resize");
        }
    },
    drawRoute: function(){

        var coordinates = [];

        if(jQuery('.lsx-map-markers').length > 0){
            jQuery('.lsx-map-markers .map-data').each(function(){
                coordinates.push({lat: Number(jQuery(this).attr('data-lat')), lng: Number(jQuery(this).attr('data-long'))});
            });
        }
        console.log(coordinates);

        var route = new google.maps.Polyline({
          path: coordinates,
          geodesic: true,
          strokeColor: '#000000',
          strokeOpacity: 1.0,
          strokeWeight: 1.5
        });
        route.setMap(this.mapObj);
    },  
    generateRoute: function(){
        if(jQuery('.lsx-map-markers').length > 0){
            jQuery('.lsx-map-markers .map-data').each(function(){
                coordinates.push(jQuery(this).attr('data-lat')+' '+Number(jQuery(this).attr('data-long')));
                //coordinates.push({lat: Number(jQuery(this).attr('data-lat')), lng: Number(jQuery(this).attr('data-long'))});
            });
        }

        jQuery.get('https://roads.googleapis.com/v1/snapToRoads', {
            interpolate: true,
            key: lsx_maps_params.apiKey,
            path: coordinates.join('|')
        }, function(data) {
            /*processSnapToRoadResponse(data);
            drawSnappedPolyline();
            getAndDrawSpeedLimits();*/ 
            console.log(data);
        });        
        console.log(coordinates);        
    }, 
    addFusionLayer: function(){
        var countryCoordinates = new google.maps.FusionTablesLayer({
          query: {
            select: 'geometry',
            from: '1N2LBk4JHwWpOY4d9fobIn27lfnZ5MDy-NoqqRpk',
            where: "ISO_2DIGIT IN ('ZA')"
          }
        });
        var country = new google.maps.Polygon({
            paths: countryCoordinates,
            strokeColor: '#C2D4BC',
            strokeOpacity: 0,
            strokeWeight: 1,
            fillColor: '#C2D4BC',
            fillOpacity: 0.3
        });

        google.maps.event.addListener(country, 'mouseover', function() {
            this.setOptions({fillOpacity: 1});
            //console.log(this);
        });
        google.maps.event.addListener(country, 'mouseout', function() {
            this.setOptions({fillOpacity: 0.3});
        });
    },
    setCenter: function(){
        this.mapObj.setCenter(this.latlng);
    },
    createMarker: function(position,icon){
        var marker = new google.maps.Marker({
            position: position.marker,
            map: this.mapObj,
            title: position.title,
            icon: icon
        });
		marker.addListener('click', function() {
            if (infowindow) {
                infowindow.close();
            }
            infowindow = new google.maps.InfoWindow({
                content: '<div style="float:left;margin-right:15px;margin-top:2px;"><img width="100" height="100" src="'+position.thumbnail+'" /></div><div style="float:right;width:80%;"><h4 style="margin-top:0px;">'+position.title+'</h4>'+position.content+'</div><br clear="all"/>'
            });  
			infowindow.open($gmap,marker); 
		});
        return marker;
    },   
    
    refreshMarkers: function(){
    	var bounds = [];
        var $this = this;
    	if(jQuery('.lsx-map-markers').length){

            //Run through each marker and grab the title, thumbnail and HTML, and send to Google.
            var counter = 0;
            var marker_length = jQuery('.lsx-map-markers .map-data').length-1;

			jQuery('.lsx-map-markers .map-data').each(function(){
			    var tempMarker = new google.maps.LatLng(Number(jQuery(this).attr('data-lat')), Number(jQuery(this).attr('data-long')));
                bounds.push(tempMarker);
			    gmap_markers.push({marker:tempMarker,title:'<a href="'+jQuery(this).attr('data-link')+'">'+jQuery(this).attr('data-title')+'</a>',thumbnail:jQuery(this).attr('data-thumbnail'),content:jQuery(this).html()});

                var icon_url = jQuery(this).attr('data-icon');
                console.log(counter);
                console.log(marker_length);
                console.log($this.type);
                if('route' == $this.type && (0==counter || marker_length == counter)){
                    if(0==counter){
                        icon_url = lsx_maps_params.start_marker;
                    }else{
                        icon_url = lsx_maps_params.end_marker;
                    }
                }
                icons.push(icon_url);
                counter++;
			});  

			for (var i = 0; i < gmap_markers.length; i++) { 
				gmap_markers[i] = this.createMarker(gmap_markers[i],icons[i]);
			}
            this.bounds = bounds;

            if('cluster' == this.type){
                var styles = [{
                    url: this.cluster_small,
                    height: 52,
                    width: 53,
                    anchor: [0, 0],
                    textColor: '#ffffff'
                }, {
                    url: this.cluster_meduim,
                    height: 52,
                    width: 53,
                    anchor: [0, 0],
                    textColor: '#ffffff'
                }, {
                    url: this.cluster_large,
                    height: 52,
                    width: 53,
                    anchor: [0, 0],
                    textColor: '#ffffff'
                }];

                var options = {
                  styles: styles
                };

                var markerCluster = new MarkerClusterer(this.mapObj, gmap_markers, options);
            }
    	}
    },   

    addRoute: function(kml){
        var ctaLayer = new google.maps.KmlLayer({
          url: kml,
          map: this.mapObj
        });
        
        this.resizeThis();
    },    

    setBounds: function(){
        if(google && google.maps){
            // map: an instance of google.maps.Map object
            // latlng: an array of google.maps.LatLng objects
            var latlngbounds = new google.maps.LatLngBounds();
            for (var i = 0; i < this.bounds.length; i++) {
              latlngbounds.extend(this.bounds[i]);
            }
            this.mapObj.fitBounds(latlngbounds); 
        }
    },

}
LSX_Elementz_Map = {
    changeMapStyleInit: function() {
        if ('undefined' != typeof google && 'undefined' != typeof google.maps) {
            google.maps.event.addDomListener(window, 'load', function() {
                if ('undefined' != typeof $gmap && 'undefined' != typeof $gmap.mapTypes) {
                    setTimeout(LSX_Elementz_Map.changeMapColors, 200);
                }
            });
        }
    },

    changeMapColors: function() {
        var snazzyMapsStyle = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}],
            styledMapElementz = new google.maps.StyledMapType(
                snazzyMapsStyle,
                {name: "Styled Map Elementz"}
            );
        
        $gmap.mapTypes.set('map_style_elementz', styledMapElementz);
        $gmap.setMapTypeId('map_style_elementz');
    }
};

jQuery(document).ready( function($) {
	if(jQuery('.lsx-map').length){
		LSX_MAPS.initThis();
        LSX_Elementz_Map.changeMapStyleInit();
	}
});