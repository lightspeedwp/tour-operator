var TO_Banners = {
	initScrollable: function() {
		jQuery( '.banner-easing a' ).on(
			'click',
			function(e) {
				e.preventDefault();

				var _$from = jQuery( this ),
				_$to = jQuery( _$from.attr( 'href' ) ),
				_top = parseInt( _$to.offset().top ),
				_extra = parseInt( _$from.data( 'extra-top' ) ? _$from.data( 'extra-top' ) : '-100' );
				_mobile = parseInt( _$from.data( 'mobile-top' ) ? _$from.data( 'mobile-top' ) : '-50' );

				console.log(_top + _extra);

				let addtion = _extra;
				if ( 900 >= jQuery(window).width() ) {
					addtion = _mobile;
				}

				console.log( _top + addtion );
				
				jQuery( 'html' ).animate(
					{
						scrollTop: (_top + addtion)
					},
					80
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
};

jQuery( document ).ready(
	function() {
		TO_Banners.initScrollable();
	}
);
