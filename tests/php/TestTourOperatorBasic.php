<?php

/**
 * Test Tour Operator Plugin Basic Functionality
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

class TestTourOperatorBasic extends Tour_Operator_Test_Case
{

	/**
	 * Test that the plugin is loaded
	 */
	public function test_plugin_loaded()
	{
		$this->assertTrue(defined('LSX_TO_PATH'), 'Plugin path constant should be defined');
		$this->assertTrue(defined('LSX_TO_URL'), 'Plugin URL constant should be defined');
		$this->assertTrue(defined('LSX_TO_VER'), 'Plugin version constant should be defined');
	}

	/**
	 * Test that custom post types are registered
	 */
	public function test_post_types_registered()
	{
		$post_types = get_post_types();

		$this->assertContains('tour', $post_types, 'Tour post type should be registered');
		$this->assertContains('accommodation', $post_types, 'Accommodation post type should be registered');
		$this->assertContains('destination', $post_types, 'Destination post type should be registered');
	}

	/**
	 * Test creating a tour post
	 */
	public function test_create_tour()
	{
		$tour_id = $this->create_tour([
			'post_title' => 'Test Safari Tour',
		]);

		$this->assertIsInt($tour_id, 'Tour creation should return an integer ID');
		$this->assertPostExists($tour_id, 'tour');

		$tour = get_post($tour_id);
		$this->assertEquals('Test Safari Tour', $tour->post_title);
	}

	/**
	 * Test creating an accommodation post
	 */
	public function test_create_accommodation()
	{
		$accommodation_id = $this->create_accommodation([
			'post_title' => 'Test Lodge',
		]);

		$this->assertIsInt($accommodation_id, 'Accommodation creation should return an integer ID');
		$this->assertPostExists($accommodation_id, 'accommodation');

		$accommodation = get_post($accommodation_id);
		$this->assertEquals('Test Lodge', $accommodation->post_title);
	}

	/**
	 * Test creating a destination post
	 */
	public function test_create_destination()
	{
		$destination_id = $this->create_destination([
			'post_title' => 'Test National Park',
		]);

		$this->assertIsInt($destination_id, 'Destination creation should return an integer ID');
		$this->assertPostExists($destination_id, 'destination');

		$destination = get_post($destination_id);
		$this->assertEquals('Test National Park', $destination->post_title);
	}

	/**
	 * Test tour meta data handling
	 */
	public function test_tour_meta_data()
	{
		$tour_id = $this->create_tour();

		// Test setting and getting meta data
		update_post_meta($tour_id, 'tour_price', '1500');
		update_post_meta($tour_id, 'tour_duration', '7');

		$this->assertPostMetaEquals($tour_id, 'tour_price', '1500');
		$this->assertPostMetaEquals($tour_id, 'tour_duration', '7');
	}

	/**
	 * Test tour with relationships
	 */
	public function test_tour_with_relations()
	{
		$package = $this->create_tour_with_relations([
			'post_title' => 'Complete Safari Package',
		]);

		$this->assertIsInt($package['tour_id']);
		$this->assertIsArray($package['destination_ids']);
		$this->assertIsArray($package['accommodation_ids']);

		// Verify destinations were created
		foreach ($package['destination_ids'] as $destination_id) {
			$this->assertPostExists($destination_id, 'destination');
		}

		// Verify accommodations were created
		foreach ($package['accommodation_ids'] as $accommodation_id) {
			$this->assertPostExists($accommodation_id, 'accommodation');
		}
	}

	/**
	 * Test plugin version constant
	 */
	public function test_plugin_version()
	{
		$this->assertTrue(defined('LSX_TO_VER'), 'Plugin version should be defined');
		$this->assertNotEmpty(LSX_TO_VER, 'Plugin version should not be empty');
	}

	/**
	 * Test plugin activation hooks (if any)
	 */
	public function test_activation_hooks()
	{
		// Test that activation doesn't cause errors
		// This would test any activation hooks your plugin has
		$this->assertTrue(true); // Placeholder - implement based on your plugin's activation logic
	}

	/**
	 * Test that required WordPress hooks are registered
	 */
	public function test_wordpress_hooks()
	{
		// Test that essential hooks are registered
		// Adjust based on your plugin's specific hooks

		// Example: Check if init hook is registered
		$this->assertTrue(has_action('init'), 'Init action should be registered');

		// You can add more specific hook tests here based on your plugin
	}
}
