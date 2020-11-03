<?php
/*
 * Plugin Name: LSX Banners
 * Plugin URI:  https://lsx.lsdev.biz/extensions/banners/
 * Description: The LSX Banners extension adds advanced banner configuration options to your WordPress site running LSX theme.
 * Version:     1.2.5
 * Author:      LightSpeed
 * Author URI:  https://www.lsdev.biz/
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: lsx-banners
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_BANNERS_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_BANNERS_CORE', __FILE__ );
define( 'LSX_BANNERS_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_BANNERS_VER', '1.2.5' );

if ( ! function_exists( 'cmb_init' ) && is_file( LSX_BANNERS_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php' ) && ! defined( 'LSX_BANNER_DISABLE_CMB' ) ) {
	require LSX_BANNERS_PATH . 'vendor/Custom-Meta-Boxes/custom-meta-boxes.php';
}

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_BANNERS_PATH . 'classes/class-lsx-banners.php' );
$lsx_banners = new LSX_Banners();
