

<div id="ui-general" class="ui-tab tabs-content active">
	<table class="form-table">
		<tbody>
			<?php if ( ! class_exists( '\lsx\currencies\classes\Currencies' ) ) { ?>
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
						<select value="{{currency}}" name="currency">
							<option value="USD" {{#is currency value=""}}selected="selected"{{/is}} {{#is currency value="USD"}} selected="selected"{{/is}}><?php esc_html_e( 'USD (united states dollar)', 'tour-operator' ); ?></option>
							<option value="GBP" {{#is currency value="GBP"}} selected="selected"{{/is}}><?php esc_html_e( 'GBP (british pound)', 'tour-operator' ); ?></option>
							<option value="ZAR" {{#is currency value="ZAR"}} selected="selected"{{/is}}><?php esc_html_e( 'ZAR (south african rand)', 'tour-operator' ); ?></option>
							<option value="NAD" {{#is currency value="NAD"}} selected="selected"{{/is}}><?php esc_html_e( 'NAD (namibian dollar)', 'tour-operator' ); ?></option>
							<option value="CAD" {{#is currency value="CAD"}} selected="selected"{{/is}}><?php esc_html_e( 'CAD (canadian dollar)', 'tour-operator' ); ?></option>
							<option value="EUR" {{#is currency value="EUR"}} selected="selected"{{/is}}><?php esc_html_e( 'EUR (euro)', 'tour-operator' ); ?></option>
							<option value="HKD" {{#is currency value="HKD"}} selected="selected"{{/is}}><?php esc_html_e( 'HKD (hong kong dollar)', 'tour-operator' ); ?></option>
							<option value="SGD" {{#is currency value="SGD"}} selected="selected"{{/is}}><?php esc_html_e( 'SGD (singapore dollar)', 'tour-operator' ); ?></option>
							<option value="NZD" {{#is currency value="NZD"}} selected="selected"{{/is}}><?php esc_html_e( 'NZD (new zealand dollar)', 'tour-operator' ); ?></option>
							<option value="AUD" {{#is currency value="AUD"}} selected="selected"{{/is}}><?php esc_html_e( 'AUD (australian dollar)', 'tour-operator' ); ?></option>
						</select>
					</td>
				</tr>
			<?php } else { ?>
				<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'currency_switcher' ); ?>
			<?php } ?>

			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'general' ); ?>

			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'Placeholder Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>
			<?php do_action( 'lsx_to_framework_dashboard_tab_placeholder', 'general' ); ?>

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



