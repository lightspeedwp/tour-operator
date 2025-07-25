<?php
/**
 * Backend actions for the Tour Operator Plugin
 *
 * @package   \lsx\legacy\Admin
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package \lsx\legacy\Admin
 * @author  LightSpeed
 */
class Admin extends Tour_Operator {

	/**
	 * Holds the maps class
	 *
	 * @var object lsx\legacy\Videos_Admin();
	 */
	public $videos = '';

	/**
	 * Holds the post_type connection keys
	 *
	 * @var array
	 */
    public $connections;

	/**
	 * Holds the array of fields needed for the indexing and search
	 *
	 * @var array
	 */
    public $single_fields;

	/**
	 * Holds the array of taxonomies.
	 *
	 * @var array
	 */
    public $taxonomies;

	/**
	 * Initialize the plugin by setting localization, filters, and
	 * administration functions.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	public function __construct() {
		$this->options = get_option( 'lsx_to_settings', false );
		$this->set_vars();

		$this->videos = Video::get_instance();

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ), 999 );
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function init() {
		if ( is_admin() ) {
			add_action( 'cmb2_pre_save_field', array( $this, 'cpt_relations' ), 2, 20 );

			$this->connections   = $this->create_post_connections();
			$this->single_fields = apply_filters( 'lsx_to_search_fields', array() );
			$this->taxonomies = apply_filters( 'lsx_to_taxonomies', $this->taxonomies );

			if ( false !== $this->taxonomies ) {

				add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
				add_action( 'edit_term', array( $this, 'save_meta' ), 10, 2 );

				foreach ( array_keys( $this->taxonomies ) as $taxonomy ) {
					add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_thumbnail_form_field' ), 1, 1 );
					add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_tagline_form_field' ), 3, 1 );
				}
			}
		}
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null
	 */
	public function enqueue_admin_stylescripts( $hook ) {
		$screen = get_current_screen();

		if ( ! is_object( $screen ) ) {
			return;
		}

		//deregister scripts
		// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['post'] ) && in_array( get_post_type( $_GET['post'] ), array( 'team', 'special', 'review', 'destination', 'accommodation', 'tour' ) ) ) {
			wp_deregister_script( 'sgpbSelect2.js' );
			wp_deregister_script( 'select2.min.js' );
			if ( defined( 'CMB_URL' ) ) {
				wp_deregister_script( 'select2' );
				wp_enqueue_script( 'select2', trailingslashit( CMB_URL ) . 'js/vendor/select2/select2.js', array( 'jquery' ), LSX_TO_VER, [ 'in_footer' => true ] );
				wp_enqueue_style( 'select2', trailingslashit( CMB_URL ) . 'js/vendor/select2/select2.css', [], LSX_TO_VER );
			}
		}


