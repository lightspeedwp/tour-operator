<div class="uix-field-wrapper">

	<ul class="ui-tab-nav">
		<li><a href="#ui-settings" class="active"><?php esc_html_e('Settings','tour-operator'); ?></a></li>
		<li><a href="#ui-keys"><?php esc_html_e('License Keys','tour-operator'); ?></a></li>
	</ul>

	<div id="ui-settings" class="ui-tab active">
        <p>Settings</p>
		<table class="form-table" style="margin-top:-13px !important;">
			<tbody>
			<?php do_action('lsx_to_framework_api_tab_content','settings'); ?>
			</tbody>
		</table>
	</div>

	<div id="ui-keys" class="ui-tab">
		<table class="form-table" style="margin-top:-13px !important;">
			<tbody>
			<?php
			$api_keys_content = false;
			ob_start();
			do_action('lsx_to_framework_api_tab_content','api');
			$api_keys_content = ob_end_clean();
			if(false !== $api_keys_content){
				?><p class="info"><?php esc_html_e('Enter the license keys for your add-ons in the boxes below.','tour-operator'); ?></p><?php
				do_action('lsx_to_framework_api_tab_content','api');
			}else{ ?>
				<p class="info"><?php esc_html_e('You have not installed any add-ons yet. View our list of add-ons','tour-operator'); ?> <a href="<?php echo esc_url(admin_url('admin.php')); ?>?page=to-addons"><?php esc_html_e('here','tour-operator'); ?></a>.</p>
			<?php }	?>
			</tbody>
		</table>

	</div>

	<?php do_action('lsx_to_framework_api_tab_bottom','api'); ?>
</div>