<?php

/**
 * Tour Operator - Permalinks Main Class
 *
 * @package   lsx
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 lightspeedwp
 */

namespace lsx\admin;

/**
 * Class Admin
 *
 * @package lsx\admin
 */
class Permalinks
{

	/**
	 * Holds the default for the permalinks.
	 *
	 * @var array
	 */
	public $defaults = array(
		'travel-style'        => '',
		'accommodation-type'  => '',
		'accommodation-brand' => '',
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action('admin_init', [$this, 'register_permalink_settings']);
		add_action('admin_init', [$this, 'save_custom_permalink_fields'], 20);
		add_filter('lsx_to_register_taxonomy_args', [$this, 'apply_taxonomy_slugs'], 10, 2);
		add_filter('content_model_post_type_args', [$this, 'alter_post_type_args'], 10, 2);
	}

	/**
	 * Register the setting to save custom fields.
	 */
	public function register_permalink_settings() {
		register_setting(
			'permalink',
			'lsx_to_slugs',
			array(
				'type'              => 'array',
				'sanitize_callback' => [$this, 'sanitize_permalink_fields'],
				'default'           => $this->defaults,
			)
		);

		add_settings_section(
			'lsx_to_permalink_section',
			'', // no title, just fields
			[$this, 'permalink_fields'],
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
		$fields    = $this->get_post_type_fields( $this->defaults );

		foreach ( $fields as $key => $default ) {
			$sanitized[ 'lsx_to_' . $key ] = isset( $input[ 'lsx_to_' . $key ] ) ? sanitize_text_field( $input[ 'lsx_to_' . $key ] ) : '';
		}

		return $sanitized;
	}

	/**
	 * Register new fields to the permalink settings page.
	 */
	public function permalink_fields() {
		// Get existing options or defaults.
		$options = get_option('lsx_to_slugs', $this->defaults);

		$fields = [
			'travel-style'        => [
				'label' => esc_html__('Travel Style', 'tour-operator'),
			],
			'accommodation-type'  => [
				'label' => esc_html__('Accommodation Type', 'tour-operator'),
			],
			'accommodation-brand' => [
				'label' => esc_html__('Brand', 'tour-operator'),
			],
		];
		?>
		<h2><?php esc_html_e('Tour Operator - Taxonomies', 'tour-operator'); ?></h2>
		<table class="form-table">
			<p>Use the following fields to alter the base slug for the Tour Operator taxonomies like <code><?php echo esc_html(home_url()); ?>/travel-style/honeymoon/</code></p>
			<?php
			foreach ($fields as $key => $field) {
			if ( isset( $options['lsx_to_' . $key] ) ) {
				$value = $options['lsx_to_' . $key];
			} else {
				$value = '';
			}
			?>
				<tr>
					<th scope="row"><label for="<?php echo esc_attr($key); ?>"><?php echo esc_attr($field['label']); ?></label></th>
					<td>
						<input type="text" id="<?php echo esc_attr($key); ?>" name="lsx_to_slugs[lsx_to_<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
					</td>
				</tr>
			<?php
			}
			?>
		</table>
		<?php


		$fields = $this->get_post_type_fields( [] );
		?>
		<h2><?php esc_html_e('Tour Operator - Post Types', 'tour-operator'); ?></h2>
		<table class="form-table">
			<p>Use the following fields to alter the base slug for the Tour Operator post types like <code><?php echo esc_html(home_url()); ?>/destination/south-africa/</code></p>
			<?php
			foreach ($fields as $key => $field) {
			if ( isset( $options['lsx_to_' . $key] ) ) {
				$value = $options['lsx_to_' . $key];
			} else {
				$value = '';
			}
			?>
				<tr>
					<th scope="row"><label for="<?php echo esc_attr($key); ?>"><?php echo esc_attr($field['label']); ?></label></th>
					<td>
						<input type="text" id="<?php echo esc_attr($key); ?>" name="lsx_to_slugs[lsx_to_<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
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
			isset($_POST['lsx_to_slugs']) &&
			is_array($_POST['lsx_to_slugs']) && // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- type check only; value is sanitized below.
			current_user_can('manage_options')
		) {
			check_admin_referer('update-permalink'); // default nonce for permalink page

			$input     = wp_unslash($_POST['lsx_to_slugs']);
			$sanitized = $this->sanitize_permalink_fields($input);
			update_option('lsx_to_slugs', $sanitized);
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
		$slug_options = get_option('lsx_to_slugs', $this->defaults);

		foreach ($slug_options as $key => $option) {

			if ('lsx_to_' . $taxonomy !== $key || '' === $option) {
				continue;
			}

			$args['rewrite']['slug'] = $option;
		}

		return $args;
	}

	/**
	 * Get the TO post types from the JSON files.
	 *
	 * @return array An array of post types, keyed by their slug.
	 */
	public function get_post_type_fields( $fields ) {

		global $CONTENT_MODEL_JSON_PATH;
		if ( ! isset( $CONTENT_MODEL_JSON_PATH ) ) {
			return $fields;
		}
		
		foreach ( $CONTENT_MODEL_JSON_PATH as $json_path ) {
			$types = glob( $json_path . '/post-types/*.json' );
			$types = array_map(
				fn( $file ) => json_decode( file_get_contents( $file ), true ),
				$types
			);
			foreach ( $types as $types ) {
				$fields[ $types['slug'] ] = [ 'label' => __( 'Single', 'tour-operator' ) . ' ' . $types['label'] ];
				$fields[ 'archive_' . $types['slug'] ] = [ 'label' => __( 'Archive', 'tour-operator' ) . ' ' . $types['label'] ];
			}
		}

		return $fields;
	}

	/**
	 * Alters the post type slugs based on the saved options.
	 *
	 * @param array $post_type The post type arguments.
	 * @return array The modified post type arguments.
	 */
	public function alter_post_type_args( $post_type, $slug ) {
		$slug_options = get_option( 'lsx_to_slugs', $this->defaults );

		if ( isset( $slug_options[ 'lsx_to_' . $slug ] ) && '' !== $slug_options[ 'lsx_to_' . $slug ] ) {
			$post_type['rewrite']['slug'] = $slug_options[ 'lsx_to_' . $slug ];
		}

		if ( isset( $slug_options[ 'lsx_to_archive_' . $slug ] ) && '' !== $slug_options[ 'lsx_to_archive_' . $slug ] ) {
			$post_type['has_archive'] = $slug_options[ 'lsx_to_archive_' . $slug ];
		}

		return $post_type;
	}
}
