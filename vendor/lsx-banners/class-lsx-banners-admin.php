<?php
/**
 * LSX Banners Admin Class
 *
 * @package   LSX Banners
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2019 LightSpeed
 */
class TO_Banners_Admin extends TO_Banners {

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

		$this->set_vars();

		if ( ! wp_doing_ajax() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}
		add_filter( 'cmb_meta_boxes', array( $this, 'metaboxes' ) );
		add_filter( 'lsx_taxonomy_admin_taxonomies', array( $this, 'add_taxonomies' ), 10, 1 );

		add_action( 'init', array( $this, 'create_settings_page' ), 200 );
		add_filter( 'lsx_framework_settings_tabs', array( $this, 'register_tabs' ), 200, 1 );

		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
	}

	/**
	 * Initializes the variables we need.
	 **/
	public function admin_init() {
		$this->taxonomy_admin = new TO_Taxonomy_Admin();
		$allowed_taxonomies = $this->get_allowed_taxonomies();
		if ( is_array( $allowed_taxonomies ) ) {
			foreach ( $allowed_taxonomies as $taxonomy ) {
				// add_action( "{$taxonomy}_add_form_fields",  array( $this, 'add_form_field'  ),1 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_form_field' ), 5, 1 );
			}
		}
		add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
		add_action( 'edit_term', array( $this, 'save_meta' ), 10, 2 );
	}

	/**
	 * Enques the assets
	 */
	public function assets() {
		wp_enqueue_style( 'lsx-banners-admin', TO_BANNERS_URL . 'assets/css/lsx-banners-admin.css', array(), TO_BANNERS_VER );
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function add_taxonomies( $taxonomies ) {
		if ( function_exists( 'get_allowed_taxonomies' ) ) {
			$allowed_taxonomies = $this->get_allowed_taxonomies();

			if ( false !== $taxonomies && is_array( $taxonomies ) ) {
				$taxonomies = array_merge( $taxonomies, $allowed_taxonomies );
			} elseif ( is_array( $allowed_taxonomies ) ) {
				$taxonomies = $allowed_taxonomies;
			}
		}
		return $taxonomies;
	}

	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	public function metaboxes( array $meta_boxes ) {
		// Allowed post types.
		$allowed_post_types = $this->get_allowed_post_types();

		// Allowed Meta_boxes.
		$title_enabled    = apply_filters( 'lsx_banner_enable_title', true );
		$subtitle_enabled = apply_filters( 'lsx_banner_enable_subtitle', true );

		// If you only want to be able to disable content per banner.
		$title_disable = apply_filters( 'lsx_banner_disable_title', true );
		$text_disable  = apply_filters( 'lsx_banner_disable_text', true );

		// This runs twice in the plugin, this is the only time it runs in the backend.
		$this->placeholder = apply_filters( 'lsx_banner_enable_placeholder', true );

		$fields = array();

		if ( true === $this->placeholder ) {
			$fields[] = array(
				'id'   => 'banner_disabled',
				'name' => esc_html__( 'Disable banner', 'lsx-banners' ),
				'type' => 'checkbox',
				'cols' => 3,
			);
		}

		if ( true === $title_disable ) {
			$fields[] = array(
				'id'   => 'banner_title_disabled',
				'name' => esc_html__( 'Disable banner title', 'lsx-banners' ),
				'type' => 'checkbox',
				'cols' => 3,
			);
		}

		if ( true === $text_disable ) {
			$fields[] = array(
				'id'   => 'banner_text_disabled',
				'name' => esc_html__( 'Disable banner text', 'lsx-banners' ),
				'type' => 'checkbox',
				'cols' => 3,
			);
		}

		if ( $title_enabled ) {
			$fields[] = array(
				'id'   => 'banner_title',
				'name' => esc_html__( 'Title', 'lsx-banners' ),
				'type' => 'text',
			);
			$fields[] = array(
				'id'         => 'title_position',
				'name'       => esc_html__( 'Title Position', 'lsx-banners' ),
				'type'       => 'select',
				'allow_none' => false,
				'sortable'   => false,
				'repeatable' => false,
				'options'    => array(
					'centered' => __( 'Centered', 'lsx-banners' ),
					'bottom'   => __( 'Bottom', 'lsx-banners' ),
				),
			);
		}

		if ( $subtitle_enabled ) {
			$fields[] = array(
				'id'   => 'banner_subtitle',
				'name' => esc_html__( 'Tagline', 'lsx-banners' ),
				'type' => 'text',
			);
		}

		// Envira Gallery.
		if ( class_exists( 'Envira_Gallery' ) && ! function_exists( 'tour_operator' ) ) {
			$fields[] = array(
				'id'         => 'envira_gallery',
				'name'       => esc_html__( 'Envira Gallery', 'lsx-banners' ),
				'type'       => 'post_select',
				'use_ajax'   => false,
				'allow_none' => true,
				'query'      => array(
					'post_type'      => 'envira',
					'nopagin'        => true,
					'posts_per_page' => '-1',
					'orderby'        => 'title',
					'order'          => 'ASC',
				),
			);
		}

		$fields[] = array(
			'id'      => 'banner_bg_color',
			'name'    => esc_html__( 'Banner background color', 'lsx-banners' ),
			'type'    => 'colorpicker',
			'default' => '#2B3840',
		);

		$fields[] = array(
			'id'      => 'banner_text_color',
			'name'    => esc_html__( 'Banner text color', 'lsx-banners' ),
			'type'    => 'colorpicker',
			'default' => '#FFFFFF',
		);

		$fields[] = array(
			'id'   => 'banner_logo',
			'name' => esc_html__( 'Banner logo', 'lsx-banners' ),
			'desc' => esc_html__( 'Add a logo to the banner', 'lsx-banners' ),
			'type' => 'image',
		);

		$button_types = array(
			'link'   => esc_html__( 'Default (link)', 'lsx-banners' ),
			'anchor' => esc_html__( 'Anchor to the page element', 'lsx-banners' ),
		);

		if ( class_exists( 'Caldera_Forms_Forms' ) ) {
			$button_types['form'] = esc_html__( 'Open a modal (Caldera Form)', 'lsx-banners' );
		}

		if ( class_exists( 'WPForms' ) ) {
			$button_types['wpform'] = esc_html__( 'Open a modal (WP Form)', 'lsx-banners' );
		}

		$fields[] = array(
			'id'   => 'button_group',
			'name' => esc_html__( 'Button', 'lsx-banners' ),
			'type' => 'group',
			'cols' => 12,
			'fields' => array(
				array(
					'id'   => 'button_text',
					'name' => esc_html__( 'Button text', 'lsx-banners' ),
					'type' => 'text',
				),
				array(
					'id'   => 'button_link',
					'name' => esc_html__( 'Button link', 'lsx-banners' ),
					'desc' => esc_html__( 'Or the form ID"', 'lsx-banners' ),
					'type' => 'text',
				),
				array(
					'id'   => 'button_class',
					'name' => esc_html__( 'Button class', 'lsx-banners' ),
					'desc' => esc_html__( 'Available classes: cta-btn, cta-border-btn, secondary-btn, secondary-border-btn, tertiary-btn, tertiary-border-btn, border-btn, white-border-btn', 'lsx-banners' ),
					'type' => 'text',
				),
				array(
					'id'         => 'button_type',
					'name'       => esc_html__( 'Button type', 'lsx-banners' ),
					'type'       => 'select',
					'allow_none' => true,
					'sortable'   => false,
					'repeatable' => false,
					'options'    => $button_types,
				),
			),
		);

		$fields[] = array(
			'id'   => 'image_group',
			'name' => esc_html__( 'BG images', 'lsx-banners' ),
			'type' => 'group',
			'cols' => 12,
			'fields' => array(
				array(
					'id'         => 'banner_image',
					'name'       => esc_html__( 'Image', 'lsx-banners' ),
					'type'       => 'image',
					'repeatable' => true,
					'show_size'  => false,
					'size'       => array( 185, 130 ),
				),
			),
		);

		$image_sizes = array(
			'full'   => esc_html__( 'Full', 'lsx-banners' ),
			'medium'  => esc_html__( 'Medium', 'lsx-banners' ),
			'thumbnail' => esc_html__( 'Thumbnail', 'lsx-banners' ),
		);
		$additional_image_sizes = wp_get_additional_image_sizes();
		if ( ! empty( $additional_image_sizes ) && is_array( $additional_image_sizes ) ) {
			foreach ( $additional_image_sizes as $ais_key => $ais_values ) {
				$image_sizes[ $ais_key ] = ucwords( str_replace( '-', ' ', $ais_key ) );
			}
		}

		$fields[] = array(
			'id'   => 'image_bg_group',
			'name' => esc_html__( 'Attributes', 'lsx-banners' ),
			'type' => 'group',
			'cols' => 12,
			'fields' => array(
				array(
					'id'   => 'banner_full_height',
					'name' => esc_html__( 'Full height', 'lsx-banners' ),
					'type' => 'checkbox',
					'cols' => 3,
				),
				array(
					'id'   => 'banner_slider',
					'name' => esc_html__( 'Slider', 'lsx-banners' ),
					'type' => 'checkbox',
					'cols' => 3,
				),
				array(
					'id'   => 'banner_height',
					'name' => esc_html__( 'Height', 'lsx-banners' ),
					'type' => 'text',
				),
				array(
					'id'         => 'banner_x',
					'name'       => esc_html__( 'X Position', 'lsx-banners' ),
					'type'       => 'select',
					'allow_none' => true,
					'sortable'   => false,
					'repeatable' => false,
					'options'    => array(
						'left'   => esc_html__( 'Left', 'lsx-banners' ),
						'right'  => esc_html__( 'Right', 'lsx-banners' ),
						'Center' => esc_html__( 'Center', 'lsx-banners' ),
					),
				),
				array(
					'id'         => 'banner_y',
					'name'       => esc_html__( 'Y Position', 'lsx-banners' ),
					'type'       => 'select',
					'allow_none' => true,
					'sortable'   => false,
					'repeatable' => false,
					'options'    => array(
						'top'    => esc_html__( 'Top', 'lsx-banners' ),
						'bottom' => esc_html__( 'Bottom', 'lsx-banners' ),
						'Center' => esc_html__( 'Center', 'lsx-banners' ),
					),
				),
				array(
					'id'         => 'banner_size',
					'name'       => esc_html__( 'Image Size', 'lsx-banners' ),
					'type'       => 'select',
					'allow_none' => true,
					'sortable'   => false,
					'repeatable' => false,
					'options'    => $image_sizes,
				),
			),
		);

		$meta_boxes[] = array(
			'title'  => esc_html__( 'Banners', 'lsx-banners' ),
			'pages'  => $allowed_post_types,
			'fields' => $fields,
		);

		return $meta_boxes;
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function add_form_field( $term = false ) {
		if ( apply_filters( 'lsx_banners_disable_taxonomy_field', false ) ) {
			return true;
		}

		if ( is_object( $term ) ) {
			$value         = get_term_meta( $term->term_id, 'banner', true );
			$image_preview = wp_get_attachment_image_src( $value, 'thumbnail' );

			if ( is_array( $image_preview ) ) {
				$image_preview = '<img src="' . $image_preview[0] . '" width="' . $image_preview[1] . '" height="' . $image_preview[2] . '" class="alignnone size-thumbnail wp-image-' . $value . '" />';
			}
		} else {
			$image_preview = false;
			$value = false;
		}
		?>
		<tr class="form-field term-banner-wrap">
			<th scope="row"><label for="banner"><?php esc_html_e( 'Banner', 'lsx-banners' ); ?></label></th>
			<td>
				<input class="input_image_id" type="hidden" name="banner" value="<?php echo esc_attr( $value ); ?>">
				<div class="banner-preview">
					<?php echo wp_kses_post( $image_preview ); ?>
				</div>
				<a style="
				<?php
				if ( '' !== $value && false !== $value ) {
					?>
					display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'lsx-banners' ); ?></a>
				<a style="
				<?php
				if ( '' === $value || false === $value ) {
					?>
					display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-remove"><?php esc_html_e( 'Remove Image', 'lsx-banners' ); ?></a>

				<?php wp_nonce_field( 'save_term_meta', 'lsx_banners_save_meta' ); ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Saves the Taxnomy term banner image
	 *
	 * @since 1.0.0
	 *
	 * @param  int    $term_id
	 * @param  string $taxonomy
	 */
	public function save_meta( $term_id = 0, $taxonomy = '' ) {

		if ( ! isset( $_POST['lsx_banners_save_meta'] ) || ! wp_verify_nonce( $_POST['lsx_banners_save_meta'], 'save_term_meta' ) ) {
			return;
		}

		if ( empty( $_POST['banner'] ) ) {
			delete_term_meta( $term_id, 'banner' );
		} else {
			update_term_meta( $term_id, 'banner', $_POST['banner'] );
		}
	}

	/**
	 * Adds in the settings neccesary for the archives
	 *
	 * @return null
	 */
	public function archive_settings() {
		?>
		<tr class="form-field banner-wrap">
			<th scope="row">
				<label for="banner"> <?php esc_html_e( 'Banner Image', 'lsx-banners' ); ?></label>
			</th>
			<td>
				<input class="input_image_id" type="hidden" {{#if banner_id}} value="{{banner_id}}" {{/if}} name="banner_id" />
				<input class="input_image" type="hidden" {{#if banner}} value="{{banner}}" {{/if}} name="banner" />
				<div class="thumbnail-preview">
					{{#if banner}}<img src="{{banner}}" width="150" />{{/if}}
				</div>
				<a {{#if banner}}style="display:none;"{{/if}} class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'lsx-banners' ); ?></a>
				<a {{#unless banner}}style="display:none;"{{/unless}} class="button-secondary lsx-thumbnail-image-delete"><?php esc_html_e( 'Delete', 'lsx-banners' ); ?></a>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="banner_video"><?php esc_html_e( 'Banner Video URL (mp4)', 'lsx-banners' ); ?></label>
			</th>
			<td>
				<input type="text" {{#if banner_video}} value="{{banner_video}}" {{/if}} name="banner_video" />
			</td>
		</tr>
		<?php if ( ! function_exists( 'tour_operator' ) ) { ?>
			<tr class="form-field">
				<th scope="row">
					<label for="title"> <?php esc_html_e( 'Banner title', 'lsx-banners' ); ?></label>
				</th>
				<td>
					<input type="text" {{#if title}} value="{{title}}" {{/if}} name="title" />
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="tagline"> <?php esc_html_e( 'Banner tagline', 'lsx-banners' ); ?></label>
				</th>
				<td>
					<input type="text" {{#if tagline}} value="{{tagline}}" {{/if}} name="tagline" />
				</td>
			</tr>
		<?php } ?>
		<?php
	}

	/**
	 * Outputs the display tabs settings.
	 */
	public function display_settings( $tab = 'general' ) {
		if ( 'placeholders' === $tab ) {
			?>
			<tr class="form-field">
				<th scope="row" colspan="2">
					<h3><?php esc_html_e( 'Banners', 'lsx-banners' ); ?></h3>
				</th>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="banners_disabled"><?php esc_html_e( 'Disable Banners', 'lsx-banners' ); ?></label>
				</th>
				<td>
					<input type="checkbox" {{#if banners_disabled}} checked="checked" {{/if}} name="banners_disabled" />
					<small><?php esc_html_e( 'Disable banners globally.', 'lsx-banners' ); ?></small>
				</td>
			</tr>
			<?php
		}
	}

	/**
	 * Returns the array of settings to the UIX Class
	 */
	public function create_settings_page() {
		if ( is_admin() ) {
			if ( ! class_exists( '\lsx\ui\uix' ) && ! function_exists( 'tour_operator' ) ) {
				include_once TO_BANNERS_PATH . 'vendor/uix/uix.php';
				$pages = $this->settings_page_array();
				$uix = \lsx\ui\uix::get_instance( 'lsx' );
				$uix->register_pages( $pages );
			}

			$post_types = $this->get_allowed_post_types();

			if ( false !== $post_types ) {
				foreach ( $post_types as $post_type ) {
					if ( function_exists( 'tour_operator' ) ) {
						add_action( 'lsx_to_framework_' . $post_type . '_tab_archive_settings_top', array( $this, 'archive_settings' ), 20 );
					} else {
						add_action( 'lsx_framework_' . $post_type . '_tab_content_top', array( $this, 'archive_settings' ), 20 );
					}
				}
			}

			if ( function_exists( 'tour_operator' ) ) {
				add_action( 'lsx_to_framework_display_tab_content', array( $this, 'display_settings' ), 25 );
			} else {
				add_action( 'lsx_framework_display_tab_content', array( $this, 'display_settings' ), 25 );
			}
		}
	}

	/**
	 * Returns the array of settings to the UIX Class
	 */
	public function settings_page_array() {
		$tabs = apply_filters( 'lsx_framework_settings_tabs', array() );

		return array(
			'settings'  => array(
				'page_title'  => esc_html__( 'Theme Options', 'lsx-banners' ),
				'menu_title'  => esc_html__( 'Theme Options', 'lsx-banners' ),
				'capability'  => 'manage_options',
				'icon'        => 'dashicons-book-alt',
				'parent'      => 'themes.php',
				'save_button' => esc_html__( 'Save Changes', 'lsx-banners' ),
				'tabs'        => $tabs,
			),
		);
	}

	/**
	 * Register tabs
	 */
	public function register_tabs( $tabs ) {
		$default = true;

		if ( false !== $tabs && is_array( $tabs ) && count( $tabs ) > 0 ) {
			$default = false;
		}

		if ( ! function_exists( 'tour_operator' ) ) {
			if ( ! array_key_exists( 'display', $tabs ) ) {
				$tabs['display'] = array(
					'page_title'        => '',
					'page_description'  => '',
					'menu_title'        => esc_html__( 'Display', 'lsx-currencies' ),
					'template'          => TO_BANNERS_PATH . 'includes/settings/display.php',
					'default'           => $default,
				);

				$default = false;
			}
		}

		$post_types = $this->get_allowed_post_types();

		if ( false !== $post_types && ! empty( $post_types ) ) {
			foreach ( $post_types as $index ) {
				if ( ! array_key_exists( $index, $tabs ) && 'page' !== $index ) {
					$tabs[ $index ] = array(
						'page_title'        => esc_html__( 'Placeholders', 'lsx-banners' ),
						'page_description'  => '',
						'menu_title'        => ucwords( str_replace( '-', ' ', $index ) ),
						'template'          => TO_BANNERS_PATH . 'includes/settings/placeholder.php',
						'default'           => $default,
					);

					$default = false;
				}
			}
		}

		return $tabs;
	}
}
