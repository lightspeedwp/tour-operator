

<div id="ui-general" class="ui-tab tabs-content active">
	<table class="form-table">
		<tbody>
			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'general' ); ?>
		</tbody>
	</table>

	<?php if ( class_exists( '\lsx\currencies\classes\Currencies' ) ) { ?>
		<table class="form-table">
			<tbody>
				<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'currency_switcher' ); ?>
			</tbody>
		</table>
	<?php } ?>

	<?php do_action( 'lsx_to_framework_dashboard_tab_bottom', 'general' ); ?>
</div>



