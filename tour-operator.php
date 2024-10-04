<?php
/*
 * Plugin Name: LSX Tour Operator
 * Plugin URI: https://www.lsdev.biz/product/tour-operator-plugin/
 * Description: The LSX Tour Operator plugin core contains the Accommodation, Destination and Tour post types. Use these core post types to build day-by-day tour itineraries that map out of the progress of each tour through the various accommodations and destinations that are stayed at along the way.
 * Tags: tour operator, tour operators, tour, tours, tour itinerary, tour itineraries, accommodation, accommodation listings, destinations, regions, tourism, lsx
 * Author: LightSpeed
 * Version: 2.0.0
 * Author URI: https://www.lsdev.biz/
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: tour-operator
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_TO_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_TO_CORE', __FILE__ );
define( 'LSX_TO_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_TO_VER', '2.0.0' );

// Post Expirator.
define( 'LSX_TO_POSTEXPIRATOR_DATEFORMAT', esc_html__( 'l F jS, Y', 'tour-operator' ) );
define( 'LSX_TO_POSTEXPIRATOR_TIMEFORMAT', esc_html__( 'g:ia', 'tour-operator' ) );

// Include bootstrapper and start plugin.
require_once LSX_TO_PATH . 'tour-operator-bootstrap.php';

/**
 * Block Initializer.
 */
require_once LSX_TO_PATH . 'src/init.php';

add_action( 'init', 'to_register_tour_type' );

function to_register_tour_type() {
    register_post_type( 'tours', [
        'public'             => true,
		'show_ui'            => true,
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'has_archive'        => 'tours',
        'menu_icon'          => 'dashicons-palmtree',
        'supports'           => [ 'editor', 'excerpt', 'title', 'thumbnail' ],
        'labels'             => [
            'name'          => __( 'Tours',        'tour-operator' ),
            'singular_name' => __( 'Tour',         'tour-operator' ),
            'add_new'       => __( 'Add New Tour', 'tour-operator' )
        ]
    ] );
}

function to_register_accommodation_type() {
    register_post_type( 'accommodations', [
        'public'             => true,
		'show_ui'            => true,
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'has_archive'        => 'accommodations',
        'menu_icon'          => 'dashicons-building',
        'supports'           => [ 'editor', 'excerpt', 'title', 'thumbnail' ],
        'labels'             => [
            'name'          => __( 'Accommodations',        'tour-operator' ),
            'singular_name' => __( 'Accommodation',         'tour-operator' ),
            'add_new'       => __( 'Add New Accommodation', 'tour-operator' )
        ]
    ] );
}