var LSX_Banners = {
	initScrollable: function() {
		jQuery( '.banner-easing a' ).on(
			'click',
			function(e) {
				e.preventDefault();

				var _$from = jQuery( this ),
				_$to = jQuery( _$from.attr( 'href' ) ),
				_top = parseInt( _$to.offset().top ),
				_extra = parseInt( _$from.data( 'extra-top' ) ? _$from.data( 'extra-top' ) : '-100' );

				jQuery( 'html, body' ).animate(
					{
						scrollTop: (_top + _extra)
					},
					800
				);

				return false;
			}
		);
	},

	doScroll: function(_$el) {
		var _href = (_$el.href).replace( /^[^#]*(#.+$)/gi, '$1' ),
			_$to = jQuery( _href ),
			_top = parseInt( _$to.offset().top ),
			_extra = -100;

		jQuery( 'html, body' ).animate(
			{
				scrollTop: (_top + _extra)
			},
			800
		);
	},

	initSliderSwiper: function() {
		if (jQuery( '#page-banner-slider' ).length > 0) {
			jQuery( '#page-banner-slider' ).slick(
				{
					draggable: false,
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					swipe: false,
					cssEase: 'ease-out',
					responsive: [{
						breakpoint: 768,
						settings: {
							draggable: true,
							swipe: true,
							arrows: false,
							dots: true
						}
					}]
				}
			);
		}
	},

	openModal: function(_$el) {
		var _href = (_$el.href).replace( /^[^#]*(#cf-modal-.+$)/gi, '$1' );
		jQuery( _href ).modal()
	}
};

jQuery( document ).ready(
	function() {
		LSX_Banners.initScrollable();
		LSX_Banners.initSliderSwiper();
	}
);
