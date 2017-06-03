var LSX_TO_Itinerary_Read_More = {
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

LSX_TO_Bootstrap_Carousel = {
	initSlider: function() {
		jQuery('.lsx-to-slider .lsx-to-slider-inner').each(function() {
			var $this = jQuery(this),
				interval = $this.data('interval'),
				autoplay = false,
				autoplaySpeed = 0;

			if ('undefined' !== typeof interval && 'boolean' !== typeof interval) {
				interval = parseInt(interval);

				if (! isNaN(interval)) {
					autoplay = true;
					autoplaySpeed = interval;
				}
			}

			$this.slick({
				draggable: false,
				infinite: false,
				swipe: false,
				cssEase: 'ease-out',
				dots: true,
				slidesToShow: 3,
				slidesToScroll: 3,
				autoplay: autoplay,
				autoplaySpeed: autoplaySpeed,
				responsive: [{
					breakpoint: 992,
					settings: {
						draggable: true,
						arrows: false,
						swipe: true
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						draggable: true,
						arrows: false,
						swipe: true
					}
				}]
			});
		});
	}
},

lsxTofacetWpLoadFirstTime = false,

LSX_TO_FacetWP = {
	effect_loaded: function() {
		jQuery(document).on('facetwp-loaded', function() {
			LSX_TO_FacetWP.effect_clearButton();

			if (!lsxTofacetWpLoadFirstTime) {
				lsxTofacetWpLoadFirstTime = true;
				return;
			}

			LSX_TO_FacetWP.effect_scrollOnLoad();
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

LSX_TO = {
	removeEmptyWidgets: function() {
		jQuery('.widget.lsx-widget').each(function() {
			var $this = jQuery(this);

			if (jQuery.trim($this.html()) == '') {
				$this.closest('section').remove();
			}
		});
	},

	addExtraClassToMeta: function() {
		jQuery('.meta').parent().each(function() {
			var nodes = jQuery(this).children('.meta');
			nodes.last().addClass('last-meta');
		});
	}
},

LSX_TO_Read_More = {
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

					if (jQuery(this).hasClass('more-link-remove-p')) {
						var html = '';

						jQuery(this).closest('.entry-content, .archive-description').children().each(function() {
							jQuery(this).show();
						});
					} else {
						jQuery(this).closest('.entry-content, .archive-description').children().show();
					}
				});
			}
		});
	}
},

LSX_TO_Scrollable = {
	initThis: function(windowWidth) {
		this.bannerScrollEasing();

		if (windowWidth >= 992) {
			this.anchorMenuScrollEasing();
			this.anchorMenuFixTo();
			this.anchorMenuScrollSpy();
		}
	},

	bannerScrollEasing: function() {
		jQuery('.banner-easing a i').on('click',function(e) {
			e.preventDefault();

			var $from = jQuery(this).parent(),
				$to = jQuery($from.attr('href')),
				top = parseInt($to.offset().top),
				extra = parseInt($from.data('extra-top') ? $from.data('extra-top') : '0');

			jQuery('html, body').animate({
				scrollTop: (top+extra)
			}, 800);
		});
	},

	anchorMenuScrollEasing: function() {
		jQuery('.lsx-to-navigation .scroll-easing a').on('click',function(e) {
			e.preventDefault();

			var $from = jQuery(this),
				$to = jQuery($from.attr('href')),
				top = parseInt($to.offset().top),
				extra_header = jQuery('header.navbar-static-top').length > 0 ? jQuery('header.navbar-static-top').outerHeight(true) : 0,
				extra_navigation = jQuery('.lsx-to-navigation').length > 0 ? jQuery('.lsx-to-navigation').outerHeight(true) : 0,
				extra_attr = parseInt($from.data('extra-top') ? $from.data('extra-top') : '0'),
				extra = -(extra_header + extra_navigation + extra_attr);

			jQuery('html, body').animate({
				scrollTop: (top+extra)
			}, 800);
		});
	},

	anchorMenuFixTo: function() {
		jQuery('.lsx-to-navigation').each(function() {
			var box = jQuery(this);

			if (jQuery('#wpadminbar').length > 0) {
				box.addClass('fixto-logged');
			}

			box.fixTo('#primary', {
				mind: 'header.navbar-static-top',
				useNativeSticky: false,
				zIndex: 100
			});
		});
	},

	anchorMenuScrollSpy: function() {
		var offset_header = jQuery('header.navbar-static-top').length > 0 ? jQuery('header.navbar-static-top').outerHeight(true) : 0,
			offset_navigation = jQuery('.lsx-to-navigation').length > 0 ? jQuery('.lsx-to-navigation').outerHeight(true) : 0;

		jQuery('body').scrollspy({
			target: '.lsx-to-navigation',
			offset: offset_header + offset_navigation
		});
	}
}

jQuery(document).ready(function() {
	var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		//windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

	LSX_TO_Read_More.initThis();
	LSX_TO_Scrollable.initThis(windowWidth);
	LSX_TO_Itinerary_Read_More.initThis();
	LSX_TO_Bootstrap_Carousel.initSlider();
	LSX_TO_FacetWP.effect_loaded();
	LSX_TO.removeEmptyWidgets();
	LSX_TO.addExtraClassToMeta();
});
