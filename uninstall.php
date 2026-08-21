<?php
/**
 * Uninstall Tour Operator.
 *
 * Runs when the plugin is deleted from the WordPress admin. Removes the plugin's
 * persisted (and autoloaded) options so nothing is orphaned in the database.
 *
 * @package tour-operator
 */

// Only run as a genuine WordPress uninstall request.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$lsx_to_options = array(
	'lsx_to_settings',
	'lsx_to_slugs',
);

if ( ! is_multisite() ) {
	foreach ( $lsx_to_options as $lsx_to_option ) {
		delete_option( $lsx_to_option );
	}
} else {
	$lsx_to_site_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	);

	foreach ( $lsx_to_site_ids as $lsx_to_site_id ) {
		switch_to_blog( $lsx_to_site_id );

		foreach ( $lsx_to_options as $lsx_to_option ) {
			delete_option( $lsx_to_option );
		}

		restore_current_blog();
	}
}
