<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_BANNERS_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_BANNERS_CORE', __FILE__ );
define( 'LSX_BANNERS_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_BANNERS_VER', '1.2.5' );

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_BANNERS_PATH . 'class-lsx-banners.php' );
$lsx_banners = new LSX_Banners();
