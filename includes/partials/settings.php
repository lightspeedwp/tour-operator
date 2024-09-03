
<?php
$settings_pages = tour_operator()->settings->settings_page_array();
?>
<div class="wrap">
	<h1><?php echo esc_html( $settings_pages['settings']['page_title'] ); ?></h1>
	<form method="post">
		<?php
		include( LSX_TO_PATH . 'includes/partials/navigation.php' );

		foreach ( $settings_pages['settings']['tabs'] as $tab_index => $tab ) {
			if ( 'post_type' === $tab['template'] ) {
				include( LSX_TO_PATH . 'includes/partials/post-type.php' );
			} else {
				include( $tab['template'] );
			}
		}
		?>
		<input name="submit" class="button button-primary" type="submit" value="Save Settings" />
	</form>
</div>