		// TO Pages: Settings
		// WP Terms: create/edit term
		$allowed_pages = array(
			'settings_page_lsx-to-settings',
			'term.php',
		);
		if ( ! in_array( $hook, $allowed_pages ) ) {
			return;
		}

		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_script( 'tour-operator-admin-script', LSX_TO_URL . 'assets/js/src/admin.js', array( 'jquery' ), LSX_TO_VER, true );
		wp_enqueue_style( 'tour-operator-admin-style', LSX_TO_URL . 'assets/css/admin.css', array(), LSX_TO_VER );
		wp_style_add_data( 'tour-operator-admin-style', 'rtl', 'replace' );

	}

	/**
	 * Fixes the CMB2 field relations
	 *
	 * @param string $field_id
	 * @param bool $status
	 * @param string $action
	 * @param object $field
	 * @return void
	 */
	public function cpt_relations( $field_id, $field ) {

		if ( in_array( $field_id, $this->connections ) ) {
			$connected_id    = get_the_ID();
			$previous_values = get_post_meta( $connected_id, $field_id, true );
			$remote_key      = $this->reverse_key( $field_id );

			if ( isset( $field->data_to_save[ $field_id ] ) ) {
				$new_values = $field->data_to_save[ $field_id ];
			} else {
				$new_values = array();
			}

			//if the new values are empty, then we need to remove the previous values.
			if ( empty( $new_values ) ) {
				if ( ! empty( $previous_values ) ) {
					foreach ( $previous_values as $remote_id ) {
						$this->remove_connected_id( $remote_id, $connected_id, $remote_key );
					}
				}
			} else {

				if ( ! is_array( $previous_values ) ) {
					$previous_values = [ $previous_values ];
				}

				// Now determine if we added or removed any values.
				$is_removing = array_diff( $previous_values, $new_values );
				$is_adding   = array_diff( $new_values, $previous_values );

				if ( ! empty( $is_removing ) ) {
					foreach ( $is_removing as $remote_id ) {
						$this->remove_connected_id( $remote_id, $connected_id, $remote_key );
					}
				}

				if ( ! empty( $is_adding ) ) {
					foreach ( $is_adding as $remote_id ) {
						$this->add_connected_id( $remote_id, $connected_id, $remote_key );
					}
				}
			}
		}
	}

	/**
	 * Reverses the key for the remote_key slug.
	 *
	 * @param [type] $meta_key
	 * @return void
	 */
	public function reverse_key( $meta_key ) {
		$ids = explode( '_to_', $meta_key );
		return $ids[1] . '_to_' . $ids[0];
	}

	/**
	 * Remove the connected ID from the serialized array.
	 *
	 * @param int $remote_id
	 * @param int $connected_id
	 * @param string $meta_key
	 * @return void
	 */
	public function remove_connected_id( $remote_id, $connected_id, $meta_key ) {
		$prev = get_post_meta( $remote_id, $meta_key, true );
		if ( ! empty( $prev ) ) {
			$diff = array_diff( $prev, array( $connected_id ) );
			update_post_meta( $remote_id, $meta_key, $diff, $prev );
		}
	}

	public function add_connected_id( $remote_id, $connected_id, $meta_key ) {
		$prev = get_post_meta( $remote_id, $meta_key, true );
		// No Previous items detected.
		if ( false === $prev || empty( $prev ) ) {
			delete_post_meta( $remote_id, $meta_key );
			$test = add_post_meta( $remote_id, $meta_key, array( $connected_id ), true );
		} else {
			if ( ! is_array( $prev ) ) {
				$new = array( $prev );
			} else {
				$new = $prev;
			}
			$new[] = $connected_id;
			$new   = array_unique( $new );
			$updated = update_post_meta( $remote_id, $meta_key, $new, $prev );
		}
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_thumbnail_form_field( $term = false ) {
		if ( is_object( $term ) ) {
			$value         = get_term_meta( $term->term_id, 'thumbnail', true );
			$image_preview = wp_get_attachment_image_src( $value, 'thumbnail' );

			if ( is_array( $image_preview ) ) {
				// phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
				$image_preview = '<img src="' . esc_url( $image_preview[0] ) . '" width="' . $image_preview[1] . '" height="' . $image_preview[2] . '" class="alignnone size-thumbnail d wp-image-' . $value . '" />';
			}
		} else {
			$image_preview = false;
			$value         = false;
		}
		?>
		<tr class="form-field term-thumbnail-wrap">
			<th scope="row"><label for="thumbnail"><?php esc_html_e( 'Featured Image', 'tour-operator' ); ?></label></th>
			<td>
				<input class="input_image" type="hidden" name="thumbnail" value="<?php echo wp_kses_post( $value ); ?>">
				<div class="thumbnail-preview">
					<?php echo wp_kses_post( $image_preview ); ?>
				</div>
				<a style="<?php if ( '' !== $value && false !== $value ) { ?> display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-add"><?php esc_html_e( 'Choose Image', 'tour-operator' ); ?></a>
				<a style="<?php if ( '' === $value || false === $value ) { ?>display:none;<?php } ?>" class="button-secondary lsx-thumbnail-image-remove"><?php esc_html_e( 'Remove Image', 'tour-operator' ); ?></a>
				<?php wp_nonce_field( 'lsx_to_save_term_thumbnail', 'lsx_to_term_thumbnail_nonce' ); ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Saves the Taxnomy term banner image
	 *
	 * @since 0.1.0
	 *
	 * @param  int    $term_id
	 * @param  string $taxonomy
	 */
	public function save_meta( $term_id = 0, $taxonomy = '' ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_POST['thumbnail'] ) || ! isset( $_POST['tagline'] ) ) {
			return;
		}

		if ( check_admin_referer( 'lsx_to_save_term_thumbnail', 'lsx_to_term_thumbnail_nonce' ) ) {
			// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( isset( $_POST['thumbnail'] ) && ! empty( $_POST['thumbnail'] ) ) {
				$thumbnail_meta = sanitize_text_field( wp_unslash( $_POST['thumbnail'] ) );
				$thumbnail_meta = ! empty( $thumbnail_meta ) ? $thumbnail_meta : '';

				if ( empty( $thumbnail_meta ) ) {
					delete_term_meta( $term_id, 'thumbnail' );
				} else {
					update_term_meta( $term_id, 'thumbnail', $thumbnail_meta );
				}
			}

			// @phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( isset( $_POST['tagline'] ) && ! empty( $_POST['tagline'] ) ) {
				$meta = sanitize_text_field( wp_unslash( $_POST['tagline'] ) );
				$meta = ! empty( $meta ) ? $meta : '';

				if ( empty( $meta ) ) {
					delete_term_meta( $term_id, 'tagline' );
				} else {
					update_term_meta( $term_id, 'tagline', $meta );
				}
			}
		}
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function add_tagline_form_field( $term = false ) {
		if ( is_object( $term ) ) {
			$value = get_term_meta( $term->term_id, 'tagline', true );
		} else {
			$value = false;
		}
		?>
		<tr class="form-field term-tagline-wrap">
			<th scope="row"><label for="tagline"><?php esc_html_e( 'Tagline', 'tour-operator' ); ?></label></th>
			<td>
				<input name="tagline" id="tagline" type="text" value="<?php echo wp_kses_post( $value ); ?>" size="40">
			</td>
		</tr>
		<?php
	}
}
