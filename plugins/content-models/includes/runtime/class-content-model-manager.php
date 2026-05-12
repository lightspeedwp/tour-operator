<?php
/**
 * Manages the existing content models.
 *
 * @package create-content-model
 */

declare( strict_types = 1 );

/**
 * Manages the registered Content Models.
 */
class Content_Model_Manager {
	public const BLOCK_NAME     = 'content-model/template';
	public const POST_TYPE_NAME = 'content_model';

	/**
	 * The instance.
	 *
	 * @var ?Content_Model_Manager
	 */
	private static $instance = null;

	/**
	 * Inits the singleton of the Content_Model_Manager class.
	 *
	 * @return Content_Model_Manager
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Holds the registered content models.
	 *
	 * @var Content_Model[]
	 */
	private $content_models = array();

	/**
	 * Initializes the Content_Model_Manager instance.
	 *
	 * @return void
	 */
	private function __construct() {
		$this->register_content_models();
	}

	/**
	 * Retrieves the registered content models.
	 *
	 * @return Content_Model[] An array of registered content models.
	 */
	public function get_content_models() {
		return $this->content_models;
	}

	/**
	 * Retrieves a content model by its slug.
	 *
	 * @param string $slug The slug of the content model to retrieve.
	 * @return Content_Model|null The content model with the matching slug, or null if not found.
	 */
	public function get_content_model_by_slug( $slug ) {
		foreach ( $this->content_models as $content_model ) {
			if ( $slug === $content_model->slug ) {
				return $content_model;
			}
		}

		return null;
	}

	/**
	 * Registers all content models.
	 *
	 * @return void
	 */
	private function register_content_models() {
		$content_models = self::get_content_models_from_json();

		foreach ( $content_models as $content_model ) {
			// Skip if content model data is invalid.
			if ( empty( $content_model ) || ! is_array( $content_model ) ) {
				continue;
			}

			$this->content_models[] = new Content_Model( $content_model );
		}
	}

	/**
	 * Retrieves the list of registered content models from JSON files.
	 *
	 * @return array[] An array of content model data arrays from JSON files.
	 */
	public static function get_content_models_from_json() {
		global $CONTENT_MODEL_JSON_PATH;

		$post_types = array();

		if ( ! isset( $CONTENT_MODEL_JSON_PATH ) || ! is_array( $CONTENT_MODEL_JSON_PATH ) ) {
			return $post_types;
		}

		foreach ( $CONTENT_MODEL_JSON_PATH as $json_path ) {
			if ( ! is_dir( $json_path . '/post-types' ) ) {
				continue;
			}

			$types = glob( $json_path . '/post-types/*.json' );

			if ( empty( $types ) ) {
				continue;
			}

			foreach ( $types as $file ) {
				$content = file_get_contents( $file );
				$data    = json_decode( $content, true );

				if ( json_last_error() === JSON_ERROR_NONE && is_array( $data ) ) {
					// Allow 3rd parties to edit the values before they are registered.
					$post_types[] = apply_filters( 'lsx_to_content_model_post_type', $data );
				}
			}
		}

		return $post_types;
	}

	/**
	 * Legacy method for backwards compatibility - now loads from JSON.
	 *
	 * @deprecated Use get_content_models_from_json() instead.
	 * @return array[] An array of content model data arrays.
	 */
	public static function get_content_models_from_database() {
		return self::get_content_models_from_json();
	}
}
