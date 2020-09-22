<div class="uix-field-wrapper accommodation">
	<table class="form-table">
		<tbody>
			<tr class="form-field banner-wrap">
				<th scope="row">
					<label for="banner"> <?php esc_html_e( 'Banner', 'tour-operator' ); ?></label>
				</th>
				<td>
					<input class="input_image_id" type="hidden" {{#if banner_id}} value="{{banner_id}}" {{/if}} name="banner_id" />
					<input class="input_image" type="hidden" {{#if banner}} value="{{banner}}" {{/if}} name="banner" />
					<div class="thumbnail-preview">
						{{#if banner}}<img src="{{banner}}" width="150" />{{/if}}
					</div>
					<a {{#if banner}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'tour-operator' ); ?></a>
					<a {{#unless banner}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete"><?php esc_html_e( 'Delete', 'tour-operator' ); ?></a>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="tagline"> <?php esc_html_e( 'Tagline', 'tour-operator' ); ?></label>
				</th>
				<td>
					<input type="text" {{#if tagline}} value="{{tagline}}" {{/if}} name="tagline" />
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="title"> <?php esc_html_e( 'Title', 'tour-operator' ); ?></label>
				</th>
				<td>
					<p><?php esc_html_e( 'Edit this on the page you have set as the "blog"', 'tour-operator' ); ?></p>
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row">
					<label for="description"> <?php esc_html_e( 'Description', 'tour-operator' ); ?></label>
				</th>
				<td>
					<p><?php esc_html_e( 'Edit this on the page you have set as the "blog"', 'tour-operator' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
