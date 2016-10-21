<div class="uix-field-wrapper">

	<ul class="ui-tab-nav">
		<li><a href="#ui-basic" class="active"><?php esc_html_e('Basic','tour-operator'); ?></a></li>
		<li><a href="#ui-advanced"><?php esc_html_e('Advanced','tour-operator'); ?></a></li>
	</ul>

	<div id="ui-basic" class="ui-tab active">
		<h3><?php esc_html_e('Basic','tour-operator'); ?></h3>
		<table class="form-table">
			<tbody>
			<?php do_action('to_framework_display_tab_content','basic'); ?>		
			</tbody>
		</table>	  
	</div>

	<div id="ui-advanced" class="ui-tab">
		<h3><?php esc_html_e('Advanced','tour-operator'); ?></h3>
		<table class="form-table">
			<tbody>
			<?php do_action('to_framework_display_tab_content','advanced'); ?>		
			</tbody>
		</table>
	</div>

	<?php do_action('to_framework_display_tab_bottom','display'); ?>

</div>