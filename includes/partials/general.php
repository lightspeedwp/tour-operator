

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
			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'currency' ); ?>

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
			<?php do_action( 'lsx_to_framework_dashboard_tab_content', 'api' ); ?>
		</tbody>
	</table>
</div>



