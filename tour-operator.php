<?php
/*
 * Plugin Name: LSX Tour Operators 
 * Plugin URI: https://www.lsdev.biz/product/lsx-tour-operators-plugin/
 * Description: By integrating with the Wetu Tour Operator system, the LSX Tourism Operators plugin brings dynamic features like live availability and bookings, digital itineraries and more to your WordPress website.
 * Author: LightSpeed
 * Version: 1.0.0
 * Author URI: https://www.lsdev.biz/products/
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: lsx-tour-operators
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('LSX_TOUR_OPERATORS_PATH',  plugin_dir_path( __FILE__ ) );
define('LSX_TOUR_OPERATORS_CORE',  __FILE__ );
define('LSX_TOUR_OPERATORS_URL',  plugin_dir_url( __FILE__ ) );
define('LSX_TOUR_OPERATORS_VER',  '1.1.0' );

if(!defined('TEAM_ARCHIVE_URL')){
	define('TEAM_ARCHIVE_URL',  'team-members' );
}

require_once( LSX_TOUR_OPERATORS_PATH . 'module.php' );