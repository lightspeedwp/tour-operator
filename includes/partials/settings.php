
<?php
$settings_pages = tour_operator()->settings->settings_page_array();
?>
<div class="wrap">
	<h1><?php echo esc_html( $settings_pages['settings']['page_title'] ); ?></h1>
	<form action="options.php" method="post">
		<?php
		include( LSX_TO_PATH . 'includes/partials/navigation.php' );
		include( LSX_TO_PATH . 'includes/partials/general.php' );
		?>
		<input name="submit" class="button button-primary" type="submit" value="Save Settings" />
	</form>
</div>