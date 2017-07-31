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
	 * Remove empty widgets.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.remove_empty_widgets = function() {
		$( '.widget.lsx-widget' ).each( function() {
			var $this = $( this );

			if ( '' === $.trim( $this.html() ) ) {
				$this.closest( 'section' ).remove();
			}
		} );
	};

	/**
	 * Remove empty single fast facts.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.remove_empty_fast_facts = function() {
		$( '#keynotes .lsx-to-single-meta-data' ).each( function() {
			var $this = $( this );

			if ( '' === $.trim( $this.html() ) ) {
				$this.closest( '#keynotes' ).addClass( 'hidden' );
			}
		} );
	};

	/**
	 * Add extra HTML class to metadata tags.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.add_extra_class_to_meta = function() {
		$( '.meta' ).parent().each( function() {
			var $nodes = $( this ).children( '.meta' );
			$nodes.last().addClass( 'last-meta' );
		} );
	};

	/**
	 * Read more effect.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_read_more = function() {
		$( '.lsx-to-team-content .more-link, .entry-content .more-link, .archive-description .more-link' ).each( function() {
			if ( 'Read More' === $( this ).html() ) {
				$( this ).closest( '.lsx-to-team-content, .entry-content, .archive-description' ).each( function() {
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

						$( this ).closest( '.lsx-to-team-content, .entry-content, .archive-description' ).children().each( function() {
							$( this ).show();
						} );
					} else {
						$( this ).closest( '.lsx-to-team-content, .entry-content, .archive-description' ).children().show();
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
		$( '.travel-info-entry-content .more-link' ).click( function( event ) {
			event.preventDefault();
			$( this ).closest( '.travel-info-entry-content' ).hide();

			$( this ).closest( '.travel-info-content' ).find( '.travel-info-entry-content.hidden' ).each( function() {
				$( this ).removeClass( 'hidden' );
			} );
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
	lsx_to.build_slider = function() {
		$( '.lsx-to-slider .lsx-to-slider-inner:not(.slider-disabled)' ).each( function() {
			var $this = $( this ),
				interval = $this.data( 'interval' ),
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

			$this.slick( {
				draggable: false,
				infinite: true,
				swipe: false,
				cssEase: 'ease-out',
				dots: true,
				slidesToShow: 3,
				slidesToScroll: 3,
				autoplay: autoplay,
				autoplaySpeed: autoplay_speed,
				responsive: [
					{
						breakpoint: 992,
						settings: {
							draggable: true,
							arrows: false,
							swipe: true
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
							draggable: true,
							arrows: false,
							swipe: true
						}
					}
				]
			} );
		} );
	};

	/**
	 * Slider Lightbox.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.build_slider_lightbox = function() {
		jQuery( '.gallery' ).slickLightbox({
			//lazy: true
		});

		jQuery( '.rooms-content' ).slickLightbox({
			//lazy: true
		});
	};

	/**
	 * Anchor menu - Fixed.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.fix_anchor_menu = function() {
		$( '.lsx-to-navigation' ).scrollToFixed({
			minWidth: 1200,
			zIndex: 100,

			marginTop: function () {
				var margin_top = 0;

				margin_top += $( '#wpadminbar' ).length > 0 ? $( '#wpadminbar' ).outerHeight() : 0;
				margin_top += $( '.top-menu-fixed #masthead' ).length > 0 ? $( '.top-menu-fixed #masthead' ).outerHeight( true ) :  0;

				return margin_top;
			}
		});
	};

	/**
	 * Anchor menu - Scroll easing.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_anchor_menu_easing_scroll = function() {
		$( '.lsx-to-navigation .scroll-easing a' ).on( 'click', function( event ) {
			event.preventDefault();

			var $from = $( this ),
				$to = $( $from.attr( 'href' ) ),
				top = parseInt( $to.offset().top );

			top -= $( '#wpadminbar' ).length > 0 ? $( '#wpadminbar' ).outerHeight( true ) : 0;
			top -= $( '.top-menu-fixed #masthead' ).length > 0 ? $( '.top-menu-fixed #masthead' ).outerHeight( true ) : 0;
			top -= $( '.lsx-to-navigation' ).length > 0 ? $( '.lsx-to-navigation' ).outerHeight( true ) : 0;

			if ( '#summary' === $from.attr( 'href' ) ) {
				top -= 85;
			} else {
				top -= parseInt( $to.data( 'extra-top' ) ? $to.data( 'extra-top' ) : '0' );
			}

			$( 'html, body' ).animate( { scrollTop: top }, 800 );
		} );
	};

	/**
	 * Anchor menu - Scroll spy.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_anchor_menu_scroll_spy = function() {
		var offset = 10;

		offset += $( '#wpadminbar' ).length > 0 ? $( '#wpadminbar' ).outerHeight( true ) : 0;
		offset += $( '.top-menu-fixed #masthead' ).length > 0 ? $( '.top-menu-fixed #masthead' ).outerHeight( true ) : 0;
		offset += $( '.lsx-to-navigation' ).length > 0 ? $( '.lsx-to-navigation' ).outerHeight( true ) : 0;

		$( 'body' ).scrollspy( {
			target: '.lsx-to-navigation',
			offset: offset
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

		lsx_to.remove_empty_widgets();
		lsx_to.remove_empty_fast_facts();
		lsx_to.add_extra_class_to_meta();
		lsx_to.set_read_more();
		lsx_to.set_read_more_travel_info();
		lsx_to.set_read_more_itinerary();
		lsx_to.build_slider();
		lsx_to.build_slider_lightbox();

		if (window_width >= 1200) {
			lsx_to.fix_anchor_menu();
			lsx_to.set_anchor_menu_easing_scroll();
			lsx_to.set_anchor_menu_scroll_spy();
		}

	} );

	/**
	 * On window load.
	 *
	 * @package    lsx
	 * @subpackage scripts
	 */
	$window.load( function() {

		lsx_to.set_easing_scroll_on_page_load();

	} );

} )( jQuery, window, document );
