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
		add_action( 'wp_head', array( $this, 'my_schema' ), 1499 );
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
	if ( is_singular( 'accommodation' ) ) {
	 $meta = array(
		  "@context" => "http://schema.org",
		  "@type" => "LocalBusiness",
		  "name" => "storename",
		  "image" => "https://staticqa.store.com/wp-content/themes/faf/images/store-logo.png",
		  "@id" => "id",
		  "url" => "",
		  "telephone" => "phone",
		  "priceRange" => "$1-$20",
		  "address" => array(
		    "@type" => "PostalAddress",
		    "streetAddress" => "address",
		    "addressLocality" => "storecityaddress",
		    "postalCode" => "storepostaladdress",
		    "addressCountry" => "USA"
		  ),
		    "geo" => array(
		    "@type" => "GeoCoordinates",
		    "latitude" => "storelatitude",
		    "longitude" => "storelongitude"
		  )
	 	 );
			$output = json_encode( $meta, JSON_UNESCAPED_SLASHES  );
			?>
			<script type="application/ld+json">
			<?php echo $output; ?>
			</script>
			<?php
		}
	}
}
