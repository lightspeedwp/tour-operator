<?php

/**
 * Simple Unit Tests that don't require WordPress environment
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

use PHPUnit\Framework\TestCase;

class TestSimpleFunctions extends TestCase
{

	/**
	 * Test that PHP version meets minimum requirement
	 */
	public function test_php_version()
	{
		$this->assertTrue(version_compare(PHP_VERSION, '8.0', '>='), 'PHP version should be 8.0 or higher');
	}

	/**
	 * Test basic PHP functionality
	 */
	public function test_basic_php_functions()
	{
		$this->assertTrue(function_exists('array_map'), 'array_map function should exist');
		$this->assertTrue(function_exists('json_encode'), 'json_encode function should exist');
		$this->assertTrue(class_exists('DateTime'), 'DateTime class should exist');
	}

	/**
	 * Test string manipulation
	 */
	public function test_string_functions()
	{
		$test_string = 'Tour Operator Plugin';

		$this->assertEquals('tour-operator-plugin', $this->slugify($test_string));
		$this->assertEquals('Tour Operator Plugin', $this->sanitize_title($test_string));
	}

	/**
	 * Test array functions
	 */
	public function test_array_functions()
	{
		$tours = [
			['id' => 1, 'title' => 'Safari Tour', 'price' => 1500],
			['id' => 2, 'title' => 'City Tour', 'price' => 800],
			['id' => 3, 'title' => 'Mountain Trek', 'price' => 1200],
		];

		// Test filtering
		$expensive_tours = array_filter($tours, function ($tour) {
			return $tour['price'] > 1000;
		});

		$this->assertCount(2, $expensive_tours);

		// Test sorting
		$sorted_tours = $this->sort_tours_by_price($tours);
		$this->assertEquals(800, $sorted_tours[0]['price']);
		$this->assertEquals(1500, $sorted_tours[2]['price']);
	}

	/**
	 * Helper function to create slug from title
	 */
	private function slugify($text)
	{
		return strtolower(str_replace(' ', '-', $text));
	}

	/**
	 * Helper function to sanitize title
	 */
	private function sanitize_title($text)
	{
		return trim($text);
	}

	/**
	 * Helper function to sort tours by price
	 */
	private function sort_tours_by_price($tours)
	{
		usort($tours, function ($a, $b) {
			return $a['price'] <=> $b['price'];
		});
		return $tours;
	}

	/**
	 * Test JSON handling
	 */
	public function test_json_functions()
	{
		$tour_data = [
			'title' => 'Test Tour',
			'price' => 1000,
			'destinations' => ['Cape Town', 'Kruger Park'],
		];

		$json = json_encode($tour_data);
		$this->assertIsString($json);

		$decoded = json_decode($json, true);
		$this->assertEquals($tour_data, $decoded);
	}

	/**
	 * Test date functions
	 */
	public function test_date_functions()
	{
		$date = new DateTime();
		$this->assertInstanceOf(DateTime::class, $date);

		$formatted_date = $date->format('Y-m-d');
		$this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $formatted_date);
	}
}
