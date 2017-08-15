<div class="uix-field-wrapper">

	<?php
		$display_settings_page = false;
		if ( class_exists( 'TO_Maps' ) || class_exists( 'LSX_Currencies' ) || class_exists( 'WETU_Importer' ) ) {
			$display_settings_page = true;
		}
	?>


	<ul class="ui-tab-nav">
		<?php if ( false !== $display_settings_page ) { ?><li><a href="#ui-settings" class="active"><?php esc_html_e('Settings','tour-operator'); ?></a></li><?php } ?>
		<li><a href="#ui-keys" <?php if ( false === $display_settings_page ) { ?>class="active"<?php } ?>><?php esc_html_e('License Keys','tour-operator'); ?></a></li>
	</ul>

	<?php if ( false !== $display_settings_page ) { ?>
		<div id="ui-settings" class="ui-tab active">
			<p>Settings</p>
			<table class="form-table" style="margin-top:-13px !important;">
				<tbody>
				<?php do_action('lsx_to_framework_api_tab_content','settings'); ?>
				</tbody>
			</table>
		</div>
	<?php } ?>

	<div id="ui-keys" class="ui-tab <?php if ( false === $display_settings_page ) { ?>active<?php } ?>">
		<table class="form-table" style="margin-top:-13px !important;">
			<tbody>
			<?php
			if ( class_exists( 'LSX_API_Manager') ) {
				?><p class="info"><?php esc_html_e('Enter the license keys for your add-ons in the boxes below.','tour-operator' ); ?></p><?php
				do_action('lsx_to_framework_api_tab_content','api');
			} else { ?>
				<p class="info"><?php esc_html_e( 'You have not installed any add-ons yet. View our list of add-ons', 'tour-operator' ); ?> <a href="<?php echo esc_url(admin_url('admin.php')); ?>?page=to-addons"><?php esc_html_e( 'here', 'tour-operator' ); ?></a>.</p>
			<?php }	?>
			</tbody>
		</table>

	</div>

	<?php do_action('lsx_to_framework_api_tab_bottom','api'); ?>
</div>