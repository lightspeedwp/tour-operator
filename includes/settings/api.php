<div class="uix-field-wrapper">

	<ul class="ui-tab-nav">
		<li><a href="#ui-settings" class="active"><?php esc_html_e('Settings','tour-operator'); ?></a></li>
		<li><a href="#ui-keys"><?php esc_html_e('Keys','tour-operator'); ?></a></li>
		<li><a href="#ui-webhooks"><?php esc_html_e('Webhooks','tour-operator'); ?></a></li>
	</ul>

	<div id="ui-settings" class="ui-tab active">
	  <h3><?php esc_html_e('Settings','tour-operator'); ?></h3>
	  <p>Enter your text here</p>
	</div>

	<div id="ui-keys" class="ui-tab">
		<table class="form-table" style="margin-top:-13px !important;">
			<tbody>
			<tr class="form-field">
				<th class="api_table_heading" style="padding-bottom:0px;" scope="row" colspan="2">
					<label><h3 style="margin-bottom:0px;margin-top: -5px;"> API Settings</h3></label>			
				</th>
			</tr>
			<?php do_action('to_framework_api_tab_content','api'); ?>		
			</tbody>
		</table>
		<?php do_action('to_framework_api_tab_bottom','api'); ?>
	</div>

	<div id="ui-webhooks" class="ui-tab">
	  <h3><?php esc_html_e('Webhooks','tour-operator'); ?></h3>
	  <p>Enter your text here</p>
	</div>

</div>