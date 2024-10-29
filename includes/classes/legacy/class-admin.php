<?php
/**
 * Backend actions for the LSX Tour Operator Plugin
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
		$this->options = get_option( '_lsx-to_settings', false );
		$this->set_vars();

		$this->videos = Video::get_instance();

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ), 999 );
		add_action( 'cmb_save_custom', array( $this, 'post_relations' ), 3, 20 );
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 0.1.0
	 */
	public function init() {
		if ( is_admin() ) {
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
		if ( isset( $_GET['post'] ) && in_array( get_post_type( $_GET['post'] ), array( 'destination', 'accommodation', 'tour' ) ) ) {
			wp_deregister_script( 'sgpbSelect2.js' );
			wp_deregister_script( 'select2.min.js' );
		}


		// TO Pages: Add-ons, Help, Settings and Welcome
		// WP Terms: create/edit term
		$allowed_pages = array(
			'tour-operator_page_to-help',
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
	 * Sets up the "post relations"
	 *
	 * @return    object
	 */
	public function post_relations( $post_id, $field, $value ) {
		if ( 'group' === $field['type'] && isset( $this->single_fields ) && array_key_exists( $field['id'], $this->single_fields ) ) {
			$delete_counter = array();

			foreach ( $this->single_fields[ $field['id'] ] as $fields_to_save ) {
				$delete_counter[ $fields_to_save ] = 0;
			}

			//Loop through each group in case of repeatable fields
			$relations          = false;
			$previous_relations = false;

			foreach ( $value as $group ) {
				//loop through each of the fields in the group that need to be saved and grab their values.
				foreach ( $this->single_fields[ $field['id'] ] as $fields_to_save ) {
					//Check if its an empty group
					if ( isset( $group[ $fields_to_save ] ) && ! empty( $group[ $fields_to_save ] ) ) {
						if ( $delete_counter[ $fields_to_save ] < 1 ) {
							//If this is a relation field, then we need to save the previous relations to remove any items if need be.
							if ( in_array( $fields_to_save, $this->connections ) ) {
								$previous_relations[ $fields_to_save ] = get_post_meta( $post_id, $fields_to_save, false );
							}

							delete_post_meta( $post_id, $fields_to_save );
							$delete_counter[ $fields_to_save ] ++;
						}

						//Run through each group
						foreach ( $group[ $fields_to_save ] as $field_value ) {
							if ( null !== $field_value ) {
								if ( 1 === $field_value ) {
									$field_value = true;
								}

								add_post_meta( $post_id, $fields_to_save, $field_value );

								//If its a related connection the save that
								if ( in_array( $fields_to_save, $this->connections ) ) {
									$relations[ $fields_to_save ][ $field_value ] = $field_value;
								}
							}
						}
					}
				}
			}//end of the repeatable group foreach

			//If we have relations, loop through them and save the meta
			if ( false !== $relations ) {
				foreach ( $relations as $relation_key => $relation_values ) {
					$temp_field = array(
						'id' => $relation_key,
					);

					$this->save_related_post( $post_id, $temp_field, $relation_values, $previous_relations[ $relation_key ] );
				}
			}
		} else {
			if ( in_array( $field['id'], $this->connections ) ) {
				$this->save_related_post( $post_id, $field, $value );
			}
		}
	}

	/**
	 * Save the reverse post relation.
	 *
	 * @return    null
	 */
	public function save_related_post( $post_id, $field, $value, $previous_values = false ) {
		$ids = explode( '_to_', $field['id'] );
		$relation = $ids[1] . '_to_' . $ids[0];

		if ( in_array( $relation, $this->connections ) ) {
			if ( false === $previous_values ) {
				$previous_values = get_post_meta( $post_id, $field['id'], false );
			}

			if ( false !== $previous_values && ! empty( $previous_values ) ) {
				foreach ( $previous_values as $tr ) {
					delete_post_meta( $tr, $relation, $post_id );
				}
			}

			if ( is_array( $value ) ) {
				foreach ( $value as $v ) {
					if ( '' !== $v && null !== $v && false !== $v ) {
						add_post_meta( $v, $relation, $post_id );
					}
				}
			}
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

		if ( ! isset( $_POST['thumbnail'] ) || ! isset( $_POST['tagline'] ) ) {
			return;
		}

		if ( check_admin_referer( 'lsx_to_save_term_thumbnail', 'lsx_to_term_thumbnail_nonce' ) ) {
			if ( isset( $_POST['thumbnail'] ) && ! empty( $_POST['thumbnail'] ) ) {
				$thumbnail_meta = sanitize_text_field( $_POST['thumbnail'] );
				$thumbnail_meta = ! empty( $thumbnail_meta ) ? $thumbnail_meta : '';
	
				if ( empty( $thumbnail_meta ) ) {
					delete_term_meta( $term_id, 'thumbnail' );
				} else {
					update_term_meta( $term_id, 'thumbnail', $thumbnail_meta );
				}
			}

			if ( isset( $_POST['tagline'] ) && ! empty( $_POST['tagline'] ) ) {
				$meta = sanitize_text_field( $_POST['tagline'] );
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
