var TO_Itinerary_Read_More = {
	initThis: function() {
		if('undefined' != jQuery('#itinerary .view-more')){
			this.watchLink();
		}
	},

	watchLink: function() {
		jQuery('#itinerary .view-more a').click(function(event){
			event.preventDefault();
			jQuery(this).hide();
			
			jQuery(this).parents('#itinerary').find('.itinerary-item.hidden').each(function(){
				jQuery(this).removeClass('hidden');
			});
		});
	}
},

TO_Bootstrap_Carousel = {
	avoidInMobile: function() {
		jQuery('.carousel.slide').on('slide.bs.carousel', function() {
			var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
			
			if (width < 992) {
				return false;
			}
		});
	}
},

lsxTofacetWpLoadFirstTime = false,

TO_FacetWP = {
	effect_loaded: function() {
		jQuery(document).on('facetwp-loaded', function() {
			TO_FacetWP.effect_clearButton();

			if (!lsxTofacetWpLoadFirstTime) {
				lsxTofacetWpLoadFirstTime = true;
				return;
			}

			TO_FacetWP.effect_scrollOnLoad();
		});
	},

	effect_scrollOnLoad: function() {
		var scrollTop = jQuery('.facetwp-facet').length > 0 ? jQuery('.facetwp-facet').offset().top : jQuery('.facetwp-template').offset().top;
		scrollTop -= 250;
		jQuery('html, body').animate({scrollTop: scrollTop}, 400);
	},

	effect_clearButton: function() {
		if (FWP.build_query_string() == '') {
			jQuery('.facetwp-results-clear-btn').addClass('hidden');
		} else {
			jQuery('.facetwp-results-clear-btn').removeClass('hidden');
		}
	},
},

TO_TO = {
	removeEmptyWidgets: function() {
		jQuery('.widget.lsx-widget').each(function() {
			var $this = jQuery(this);

			if (jQuery.trim($this.html()) == '') {
				$this.closest('section').remove();
			}
		});
	}
};

jQuery(document).ready( function() {
	TO_Itinerary_Read_More.initThis();
	TO_Bootstrap_Carousel.avoidInMobile();
	TO_FacetWP.effect_loaded();
	TO_TO.removeEmptyWidgets();
});