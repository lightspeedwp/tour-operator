var TO_Read_More = {
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

var TO_Scrollable = {
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
	TO_Read_More.initThis(); 
	TO_Scrollable.initThis();
});