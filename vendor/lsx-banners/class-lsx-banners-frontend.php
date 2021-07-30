<?php
/**
 * LSX Banners Frontend Class
 *
 * @package   LSX Banners
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2019 LightSpeed
 */
class TO_Banners_Frontend extends TO_Banners {

	/**
	 * This holds the class OBJ of TO_Template_Redirects
	 */
	public $redirects = false;

	/**
	 * @var boolean
	 */
	public $banner_disabled;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct() {
		$this->options = get_option( '_lsx_settings', false );
		if ( false === $this->options ) {
			$this->options = get_option( '_lsx_lsx-settings', false );
		}
		$lsx_to_options = get_option( '_lsx-to_settings', false );
		if ( ! empty( $lsx_to_options ) ) {
			$this->options = $lsx_to_options;
		}
		$this->set_vars();
		add_action( 'wp_head', array( $this, 'init' ), 15 );
		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylescripts' ), 5 );
		} else {
			add_filter( 'lsx_customizer_colour_selectors_banner', array( $this, 'customizer_colours_handler' ), 15, 2 );
		}
		add_filter( 'lsx_fonts_css', array( $this, 'customizer_fonts_handler' ), 15 );
		add_shortcode( 'banner_navigation', 'to_banner_navigation' );
		add_filter( 'wp_kses_allowed_html', array( $this, 'wp_kses_allowed_html' ), 10, 2 );
		add_action( 'wp_footer', array( $this, 'add_form_modal' ) );
	}

	/**
	 * Enques the assets
	 */
	public function enqueue_stylescripts() {
		wp_enqueue_script( 'lsx-banners', TO_BANNERS_URL . 'assets/js/lsx-banners.min.js', array( 'jquery' ), TO_BANNERS_VER, true );

		$params = apply_filters(
			'lsx_banners_js_params',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);

		wp_localize_script( 'lsx-banners', 'lsx_banners_params', $params );

		wp_enqueue_style( 'lsx-banners', TO_BANNERS_URL . 'assets/css/lsx-banners.css', array(), TO_BANNERS_VER );
		wp_style_add_data( 'lsx-banners', 'rtl', 'replace' );
	}

	/**
	 * Initializes the variables we need.
	 */
	public function init() {
		$allowed_post_types = $this->get_allowed_post_types();
		$allowed_taxonomies = $this->get_allowed_taxonomies();
		$post_type          = get_post_type();

		$this->post_id = get_queried_object_id();
		$this->banner_plugin_disabled = apply_filters( 'lsx_banner_plugin_disable', false );
		$this->banner_disabled = apply_filters( 'lsx_banner_disable', false );

		if ( empty( $this->banner_disabled ) ) {
			$this->banner_disabled = get_post_meta( $this->post_id, 'banner_disabled', true );
		}

		if ( function_exists( 'lsx_is_rest_api_request' ) && lsx_is_rest_api_request() ) {
			return;
		}

		if ( ! empty( $this->banner_plugin_disabled ) ) {
			// Plugin disable, skip any other test.
			return;
		} elseif ( ! empty( $this->options['display']['banners_disabled'] ) || ! empty( $this->banner_disabled ) ) {
			if ( function_exists( 'lsx_setup' ) ) {
				// remove_action( 'lsx_header_after', 'lsx_page_banner' );
				add_filter( 'lsx_page_banner_disable', '__return_true' );
				add_filter( 'lsx_global_header_disable', '__return_true' );
			}
		} elseif ( is_singular( $allowed_post_types ) || is_post_type_archive( $allowed_post_types ) || is_tax( $allowed_taxonomies ) || is_category() || is_author() || is_404() || is_front_page() || is_home() ) {
			if ( function_exists( 'lsx_setup' ) ) {
				$this->theme = 'lsx';
				// remove_action( 'lsx_header_after', 'lsx_page_banner' );
				$img_group = get_post_meta( $this->post_id, 'image_group', true );
				if ( false === $img_group ) {
					$img_group = array();
				}
				if ( ! is_array( $img_group ) ) {
					$img_group = array( $img_group );
				}
				$img_group = array_filter( $img_group );
				if ( ( is_single( $allowed_post_types ) ) || ( is_singular( 'post' ) ) ) {
					if ( ! empty( $img_group ) ) {
						add_filter( 'lsx_page_banner_disable', '__return_true' );
						add_action( 'lsx_header_after', array( $this, 'banner' ) );
					}
				} else {
					add_filter( 'lsx_page_banner_disable', '__return_true' );
					add_action( 'lsx_header_after', array( $this, 'banner' ) );
				}
			} elseif ( class_exists( 'Storefront' ) ) {
				$this->theme = 'storefront';
				add_action( 'storefront_before_content', array( $this, 'banner' ) );
			} else {
				$this->theme = 'other';
			}

			add_action( 'lsx_banner_container_top', array( $this, 'banner_part_logo' ), 25 );

			add_filter( 'lsx_banner_title', array( $this, 'banner_part_title' ), 20 );

			add_filter( 'lsx_banner_meta_boxes', array( $this, 'subtitle_metabox' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );

			add_action( 'lsx_banner_content', array( $this, 'banner_part_tagline' ), 20 );
			add_action( 'lsx_banner_content', array( $this, 'banner_part_button' ), 25 );
			add_action( 'lsx_banner_content', array( $this, 'banner_post_content' ), 30 );

			$this->placeholder = apply_filters( 'lsx_banner_enable_placeholder', true );

			if ( ! empty( $this->placeholder ) ) {
				add_filter( 'lsx_banner_placeholder_url', array( $this, 'default_placeholder' ) );
			}
		}
	}

	/**
	 * Outputs the Banner HTML
	 */
	public function banner() {
		$post_id = $this->post_id;
		$full_height = false;
		$slider = false;
		$height = '';
		$x_position = 'center';
		$y_position = 'center';
		$show_slider = false;
		$img_group = false;
		$banner_size = 'full';
		$title = get_the_title( $post_id );

		$bg_color = get_post_meta( $post_id, 'banner_bg_color', true );
		$text_color = get_post_meta( $post_id, 'banner_text_color', true );
		$mask = get_post_meta( $post_id, 'banner_mask', true );

		/*
		 * This section gets the image meta, size etc.
		 */
		$image_bg_group = get_post_meta( $post_id, 'image_bg_group', true );
		$image_bg_group = apply_filters( 'lsx_banner_bg_group', $image_bg_group, $post_id );

		if ( ! empty( $image_bg_group ) && is_array( $image_bg_group ) ) {
			if ( isset( $image_bg_group['banner_full_height'] ) ) {
				$full_height = $image_bg_group['banner_full_height'];
			}

			if ( isset( $image_bg_group['banner_slider'] ) ) {
				$slider = $image_bg_group['banner_slider'];
			}

			if ( empty( $full_height ) && isset( $image_bg_group['banner_height'] ) && ! empty( $image_bg_group['banner_height'] ) ) {
				$height = $image_bg_group['banner_height'];
			}

			if ( isset( $image_bg_group['banner_x'] ) && ! empty( $image_bg_group['banner_x'] ) ) {
				$x_position = $image_bg_group['banner_x'];
			}

			if ( isset( $image_bg_group['banner_y'] ) && ! empty( $image_bg_group['banner_y'] ) ) {
				$y_position = $image_bg_group['banner_y'];
			}

			if ( isset( $image_bg_group['banner_size'] ) && ! empty( $image_bg_group['banner_size'] ) ) {
				$banner_size = $image_bg_group['banner_size'];
			}
		}

		$banner_image = false;

		// We change the id to the page with a matching slug ar the post_type archive.
		// Singular Banners.
		if ( is_front_page() || is_home() || is_singular( $this->get_allowed_post_types() ) || in_array( 'blog', get_body_class(), true ) ) {
			$img_group = get_post_meta( $this->post_id, 'image_group', true );
			$img_group = apply_filters( 'lsx_banner_image_group', $img_group, $this->post_id );
			$show_slider = false;

			if ( ! empty( $img_group ) && is_array( $img_group ) && ! empty( $img_group['banner_image'] ) ) {

				if ( ! is_array( $img_group['banner_image'] ) ) {
					$banner_image_id = $img_group['banner_image'];
				} else {
					if ( empty( $slider ) ) {
						$banners_length = count( $img_group['banner_image'] );
						$banner_ids = array_values( $img_group['banner_image'] );

						if ( $banners_length > 1 ) {
							$banner_index = rand( '0', $banners_length - 1 );
							$banner_image_id = $banner_ids[ $banner_index ];
						} else {
							$banner_image_id = $banner_ids[0];
						}
					} else {
						$show_slider = true;
					}
				}

				if ( ! empty( $banner_image_id ) ) {
					$banner_image = wp_get_attachment_image_src( $banner_image_id, $banner_size );

					if ( ! empty( $banner_image ) ) {
						$banner_image = $banner_image[0];
					} else {
						$banner_image = false;
					}
				}
			}

			// If its the LSX theme, and there is no banner, but there is a featured image, then use that for the banner.
			if ( 'lsx' === $this->theme && empty( $bg_color ) && is_singular( array( 'post', 'page' ) ) && false === $banner_image && false === $show_slider && has_post_thumbnail( $this->post_id ) ) {
				$banner_image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->post_id ), $banner_size );

				if ( ! empty( $banner_image ) ) {
					$banner_image = $banner_image[0];
				} else {
					$banner_image = false;
				}
			}

			// Default to the post archive banner.
			if ( false === $banner_image ) {
				$post_type = get_query_var( 'post_type' );
				if ( isset( $this->options[ $post_type ] ) && ! empty( $this->options[ $post_type ]['banner'] ) && '' !== $this->options[ $post_type ]['banner'] ) {
					$banner_image = $this->options[ $post_type ]['banner'];
				}
			}
		}

		if ( is_post_type_archive( $this->get_allowed_post_types() ) ) {
			$archive_banner = apply_filters( 'lsx_banner_post_type_archive_url', false );

			if ( ! empty( $archive_banner ) ) {
				$banner_image = $archive_banner;
			}

			$post_type = get_query_var( 'post_type' );
			if ( isset( $this->options[ $post_type ] ) && ! empty( $this->options[ $post_type ]['banner'] ) ) {
				$banner_image = $this->options[ $post_type ]['banner'];
			}

			$title = get_the_archive_title();
		}

		// If its a taxonomy, then get the image from out term meta.
		if ( ( is_category() || is_tax( $this->get_allowed_taxonomies() ) ) && ! empty( $this->banner_id ) ) {
			$banner_image = wp_get_attachment_image_src( $this->banner_id, $banner_size );

			if ( ! empty( $banner_image ) ) {
				$banner_image = $banner_image[0];
			} else {
				$banner_image = false;
			}
		} elseif ( is_tax( $this->get_allowed_taxonomies() ) || is_category() ) {
			$tax_banner = apply_filters( 'lsx_banner_post_type_archive_url', false );

			if ( empty( $tax_banner ) ) {
				$banner_image = $tax_banner;
			}
		}

		// If its a author archive, then get the image from out user meta.
		if ( is_author() && ! empty( $this->banner_id ) ) {
			$banner_image = wp_get_attachment_image_src( $this->banner_id, $banner_size );

			if ( ! empty( $banner_image ) ) {
				$banner_image = $banner_image[0];
			} else {
				$banner_image = false;
			}
		} elseif ( is_author() ) {
			$tax_banner = apply_filters( 'lsx_banner_post_type_archive_url', false );

			if ( ! empty( $tax_banner ) ) {
				$banner_image = $tax_banner;
			}
		}

		// If we have enabled the placeholders, then force a placeholdit url.
		if ( true === $this->placeholder && empty( $banner_image ) && ! is_404() && empty( $bg_color ) ) {
			$banner_image = apply_filters( 'lsx_banner_placeholder_url', 'https://place-hold.it/1920x600/aaa/969696.jpeg&text=1920x600&bold&fontsize=33' );
		}

		$banner_image = apply_filters( 'lsx_banner_image', $banner_image );

		// Check if the content should be disabled or not.
		$title_disable = get_post_meta( $post_id, 'banner_title_disabled', true );
		$text_disable  = get_post_meta( $post_id, 'banner_text_disabled', true );

		// Embed video.
		$embed_video = get_post_meta( $this->post_id, 'banner_video', true );

		if ( ! empty( $embed_video ) ) {
			$embed_video = wp_get_attachment_url( $embed_video );
			$embed_video = '<video src="' . $embed_video . '" ' . ( ! empty( $banner_image ) ? ( 'poster="' . $banner_image . '"' ) : '' ) . ' width="auto" height="auto" autoplay loop preload muted>' . ( ! empty( $banner_image ) ? ( '<img class="disable-lazyload" src="' . $banner_image . '">' ) : '' ) . '</video>';
		}

		// Envira Gallery.
		$envira_gallery_id = get_post_meta( $this->post_id, 'envira_gallery', true );

		if ( class_exists( 'Envira_Gallery' ) && apply_filters( 'lsx_banners_envira_enable', true ) ) {
			if ( ! empty( $envira_gallery_id ) ) {
				$envira_gallery = Envira_Gallery::get_instance();
				$envira_gallery_images = $envira_gallery->get_gallery( $envira_gallery_id );

				if ( 'lsx' === $this->theme && is_array( $envira_gallery_images ) && count( $envira_gallery_images ) > 1 && apply_filters( 'lsx_banner_enable_sliders', true ) ) {
					$img_group = array(
						'banner_image' => array(),
					);

					$show_slider = true;

					foreach ( $envira_gallery_images['gallery'] as $key => $value ) {
						$img_group['banner_image'][] = array(
							'image_id' => $key,
							'image_title' => $value['title'],
							'image_text' => $value['caption'],
						);
					}
				}
			}
		} else {
			$envira_gallery_id = false;
		}

		// Soliloquy Slider.
		$soliloquy_slider_id = false;

		// This is where the title postition is determined.
		$title_position = get_post_meta( $this->post_id, 'title_position', true );
		if ( false === $title_position || '' === $title_position ) {
			$title_position = 'centered';
		}

		// Cart and Checkout won't have banners of any kind.
		if ( function_exists( 'is_woocommerce' ) && ( is_checkout() || is_cart() ) ) {
			return;
		}

		if ( ! empty( $show_slider ) || ! empty( $banner_image ) || ! empty( $embed_video ) || ! empty( $bg_color ) ) {
			add_filter( 'lsx_global_header_disable', '__return_true' );
			?>
			<div id="lsx-banner">
				<?php
					do_action( 'lsx_banner_top' );

					$style_attr = '';

				if ( ! empty( $height ) ) {
					$style_attr .= 'min-height: ' . esc_attr( $height ) . ';';
				}

				if ( ! empty( $bg_color ) ) {
					$style_attr .= 'background-color: ' . esc_attr( $bg_color ) . ';';
				}

				if ( ! empty( $text_color ) ) {
					$style_attr .= 'color: ' . esc_attr( $text_color ) . ';';
				}

					$class_attr = 'page-banner-wrap';

				if ( ! empty( $mask ) ) {
					$class_attr .= ' page-banner-no-mask';
				}

				if ( empty( $show_slider ) ) {
					?>
						<div class="<?php echo esc_attr( $class_attr ); ?>">
							<div class="page-banner rotating" style="<?php echo esc_attr( $style_attr ); ?>">

							<?php
							if ( function_exists( 'lsx_banner_inner_top' ) ) {
								lsx_banner_inner_top();
							};
							?>

								<?php if ( ! empty( $banner_image ) ) : ?>
									<div class="page-banner-image" style="background-position: <?php echo esc_attr( $x_position ); ?> <?php echo esc_attr( $y_position ); ?>; background-image:url(<?php echo esc_attr( $banner_image ); ?>);"></div>
								<?php endif; ?>

								<?php if ( ! empty( $embed_video ) ) : ?>
									<div class="video-background">
										<div class="video-foreground">
											<?php echo wp_kses_post( $embed_video ); ?>
										</div>
									</div>
								<?php endif; ?>

								<div class="container">
								<?php do_action( 'lsx_banner_container_top' ); ?>

								<?php if ( empty( $title_disable ) ) : ?>
										<?php $title = apply_filters( 'lsx_banner_title', '<h1 class="page-title">' . $title . '</h1>' ); ?>

										<?php if ( ! empty( $title ) ) : ?>
											<header class="page-header">
												<?php echo wp_kses_post( $title ); ?>
											</header>
										<?php endif; ?>
									<?php endif; ?>

								<?php if ( empty( $text_disable ) && ! empty( $this->banner_content() ) ) : ?>
										<div class="banner-content"><?php echo wp_kses_post( force_balance_tags( $this->banner_content() ) ); ?></div>
									<?php endif; ?>

								<?php do_action( 'lsx_banner_container_bottom' ); ?>
								</div>

								<?php
								if ( function_exists( 'lsx_banner_inner_bottom' ) ) {
									lsx_banner_inner_bottom();
								};
								?>
							</div>
						</div>
						<?php
				} else {
					?>
						<div id="page-banner-slider">
						<?php
						foreach ( $img_group['banner_image'] as $key => $value ) {
							if ( is_array( $value ) ) {
								$slide   = wp_get_attachment_image_src( $value['image_id'], $banner_size );
								$title   = $value['image_title'];
								$content = $value['image_text'];
							} else {
								$slide   = wp_get_attachment_image_src( $value, $banner_size );
								$title   = get_the_title( $post_id );
								$content = $this->banner_content();
							}
							?>
									<div class="page-banner-slide">
										<div class="<?php echo esc_attr( $class_attr ); ?>">
											<div class="page-banner rotating" style="<?php echo esc_attr( $style_attr ); ?>">
												<div class="page-banner-image" style="background-position: <?php echo esc_attr( $x_position ); ?> <?php echo esc_attr( $y_position ); ?>; background-image:url(<?php echo esc_attr( $slide[0] ); ?>);"></div>

												<div class="container">
											<?php do_action( 'lsx_banner_container_top' ); ?>

											<?php if ( empty( $title_disable ) ) : ?>
														<?php $title = apply_filters( 'lsx_banner_title', '<h1 class="page-title">' . $title . '</h1>' ); ?>

														<?php if ( ! empty( $title ) ) : ?>
															<header class="page-header">
																<?php echo wp_kses_post( $title ); ?>
															</header>
														<?php endif; ?>
													<?php endif; ?>

											<?php if ( empty( $text_disable ) && ! empty( $content ) ) : ?>
														<div class="banner-content"><?php echo wp_kses_post( force_balance_tags( $content ) ); ?></div>
													<?php endif; ?>

											<?php do_action( 'lsx_banner_container_bottom' ); ?>
												</div>
											</div>
										</div>
									</div>
								<?php
						}
						?>
						</div>
						<?php
				}

					do_action( 'lsx_banner_bottom' );
				?>
			</div>
			<?php
		}
	}

	/**
	 * Add <body> classes
	 */
	public function body_class( $classes ) {
		$banner_image = false;

		if ( 0 !== get_the_ID() || is_front_page() || is_home() ) {
			$post_id = $this->post_id;

			if ( is_home() ) {
				$post_id = get_option( 'page_for_posts' );
			}

			$img_group = get_post_meta( $post_id, 'image_group', true );

			if ( ! empty( $img_group ) && is_array( $img_group ) && ! empty( $img_group['banner_image'] ) ) {
				$classes[] = 'page-has-banner';
				$this->has_banner = true;
			}
		}

		if ( is_author() ) {
			$term_banner_id = get_user_meta( $this->post_id, 'banner', true );

			if ( ! empty( $term_banner_id ) ) {
				$classes[] = 'page-has-banner';
				$this->has_banner = true;
				$this->banner_id = $term_banner_id;
			}
		}

		if ( is_category() || is_tax( $this->get_allowed_taxonomies() ) ) {
			$term_banner_id = get_term_meta( $this->post_id, 'banner', true );

			if ( ! empty( $term_banner_id ) ) {
				$classes[] = 'page-has-banner';
				$this->has_banner = true;
				$this->banner_id = $term_banner_id;
			}
		}

		if ( true === $this->placeholder && ! is_404() ) {
			$classes[] = 'page-has-banner';
			$this->has_banner = true;
		}

		if ( true === $this->has_banner ) {
			if ( ! empty( $this->post_id ) ) {
				$image_bg_group = get_post_meta( $this->post_id, 'image_bg_group', true );

				if ( ! empty( $image_bg_group ) && is_array( $image_bg_group ) ) {
					if ( isset( $image_bg_group['banner_full_height'] ) ) {
						$full_height = $image_bg_group['banner_full_height'];

						if ( ! empty( $full_height ) ) {
							$classes[] = 'page-has-banner-full';
						}
					}
				}
			}
		}
		return $classes;
	}

	/**
	 * Outputs the banner logo.
	 */
	public function banner_part_logo() {
		$logo = get_post_meta( $this->post_id, 'banner_logo', true );

		if ( ! empty( $logo ) ) {
			$logo = wp_get_attachment_image_src( $logo, 'full' );

			if ( ! empty( $logo ) ) {
				$logo = '<img src="' . $logo[0] . '" class="lsx-banners-logo" alt="' . the_title( '', '', false ) . '">';
			} else {
				$logo = false;
			}
		}

		if ( ! empty( $logo ) ) {
			echo wp_kses_post( $logo );
		}
	}

	/**
	 * A filter to check if a custom title has been added, if so, use that instead of the post title.
	 */
	public function banner_part_title( $post_title ) {
		$allowed_post_types = $this->get_allowed_post_types();
		$allowed_taxonomies = $this->get_allowed_taxonomies();

		if ( is_post_type_archive( $allowed_post_types ) && isset( $this->options[ get_post_type() ] ) && isset( $this->options[ get_post_type() ]['title'] ) ) {
			$new_title = $this->options[ get_post_type() ]['title'];

			if ( ! empty( $new_title ) ) {
				$post_title = '<h1 class="page-title">' . $new_title . '</h1>';
			}
		} elseif ( is_post_type_archive( $allowed_post_types ) ) {
			$post_title = '<h1 class="page-title">' . get_the_archive_title() . '</h1>';
		} elseif ( is_tax( $allowed_taxonomies ) || is_category() ) {
			$post_title = '<h1 class="page-title">' . single_term_title( '', false ) . '</h1>';
		} elseif ( is_author() ) {
			$post_title = '<h1 class="page-title">' . get_the_archive_title() . '</h1>';
		} elseif ( apply_filters( 'lsx_banner_enable_title', true ) && ! empty( $this->post_id ) ) {
			$new_title = get_post_meta( $this->post_id, 'banner_title', true );

			if ( ! empty( $new_title ) ) {
				$post_title = '<h1 class="page-title">' . $new_title . '</h1>';
			}
		}

		return $post_title;
	}

	/**
	 * Outputs the banner content.
	 */
	public function banner_content() {
		switch ( $this->theme ) {
			case 'lsx':
				ob_start();
				lsx_banner_content();
				$retval = ob_get_clean();
				break;

			default:
				$retval = apply_filters( 'lsx_banner_content', '' );
				break;
		}

		return $retval;
	}

	/**
	 * Outputs the banner tagline.
	 */
	public function banner_part_tagline() {
		$allowed_post_types = $this->get_allowed_post_types();
		$allowed_taxonomies = $this->get_allowed_taxonomies();
		$tagline            = false;

		if ( is_post_type_archive( $allowed_post_types ) && isset( $this->options[ get_post_type() ] ) && isset( $this->options[ get_post_type() ]['tagline'] ) ) {
			$new_tagline = $this->options[ get_post_type() ]['tagline'];

			if ( ! empty( $new_tagline ) ) {
				$tagline = '<p class="tagline">' . $new_tagline . '</p>';
			}
		} elseif ( is_tax( $allowed_taxonomies ) || is_category() ) {
			$new_tagline = get_term_meta( $this->post_id, 'tagline', true );

			if ( ! empty( $new_tagline ) ) {
				$tagline = '<p class="tagline">' . $new_tagline . '</p>';
			}
		} elseif ( apply_filters( 'lsx_banner_enable_subtitle', true ) && ! empty( $this->post_id ) ) {
			$new_tagline = get_post_meta( $this->post_id, 'banner_subtitle', true );

			if ( ! empty( $new_tagline ) ) {
				$tagline = '<p class="tagline">' . $new_tagline . '</p>';
			}
		}

		$tagline = apply_filters( 'lsx_banner_tagline', $tagline );

		if ( ! empty( $tagline ) ) {
			echo wp_kses_post( $tagline );
		}
	}

	/**
	 * Outputs the banner button.
	 */
	public function banner_part_button() {
		$button = '';

		if ( ! empty( $this->post_id ) ) {
			$button_group = get_post_meta( $this->post_id, 'button_group', true );

			if ( ! empty( $button_group ) && is_array( $button_group ) ) {
				$button_text = '';
				$button_link = '';
				$button_class = 'btn';
				$button_type = 'link';

				if ( ! empty( $button_group['button_text'] ) ) {
					$button_text = $button_group['button_text'];
				}

				if ( ! empty( $button_group['button_link'] ) ) {
					$button_link = $button_group['button_link'];
				}

				if ( ! empty( $button_group['button_class'] ) ) {
					$button_class .= ' ' . $button_group['button_class'];
				}

				if ( ! empty( $button_group['button_type'] ) ) {
					$button_type = $button_group['button_type'];
				}

				if ( ! empty( $button_text ) && ! empty( $button_link ) ) {
					$button_attr = '';

					if ( 'anchor' === $button_type ) {
						$button_attr = ' onclick="TO_Banners.doScroll(this); return false;"';
					} elseif ( 'form' === $button_type ) {
						$button_attr = ' data-toggle="modal"';
						$button_link = '#cf-modal-' . $button_link;
					} elseif ( 'wpform' === $button_type ) {
						$button_attr = ' data-toggle="modal"';
						$button_link = '#' . $button_link;
					}

					$button = '<a class="' . $button_class . '" href="' . $button_link . '"' . $button_attr . '>' . $button_text . '</a>';
				}

				if ( ! empty( $button ) ) {
					$button = '<p class="lsx-banners-button">' . $button . '</p>';
				}
			}
		}

		if ( ! empty( $button ) ) {
			echo wp_kses_post( $button );
		}
	}

	/**
	 * Outputs the page/post content.
	 */
	public function banner_post_content() {
		$content = '';

		if ( is_front_page() ) {
			$content = get_post( $this->post_id );
			$content = $content->post_content;

			if ( ! empty( $content ) ) {
				$content = apply_filters( 'the_content', $content );
				$content = '<div class="banner-content-from-post">' . $content . '</div>';
			}
		}

		if ( ! empty( $content ) ) {
			echo wp_kses_post( $content );
		}
	}

	/**
	 * Handle fonts that might be change by LSX Customiser
	 */
	public function customizer_fonts_handler( $css_fonts ) {
		global $wp_filesystem;

		$css_fonts_file = TO_BANNERS_PATH . '/assets/css/lsx-banners-fonts.css';

		if ( file_exists( $css_fonts_file ) ) {
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			if ( $wp_filesystem ) {
				$css_fonts .= $wp_filesystem->get_contents( $css_fonts_file );
			}
		}

		return $css_fonts;
	}

	/**
	 * Handle colours that might be change by LSX Customiser
	 */
	public function customizer_colours_handler( $css, $colors ) {
		$css .= '
			@import "' . TO_BANNERS_PATH . '/assets/css/scss/customizer-banners-banner-colours";

			/**
			 * LSX Customizer - LSX Banners
			 */
			@include customizer-banners-banner-colours (
				$color: ' . $colors['banner_text_image_color'] . '
			);
		';

		return $css;
	}

	/**
	 * Allow extra tags and attributes to wp_kses_post()
	 */
	public function wp_kses_allowed_html( $allowedtags, $context ) {
		if ( ! isset( $allowedtags['a'] ) ) {
			$allowedtags['a'] = array();
		}

		$allowedtags['a']['data-extra-top'] = true;
		$allowedtags['a']['onclick'] = true;

		return $allowedtags;
	}

	/**
	 * Add form modal
	 */
	public function add_form_modal() {
		$button_group = get_post_meta( get_queried_object_id(), 'button_group', true );

		if ( empty( $button_group ) || ! is_array( $button_group ) ) {
			return '';
		}

		if ( 'form' !== $button_group['button_type'] ) {
			if ( 'wpform' !== $button_group['button_type'] ) {
				return '';
			}
		}

		$form_kind = $button_group['button_type'];
		$form_id = $button_group['button_link'];

		if ( 'form' == $form_kind ) {
			$form_id = 'cf-modal-' . $form_id;
		}

		?>
		<div class="lsx-modal modal fade" id="<?php echo esc_attr( $form_id ); ?>" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<div class="modal-header">
						<h4 class="modal-title"><?php echo esc_html( $button_group['button_text'] ); ?></h4>
					</div>

					<div class="modal-body">
						<?php
						if ( 'form' == $form_kind ) {
							$form_id = $button_group['button_link'];
							echo do_shortcode( '[caldera_form id="' . $form_id . '"]' );
						}
						if ( 'wpform' == $form_kind ) {
							echo do_shortcode( '[wpforms id="' . $form_id . '" title="false" description="false"]' );
						}
						?>

					</div>
				</div>
			</div>
		</div>
		<?php
	}

}
