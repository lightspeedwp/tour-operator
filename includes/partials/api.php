<div class="uix-field-wrapper">
	<?php
		$display_settings_page = false;

		if ( class_exists( 'TO_Maps' ) || class_exists( 'LSX_Currencies' ) || class_exists( 'WETU_Importer' ) ) {
			$display_settings_page = true;
		}
	?>

	<ul class="ui-tab-nav">
		<?php if ( false !== $display_settings_page ) { ?><li><a href="#ui-settings" class="active"><?php esc_html_e( 'Settings', 'tour-operator' ); ?></a></li><?php } ?>
		<li><a href="#ui-keys" <?php if ( false === $display_settings_page ) { ?>class="active"<?php } ?>><?php esc_html_e( 'License Keys', 'tour-operator' ); ?></a></li>
	</ul>

	<?php if ( false !== $display_settings_page ) { ?>
		<div id="ui-settings" class="ui-tab active">
			<p><?php esc_html_e( 'Please enter your user details (email address, API key, username, etc) below as required for the extensions that you have installed.', 'tour-operator' ); ?></p>

			<table class="form-table" style="margin-top:-13px !important;">
				<tbody>
					<?php do_action( 'lsx_to_framework_api_tab_content', 'settings' ); ?>
				</tbody>
			</table>
		</div>
	<?php } ?>

	<div id="ui-keys" class="ui-tab <?php if ( false === $display_settings_page ) { ?>active<?php } ?>">
		<table class="form-table" style="margin-top:-13px !important;">
			<tbody>
				<?php
					$current_theme = wp_get_theme();
					$lsx = admin_url( 'themes.php?page=lsx-welcome' );
					$message = sprintf( "Please enter the license and API key's for your add-ons below." );
					$tour_operator = admin_url( 'admin.php?page=to-addons' );

					if ( 'lsx' === $current_theme->get_template() || 'lsx' === $current_theme->get_stylesheet() ) {
						$message .= sprintf( " Follow the links to see what extensions are available for <a href='%s' title='LSX add-ons'>LSX</a> Theme and the <a href='%s' title='TO add-ons'>Tour Operator</a> plugin.", $lsx, $tour_operator );
					} else {
						$message .= sprintf( " Follow this <a href='%s' title='TO add-ons'>link</a> to see what extensions are available for Tour Operator plugin.", $tour_operator );
					}
				?>

				<p class="info"><?php echo wp_kses_post( $message ); ?></p>

				<tr class="form-field-wrap">
					<th class="tour-operator_table_heading" style="padding-bottom:0px;" scope="row" colspan="2">
						<h4 style="margin-bottom:0px;"><span><?php echo esc_html_e( 'Google Maps API', 'tour-operator' ); ?></span></h4>
					</th>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<i class="dashicons-before dashicons-admin-network"></i><label for="title"> <?php echo esc_html_e( 'Key', 'tour-operator' ); ?></label>
					</th>
					<td>
						<input type="text" {{#if googlemaps_key}} value="{{googlemaps_key}}" {{/if}} name="googlemaps_key" />
					</td>
				</tr>				

				<?php
					do_action( 'lsx_to_framework_api_tab_content', 'api' );
				?>
			</tbody>
		</table>

	</div>

	<?php do_action( 'lsx_to_framework_api_tab_bottom', 'api' ); ?>
</div>
