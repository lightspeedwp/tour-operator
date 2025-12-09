<?php

/**
 * Base Test Case for Tour Operator Plugin
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

/**
 * Tour Operator Test Case Base Class
 *
 * Extends WP_UnitTestCase with Tour Operator specific functionality
 */
class Tour_Operator_Test_Case extends WP_UnitTestCase
{

	/**
	 * Set up before each test
	 */
	public function setUp(): void
	{
		parent::setUp();

		// Clear any cached data
		wp_cache_flush();

		// Reset query variables
		$GLOBALS['wp_query'] = new WP_Query();
		$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];

		// Ensure clean state for each test
		$this->clean_up_global_scope();
	}

	/**
	 * Tear down after each test
	 */
	public function tearDown(): void
	{
		parent::tearDown();

		// Clean up any created posts, terms, users, etc.
		$this->clean_up_global_scope();
		wp_cache_flush();
	}

	/**
	 * Create a tour post for testing
	 *
	 * @param array $args Post arguments to override defaults
	 * @return int|WP_Error Post ID on success, WP_Error on failure
	 */
	protected function create_tour($args = [])
	{
		$defaults = [
			'post_type'    => 'tour',
			'post_status'  => 'publish',
			'post_title'   => 'Test Tour',
			'post_content' => 'This is a test tour description.',
		];

		$args = wp_parse_args($args, $defaults);

		return wp_insert_post($args);
	}

	/**
	 * Create an accommodation post for testing
	 *
	 * @param array $args Post arguments to override defaults
	 * @return int|WP_Error Post ID on success, WP_Error on failure
	 */
	protected function create_accommodation($args = [])
	{
		$defaults = [
			'post_type'    => 'accommodation',
			'post_status'  => 'publish',
			'post_title'   => 'Test Accommodation',
			'post_content' => 'This is a test accommodation description.',
		];

		$args = wp_parse_args($args, $defaults);

		return wp_insert_post($args);
	}

	/**
	 * Create a destination post for testing
	 *
	 * @param array $args Post arguments to override defaults
	 * @return int|WP_Error Post ID on success, WP_Error on failure
	 */
	protected function create_destination($args = [])
	{
		$defaults = [
			'post_type'    => 'destination',
			'post_status'  => 'publish',
			'post_title'   => 'Test Destination',
			'post_content' => 'This is a test destination description.',
		];

		$args = wp_parse_args($args, $defaults);

		return wp_insert_post($args);
	}

	/**
	 * Create a tour with related destinations and accommodations
	 *
	 * @param array $args Tour arguments
	 * @return array Contains tour_id, destination_ids, accommodation_ids
	 */
	protected function create_tour_with_relations($args = [])
	{
		// Create destinations
		$destination_1 = $this->create_destination([
			'post_title' => 'Cape Town',
		]);
		$destination_2 = $this->create_destination([
			'post_title' => 'Kruger National Park',
		]);

		// Create accommodations
		$accommodation_1 = $this->create_accommodation([
			'post_title' => 'Safari Lodge',
		]);
		$accommodation_2 = $this->create_accommodation([
			'post_title' => 'City Hotel',
		]);

		// Create tour
		$tour_id = $this->create_tour($args);

		// Add relationships (this would depend on your plugin's specific implementation)
		// Example: add_post_meta( $tour_id, 'destinations', [ $destination_1, $destination_2 ] );
		// Example: add_post_meta( $tour_id, 'accommodations', [ $accommodation_1, $accommodation_2 ] );

		return [
			'tour_id'          => $tour_id,
			'destination_ids'  => [$destination_1, $destination_2],
			'accommodation_ids' => [$accommodation_1, $accommodation_2],
		];
	}

	/**
	 * Assert that a post exists and has the expected properties
	 *
	 * @param int    $post_id Post ID to check
	 * @param string $post_type Expected post type
	 * @param string $post_status Expected post status
	 */
	public function assertPostExists($post_id, $post_type = null, $post_status = 'publish')
	{
		$post = get_post($post_id);

		$this->assertInstanceOf('WP_Post', $post, 'Post should exist');

		if ($post_type) {
			$this->assertEquals($post_type, $post->post_type, "Post should be of type {$post_type}");
		}

		$this->assertEquals($post_status, $post->post_status, "Post should have status {$post_status}");
	}

	/**
	 * Assert that a meta value exists and matches expected value
	 *
	 * @param int    $post_id Post ID
	 * @param string $meta_key Meta key to check
	 * @param mixed  $expected_value Expected meta value
	 */
	public function assertPostMetaEquals($post_id, $meta_key, $expected_value)
	{
		$actual_value = get_post_meta($post_id, $meta_key, true);
		$this->assertEquals($expected_value, $actual_value, "Meta key {$meta_key} should equal expected value");
	}

	/**
	 * Assert that a shortcode renders expected output
	 *
	 * @param string $shortcode Shortcode to test
	 * @param string $expected Expected output (can be partial)
	 */
	public function assertShortcodeOutputContains($shortcode, $expected)
	{
		$output = do_shortcode($shortcode);
		$this->assertStringContainsString($expected, $output, "Shortcode output should contain expected content");
	}

	/**
	 * Assert that a hook is registered
	 *
	 * @param string $hook_name Hook name to check
	 * @param string $function_name Function name that should be hooked
	 * @param int    $priority Expected priority (optional)
	 */
	public function assertHookRegistered($hook_name, $function_name, $priority = null)
	{
		$this->assertTrue(has_action($hook_name, $function_name), "Hook {$hook_name} should have {$function_name} registered");

		if ($priority !== null) {
			$actual_priority = has_action($hook_name, $function_name);
			$this->assertEquals($priority, $actual_priority, "Hook {$hook_name} should have priority {$priority}");
		}
	}

	/**
	 * Clean up global scope
	 */
	protected function clean_up_global_scope()
	{
		$_GET = [];
		$_POST = [];
		$_REQUEST = [];

		unset($GLOBALS['post']);
		unset($GLOBALS['wp_query']);
		unset($GLOBALS['wp_the_query']);
	}

	/**
	 * Skip test if WooCommerce is not active
	 */
	protected function skipWithoutWooCommerce()
	{
		if (! class_exists('WooCommerce')) {
			$this->markTestSkipped('WooCommerce is not active');
		}
	}

	/**
	 * Skip test if specific plugin is not active
	 *
	 * @param string $plugin Plugin class or function to check
	 * @param string $plugin_name Human readable plugin name
	 */
	protected function skipWithoutPlugin($plugin, $plugin_name)
	{
		if (! class_exists($plugin) && ! function_exists($plugin)) {
			$this->markTestSkipped("{$plugin_name} is not active");
		}
	}
}
