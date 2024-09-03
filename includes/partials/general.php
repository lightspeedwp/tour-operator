

<div id="ui-general" class="ui-tab tabs-content active">
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'Currency Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>

			<tr class="form-field-wrap">
				<th scope="row">
					<label for="currency"> <?php esc_html_e( 'Currency', 'tour-operator' ); ?></label>
				</th>
				<td>
					<select value="" name="currency">
						<option value="USD" selected="selected" selected="selected"><?php esc_html_e( 'USD (united states dollar)', 'tour-operator' ); ?></option>
						<option value="GBP" selected="selected"><?php esc_html_e( 'GBP (british pound)', 'tour-operator' ); ?></option>
						<option value="ZAR" selected="selected"><?php esc_html_e( 'ZAR (south african rand)', 'tour-operator' ); ?></option>
						<option value="NAD" selected="selected"><?php esc_html_e( 'NAD (namibian dollar)', 'tour-operator' ); ?></option>
						<option value="CAD" selected="selected"><?php esc_html_e( 'CAD (canadian dollar)', 'tour-operator' ); ?></option>
						<option value="EUR" selected="selected"><?php esc_html_e( 'EUR (euro)', 'tour-operator' ); ?></option>
						<option value="HKD" selected="selected"><?php esc_html_e( 'HKD (hong kong dollar)', 'tour-operator' ); ?></option>
						<option value="SGD" selected="selected"><?php esc_html_e( 'SGD (singapore dollar)', 'tour-operator' ); ?></option>
						<option value="NZD" selected="selected"><?php esc_html_e( 'NZD (new zealand dollar)', 'tour-operator' ); ?></option>
						<option value="AUD" selected="selected"><?php esc_html_e( 'AUD (australian dollar)', 'tour-operator' ); ?></option>
					</select>
				</td>
			</tr>
			
			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'currency_switcher' ); ?>

			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'Map Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>
			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'maps' ); ?>

			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'Fusion Table Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>
			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'fusion' ); ?>

			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'Placeholder Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>
			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'placeholders' ); ?>

			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'APIs', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<i class="dashicons-before dashicons-admin-network"></i><label for="title"> <?php echo esc_html_e( 'Google Maps API', 'tour-operator' ); ?></label>
				</th>
				<td>
					<input type="text" value="" name="googlemaps_key" />
				</td>
			</tr>

			<?php do_action( 'lsx_to_framework_dashboard_tab_api', 'general' ); ?>

		</tbody>
	</table>
</div>



