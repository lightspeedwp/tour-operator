<?php
$settings_pages = tour_operator()->legacy->get_post_types();
?>
<h2 class="nav-tab-wrapper">
	<?php
	$current_tab = 'general';
	// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['tab'] ) ) {
		// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$current_tab = sanitize_key( wp_unslash( $_GET['tab'] ) );	
	}

	echo wp_kses_post( '<a class="nav-tab nav-tab-active" href="#ui-general">' . esc_html__( 'General', 'tour-operator' ) . '</a>' );
	foreach ( $settings_pages as $tab_index => $tab ) {
		$class = '';
		if ( $tab_index === $current_tab ) {
			$class = 'nav-tab-active';
		}
		echo wp_kses_post( '<a class="nav-tab ' . $class . '" href="#ui-' . $tab_index . '">' . $tab . '</a>' );
	}
	?>
</h2>
