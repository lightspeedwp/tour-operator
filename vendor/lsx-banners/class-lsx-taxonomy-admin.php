<?php
/**
 * LSX Banners Taxonomy Class
 *
 * @package   LSX Banners
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2016 LightSpeed
 */
class TO_Taxonomy_Admin {

	public $taxonomies = array( 'category' );

	public $fields = false;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	public function __construct( $taxonomies = false ) {
		add_action( 'admin_init', array( $this, 'init' ), 100 );
		if ( false !== $taxonomies ) {
			$this->taxonomies = $taxonomies;
		}

		$this->fields = array(
			'thumbnail' => esc_html__( 'Thumbnail', 'lsx-banners' ),
			'tagline' => esc_html__( 'Tagline', 'lsx-banners' ),
			'expert' => esc_html__( 'Expert', 'lsx-banners' ),
			'banner_video' => esc_html__( 'Video URL', 'lsx-banners' ),
		);
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function init() {
		$this->taxonomies = apply_filters( 'lsx_taxonomy_admin_taxonomies', $this->taxonomies );

		if ( false !== $this->taxonomies ) {
			add_action( 'create_term', array( $this, 'save_meta' ), 10, 2 );
			foreach ( $this->taxonomies as $taxonomy ) {
				// add_action( "{$taxonomy}_add_form_fields",  array( $this, 'add_thumbnail_form_field'  ),3 );
				add_action( "edit_{$taxonomy}", array( $this, 'save_meta' ), 10, 2 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_thumbnail_form_field' ), 3, 1 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_tagline_form_field' ), 3, 1 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_banner_video_form_field' ), 3, 1 );
			}
		}
	}
	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function widget_taxonomies( $taxonomies ) {
		if ( false !== $this->taxonomies ) {
			$taxonomies = array_merge( $taxonomies, $this->taxonomies );
		}
		return $taxonomies;
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function add_thumbnail_form_field( $term = false ) {

		if ( is_object( $term ) ) {
			$value = get_term_meta( $term->term_id, 'thumbnail', true );
			$image_preview = wp_get_attachment_image_src( $value, 'thumbnail' );
			if ( is_array( $image_preview ) ) {
				$image_preview = '<img src="' . $image_preview[0] . '" width="' . $image_preview[1] . '" height="' . $image_preview[2] . '" class="alignnone size-thumbnail wp-image-' . $value . '" />';
			}
		} else {
			$image_preview = false;
			$value = false;
		}
		?>
		<tr class="form-field term-thumbnail-wrap">
			<th scope="row"><label for="thumbnail"><?php esc_html_e( 'Featured Image', 'lsx-banners' ); ?></label></th>
			<td>
				<input class="input_image_id" type="hidden" name="thumbnail" value="<?php echo esc_attr( $value ); ?>">
				<div class="thumbnail-preview">
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
				<?php wp_nonce_field( 'lsx_banners_save_term_thumbnail', 'lsx_banners_term_thumbnail_nonce' ); ?>
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
		if ( ! wp_verify_nonce( sanitize_text_field( $_REQUEST['lsx_banners_term_thumbnail_nonce'] ), 'lsx_banners_save_term_thumbnail' ) ) {
			return;
		}
		if ( false !== $this->fields ) {
			foreach ( $this->fields as $slug => $label ) {
				if ( empty( $_POST[ $slug ] ) ) {
					delete_term_meta( $term_id, $slug );
				} else {
					update_term_meta( $term_id, $slug, $_POST[ $slug ] );
				}
			}
		}
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function add_tagline_form_field( $term = false ) {
		if ( is_object( $term ) ) {
			$value = get_term_meta( $term->term_id, 'tagline', true );
		} else {
			$value = false;
		}
		?>
		<tr class="form-field term-tagline-wrap">
			<th scope="row"><label for="tagline"><?php esc_html_e( 'Banner tagline', 'lsx-banners' ); ?></label></th>
			<td>
				<input name="tagline" id="tagline" type="text" value="<?php echo esc_attr( $value ); ?>" size="40" aria-required="true">
			</td>
		</tr>
		<?php
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function add_banner_video_form_field( $term = false ) {
		if ( is_object( $term ) ) {
			$value = get_term_meta( $term->term_id, 'banner_video', true );
		} else {
			$value = false;
		}
		?>
		<tr class="form-field term-youtube-wrap">
			<th scope="row"><label for="banner_video"><?php esc_html_e( 'Banner Video URL (mp4)', 'lsx-banners' ); ?></label></th>
			<td>
				<input name="banner_video" id="banner_video" type="text" value="<?php echo esc_attr( $value ); ?>" size="40" aria-required="true">
			</td>
		</tr>
		<?php
	}

	/**
	 * Output the form field for this metadata when adding a new term
	 *
	 * @since 1.0.0
	 */
	public function add_expert_form_field( $term = false ) {
		if ( is_object( $term ) ) {
			$value = get_term_meta( $term->term_id, 'expert', true );
		} else {
			$value = false;
		}

		$experts = get_posts(
			array(
				'post_type' => 'team',
				'posts_per_page' => -1,
				'orderby' => 'menu_order',
				'order' => 'ASC',
			)
		);
		?>

		<tr class="form-field term-expert-wrap">
			<th scope="row">
				<label for="expert"><?php esc_html_e( 'Expert', 'lsx-banners' ); ?></label>
			</th>

			<td>
				<select name="expert" id="expert" aria-required="true">
					<option value=""><?php esc_html_e( 'None', 'lsx-banners' ); ?></option>

					<?php
					foreach ( $experts as $expert ) {
						echo '<option value="' . esc_attr( $expert->ID ) . '"' . selected( $value, esc_attr( $expert->ID ), false ) . '>' . esc_attr( $expert->post_title ) . '</option>';
					}
					?>
				</select>
			</td>
		</tr>

		<?php
	}
}
/**
 * Checks if the current term has a thumbnail
 *
 * @param   $term_id
 */
function lsx_has_term_thumbnail( $term_id = false ) {
	if ( false !== $term_id ) {
		$term_thumbnail = get_term_meta( $term_id, 'thumbnail', true );
		if ( false !== $term_thumbnail && '' !== $term_thumbnail ) {
			return true;
		}
	}
	return false;
}

/**
 * Outputs the current terms thumbnail
 *
 * @param   $term_id string
 */
function lsx_term_thumbnail( $term_id = false, $size = 'lsx-thumbnail-wide' ) {
	if ( false !== $term_id ) {
		echo wp_kses_post( lsx_get_term_thumbnail( $term_id, $size ) );
	}
}

/**
 * Outputs the current terms thumbnail
 *
 * @param   $term_id string
 */
function lsx_get_term_thumbnail( $term_id = false, $size = 'lsx-thumbnail-wide' ) {
	if ( false !== $term_id ) {
		$term_thumbnail_id = get_term_meta( $term_id, 'thumbnail', true );
		$img               = wp_get_attachment_image_src( $term_thumbnail_id, $size );
		$image_url         = $img[0];
		$img               = '<img alt="thumbnail" class="attachment-responsive wp-post-image lsx-responsive" src="' . $image_url . '" />';
		$img               = apply_filters( 'lsx_lazyload_slider_images', $img, $term_thumbnail_id, $size, false, $image_url );
		return $img;
	}
}
