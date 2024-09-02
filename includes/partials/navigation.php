<?php
$settings_pages = tour_operator()->settings->settings_page_array();
?>
<h2 class="nav-tab-wrapper">
	<?php
	$current_tab = 'general';
	if ( isset( $_GET['tab'] ) ) {
		$current_tab = sanitize_key( $_GET['tab'] );	
	}
	foreach ( $settings_pages['settings']['tabs'] as $tab_index => $tab ) {
		$class = '';
		if ( $tab_index === $current_tab ) {
			$class = 'nav-tab-active';
		}
		echo wp_kses_post( '<a class="nav-tab ' . $class . '" href="#ui-' . $tab_index . '">' . $tab['menu_title'] . '</a>' );
	}
	?>
</h2>
