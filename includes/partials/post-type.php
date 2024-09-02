<?php

?>
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

			<?php do_action( 'lsx_to_framework_' . $tab_index . '_tab_content', 'placeholders' ); ?>

			<tr class="form-field">
				<th scope="row" colspan="2">
					<label>
						<h3><?php esc_html_e( 'Template Settings', 'tour-operator' ); ?></h3>
					</label>
				</th>
			</tr>

			<tr class="form-field">
				<th scope="row">
					<label for="disable_archives"><?php esc_html_e( 'Disable Archives', 'tour-operator' ); ?></label>
				</th>
				<td>
					<input type="checkbox" checked="checked" name="disable_archives" />
					<small><?php esc_html_e( 'This disables the "post type archive", if you create your own custom loop it will still work.', 'tour-operator' ); ?></small>
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row">
					<label for="disable_single"><?php esc_html_e( 'Disable Singles', 'tour-operator' ); ?></label>
				</th>
				<td>
					<input type="checkbox" checked="checked" name="disable_single" />
					<small><?php esc_html_e( 'When disabled you will be redirected to the homepage when trying to access a single page.', 'tour-operator' ); ?></small>
				</td>
			</tr>
		</tbody>
	</table>
</div>