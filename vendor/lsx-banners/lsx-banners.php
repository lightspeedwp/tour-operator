<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_BANNERS_PATH', LSX_TO_PATH . 'vendor/lsx-banners/' );
define( 'LSX_BANNERS_CORE', LSX_TO_PATH . 'vendor/lsx-banners/lsx-banners.php' );
define( 'LSX_BANNERS_URL', LSX_TO_URL . 'vendor/lsx-banners/' );
define( 'LSX_BANNERS_VER', '1.2.5' );

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_BANNERS_PATH . 'class-lsx-banners.php' );
$lsx_banners = new LSX_Banners();
