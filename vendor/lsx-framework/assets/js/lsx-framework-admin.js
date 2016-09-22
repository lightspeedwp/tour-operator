var LSX_Settings_Media_Uploader = {
	initThis: function(){
		console.log('test');
		jQuery( '.lsx-thumbnail-image-add' ).on( 'click', function() {
			tb_show('Choose a Featured Image', 'media-upload.php?type=image&TB_iframe=1');
			var image_thumbnail = '';
			var $this = jQuery(this);
			window.send_to_editor = function( html ) 
			{
				var image_thumbnail = jQuery( 'img',html ).html();

				jQuery( $this ).parent('td').find('.thumbnail-preview' ).append('<img width="150" height="150" src="'+jQuery( 'img',html ).attr( 'src' )+'" />');
				jQuery( $this ).parent('td').find('input[name="banner"]').val(jQuery( 'img',html ).attr( 'src' ));
				
				var imgClasses = jQuery( 'img',html ).attr( 'class' );
				imgClasses = imgClasses.split('wp-image-');
				
				jQuery( $this ).parent('td').find('input[name="banner_id"]').val(imgClasses[1]);
				jQuery( $this ).hide();
				jQuery( $this ).parent('td').find('.lsx-thumbnail-image-delete' ).show();
				tb_remove();
			}
			jQuery( this ).hide();
			
			return false;
		});	
		jQuery( '.lsx-thumbnail-image-delete' ).on( 'click', function() {
			jQuery( this ).parent('td').find('input[name="banner_id"]').val('');
			jQuery( this ).parent('td').find('input[name="banner"]').val('');
			jQuery( this ).parent('td').find('.thumbnail-preview' ).html('');
			jQuery( this ).hide();
			jQuery( this ).parent('td').find('.lsx-thumbnail-image-add' ).show();
		});			
	}

	addMedia: function(){
		console.log('yyeyeye');
	}
}

jQuery(document).ready( function() {
	LSX_Settings_Media_Uploader.initThis(); 
});