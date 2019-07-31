<?php
/**
 * Schema Class
 *
 * @package   Schema
 * @author    LightSpeed
 * @license   GPL3
 * @link
 * @copyright 2019 LightSpeedDevelopment
 */

namespace lsx\legacy;

/**
 * Main plugin class.
 *
 * @package Schema
 * @author  LightSpeed
 */
class Schema {

	/**
	 * Holds instances of the class
	 */
	protected static $instance;

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( is_singular( 'accommodation' ) ) {
			add_action( 'wp_head', array( $this, 'my_schema' ), 99 );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Creates the schema for the tour post type
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public function my_schema() {
		$meta   = array();
		$output = json_encode( $meta );
		?>
		<script type="application/ld+json">
		<?php echo $output; ?>
		</script>
		<?php
	}
}