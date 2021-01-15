/*
 * lsx-banners-admin.js
 */

jQuery( document ).ready(
	function() {

		var lsx_media_frame,
		$lsx_media_box,
		$lsx_media_button;

		/*
		* Choose Image
		*/
		if (undefined === window.lsx_thumbnail_image_add) {
			jQuery( document ).on(
				'click',
				'.lsx-thumbnail-image-add',
				function(e) {
					e.preventDefault();
					e.stopPropagation();

					// tb_show('Choose a Featured Image', 'media-upload.php?type=image&feature_image_text_button=1&TB_iframe=1');

					// Save the current object for use in the
					$lsx_media_button = jQuery( this ),
					$lsx_media_box = $lsx_media_button.parent( 'td' );

					if ( lsx_media_frame ) {
						lsx_media_frame.open();
						return;
					}

					lsx_media_frame = wp.media(
						{
							title: 'Select your imageimage',
							button: {
								text: 'Insert image'
							},
							multiple: false  // Set to true to allow multiple files to be selected
						}
					);

					// When an image is selected in the media frame...
					lsx_media_frame.on(
						'select',
						function() {

							// Get media attachment details from the frame state
							var attachment = lsx_media_frame.state().get( 'selection' ).first().toJSON();

							// Send the attachment URL to our custom image input field.
							$lsx_media_box.find( '.thumbnail-preview, .banner-preview' ).append( '<img width="150" src="' + attachment.url + '" />' );

							// Send the attachment id to our hidden input
							$lsx_media_box.find( 'input.input_image_id' ).val( attachment.id );
							$lsx_media_box.find( 'input.input_image' ).val( attachment.url );

							// Hide the add image link
							$lsx_media_button.hide();

							// Unhide the remove image link
							$lsx_media_box.find( '.lsx-thumbnail-image-delete, .lsx-thumbnail-image-remove' ).show();

						}
					);

					// Finally, open the modal on click
					lsx_media_frame.open();

					return false;

				}
			);

			window.lsx_thumbnail_image_add = true;
		}

		/*
		* Delete Image
		*/
		if (undefined === window.lsx_thumbnail_image_delete) {
			jQuery( document ).on(
				'click',
				'.lsx-thumbnail-image-delete, .lsx-thumbnail-image-remove',
				function(e) {
					e.preventDefault();
					e.stopPropagation();

					var $this = jQuery( this ),
					$td = $this.parent( 'td' );

					$td.find( 'input.input_image_id' ).val( '' );
					$td.find( 'input.input_image' ).val( '' );
					$td.find( '.thumbnail-preview, .banner-preview' ).html( '' );
					$this.hide();
					$td.find( '.lsx-thumbnail-image-add' ).show();

					return false;
				}
			);

			window.lsx_thumbnail_image_delete = true;
		}

		/*
		* Subtabs navigation
		*/
		if (undefined === window.lsx_thumbnail_subtabs_nav) {
			jQuery( document ).on(
				'click',
				'.ui-tab-nav a',
				function(e) {
					e.preventDefault();
					e.stopPropagation();

					var $this = jQuery( this );

					jQuery( '.ui-tab-nav a.active' ).removeClass( 'active' );
					$this.addClass( 'active' );
					jQuery( '.ui-tab.active' ).removeClass( 'active' );
					$this.closest( '.uix-field-wrapper' ).find( $this.attr( 'href' ) ).addClass( 'active' );

					return false;
				}
			);

			window.lsx_thumbnail_subtabs_nav = true;
		}

		// This is for the banner tabs

		// if ( 0 < jQuery('.meta-box-sortables #banners').length ) {
		// var tab_headers = [];

		// tab_headers.push('<div class="tab-toggle active" data-trigger="general"><a href="#">General</a></div>');
		// tab_headers.push('<div class="tab-toggle" data-trigger="button"><a href="#">Button</a></div>');
		// tab_headers.push('<div class="tab-toggle" data-trigger="bg_images"><a href="#">BG Images</a></div>');
		// tab_headers.push('<div class="tab-toggle" data-trigger="attributes"><a href="#">Attributes</a></div>');

		// jQuery('.meta-box-sortables #banners .inside').prepend( tab_headers );

		// jQuery('.meta-box-sortables #banners').find( '#button_group' ).hide();
		// jQuery('.meta-box-sortables #banners').find( '#image_group' ).hide();
		// jQuery('.meta-box-sortables #banners').find( '#image_bg_group' ).hide();

		// Grab all the "Groups"
		// *jQuery('.cmb-row').children().each( function( e ) {
		// if ( 0 < jQuery(this).find('.field-title').length ) {
		// var anchor = jQuery(this).find('.field-title').parent().attr('id');
		// tab_headers.push('<div class="tab-toggle" data-trigger="'+anchor+'">'+anchor+'</div>');
		// }
		// });*/

		// jQuery(document).on('click', '.meta-box-sortables #banners .tab-toggle a:not(.active)', function(e) {
		// jQuery('.meta-box-sortables #banners .tab-toggle a.active').removeClass('active');
		// jQuery(this).addClass('active');
		// });
		// }
	}
);
