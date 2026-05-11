<?php
/**
 * Loads the JSON initializer.
 *
 * @package create-content-model
 */

declare( strict_types = 1 );

require_once __DIR__ . '/class-content-model-json-initializer.php';

/**
 * JSON initializer disabled - content models now load directly from JSON at runtime.
 * Database storage is no longer used to avoid sync issues on cloned/migrated sites.
 */
// add_action(
// 	'init',
// 	array( Content_Model_Json_Initializer::class, 'maybe_register_content_models_from_json' )
// );
