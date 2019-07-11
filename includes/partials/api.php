<div class="uix-field-wrapper">
	<div id="ui-settings" class="ui-tab active">
		<p><?php esc_html_e( 'Please enter your user details (email address, API key, username, etc) below as required for the extensions that you have installed.', 'tour-operator' ); ?></p>

		<table class="form-table" style="margin-top:-13px !important;">
			<tbody>

				<tr class="form-field-wrap">
					<th class="tour-operator_table_heading" style="padding-bottom:0px;" scope="row" colspan="2">
						<h4 style="margin-bottom:0px;"><span><?php echo esc_html_e( 'Google Maps API', 'tour-operator' ); ?></span></h4>
					</th>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<i class="dashicons-before dashicons-admin-network"></i><label for="title"> <?php echo esc_html_e( 'Key', 'tour-operator' ); ?></label>
					</th>
					<td>
						<input type="text" {{#if googlemaps_key}} value="{{googlemaps_key}}" {{/if}} name="googlemaps_key" />
					</td>
				</tr>

				<?php do_action( 'lsx_to_framework_api_tab_content', 'settings' ); ?>

				<?php do_action( 'lsx_to_framework_api_tab_content', 'api' ); ?>
			</tbody>
		</table>
	</div>

	<?php do_action( 'lsx_to_framework_api_tab_bottom', 'api' ); ?>
</div>
