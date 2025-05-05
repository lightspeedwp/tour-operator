<?php
/**
 * Tour Operator - Permalinks Main Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 LightSpeedDevelopment
 */

namespace lsx\admin;

/**
 * Class Admin
 *
 * @package lsx\admin
 */
class Permalinks {

	/**
	 * Holds the default for the permalinks.
	 *
	 * @var array
	 */
	public $defaults = array(
		'lsx_to_travel-style'        => '',
		'lsx_to_accommodation-type'  => '',
		'lsx_to_accommodation-brand' => '',
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'register_permalink_settings' ] );
		add_action( 'admin_init', [ $this, 'save_custom_permalink_fields' ], 20 );
		add_filter( 'lsx_to_register_taxonomy_args', [ $this, 'apply_taxonomy_slugs' ], 10, 2 );
	}

	/**
	 * Register the setting to save custom fields.
	 */
	public function register_permalink_settings() {
		register_setting( 'permalink', 'lsx_to_slugs', array(
			'type'              => 'array',
			'sanitize_callback' => [ $this, 'sanitize_permalink_fields' ],
			'default'           => $this->defaults,
		) );

		add_settings_section(
			'lsx_to_permalink_section',
			'', // no title, just fields
			[ $this, 'permalink_fields' ],
			'permalink'
		);
	}

	/**
	 * Sanitize the custom permalink fields before saving.
	 *
	 * @param array $input Raw input from the form.
	 * @return array Sanitized input.
	 */
	public function sanitize_permalink_fields( $input ) {
		$sanitized = array();

		foreach ( $this->defaults as $key => $default ){
			$sanitized[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';
		}

		return $sanitized;
	}

	/**
	 * Register new fields to the permalink settings page.
	 */
	public function permalink_fields() {
		// Get existing options or defaults.
		$options = get_option( 'lsx_to_slugs', $this->defaults );

		$fields = [
			'travel-style' => [
				'label' => esc_html__( 'Travel Style', 'tour-operator' ),
			],
			'accommodation-type' => [
				'label' => esc_html__( 'Accommodation Type', 'tour-operator' ),
			],
			'accommodation-brand' => [
				'label' => esc_html__( 'Brand', 'tour-operator' ),
			],
		];

		?>
		<h2><?php esc_html_e( 'Tour Operator', 'tour-operator' ); ?></h2>
		<table class="form-table">
			<p>Use the following fields to alter the base slug for the Tour Operator taxonomies like <code><?php echo esc_html( home_url() );?>/travel-style/honeymoon/</code></p>
			<?php
				foreach ( $fields as $key => $field ) {
					?>
					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $field['label'] ); ?></label></th>
						<td>
							<input type="text" id="<?php echo esc_attr( $key ); ?>" name="lsx_to_slugs[lsx_to_<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $options[ 'lsx_to_' . $key ] ); ?>" class="regular-text" />
						</td>
					</tr>
					<?php
				}
			?>
		</table>
		<?php
	}

	/**
	 * Manually save the fields on permalink save
	 *
	 * @return void
	 */
	public function save_custom_permalink_fields() {
		if (
			isset( $_POST['lsx_to_slugs'] ) &&
			is_array( $_POST['lsx_to_slugs'] ) &&
			current_user_can( 'manage_options' )
		) {
			check_admin_referer( 'update-permalink' ); // default nonce for permalink page

			$input     = sanitize_text_field( $_POST['lsx_to_slugs'] );
			$sanitized = $this->sanitize_permalink_fields( $input );

			update_option( 'lsx_to_slugs', $sanitized );
		}
	}

	/**
	 * Applies the taxonomy slugs.
	 *
	 * @param array $args
	 * @param array $object_types
	 * @return array
	 */
	public function apply_taxonomy_slugs( $args, $taxonomy ) {
		$slug_options = get_option( 'lsx_to_slugs', $this->defaults );

		foreach ( $slug_options as $key => $option ) {

			if ( 'lsx_to_' . $taxonomy !== $key || '' === $option ) {
				continue;
			}

			$args['rewrite']['slug'] = $option;
		}

		return $args;
	}
}
