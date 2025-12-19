<?php

/**
 * Factory for creating test data for Tour Operator Plugin
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

/**
 * Tour Operator Factory Class
 *
 * Provides methods for generating test data
 */
class Tour_Operator_Factory
{

	/**
	 * Create multiple tours with random data
	 *
	 * @param int   $count Number of tours to create
	 * @param array $args Arguments to override defaults
	 * @return array Array of tour IDs
	 */
	public static function create_tours($count = 5, $args = [])
	{
		$tour_ids = [];

		for ($i = 1; $i <= $count; $i++) {
			$defaults = [
				'post_title'   => "Test Tour {$i}",
				'post_content' => "Description for test tour {$i}",
				'post_type'    => 'tour',
				'post_status'  => 'publish',
			];

			$tour_args = wp_parse_args($args, $defaults);
			$tour_id = wp_insert_post($tour_args);

			if ($tour_id && ! is_wp_error($tour_id)) {
				// Add some sample meta data
				self::add_tour_meta($tour_id, $i);
				$tour_ids[] = $tour_id;
			}
		}

		return $tour_ids;
	}

	/**
	 * Create multiple accommodations with random data
	 *
	 * @param int   $count Number of accommodations to create
	 * @param array $args Arguments to override defaults
	 * @return array Array of accommodation IDs
	 */
	public static function create_accommodations($count = 5, $args = [])
	{
		$accommodation_ids = [];

		for ($i = 1; $i <= $count; $i++) {
			$defaults = [
				'post_title'   => "Test Accommodation {$i}",
				'post_content' => "Description for test accommodation {$i}",
				'post_type'    => 'accommodation',
				'post_status'  => 'publish',
			];

			$accommodation_args = wp_parse_args($args, $defaults);
			$accommodation_id = wp_insert_post($accommodation_args);

			if ($accommodation_id && ! is_wp_error($accommodation_id)) {
				// Add some sample meta data
				self::add_accommodation_meta($accommodation_id, $i);
				$accommodation_ids[] = $accommodation_id;
			}
		}

		return $accommodation_ids;
	}

	/**
	 * Create multiple destinations with random data
	 *
	 * @param int   $count Number of destinations to create
	 * @param array $args Arguments to override defaults
	 * @return array Array of destination IDs
	 */
	public static function create_destinations($count = 5, $args = [])
	{
		$destination_ids = [];

		for ($i = 1; $i <= $count; $i++) {
			$defaults = [
				'post_title'   => "Test Destination {$i}",
				'post_content' => "Description for test destination {$i}",
				'post_type'    => 'destination',
				'post_status'  => 'publish',
			];

			$destination_args = wp_parse_args($args, $defaults);
			$destination_id = wp_insert_post($destination_args);

			if ($destination_id && ! is_wp_error($destination_id)) {
				// Add some sample meta data
				self::add_destination_meta($destination_id, $i);
				$destination_ids[] = $destination_id;
			}
		}

		return $destination_ids;
	}

	/**
	 * Add sample meta data to tour posts
	 *
	 * @param int $tour_id Tour post ID
	 * @param int $index Index for generating varied data
	 */
	private static function add_tour_meta($tour_id, $index)
	{
		$sample_prices = ['1200', '2500', '850', '3200', '1800'];
		$sample_durations = ['3', '7', '5', '10', '14'];
		$sample_difficulties = ['easy', 'moderate', 'challenging', 'extreme'];

		// Add some sample meta fields (adjust based on your plugin's meta structure)
		update_post_meta($tour_id, 'price', $sample_prices[($index - 1) % count($sample_prices)]);
		update_post_meta($tour_id, 'duration', $sample_durations[($index - 1) % count($sample_durations)]);
		update_post_meta($tour_id, 'difficulty', $sample_difficulties[($index - 1) % count($sample_difficulties)]);
		update_post_meta($tour_id, 'featured', $index % 2 === 0 ? 'yes' : 'no');
	}

