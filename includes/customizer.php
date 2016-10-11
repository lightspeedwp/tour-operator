<?php
/**
 * Template Tags
 *
 * @package   Lsx_Tour_Operators
 * @license   GPL3
 */

if ( ! defined( 'ABSPATH' ) ) return; // Exit if accessed directly

/**
 * Add new selectors in "button" group of colours
 */
function to_customizer_colour_selectors_button( $css, $colors ) {
	$css .= <<<CSS
		/*
		 *
		 * Button - LSX Tour Operators - New selectors
		 *
		 */

		body.home aside.lsx-widget,
		body.archive-tour-operator #safari-brands,
		body.archive-tour-operator #travel-styles,
		body.archive.post-type-archive-destination .countries .regions,
		body.single-tour-operator {
			.slider-container {
				.carousel-control {
					.fa {
						color: {$colors['button_background_color']};
					}
				}

				.carousel-indicators {
					li {
						border-color: {$colors['button_background_color']};

						&.active {
							background-color: {$colors['button_background_color']};
						}
					}
				}
			}
		}
CSS;

	return $css;
}
add_filter( 'to_customizer_colour_selectors_button', 'to_customizer_colour_selectors_button', 10, 2 );

/**
 * Add new selectors in "header" group of colours
 */
function to_customizer_colour_selectors_header( $css, $colors ) {
	$css .= <<<CSS
		/*
		 *
		 * Header - LSX Tour Operators - New selectors
		 *
		 */

		body.archive-tour-operator,
		body.single-tour-operator {
			#main {
				& > section[class$="-navigation"] {
					background-color: {$colors['header_background_color']};
				}
			}
		}
CSS;

	return $css;
}
add_filter( 'to_customizer_colour_selectors_header', 'to_customizer_colour_selectors_header', 10, 2 );

/**
 * Add new selectors in "main meun" group of colours
 */
function to_customizer_colour_selectors_main_menu( $css, $colors ) {
	$css .= <<<CSS
		/*
		 *
		 * Main Menu - LSX Tour Operators - New selectors
		 *
		 */

		body.archive-tour-operator,
		body.single-tour-operator {
			#main {
				& > section[class$="-navigation"] {
					ul {
						li {
							border-right-color: {$colors['main_menu_text_color']};
						}
					}

					a {
						color: {$colors['main_menu_text_color']};
					}
				}
			}
		}
CSS;

	return $css;
}
add_filter( 'to_customizer_colour_selectors_main_menu', 'to_customizer_colour_selectors_main_menu', 10, 2 );

/**
 * Add new selectors in "body" group of colours
 */
function to_customizer_colour_selectors_body( $css, $colors ) {
	$css .= <<<CSS
		/*
		 *
		 * Body - LSX Tour Operators - New selectors
		 *
		 */

		body {
			&.home {
				aside.lsx-widget {
					& > .widget-title,
					& > .section-title {
						a:hover,
						a:focus,
						a:active {
							color: {$colors['body_link_hover_color']};
						}
					}

					.panel {
						& > article {
							h3 {
								a {
									&:hover,
									&:active,
									&:focus {
										color: {$colors['body_link_hover_color']};
									}
								}
							}
						}
					}
				}
			}

			&.archive-tour-operator {
				.panel {
					& > article {
						h3 {
							& + strong {
								color: {$colors['body_text_color']};
							}

							a {
								&:hover,
								&:active,
								&:focus {
									color: {$colors['body_link_hover_color']};
								}
							}
						}

						.entry-content {
							p {
								color: {$colors['body_text_color']};
							}
						}
					}
				}

				#safari-brands,
				#travel-styles {
					& > .widget-title,
					& > .section-title {
						a:hover,
						a:focus,
						a:active {
							color: {$colors['body_link_hover_color']};
						}
					}

					.panel {
						& > article {
							h3 {
								a {
									&:hover,
									&:active,
									&:focus {
										color: {$colors['body_link_hover_color']};
									}
								}
							}
						}
					}
				}
			}

			&.single-tour-operator {
				#tours,
				#regions,
				#accommodation,
				#destinations,
				#activities,
				#activites,
				#related-items,
				#videos {
					.panel {
						& > article {
							h3 {
								a {
									&:hover,
									&:active,
									&:focus {
										color: {$colors['body_link_hover_color']};
									}
								}
							}

							.entry-content {
								p {
									color: {$colors['body_text_color']};
								}
							}
						}
					}
				}
				
				#itinerary {
					.panel {
						.itinerary-inner {
							h3 {
								& + strong {
									color: {$colors['body_text_color']};
								}
							}

							.title {
								a {
									&:hover,
									&:active,
									&:focus {
										color: {$colors['body_link_hover_color']};
									}
								}
							}

							.entry-content {
								p {
									color: {$colors['body_text_color']};
								}
							}
						}
					}
				}
				
				#rooms,
				#chalets,
				#tents,
				#spas,
				#villas {
					.panel {
						& > .unit {
							h3 {
								& + strong {
									color: {$colors['body_text_color']};
								}
							}

							.entry-content {
								p {
									color: {$colors['body_text_color']};
								}
							}
						}
					}
				}
				
				#rooms {
					.panel {
						& > .room {
							.title {
								a {
									&:hover,
									&:active,
									&:focus {
										color: {$colors['body_link_hover_color']};
									}
								}
							}
						}
					}
				}
			}

			&.archive-tour-operator,
			&.single-tour-operator {
				#summary {
					article.hentry {
						.entry-content {
							p,
							ul > li {
								color: {$colors['body_text_color']};
							}

							& + .col-sm-3 {
								.team-member-widget {
									.title {
										a {
											&:hover,
											&:active,
											&:focus {
												color: {$colors['body_link_hover_color']};
											}
										}
									}
								}
							}
						}
					}
				}
			}

			&.home,
			&.archive-tour-operator,
			&.single-tour-operator {
				.info.meta {
					.price,
					.duration {
						color: {$colors['body_text_color']};
					}
				}

				.meta:not(.info) {
					color: {$colors['body_text_color']};
				}
			}
		}
CSS;

	return $css;
}
add_filter( 'to_customizer_colour_selectors_body', 'to_customizer_colour_selectors_body', 10, 2 );
