<?php

/**
 * Unit tests for Query_Loop's featured-query cache-generation logic.
 *
 * Runs without a WordPress environment (see TestSimpleFunctions.php for the same
 * approach): the handful of WP cache functions the class calls are stubbed with a
 * simple in-memory array so the actual class methods under test are exercised
 * directly, not a re-implementation of them.
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

use PHPUnit\Framework\TestCase;

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

if ( ! defined( 'HOUR_IN_SECONDS' ) ) {
	define( 'HOUR_IN_SECONDS', 3600 );
}

if ( ! function_exists( 'wp_cache_get' ) ) {
	function wp_cache_get( $key, $group = '' ) {
		$k = $group . ':' . $key;
		return $GLOBALS['__test_cache_store'][ $k ] ?? false;
	}
}

if ( ! function_exists( 'wp_cache_set' ) ) {
	function wp_cache_set( $key, $value, $group = '', $ttl = 0 ) {
		$k = $group . ':' . $key;
		$GLOBALS['__test_cache_store'][ $k ] = $value;
		return true;
	}
}

if ( ! function_exists( 'maybe_serialize' ) ) {
	function maybe_serialize( $data ) {
		return is_array( $data ) || is_object( $data ) ? serialize( $data ) : $data;
	}
}

if ( ! function_exists( 'wp_is_post_revision' ) ) {
	function wp_is_post_revision( $id ) {
		return false;
	}
}

if ( ! function_exists( 'wp_is_post_autosave' ) ) {
	function wp_is_post_autosave( $id ) {
		return false;
	}
}

require_once dirname( __DIR__, 2 ) . '/includes/classes/blocks/class-query-loop.php';

class TestQueryLoopFeaturedCache extends TestCase {

	private \ReflectionMethod $get_generation;
	private \ReflectionMethod $bump_generation;

	protected function setUp(): void {
		parent::setUp();
		// Each test gets a clean slate -- the generation counter lives in the same
		// in-memory store the stubbed wp_cache_* functions share globally.
		$GLOBALS['__test_cache_store'] = [];

		$this->get_generation = new \ReflectionMethod( \lsx\blocks\Query_Loop::class, 'get_featured_cache_generation' );
		$this->bump_generation = new \ReflectionMethod( \lsx\blocks\Query_Loop::class, 'bump_featured_cache_generation' );
	}

	public function test_generation_starts_at_one_when_nothing_cached() {
		$this->assertSame( 1, $this->get_generation->invoke( null ) );
	}

	public function test_bump_advances_the_generation() {
		$this->assertSame( 1, $this->get_generation->invoke( null ) );
		$this->bump_generation->invoke( null );
		$this->assertSame( 2, $this->get_generation->invoke( null ) );
	}

	public function test_bump_advances_monotonically_across_multiple_calls() {
		$this->bump_generation->invoke( null );
		$this->bump_generation->invoke( null );
		$this->assertSame( 3, $this->get_generation->invoke( null ) );
	}

	/**
	 * The actual bug this generation counter exists to prevent: without it, a
	 * cache key built only from the query args would keep resolving to a
	 * pre-invalidation result forever (or until FEATURED_CACHE_TTL expires),
	 * because nothing about the key itself changes when the underlying data does.
	 */
	public function test_a_cache_key_from_before_a_bump_never_resolves_after_it() {
		$query = [ 'post_type' => 'tour', 'meta_key' => 'featured' ];

		$generation_before = $this->get_generation->invoke( null );
		$key_before         = 'lsx_to_featured_' . $generation_before . '_' . md5( maybe_serialize( $query ) );
		wp_cache_set( $key_before, [ 'stale-result' ], \lsx\blocks\Query_Loop::FEATURED_CACHE_GROUP, HOUR_IN_SECONDS );

		$this->bump_generation->invoke( null );

		$generation_after = $this->get_generation->invoke( null );
		$key_after         = 'lsx_to_featured_' . $generation_after . '_' . md5( maybe_serialize( $query ) );

		$this->assertNotSame( $key_before, $key_after, 'cache key must change across a generation bump' );
		$this->assertFalse(
			wp_cache_get( $key_after, \lsx\blocks\Query_Loop::FEATURED_CACHE_GROUP ),
			'the post-bump key must not resolve to the pre-bump (stale) cached value'
		);
	}
}
