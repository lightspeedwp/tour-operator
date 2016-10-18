<div class="uix-field-wrapper accommodation">
	<table class="form-table">
		<tbody>
			<tr class="form-field banner-wrap">
				<th scope="row">
					<label for="banner"> Banner</label>
				</th>
				<td>
					<input type="hidden" {{#if banner_id}} value="{{banner_id}}" {{/if}} name="banner_id" />
					<input type="hidden" {{#if banner}} value="{{banner}}" {{/if}} name="banner" />
					<div class="thumbnail-preview">
						{{#if banner}}<img src="{{banner}}" width="150" height="150" />{{/if}}	
					</div>

					<a {{#if banner}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add">Choose Image</a>

					<a {{#unless banner}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete">Delete</a>
					
				</td>
			</tr>	
			<tr class="form-field">
				<th scope="row">
					<label for="tagline"> Tagline</label>
				</th>
				<td>
					<input type="text" {{#if tagline}} value="{{tagline}}" {{/if}} name="tagline" />
				</td>
			</tr>			
			<tr class="form-field">
				<th scope="row">
					<label for="title"> Title</label>
				</th>
				<td>
					<p>Edit this on the page you have set as the "blog"</p>
				</td>
			</tr>				

			<tr class="form-field">
				<th scope="row">
					<label for="description"> Description</label>
				</th>
				<td>
					<p>Edit this on the page you have set as the "blog"</p>
				</td>
			</tr>										
		</tbody>
	</table>

	<script>
		jQuery(document).ready( function() {	
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
		});
	</script>
</div>