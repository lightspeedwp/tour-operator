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
			'expert' => esc_html__( 'Expert', 'lsx-banners' ),
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
				add_action( "edit_{$taxonomy}", array( $this, 'save_meta' ), 10, 2 );
				add_action( "{$taxonomy}_edit_form_fields", array( $this, 'add_tagline_form_field' ), 3, 1 );
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
