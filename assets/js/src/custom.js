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
		// First slider: .lsx-to-slider
		$( '.lsx-to-slider .wp-block-post-template:not(.slider-disabled)' ).each( function() {
			var $this = $( this );
	
			lsx_to.pre_build_slider( $this );
	
			if ( 1 < $this.children().length ) {
				$this.slick( {
					draggable: false,
					infinite: true,
					swipe: false,
					dots: false,
					slidesToShow: 3,  // Show 3 items at a time
					slidesToScroll: 1, // Scroll 1 item at a time
					autoplay: false,
					autoplaySpeed: 0,
					appendArrows: $this.parent(),  // Ensure arrows are appended correctly
					appendDots: $this.parent(),    // Append dots in the right container
					responsive: [
						{
							breakpoint: 1028,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1,
								draggable: true,
								arrows: true,
								swipe: true,
								dots: true,
							}
						},
						{
							breakpoint: 782,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
								draggable: true,
								arrows: true,
								swipe: true,
								dots: true,
							}
						}
					]
				} );
			}
		} );
	
		// Second slider: .lsx-to-slider.travel-information
		$( '.lsx-travel-information-wrapper.lsx-to-slider .travel-information:not(.slider-disabled)' ).each( function() {
			var $this = $( this );
	
			lsx_to.pre_build_slider( $this );
	
			// Ensure the second slider has 4 slides showing
			if ( 1 < $this.children().length ) {
				$this.slick( {
					draggable: false,
					infinite: true,
					swipe: false,
					dots: false,
					slidesToShow: 4,  // Show 4 items at a time
					slidesToScroll: 1, // Scroll 1 item at a time
					autoplay: false,
					autoplaySpeed: 0,
					appendArrows: $this.parent(),  // Ensure arrows are appended correctly for this slider
					appendDots: $this.parent(),    // Append dots in the correct place
					responsive: [
						{
							breakpoint: 1028,
							settings: {
								slidesToShow: 3,
								slidesToScroll: 1,
								draggable: true,
								arrows: true,
								swipe: true,
								dots: true,
							}
						},
						{
							breakpoint: 782,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
								draggable: true,
								arrows: true,
								swipe: true,
								dots: true,
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

	document.addEventListener('DOMContentLoaded', function () {
		const paragraphs = document.querySelectorAll('.additional-info .wp-block-group.content p');
	
		paragraphs.forEach(function (p) {
			const text = p.innerText.trim();
	
			if (text.split(' ').length > 30) {  // Check if paragraph exceeds 30 words
				const fullText = p.innerText.trim();
				const truncatedText = fullText.split(' ').slice(0, 30).join(' ') + '...';
				p.innerHTML = `<span class="truncated-text">${truncatedText}</span><span class="full-text" style="display: none;">${fullText}</span>`;
	
				// Create Read More button
				const readMoreBtn = document.createElement('span');
				readMoreBtn.textContent = ' Read More';
				readMoreBtn.classList.add('read-more-btn');
				p.appendChild(readMoreBtn);
	
				// Create Read Less button
				const readLessBtn = document.createElement('span');
				readLessBtn.textContent = ' Read Less';
				readLessBtn.classList.add('read-less-btn');
				p.appendChild(readLessBtn);
	
				// Add functionality to toggle text
				readMoreBtn.addEventListener('click', function () {
					p.querySelector('.truncated-text').style.display = 'none';
					p.querySelector('.full-text').style.display = 'inline';
					readMoreBtn.style.display = 'none';
					readLessBtn.style.display = 'inline';
				});
	
				readLessBtn.addEventListener('click', function () {
					p.querySelector('.truncated-text').style.display = 'inline';
					p.querySelector('.full-text').style.display = 'none';
					readMoreBtn.style.display = 'inline';
					readLessBtn.style.display = 'none';
				});
			}
		});
	});	

	document.addEventListener('DOMContentLoaded', function () {
		// Select all sections within `.single-tour-operator`
		const sections = document.querySelectorAll('.single-tour-operator section.wp-block-group');

		sections.forEach(section => {
			// Locate the first <h2> within the section
			const heading = section.querySelector('h2');
			// Locate the second div with the class wp-block-group
			const toggleTarget = section.querySelectorAll('.wp-block-group')[1];
	
			console.log('Processing Section:', section); // Debug
			console.log('Found Heading:', heading); // Debug
			console.log('Toggle Target:', toggleTarget); // Debug
	
			if (heading && toggleTarget) {
				// Create a toggle button
				const toggleButton = document.createElement('button');
				toggleButton.classList.add('toggle-button');
				toggleButton.innerHTML = `
					<svg class="toggle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
						<path class="icon-down" d="M1 5l7 7 7-7H1z"></path>
						<path class="icon-up" d="M1 11l7-7 7 7H1z" style="display: none;"></path>
					</svg>
				`;
	
				// Insert the button after the heading
				heading.insertAdjacentElement('afterend', toggleButton);
	
				// Add click event listener to toggle visibility of the second wp-block-group
				toggleButton.addEventListener('click', function () {
					toggleTarget.classList.toggle('collapsed'); // Add or remove the collapsed class
	
					// Toggle the display of the up/down icons
					const iconDown = toggleButton.querySelector('.icon-down');
					const iconUp = toggleButton.querySelector('.icon-up');
	
					if (toggleTarget.classList.contains('collapsed')) {
						iconDown.style.display = 'none';
						iconUp.style.display = 'inline';
					} else {
						iconDown.style.display = 'inline';
						iconUp.style.display = 'none';
					}
				});
			}
		});
	});

} )( jQuery, window, document );
