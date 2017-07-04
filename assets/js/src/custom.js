/**
 * Scripts
 *
 * @package    tour-operator
 * @subpackage scripts
 */

var lsx_to = Object.create( null );

;( function( $, window, document, undefined ) {

	'use strict';

	var $document    = $( document ),
		$window      = $( window ),
		windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight,
		windowWidth  = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

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
	 * Add extra HTML class to metadata tags.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.add_extra_class_to_meta = function() {
		$( '.meta' ).parent().each( function() {
			var nodes = $( this ).children( '.meta' );
			nodes.last().addClass( 'last-meta' );
		} );
	};

	/**
	 * Read more effect.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_read_more = function() {
		$( '.entry-content .more-link, .archive-description .more-link' ).each( function() {
			if ( 'Read More' === $( this ).html() ) {
				$( this ).closest( '.entry-content, .archive-description' ).each( function() {
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

						$( this ).closest( '.entry-content, .archive-description' ).children().each( function() {
							$( this ).show();
						} );
					} else {
						$( this ).closest( '.entry-content, .archive-description' ).children().show();
					}
				} );
			}
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
		$( '.lsx-to-slider .lsx-to-slider-inner' ).each( function() {
			var $this = $( this ),
				interval = $this.data( 'interval' ),
				autoplay = false,
				autoplaySpeed = 0;

			lsx_to.pre_build_slider( $this );

			if ( 'undefined' !== typeof interval && 'boolean' !== typeof interval ) {
				interval = parseInt( interval );

				if ( ! isNaN( interval ) ) {
					autoplay = true;
					autoplaySpeed = interval;
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
				autoplaySpeed: autoplaySpeed,
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

			marginTop: function () {
				var mt = 0;

				mt += $( '.top-menu-fixed #masthead' ).length > 0 ? $( '.top-menu-fixed #masthead' ).outerHeight( true ) :  0;
				mt += $( '#wpadminbar' ).length > 0 ? $( '#wpadminbar' ).outerHeight() : 0;

				return mt;
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
		$( '.lsx-to-navigation .scroll-easing a' ).on( 'click', function( e ) {
			e.preventDefault();

			var $from = $( this ),
				$to = $( $from.attr( 'href' ) ),
				top = parseInt( $to.offset().top ),
				extra_header = $( '.top-menu-fixed #masthead' ).length > 0 ? $( '.top-menu-fixed #masthead' ).outerHeight( true ) : 0,
				extra_navigation = $( '.lsx-to-navigation' ).length > 0 ? $( '.lsx-to-navigation' ).outerHeight( true ) : 0,
				extra_attr = parseInt( $to.data( 'extra-top' ) ? $to.data( 'extra-top' ) : '0' ),
				extra;

			if ( '#summary' === $from.attr( 'href' ) ) {
				extra_attr = 85;
			}

			extra = - ( extra_header + extra_navigation + extra_attr );

			$( 'html, body' ).animate({
				scrollTop: ( top + extra )
			}, 800);
		} );
	};

	/**
	 * Anchor menu - Scroll spy.
	 *
	 * @package    tour-operator
	 * @subpackage scripts
	 */
	lsx_to.set_anchor_menu_scroll_spy = function() {
		var offset_header = $( '.top-menu-fixed #masthead' ).length > 0 ? $( '.top-menu-fixed #masthead' ).outerHeight( true ) : 0,
			offset_navigation = $( '.lsx-to-navigation' ).length > 0 ? $( '.lsx-to-navigation' ).outerHeight( true ) : 0;

		$( 'body' ).scrollspy( {
			target: '.lsx-to-navigation',
			offset: offset_header + offset_navigation + 10
		} );
	};

	/**
	 * On window resize.
	 *
	 * @package    lsx
	 * @subpackage scripts
	 */
	$window.resize( function() {

		windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

	} );

	/**
	 * On document ready.
	 *
	 * @package    lsx
	 * @subpackage scripts
	 */
	$document.ready( function() {

		lsx_to.remove_empty_widgets();
		lsx_to.add_extra_class_to_meta();
		lsx_to.set_read_more();
		lsx_to.set_read_more_itinerary();
		lsx_to.build_slider();
		lsx_to.build_slider_lightbox();

		if (windowWidth >= 1200) {
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
	$window.load( function() {} );

} )( jQuery, window, document );
