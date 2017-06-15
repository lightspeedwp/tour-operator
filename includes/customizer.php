<?php
/**
 * Template Tags
 *
 * @package   Tour Operators
 * @license   GPL3
 */

if ( ! defined( 'ABSPATH' ) ) return; // Exit if accessed directly

/**
 * Add new selectors in "button" group of colours
 */
function lsx_to_customizer_colour_selectors_button( $css, $colors ) {
	$css .= <<<CSS
		/*
		 *
		 * Button - LSX Tour Operators - New selectors
		 *
		 */

		body.home aside.lsx-widget,
		body.archive-tour-operator #safari-brands,
		body.archive-tour-operator #travel-styles,
		body.archive.post-type-archive-lsx-to-destination .countries .regions,
		body.single-tour-operator {
			.slider-container {
				.slick-arrow {
					&,
					&:hover {
						color: {$colors['button_background_color']};
					}
				}

				.slick-dots {
					& > li {
						& > button {
							border-color: {$colors['button_background_color']};
						}

						&.slick-active > button {
							background-color: {$colors['button_background_color']};
						}
					}
				}
			}
		}

		body.archive-tour-operator {
			.facetwp-slider-reset {
				&,
				&:visited {
					background-color: {$colors['button_background_color']};
					color: {$colors['button_text_color']};
				}

				&:hover,
				&:focus,
				&:active {
					background-color: {$colors['button_background_hover_color']};
					color: {$colors['button_text_color_hover']};
				}
			}
		}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_button', 'lsx_to_customizer_colour_selectors_button', 10, 2 );

/**
 * Add new selectors in "header" group of colours
 */
function lsx_to_customizer_colour_selectors_header( $css, $colors ) {
	$css .= <<<CSS
		/*
		 *
		 * Header - LSX Tour Operators - New selectors
		 *
		 */

		body.archive-tour-operator,
		body.single-tour-operator {
			#main {
				& > .lsx-to-navigation {
					ul {
						background-color: {$colors['header_background_color']};
					}
				}
			}
		}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_header', 'lsx_to_customizer_colour_selectors_header', 10, 2 );

/**
 * Add new selectors in "main meun" group of colours
 */
function lsx_to_customizer_colour_selectors_main_menu( $css, $colors ) {
	$css .= <<<CSS
		/*
		 *
		 * Main Menu - LSX Tour Operators - New selectors
		 *
		 */

		body.archive-tour-operator,
		body.single-tour-operator {
			#main {
				& > .lsx-to-navigation {
					a {
						&,
						&:active,
						&:visited {
							color: {$colors['main_menu_text_color']};
						}

						&:hover,
						&:hover:active,
						&:focus {
							background-color: {$colors['main_menu_background_hover1_color']};
							color: {$colors['main_menu_text_hover1_color']};
						}
					}

					li.active {
						a {
							background-color: {$colors['main_menu_background_hover1_color']};
							color: {$colors['main_menu_text_hover1_color']};
						}
					}
				}
			}
		}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_main_menu', 'lsx_to_customizer_colour_selectors_main_menu', 10, 2 );

/**
 * Add new selectors in "body" group of colours
 */
function lsx_to_customizer_colour_selectors_body( $css, $colors ) {
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
add_filter( 'lsx_customizer_colour_selectors_body', 'lsx_to_customizer_colour_selectors_body', 10, 2 );
