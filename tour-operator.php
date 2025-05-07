<?php
/*
 * Plugin Name:       Tour Operator
 * Plugin URI:        https://touroperator.solutions/
 * Description:       Showcase tours, destinations, and accommodations with digital itineraries, galleries, and integrated maps.
 * Author:            lightspeedwp
 * Author URI:        https://lightspeedwp.agency/
 * Version:           2.1.0
 * Requires at least: 6.7
 * Tested up to:      6.8
 * Requires PHP:      8.0
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       tour-operator
 * Domain Path:       /languages/
 * Tags:              lsx, tour operator, travel, tourism, itinerary
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_TO_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_TO_CORE', __FILE__ );
define( 'LSX_TO_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_TO_VER', '2.1.0' );

global $CONTENT_MODEL_JSON_PATH;
$CONTENT_MODEL_JSON_PATH[] = LSX_TO_PATH;

// Post Expirator.
define( 'LSX_TO_POSTEXPIRATOR_DATEFORMAT', esc_html__( 'l F jS, Y', 'tour-operator' ) );
define( 'LSX_TO_POSTEXPIRATOR_TIMEFORMAT', esc_html__( 'g:ia', 'tour-operator' ) );

// Include bootstrapper and start plugin.
require_once LSX_TO_PATH . 'tour-operator-bootstrap.php';
