var LSX_TO_PATHItinerary_Read_More = {
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

LSX_TO_PATHBootstrap_Carousel = {
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

LSX_TO_PATHFacetWP = {
	effect_loaded: function() {
		jQuery(document).on('facetwp-loaded', function() {
			LSX_TO_PATHFacetWP.effect_clearButton();

			if (!lsxTofacetWpLoadFirstTime) {
				lsxTofacetWpLoadFirstTime = true;
				return;
			}

			LSX_TO_PATHFacetWP.effect_scrollOnLoad();
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

LSX_TO_PATHTO = {
	removeEmptyWidgets: function() {
		jQuery('.widget.lsx-widget').each(function() {
			var $this = jQuery(this);

			if (jQuery.trim($this.html()) == '') {
				$this.closest('section').remove();
			}
		});
	}
};

var LSX_TO_PATHRead_More = {
	initThis: function(){
		jQuery('.entry-content .more-link, .archive-description .more-link').each(function() {
			if ('Read More' == jQuery(this).html()) {
				jQuery(this).closest('.entry-content, .archive-description').each(function() {
					var visible = true;

					jQuery(this).children().each(function() {
						if ('Read More' == jQuery(this).find('.more-link').html()) {
							visible = false;
						} else if (!visible) {
							jQuery(this).hide();
						}
					});
				});

				jQuery(this).click(function(event) {
					event.preventDefault();
					jQuery(this).hide();
					jQuery(this).closest('.entry-content, .archive-description').children().show();
				});
			}
		});
	}
}

var LSX_TO_PATHScrollable = {
	initThis: function(){
		jQuery('.scroll-easing a').on('click',function(e) {
			e.preventDefault();

			var $from = jQuery(this),
				$to = jQuery($from.attr('href')),
				top = parseInt($to.offset().top),
				extra = parseInt($from.data('extra-top') ? $from.data('extra-top') : '-160');

			jQuery('html, body').animate({
				scrollTop: (top+extra)
			}, 1200);
		});
		
		jQuery('.banner-easing a i').on('click',function(e) {
			e.preventDefault();

			var $from = jQuery(this).parent(),
				$to = jQuery($from.attr('href')),
				top = parseInt($to.offset().top),
				extra = parseInt($from.data('extra-top') ? $from.data('extra-top') : '0');

			jQuery('html, body').animate({
				scrollTop: (top+extra)
			}, 1200);
		});		
	}
}

jQuery(document).ready( function() {
	LSX_TO_PATHRead_More.initThis();
	LSX_TO_PATHScrollable.initThis();
	LSX_TO_PATHItinerary_Read_More.initThis();
	LSX_TO_PATHBootstrap_Carousel.avoidInMobile();
	LSX_TO_PATHFacetWP.effect_loaded();
	LSX_TO_PATHTO.removeEmptyWidgets();
});