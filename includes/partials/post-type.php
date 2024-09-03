<div id="ui-<?php echo esc_attr( $tab_index ); ?>" class="ui-tab tabs-content">
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3> <?php echo esc_html( $tab['menu_title'] ); ?> <?php esc_html_e( 'Placeholder Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>

			<?php do_action( 'lsx_to_framework_post_type_tab_content', 'placeholders', $tab_index ); ?>

			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'Template Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>

			<?php do_action( 'lsx_to_framework_post_type_tab_content', 'template', $tab_index ); ?>
		</tbody>
	</table>
</div>