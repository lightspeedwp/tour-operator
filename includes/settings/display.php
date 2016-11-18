<div class="uix-field-wrapper">

	<ul class="ui-tab-nav">
		<li><a href="#ui-general" class="active"><?php esc_html_e('General','tour-operator'); ?></a></li>
		<?php if(class_exists('LSX_Currencies')) { ?>
			<li><a href="#ui-currencies"><?php esc_html_e('Currency Switcher','tour-operator'); ?></a></li>
		<?php } ?>
		<?php if(class_exists('TO_Maps')) { ?>
			<li><a href="#ui-maps"><?php esc_html_e('Maps','tour-operator'); ?></a></li>
		<?php } ?>
		<li><a href="#ui-placeholders"><?php esc_html_e('Placeholders','tour-operator'); ?></a></li>
		<li><a href="#ui-advanced"><?php esc_html_e('Advanced','tour-operator'); ?></a></li>
	</ul>

	<div id="ui-general" class="ui-tab active">
		<table class="form-table">
			<tbody>
			<?php do_action('to_framework_display_tab_content','basic'); ?>		
			</tbody>
		</table>	  
	</div>

	<?php if(class_exists('LSX_Currencies')) { ?>
		<div id="ui-currencies" class="ui-tab">
			<table class="form-table">
				<tbody>
				<?php do_action('to_framework_display_tab_content','currency_switcher'); ?>
				</tbody>
			</table>
		</div>
	<?php } ?>

	<?php if(class_exists('TO_Maps')) { ?>
		<div id="ui-maps" class="ui-tab">
			<table class="form-table">
				<tbody>
				<?php do_action('to_framework_display_tab_content','maps'); ?>
				</tbody>
			</table>
		</div>
	<?php } ?>

	<div id="ui-placeholders" class="ui-tab">
		<table class="form-table">
			<tbody>
			<?php do_action('to_framework_display_tab_content','placeholders'); ?>
			</tbody>
		</table>
	</div>

	<div id="ui-advanced" class="ui-tab">
		<table class="form-table">
			<tbody>
			<?php do_action('to_framework_display_tab_content','advanced'); ?>		
			</tbody>
		</table>
	</div>

	<?php do_action('to_framework_display_tab_bottom','display'); ?>

</div>