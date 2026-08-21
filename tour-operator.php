<?php

/**
 * Plugin Name:       Tour Operator
 * Plugin URI:        https://touroperator.solutions/
 * Description:       Showcase tours, destinations, and accommodations with digital itineraries, galleries, and integrated maps.
 * Author:            lightspeedwp
 * Author URI:        https://lightspeedwp.agency/
 * Version:           2.2
 * Requires at least: 6.7
 * Tested up to:      7.1
 * Requires PHP:      8.0
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       tour-operator
 * Domain Path:       /languages/
 * Tags:              lsx, tour operator, travel, tourism, itinerary
 *
 * @package tour-operator
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

define('LSX_TO_PATH', plugin_dir_path(__FILE__));
define('LSX_TO_CORE', __FILE__);
define('LSX_TO_URL', plugin_dir_url(__FILE__));
define('LSX_TO_VER', '2.2.0');

// Maintain a list of content model JSON paths consumed by the plugin.
// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
global $CONTENT_MODEL_JSON_PATH;
$CONTENT_MODEL_JSON_PATH[] = LSX_TO_PATH;
// phpcs:enable WordPress.WP.GlobalVariablesOverride.Prohibited

// Post Expirator.
define('LSX_TO_POSTEXPIRATOR_DATEFORMAT', esc_html__('l F jS, Y', 'tour-operator'));
define('LSX_TO_POSTEXPIRATOR_TIMEFORMAT', esc_html__('g:ia', 'tour-operator'));

// Define asset debug mode based on SCRIPT_DEBUG constant.
if (! defined('DEBUG_SCRIPTS')) {
	define('LSX_TO_ASSET_DEBUG', '.min');
} else {
	define('LSX_TO_ASSET_DEBUG', '');
}

// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
// Plugin dependencies.
require_once LSX_TO_PATH . 'plugins/content-models/create-content-model.php';
require_once LSX_TO_PATH . 'plugins/cmb2/init.php';
require_once LSX_TO_PATH . 'plugins/cmb2-field-map/cmb-field-map.php';
require_once LSX_TO_PATH . 'plugins/cmb-field-select2/cmb-field-select2.php';
// phpcs:enable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

// Template Tags.
require_once LSX_TO_PATH . 'includes/template-tags/general.php';
require_once LSX_TO_PATH . 'includes/template-tags/helpers.php';
require_once LSX_TO_PATH . 'includes/template-tags/maps.php';

// Include context helper & autoloader.
require_once LSX_TO_PATH . 'includes/tour-operator.php';
// Include functions.
require_once LSX_TO_PATH . 'includes/functions.php';

// Register tour operator autoloader.
spl_autoload_register('tour_operator_autoload_class', true, false);

// Init legacy.
\lsx\legacy\Tour_Operator::get_instance();

// Init Plugin.
tour_operator();

/**
 * Include sticky menu block filters. This adds mobile section headers to group blocks.
 */
require_once LSX_TO_PATH . 'build/blocks/sticky-menu/filters.php';
