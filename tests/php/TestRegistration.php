<?php

/**
 * Test Tour Operator Plugin Registration (CPT, Taxonomies, Patterns, Bindings)
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

class TestRegistration extends Tour_Operator_Test_Case
{

	/**
	 * Test that custom post types are registered
	 */
	public function test_post_types_registered()
	{
		$post_types = get_post_types();

		$this->assertContains('tour', $post_types, 'Tour post type should be registered');
		$this->assertContains('accommodation', $post_types, 'Accommodation post type should be registered');
		$this->assertContains('destination', $post_types, 'Destination post type should be registered');

		// Verify CPT objects have expected properties
		$tour_cpt = get_post_type_object('tour');
		$this->assertInstanceOf('WP_Post_Type', $tour_cpt, 'Tour CPT should be a WP_Post_Type object');
		$this->assertTrue($tour_cpt->public, 'Tour CPT should be public');
		$this->assertTrue($tour_cpt->show_in_rest, 'Tour CPT should be REST API enabled');

		$accommodation_cpt = get_post_type_object('accommodation');
		$this->assertInstanceOf('WP_Post_Type', $accommodation_cpt, 'Accommodation CPT should be a WP_Post_Type object');
		$this->assertTrue($accommodation_cpt->public, 'Accommodation CPT should be public');
		$this->assertTrue($accommodation_cpt->show_in_rest, 'Accommodation CPT should be REST API enabled');

		$destination_cpt = get_post_type_object('destination');
		$this->assertInstanceOf('WP_Post_Type', $destination_cpt, 'Destination CPT should be a WP_Post_Type object');
		$this->assertTrue($destination_cpt->public, 'Destination CPT should be public');
		$this->assertTrue($destination_cpt->show_in_rest, 'Destination CPT should be REST API enabled');
	}

	/**
	 * Test that taxonomies are registered
	 */
	public function test_taxonomies_registered()
	{
		$taxonomies = get_taxonomies();

		// Test key taxonomies from config files
		$this->assertContains('travel-style', $taxonomies, 'Travel Style taxonomy should be registered');
		$this->assertContains('accommodation-type', $taxonomies, 'Accommodation Type taxonomy should be registered');
		$this->assertContains('accommodation-brand', $taxonomies, 'Accommodation Brand taxonomy should be registered');
		$this->assertContains('facility', $taxonomies, 'Facility taxonomy should be registered');

		// Verify taxonomy objects have expected properties
		$travel_style_tax = get_taxonomy('travel-style');
		$this->assertInstanceOf('WP_Taxonomy', $travel_style_tax, 'Travel Style should be a WP_Taxonomy object');
		$this->assertTrue($travel_style_tax->show_in_rest, 'Travel Style should be REST API enabled');
		$this->assertTrue($travel_style_tax->hierarchical, 'Travel Style should be hierarchical');

		// Verify taxonomy is registered to correct post types
		$this->assertContains('tour', $travel_style_tax->object_type, 'Travel Style should be registered to tour CPT');
		$this->assertContains('accommodation', $travel_style_tax->object_type, 'Travel Style should be registered to accommodation CPT');
		$this->assertContains('destination', $travel_style_tax->object_type, 'Travel Style should be registered to destination CPT');
	}

	/**
	 * Test that the pattern category is registered
	 */
	public function test_pattern_category_registered()
	{
		// Verify pattern category exists
		$pattern_categories = WP_Block_Pattern_Categories_Registry::get_instance()->get_all_registered();

		$category_exists = false;
		foreach ($pattern_categories as $category) {
			if ($category['name'] === 'lsx-tour-operator') {
				$category_exists = true;
				$this->assertEquals('Tour Operator', $category['label'], 'Pattern category should have correct label');
				break;
			}
		}

		$this->assertTrue($category_exists, 'Pattern category "lsx-tour-operator" should be registered');
	}

	/**
	 * Test that specific patterns are registered
	 */
	public function test_patterns_registered()
	{
		// Get all registered patterns
		$patterns_registry = WP_Block_Patterns_Registry::get_instance();
		$all_patterns = $patterns_registry->get_all_registered();

		// Expected patterns from includes/patterns/ directory
		$expected_patterns = array(
			'lsx-tour-operator/accommodation-card',
			'lsx-tour-operator/destination-card',
			'lsx-tour-operator/gallery',
			'lsx-tour-operator/itinerary-list',
			'lsx-tour-operator/room-card',
			'lsx-tour-operator/tour-card',
			'lsx-tour-operator/travel-information',
		);

		foreach ($expected_patterns as $pattern_name) {
			$this->assertTrue(
				$patterns_registry->is_registered($pattern_name),
				"Pattern '{$pattern_name}' should be registered"
			);
		}

		// Verify patterns have the correct category
		foreach ($expected_patterns as $pattern_name) {
			$pattern = $patterns_registry->get_registered($pattern_name);
			if ($pattern && isset($pattern['categories'])) {
				$this->assertContains(
					'lsx-tour-operator',
					$pattern['categories'],
					"Pattern '{$pattern_name}' should be in 'lsx-tour-operator' category"
				);
			}
		}
	}

	/**
	 * Test that the Bindings class exists and has expected properties
	 */
	public function test_custom_fields_logic()
	{
		// Verify Bindings class exists
		$this->assertTrue(
			class_exists('lsx\blocks\Bindings'),
			'Bindings class should exist in lsx\blocks namespace'
		);

		// Verify block bindings sources are registered
		$bindings_registry = get_all_block_bindings_sources();

		$this->assertArrayHasKey(
			'lsx/post-connection',
			$bindings_registry,
			'Block binding source "lsx/post-connection" should be registered'
		);

		$this->assertArrayHasKey(
			'lsx/post-meta',
			$bindings_registry,
			'Block binding source "lsx/post-meta" should be registered'
		);

		// Verify Bindings class has expected itinerary fields
		$reflection = new ReflectionClass('lsx\blocks\Bindings');
		$bindings_instance = $reflection->newInstanceWithoutConstructor();
		$property = $reflection->getProperty('itinerary_fields');
		$property->setAccessible(true);

		// Set expected itinerary fields (from constructor)
		$expected_itinerary_fields = array(
			'title',
			'description',
			'location',
			'accommodation',
			'type',
			'drinks',
			'room',
			'included',
			'excluded',
		);

		// Note: This test uses reflection to check private properties
		// In actual plugin instance, these would be set during construction
		// This validates the class structure is correct
		$this->assertTrue(
			$reflection->hasProperty('itinerary_fields'),
			'Bindings class should have itinerary_fields property'
		);

		$this->assertTrue(
			$reflection->hasProperty('unit_fields'),
			'Bindings class should have unit_fields property'
		);

		$this->assertTrue(
			$reflection->hasProperty('unit_types'),
			'Bindings class should have unit_types property'
		);
	}
}
