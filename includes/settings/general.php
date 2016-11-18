<div class="uix-field-wrapper">

	<ul class="ui-tab-nav">
		<li><a href="#ui-general" class="active"><?php esc_html_e('General','tour-operator'); ?></a></li>
		<?php if(class_exists('LSX_Currencies')) { ?>
			<li><a href="#ui-currencies"><?php esc_html_e('Currency','tour-operator'); ?></a></li>
		<?php } ?>
	</ul>

	<div id="ui-general" class="ui-tab active">
		<table class="form-table" style="margin-top:-13px !important;">
			<tbody>
			<?php do_action('to_framework_dashboard_tab_content','general'); ?>
			</tbody>
		</table>
	</div>

	<?php if(class_exists('LSX_Currencies')) { ?>
		<div id="ui-currencies" class="ui-tab">
			<table class="form-table" style="margin-top:-13px !important;">
				<tbody>
				<?php do_action('to_framework_dashboard_tab_content','currency_switcher'); ?>
				</tbody>
			</table>
		</div>
	<?php } ?>

	<?php do_action('to_framework_dashboard_tab_bottom','general'); ?>
</div>