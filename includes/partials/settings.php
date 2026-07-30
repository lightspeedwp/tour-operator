<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$settings_pages = tour_operator()->legacy->get_post_types(); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<div class="wrap lsx-to-settings">
	<h1><?php echo esc_html__( 'Tour Operator Settings', 'tour-operator' ); ?></h1>
	<form method="post">
		<?php
		require LSX_TO_PATH . 'includes/partials/navigation.php';
		require LSX_TO_PATH . 'includes/partials/general.php';

		foreach ( $settings_pages as $tab_index => $tab ) {
			include LSX_TO_PATH . 'includes/partials/post-type.php';
		}
		?>
		<input name="submit" class="button button-primary" type="submit" value="Save Settings" />
	</form>
</div>