	/**
	 * Add sample meta data to accommodation posts
	 *
	 * @param int $accommodation_id Accommodation post ID
	 * @param int $index Index for generating varied data
	 */
	private static function add_accommodation_meta($accommodation_id, $index)
	{
		$sample_ratings = ['3', '4', '5', '4', '3'];
		$sample_types = ['hotel', 'lodge', 'guesthouse', 'resort', 'camp'];

		update_post_meta($accommodation_id, 'rating', $sample_ratings[($index - 1) % count($sample_ratings)]);
		update_post_meta($accommodation_id, 'type', $sample_types[($index - 1) % count($sample_types)]);
		update_post_meta($accommodation_id, 'featured', $index % 3 === 0 ? 'yes' : 'no');
	}

	/**
	 * Add sample meta data to destination posts
	 *
	 * @param int $destination_id Destination post ID
	 * @param int $index Index for generating varied data
	 */
	private static function add_destination_meta($destination_id, $index)
	{
		$sample_countries = ['South Africa', 'Kenya', 'Tanzania', 'Botswana', 'Zambia'];
		$sample_regions = ['Southern Africa', 'East Africa', 'West Africa', 'Central Africa'];

		update_post_meta($destination_id, 'country', $sample_countries[($index - 1) % count($sample_countries)]);
		update_post_meta($destination_id, 'region', $sample_regions[($index - 1) % count($sample_regions)]);
		update_post_meta($destination_id, 'featured', $index % 4 === 0 ? 'yes' : 'no');
	}

	/**
	 * Create a complete tour package with related posts
	 *
	 * @param array $args Arguments for the tour package
	 * @return array Tour package data
	 */
	public static function create_tour_package($args = [])
	{
		$defaults = [
			'destinations_count'    => 2,
			'accommodations_count' => 2,
			'tour_title'           => 'Complete Safari Package',
		];

		$args = wp_parse_args($args, $defaults);

		// Create destinations
		$destinations = self::create_destinations($args['destinations_count']);

		// Create accommodations
		$accommodations = self::create_accommodations($args['accommodations_count']);

		// Create main tour
		$tour_id = wp_insert_post([
			'post_title'   => $args['tour_title'],
			'post_content' => 'A complete tour package with destinations and accommodations.',
			'post_type'    => 'tour',
			'post_status'  => 'publish',
		]);

		// Link tour with destinations and accommodations (adjust based on your plugin's structure)
		if ($tour_id && ! is_wp_error($tour_id)) {
			update_post_meta($tour_id, 'destinations', $destinations);
			update_post_meta($tour_id, 'accommodations', $accommodations);
		}

		return [
			'tour_id'        => $tour_id,
			'destinations'   => $destinations,
			'accommodations' => $accommodations,
		];
	}

	/**
	 * Generate sample itinerary data
	 *
	 * @param int $days Number of days
	 * @return array Itinerary data
	 */
	public static function generate_itinerary($days = 7)
	{
		$itinerary = [];

		$sample_activities = [
			'Game drive in national park',
			'Cultural village visit',
			'Boat safari on the river',
			'Walking safari with guide',
			'Photography session',
			'Sunset viewing',
			'Local market visit',
			'Wildlife tracking',
		];

		for ($day = 1; $day <= $days; $day++) {
			$activity_count = rand(1, 3);
			$day_activities = array_rand(array_flip($sample_activities), $activity_count);

			if (! is_array($day_activities)) {
				$day_activities = [$day_activities];
			}

			$itinerary["day_{$day}"] = [
				'title'      => "Day {$day}",
				'activities' => $day_activities,
				'meals'      => ['breakfast', 'lunch', 'dinner'],
			];
		}

		return $itinerary;
	}

	/**
	 * Clean up all test data created by factory
	 */
	public static function clean_up()
	{
		// Get all posts created by the factory
		$post_types = ['tour', 'accommodation', 'destination'];

		foreach ($post_types as $post_type) {
			$posts = get_posts([
				'post_type'      => $post_type,
				'posts_per_page' => -1,
				'post_status'    => 'any',
				'meta_query'     => [
					[
						'key'     => '_test_data',
						'value'   => 'tour_operator_factory',
						'compare' => '=',
					],
				],
			]);

			foreach ($posts as $post) {
				wp_delete_post($post->ID, true);
			}
		}

		// Clean up any orphaned meta data
		wp_cache_flush();
	}
}
