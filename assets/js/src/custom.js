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
		console.log(contentWrapper);
		console.log(contentWrapper.length);
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
			$(this).show();
			lsx_to.readMoreItinText = $(this).find('a').text();
			lsx_to.readMoreSet( $(this), $(this).parent( 'div' ).find('.itinerary-description') );
		} );

		$( '.single-tour-operator .lsx-itinerary-wrapper .wp-block-read-more' ).on( 'click', function( event ) {
			event.preventDefault();
			$( this ).hide();

			if ( $( this ).hasClass( 'less-link' ) ) {
				lsx_to.readMoreSet( $(this), $(this).parent( 'div' ).find('.itinerary-description') );
			} else {
				lsx_to.readMoreOpen( $(this), $(this).parent( 'div' ).find('.itinerary-description') );
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
			var $this = $( this );

			lsx_to.pre_build_slider( $this );

			if ( 1 < $this.children.length ) {

				$this.slick( {
					draggable: false,
					infinite: true,
					swipe: false,
					dots: true,
					slidesToShow: 3,
					slidesToScroll: 1,
					autoplay: false,
					autoplaySpeed: 0,
					//appendArrows: $this.parent(),
					//appendDots: $this.parent(),
					responsive: [
						{
							breakpoint: 1279,
							settings: {
								slidesToShow:   2,
								slidesToScroll: 1,
								draggable: false,
								arrows: true,
								swipe: false,
							}
						},
						{
							breakpoint: lsx_to_params.slickSlider.mobile.breakpoint,
							settings: {
								slidesToShow:   1,
								slidesToScroll: 1,
								draggable: true,
								arrows: false,
								swipe: true,
							}
						}
					]
				} );
			}
		} );
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
