/**
 * Scripts
 *
 * @package    tour-operator
 * @subpackage scripts
 */

var lsx_to = Object.create( null );

if ( window.location.hash ) {
	( document.body || document.documentElement ).scrollIntoView();
	setTimeout( function() { ( document.body || document.documentElement ).scrollIntoView(); }, 1 );
}

;( function( $, window, document, undefined ) {

	'use strict';

	var $document    = $( document ),
		$window      = $( window ),
		window_height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight,
		window_width  = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

	/**
	 * Easing browser scroll on page load (document URL with hash).
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_easing_scroll_on_page_load = function() {
		if ( window.location.hash ) {
			var $to = $( window.location.hash ),
				top = parseInt( $to.offset().top );

			top -= $( '#wpadminbar' ).length > 0 ? $( '#wpadminbar' ).outerHeight( true ) : 0;
			top -= $( '.top-menu-fixed #masthead' ).length > 0 ? $( '.top-menu-fixed #masthead' ).outerHeight( true ) : 0;
			top -= $( '.lsx-to-navigation' ).length > 0 ? $( '.lsx-to-navigation' ).outerHeight( true ) : 0;

			$( 'html, body' ).animate( { scrollTop: top }, 800 );
		}
	};

	/**
	 * Read more effect.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_read_more = function() {
		$( '.single-tour-operator .wp-block-read-more' ).each( function() {
			lsx_to.readMoreText = $(this).contents().filter(function() {
				return this.nodeType === Node.TEXT_NODE;
			}).text();
			lsx_to.readMoreSet( $(this), $(this).closest( '.wp-block-group' ).find('.wp-block-post-content') );
		} );

		$( '.single-tour-operator .wp-block-read-more' ).on( 'click', function( event ) {
			event.preventDefault();
			$( this ).hide();

			if ( $( this ).hasClass( 'less-link' ) ) {
				lsx_to.readMoreSet( $(this), $(this).closest( '.wp-block-group' ).find('.wp-block-post-content') );
			} else {
				lsx_to.readMoreOpen( $(this), $(this).closest( '.wp-block-group' ).find('.wp-block-post-content') );
			}

			$( this ).show();
		} );
	};

	lsx_to.readMoreSet = function( button, contentWrapper ) {
		if ( 0 < contentWrapper.length ) {
			if ( 1 < contentWrapper.children().length ) {

				var limit = 1;
				let counter = 0;

				contentWrapper.children().each( function() {
					if ( limit <= counter ) {
						$(this).hide();
					}
					counter++;
				});
			} else {
				button.hide();
			}
			button.removeClass('less-link');
			button.text( lsx_to.readMoreText );
		} else {
			button.hide();
		}
	}

	lsx_to.readMoreOpen = function( button, contentWrapper ) {
		if ( 0 < contentWrapper.children().length ) {
			contentWrapper.children().each( function() {
				if ( ! $(this).hasClass('wp-block-read-more') ) {
					$(this).show();	
				}
			});
			button.addClass( 'less-link' );
			button.text( 'Read Less' );
			button.show();
		}
	}

	/**
	 * Read more (travel info) effect.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.readMoreTIText = '';

	lsx_to.set_read_more_travel_info = function() {

		$( '.single-tour-operator .additional-info .lsx-to-more-link' ).each( function() {
			lsx_to.readMoreTIText = $(this).find('a').text();
			lsx_to.readMoreSet( $(this), $(this).closest( '.additional-info' ).find('.content') );
		} );

		$( '.single-tour-operator .additional-info .lsx-to-more-link' ).on( 'click', function( event ) {
			event.preventDefault();
			$( this ).hide();

			if ( $( this ).hasClass( 'less-link' ) ) {
				lsx_to.readMoreSet( $(this), $(this).closest( '.additional-info' ).find('.content') );
			} else {
				lsx_to.readMoreOpenTI( $(this), $(this).closest( '.additional-info' ).find('.content') );
			}

			$( this ).show();
		} );
	};

	/**
	 * Read more (itinerary) effect.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */

	lsx_to.readMoreItinText = '';

	lsx_to.set_read_more_itinerary = function() {
		$( '.single-tour-operator .lsx-itinerary-wrapper .wp-block-read-more' ).each( function() {
			lsx_to.readMoreItinText = $(this).find('a').text();
			lsx_to.readMoreSet( $(this), $(this).closest( 'div' ).find('.itinerary-description') );
		} );

		$( '.single-tour-operator .lsx-itinerary-wrapper .wp-block-read-more' ).on( 'click', function( event ) {
			event.preventDefault();
			$( this ).hide();

			if ( $( this ).hasClass( 'less-link' ) ) {
				lsx_to.readMoreSet( $(this), $(this).closest( 'div' ).find('.itinerary-description') );
			} else {
				lsx_to.readMoreOpen( $(this), $(this).closest( 'div' ).find('.itinerary-description') );
			}

			$( this ).show();
		} );
	};

	/**
	 * Slider - Pre build.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.pre_build_slider = function( $slider ) {

		$slider.removeClass( 'is-layout-grid' );

		$slider.on( 'init', function( event, slick ) {
			if ( slick.options.arrows && slick.slideCount > slick.options.slidesToShow ) {
				$slider.addClass( 'slick-has-arrows' );
			}
		} );

		$slider.on( 'setPosition', function( event, slick ) {
			if ( ! slick.options.arrows ) {
				$slider.removeClass( 'slick-has-arrows' );
			} else if ( slick.slideCount > slick.options.slidesToShow ) {
				$slider.addClass( 'slick-has-arrows' );
			}
		} );
	};

	/**
	 * Slider.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.build_slider = function( window_width ) {
		$( '.lsx-to-slider .wp-block-post-template:not(.slider-disabled)' ).each( function() {
			var $this = $( this ),
				interval = $this.data( 'interval' ),
				currentSettings = $this.data( 'slick' ),
				autoplay = false,
				autoplay_speed = 0;

			lsx_to.pre_build_slider( $this );

			if ( 'undefined' !== typeof interval && 'boolean' !== typeof interval ) {
				interval = parseInt( interval );

				if ( ! isNaN( interval ) ) {
					autoplay = true;
					autoplay_speed = interval;
				}
			}


			let tabletSlidesToShow   = lsx_to_params.slickSlider.tablet.slidesToShow;
			let tabletSlidesToScroll = lsx_to_params.slickSlider.tablet.slidesToScroll;

			if ( 'undefined' !== typeof currentSettings && 'boolean' !== typeof currentSettings ) {

				// Tablet Settings.
				if ( 'undefined' !== typeof currentSettings.tablet ) {
					if ( 'undefined' !== typeof currentSettings.tablet.slidesToShow ) {
						tabletSlidesToShow = currentSettings.tablet.slidesToShow;
					}
					if ( 'undefined' !== typeof currentSettings.tablet.slidesToShow ) {
						tabletSlidesToScroll = currentSettings.tablet.slidesToScroll;
					}
				}
			}

			if ( 1 < $this.children.length ) {
				console.log($this);

				$this.slick( {
					draggable: lsx_to_params.slickSlider.desktop.draggable,
					infinite: lsx_to_params.slickSlider.desktop.infinite,
					swipe: lsx_to_params.slickSlider.desktop.swipe,
					cssEase: lsx_to_params.slickSlider.desktop.cssEase,
					dots: lsx_to_params.slickSlider.desktop.dots,
					slidesToShow: lsx_to_params.slickSlider.desktop.slidesToShow,
					slidesToScroll: lsx_to_params.slickSlider.desktop.slidesToScroll,
					autoplay: autoplay,
					autoplaySpeed: autoplay_speed,
					appendArrows: $this.parent(),
					appendDots: $this.parent(),
					responsive: [
						{
							breakpoint: lsx_to_params.slickSlider.tablet.breakpoint,
							settings: {
								slidesToShow:   tabletSlidesToShow,
								slidesToScroll: tabletSlidesToScroll,
								draggable: lsx_to_params.slickSlider.tablet.draggable,
								arrows: lsx_to_params.slickSlider.tablet.arrows,
								swipe: lsx_to_params.slickSlider.tablet.swipe,
							}
						},
						{
							breakpoint: lsx_to_params.slickSlider.mobile.breakpoint,
							settings: {
								slidesToShow:   lsx_to_params.slickSlider.mobile.slidesToShow,
								slidesToScroll: lsx_to_params.slickSlider.mobile.slidesToScroll,
								draggable:      lsx_to_params.slickSlider.mobile.draggable,
								arrows:         lsx_to_params.slickSlider.mobile.arrows,
								swipe:          lsx_to_params.slickSlider.mobile.swipe
							}
						}
					]
				} );
			}
		} );

		if ( window_width < 768 ) {
			$( '.gallery' ).not('.slick-initialized').slick( {
				slide: 'dl',
				arrows: false,
				draggable: true,
				infinite: true,
				swipe: true,
				cssEase: 'ease-out',
				dots: true,
				autoplay: false,
				responsive: [
					{
						breakpoint: 99999,
						settings: 'unslick'
					},
					{
						breakpoint: 768,
						setting: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				]
			} );
		}
	};

	/**
	 * Slider Lightbox.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.build_slider_lightbox = function() {
		if ( 0 <  $( '.wp-block-gallery.has-nested-images' ).length ) {
			$( '.wp-block-gallery.has-nested-images' ).slickLightbox( {
				caption: function( element, info ) {
					return $( element ).find( 'img' ).attr( 'alt' );
				}
			} );
		}
		
		if ( 0 <  $( '.lsx-units-wrapper .unit-image a' ).length ) {
			let roomImages = $('.lsx-units-wrapper .unit-image a img').map(function() {
				return $(this).attr('src');
			}).get();
			console.log(roomImages);

			$( '.lsx-units-wrapper' ).slickLightbox( {
				//images : roomImages,
				itemSelector: '.unit-image a',
				caption: function( element, info ) {
					return $( element ).find( 'img' ).attr( 'alt' );
				}
			} );
		}
	};

	/**
	 * On window resize.
	 *
	 * @package    lsx
	 * @subpackage scripts
	 */
	$window.resize( function() {

		window_height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		window_width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

	} );

	/**
	 * On document ready.
	 *
	 * @package    lsx
	 * @subpackage scripts
	 */
	$document.ready( function() {
		lsx_to.set_read_more();
		lsx_to.set_read_more_travel_info();
		lsx_to.set_read_more_itinerary();
		lsx_to.build_slider( window_width );
	} );

	/**
	 * On window load.
	 *
	 * @package    lsx
	 * @subpackage scripts
	 */

	$window.on('load', function() {
		lsx_to.build_slider_lightbox();
	} );

} )( jQuery, window, document );
