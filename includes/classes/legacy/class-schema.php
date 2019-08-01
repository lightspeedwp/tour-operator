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
		add_action( 'wp_head', array( $this, 'tour_single_schema' ), 1499 );
		add_action( 'wp_head', array( $this, 'destination_single_schema' ), 1499 );
		add_action( 'wp_head', array( $this, 'accommodation_single_schema' ), 1499 );
		add_action( 'wp_head', array( $this, 'reviews_single_schema' ), 1499 );
		add_action( 'wp_head', array( $this, 'specials_single_schema' ), 1499 );
		add_action( 'wp_head', array( $this, 'team_single_schema' ), 1499 );
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
	public function tour_single_schema() {
		if ( is_singular( 'tour' ) ) {
			$tours_list = get_post_meta( get_the_ID(), 'itinerary', false );
			$list_array = array();
			$url_option = get_the_permalink() . '#itinerary';
			$i = 0;
				foreach($tours_list as $day) {
				$day_title        = $day['title'];
				$day_description  = $day['description'];
				$i++;
				$schema_day       = array(
					"@type" => "ListItem",
					"position"=> $i,
					"item" =>
					array(
					"@id" => $url_option,
					"name" => $day_title,
					"description" => $day_description,
				)
			);
			$list_array[] = $schema_day;		
			}
			$meta = array(
				array(
					"@context" => "http://schema.org",
					"@type" => "Trip",
					"description" => "Description Text Here",
					"image" => "URL for image goes here - banner",
					"itinerary" => array(
					"@type" => "ItemList",
					"itemListElement" => $list_array,
					),
					"name" => "Title of tour post",
					"provider" => "Southern Destinations",
					"url" => "the page url"
				),
			);
			$output = json_encode( $meta, JSON_UNESCAPED_SLASHES  );
			?>
			<script type="application/ld+json">
				<?php echo $output; ?>
			</script>
			<?php
		}
	}


		/**
	 * Creates the schema for the destination post type
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public function destination_single_schema() {
		if ( is_singular( 'destination' ) ) {
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
				),
			);
			$output = json_encode( $meta, JSON_UNESCAPED_SLASHES  );
			?>
			<script type="application/ld+json">
				<?php echo $output; ?>
			</script>
			<?php
		}
	}

		/**
	 * Creates the schema for the accommodation post type
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public function accommodation_single_schema() {
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
				),
			);
			$output = json_encode( $meta, JSON_UNESCAPED_SLASHES  );
			?>
			<script type="application/ld+json">
				<?php echo $output; ?>
			</script>
			<?php
		}
	}

		/**
	 * Creates the schema for the reviews post type
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public function reviews_single_schema() {
		if ( is_singular( 'review' ) ) {
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
				),
			);
			$output = json_encode( $meta, JSON_UNESCAPED_SLASHES  );
			?>
			<script type="application/ld+json">
				<?php echo $output; ?>
			</script>
			<?php
		}
	}

		/**
	 * Creates the schema for the specials post type
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public function specials_single_schema() {
		if ( is_singular( 'special' ) ) {
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
				),
			);
			$output = json_encode( $meta, JSON_UNESCAPED_SLASHES  );
			?>
			<script type="application/ld+json">
				<?php echo $output; ?>
			</script>
			<?php
		}
	}

	/**
	 * Creates the schema for the team post type
	 *
	 * @since 1.0.0
	 * @return    object    A single instance of this class.
	 */
	public function team_single_schema() {
		if ( is_singular( 'team' ) ) {
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
				),
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
