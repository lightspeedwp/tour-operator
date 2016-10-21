<?php
/*
 * Plugin Name: Tour Operators 
 * Plugin URI: https://www.lsdev.biz/product/tour-operator-plugin/
 * Description: By integrating with the Wetu Tour Operator system, the Tour Operator plugin brings dynamic features like live availability and bookings, digital itineraries and more to your WordPress website.
 * Author: LightSpeed
 * Version: 1.0.0
 * Author URI: https://www.lsdev.biz/products/
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: tour-operator
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('TO_PATH',  plugin_dir_path( __FILE__ ) );
define('TO_CORE',  __FILE__ );
define('TO_URL',  plugin_dir_url( __FILE__ ) );
define('TO_VER',  '1.1.0' );

if(!defined('TEAM_ARCHIVE_URL')){
	define('TEAM_ARCHIVE_URL',  'team-members' );
}

require_once( TO_PATH . 'module.php' );