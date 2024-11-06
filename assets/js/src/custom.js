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
		$( '.lsx-to-review-content .more-link, .lsx-to-team-content .more-link, .entry-content .more-link, .archive-description .more-link' ).each( function() {
			if ( 'Read More' === $( this ).html() || 'Lees verder' === $( this ).html() ) {
				$( this ).closest( '.lsx-to-review-content, .lsx-to-team-content, .entry-content, .archive-description' ).each( function() {
					var visible = true;

					$( this ).children().each( function() {
						if ( 'Read More' === $( this ).find( '.more-link' ).html() ) {
							visible = false;
						} else if ( ! visible && this.id !== 'sharing' ) {
							$( this ).hide();
						}
					} );
				} );

				$( this ).click( function( event ) {
					event.preventDefault();
					$( this ).hide();

					if ($( this ).hasClass( 'more-link-remove-p' ) ) {
						var html = '';

						$( this ).closest( '.lsx-to-review-content, .lsx-to-team-content, .entry-content, .archive-description' ).children().each( function() {
							$( this ).show();
						} );
					} else {
						$( this ).closest( '.lsx-to-review-content, .lsx-to-team-content, .entry-content, .archive-description' ).children().show();
					}
				} );
			}
		} );
	};

	/**
	 * Read more (travel info) effect.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_read_more_travel_info = function() {
		$( '.moretag-travel-info' ).click( function( event ) {
			event.preventDefault();

			var $modal = $( '#lsx-modal-placeholder' ),
				$entry = $( this ).closest( '.lsx-travel-info' ),
				title = $entry.find( '.lsx-to-widget-title' ).html(),
				content = $entry.find( '.travel-info-entry-content' ).html();

			$modal.find( '.modal-title' ).html( title );
			$modal.find( '.modal-body' ).html( content );

			$modal.modal();
		} );
	};

	/**
	 * Read more (itinerary) effect.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_read_more_itinerary = function() {
		$( '#itinerary .view-more a' ).click( function( event ) {
			event.preventDefault();
			$( this ).hide();

			$( this ).parents( '#itinerary' ).find( '.itinerary-item.hidden' ).each( function() {
				$( this ).removeClass( 'hidden' );
			} );
		} );
	};

	/**
	 * Slider - Pre build.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.pre_build_slider = function( $slider ) {
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
		$( '.lsx-to-slider .lsx-to-slider-inner:not(.slider-disabled)' ).each( function() {
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
		$( '.single-tour-operator .gallery' ).slickLightbox( {
			caption: function( element, info ) {
				return $( element ).find( 'img' ).attr( 'alt' );
			}
		} );

		$( '.single-tour-operator .rooms-content' ).slickLightbox( {
			caption: function( element, info ) {
				return $( element ).find( 'img' ).attr( 'alt' );
			}
		} );
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
