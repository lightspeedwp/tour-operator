<?php
/**
 * Template Tags
 *
 * @package   Lsx_Tour_Operators
 * @license   GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) return; // Exit if accessed directly

/**
 * Add new selectors in "button" group of colours
 */
function lsx_tour_operators_customizer_colour_selectors_button( $css, $colors ) {
	$css .= <<<CSS
	
	/* Button - LSX Tour Operators - New selectors */

	body.home aside.lsx-widget .slider-container .carousel-control .fa,
	body.archive-tour-operator #safari-brands .slider-container .carousel-control .fa,
	body.archive-tour-operator #travel-styles .slider-container .carousel-control .fa,
	body.archive.post-type-archive-destination .countries .regions .slider-container .carousel-control .fa {
		color: {$colors['button_background_color']};
	}

	body.home aside.lsx-widget .slider-container .carousel-indicators li,
	body.archive-tour-operator #safari-brands .slider-container .carousel-indicators li,
	body.archive-tour-operator #travel-styles .slider-container .carousel-indicators li,
	body.archive.post-type-archive-destination .countries .regions .slider-container .carousel-indicators li {
		border-color: {$colors['button_background_color']};
	}

	body.home aside.lsx-widget .slider-container .carousel-indicators li.active,
	body.archive-tour-operator #safari-brands .slider-container .carousel-indicators li.active,
	body.archive-tour-operator #travel-styles .slider-container .carousel-indicators li.active,
	body.archive.post-type-archive-destination .countries .regions .slider-container .carousel-indicators li.active {
		background-color: {$colors['button_background_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_button', 'lsx_tour_operators_customizer_colour_selectors_button', 10, 2 );

/**
 * Add new selectors in "header" group of colours
 */
function lsx_tour_operators_customizer_colour_selectors_header( $css, $colors ) {
	$css .= <<<CSS
	
	/* Header - LSX Tour Operators - New selectors */

	body.archive-tour-operator #main > section[class$="-navigation"],
	body.single-tour-operator #main > section[class$="-navigation"] {
		background-color: {$colors['header_background_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_header', 'lsx_tour_operators_customizer_colour_selectors_header', 10, 2 );

/**
 * Add new selectors in "main meun" group of colours
 */
function lsx_tour_operators_customizer_colour_selectors_main_menu( $css, $colors ) {
	$css .= <<<CSS
	
	/* Main Menu - LSX Tour Operators - New selectors */

	body.archive-tour-operator #main > section[class$="-navigation"] ul li,
	body.single-tour-operator #main > section[class$="-navigation"] ul li {
		border-right-color: {$colors['main_menu_text_color']};
	}

	body.archive-tour-operator #main > section[class$="-navigation"] a,
	body.single-tour-operator #main > section[class$="-navigation"] a {
		color: {$colors['main_menu_text_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_main_menu', 'lsx_tour_operators_customizer_colour_selectors_main_menu', 10, 2 );

/**
 * Add new selectors in "body" group of colours
 */
function lsx_tour_operators_customizer_colour_selectors_body( $css, $colors ) {
	$css .= <<<CSS
	
	/* Body - LSX Tour Operators - New selectors */

	body.archive-tour-operator .panel > article .entry-content p,
	body.single-tour-operator #tours .panel > article .entry-content p,
	body.single-tour-operator #regions .panel > article .entry-content p,
	body.single-tour-operator #accommodation .panel > article .entry-content p,
	body.single-tour-operator #destinations .panel > article .entry-content p,
	body.single-tour-operator #activities .panel > article .entry-content p,
	body.single-tour-operator #activites .panel > article .entry-content p,
	body.single-tour-operator #related-items .panel > article .entry-content p,
	body.single-tour-operator #videos .panel > article .entry-content p,
	body.single-tour-operator #itinerary .panel .itinerary-inner .entry-content p,
	body.single-tour-operator #rooms .panel > .unit .entry-content p,
	body.single-tour-operator #chalets .panel > .unit .entry-content p,
	body.single-tour-operator #tents .panel > .unit .entry-content p,
	body.single-tour-operator #spas .panel > .unit .entry-content p,
	body.single-tour-operator #villas .panel > .unit .entry-content p {
		color: {$colors['body_text_color']};
	}

	body.home .info.meta .price,
	body.archive-tour-operator .info.meta .price,
	body.single-tour-operator .info.meta .price,
	body.home .info.meta .duration,
	body.archive-tour-operator .info.meta .duration,
	body.single-tour-operator .info.meta .duration,
	body.home .meta:not(.info),
	body.archive-tour-operator .meta:not(.info),
	body.single-tour-operator .meta:not(.info) {
		color: {$colors['body_text_color']};
	}

	body.archive-tour-operator .panel > article h3 + strong,
	body.single-tour-operator #tours .panel > article h3 + strong,
	body.single-tour-operator #regions .panel > article h3 + strong,
	body.single-tour-operator #accommodation .panel > article h3 + strong,
	body.single-tour-operator #destinations .panel > article h3 + strong,
	body.single-tour-operator #activities .panel > article h3 + strong,
	body.single-tour-operator #activites .panel > article h3 + strong,
	body.single-tour-operator #related-items .panel > article h3 + strong,
	body.single-tour-operator #videos .panel > article h3 + strong,
	body.single-tour-operator #itinerary .panel .itinerary-inner h3 + strong,
	body.single-tour-operator #rooms .panel > .unit h3 + strong,
	body.single-tour-operator #chalets .panel > .unit h3 + strong,
	body.single-tour-operator #tents .panel > .unit h3 + strong,
	body.single-tour-operator #spas .panel > .unit h3 + strong,
	body.single-tour-operator #villas .panel > .unit h3 + strong {
		color: {$colors['body_text_color']};
	}

	body.archive-tour-operator #summary article.hentry .entry-content p,
	body.single-tour-operator #summary article.hentry .entry-content p,
	body.archive-tour-operator #summary article.hentry .entry-content ul > li,
	body.single-tour-operator #summary article.hentry .entry-content ul > li {
		color: {$colors['body_text_color']};
	}

	body.home aside.lsx-widget > .widget-title a:hover,
	body.archive-tour-operator #safari-brands > .widget-title a:hover,
	body.archive-tour-operator #travel-styles > .widget-title a:hover,
	body.home aside.lsx-widget > .widget-title a:focus,
	body.archive-tour-operator #safari-brands > .widget-title a:focus,
	body.archive-tour-operator #travel-styles > .widget-title a:focus,
	body.home aside.lsx-widget > .widget-title a:active,
	body.archive-tour-operator #safari-brands > .widget-title a:active,
	body.archive-tour-operator #travel-styles > .widget-title a:active,
	body.home aside.lsx-widget > .section-title a:hover,
	body.archive-tour-operator #safari-brands > .section-title a:hover,
	body.archive-tour-operator #travel-styles > .section-title a:hover,
	body.home aside.lsx-widget > .section-title a:focus,
	body.archive-tour-operator #safari-brands > .section-title a:focus,
	body.archive-tour-operator #travel-styles > .section-title a:focus,
	body.home aside.lsx-widget > .section-title a:active,
	body.archive-tour-operator #safari-brands > .section-title a:active,
	body.archive-tour-operator #travel-styles > .section-title a:active {
		color: {$colors['body_link_hover_color']};
	}

	body.home aside.lsx-widget .panel > article h3 a:hover,
	body.archive-tour-operator #safari-brands .panel > article h3 a:hover,
	body.archive-tour-operator #travel-styles .panel > article h3 a:hover,
	body.archive-tour-operator .panel > article h3 a:hover,
	body.single-tour-operator #tours .panel > article h3 a:hover,
	body.single-tour-operator #regions .panel > article h3 a:hover,
	body.single-tour-operator #accommodation .panel > article h3 a:hover,
	body.single-tour-operator #destinations .panel > article h3 a:hover,
	body.single-tour-operator #activities .panel > article h3 a:hover,
	body.single-tour-operator #activites .panel > article h3 a:hover,
	body.single-tour-operator #related-items .panel > article h3 a:hover,
	body.single-tour-operator #videos .panel > article h3 a:hover,
	body.single-tour-operator #itinerary .panel .itinerary-inner .title a:hover,
	body.single-tour-operator #rooms .panel > .room .title a:hover,
	body.archive-tour-operator #summary article.hentry .entry-content + .col-sm-3 .team-member-widget .title a:hover,
	body.single-tour-operator #summary article.hentry .entry-content + .col-sm-3 .team-member-widget .title a:hover,
	body.home aside.lsx-widget .panel > article h3 a:active,
	body.archive-tour-operator #safari-brands .panel > article h3 a:active,
	body.archive-tour-operator #travel-styles .panel > article h3 a:active,
	body.archive-tour-operator .panel > article h3 a:active,
	body.single-tour-operator #tours .panel > article h3 a:active,
	body.single-tour-operator #regions .panel > article h3 a:active,
	body.single-tour-operator #accommodation .panel > article h3 a:active,
	body.single-tour-operator #destinations .panel > article h3 a:active,
	body.single-tour-operator #activities .panel > article h3 a:active,
	body.single-tour-operator #activites .panel > article h3 a:active,
	body.single-tour-operator #related-items .panel > article h3 a:active,
	body.single-tour-operator #videos .panel > article h3 a:active,
	body.single-tour-operator #itinerary .panel .itinerary-inner .title a:active,
	body.single-tour-operator #rooms .panel > .room .title a:active,
	body.archive-tour-operator #summary article.hentry .entry-content + .col-sm-3 .team-member-widget .title a:active,
	body.single-tour-operator #summary article.hentry .entry-content + .col-sm-3 .team-member-widget .title a:active,
	body.home aside.lsx-widget .panel > article h3 a:focus,
	body.archive-tour-operator #safari-brands .panel > article h3 a:focus,
	body.archive-tour-operator #travel-styles .panel > article h3 a:focus,
	body.archive-tour-operator .panel > article h3 a:focus,
	body.single-tour-operator #tours .panel > article h3 a:focus,
	body.single-tour-operator #regions .panel > article h3 a:focus,
	body.single-tour-operator #accommodation .panel > article h3 a:focus,
	body.single-tour-operator #destinations .panel > article h3 a:focus,
	body.single-tour-operator #activities .panel > article h3 a:focus,
	body.single-tour-operator #activites .panel > article h3 a:focus,
	body.single-tour-operator #related-items .panel > article h3 a:focus,
	body.single-tour-operator #videos .panel > article h3 a:focus,
	body.single-tour-operator #itinerary .panel .itinerary-inner .title a:focus,
	body.single-tour-operator #rooms .panel > .room .title a:focus,
	body.archive-tour-operator #summary article.hentry .entry-content + .col-sm-3 .team-member-widget .title a:focus,
	body.single-tour-operator #summary article.hentry .entry-content + .col-sm-3 .team-member-widget .title a:focus {
		color: {$colors['body_link_hover_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_body', 'lsx_tour_operators_customizer_colour_selectors_body', 10, 2 );

?>