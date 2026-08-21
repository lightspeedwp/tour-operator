<?php

/**
 * Unit tests for Query_Loop's featured-query cache-generation logic.
 *
 * Runs without a WordPress environment (see TestSimpleFunctions.php for the same
 * approach): the handful of WP functions the class calls are stubbed with a
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

if ( ! function_exists( 'get_transient' ) ) {
	/**
	 * Stub of WordPress's get_transient(), backed by an in-memory array instead
	 * of wp_options so these tests can run without a WordPress environment.
	 *
	 * @param string $key Transient name.
	 * @return mixed Stored value, or false if not set.
	 * @since 2.3.0
	 */
	function get_transient( $key ) {
		return $GLOBALS['__test_transient_store'][ $key ] ?? false;
	}
}

if ( ! function_exists( 'set_transient' ) ) {
	/**
	 * Stub of WordPress's set_transient(); TTL is accepted but not enforced,
	 * since these tests only assert on generation-based invalidation.
	 *
	 * @param string $key   Transient name.
	 * @param mixed  $value Value to store.
	 * @param int    $ttl   Time to live in seconds (unused by the stub).
	 * @return bool Always true.
	 * @since 2.3.0
	 */
	function set_transient( $key, $value, $ttl = 0 ) {
		$GLOBALS['__test_transient_store'][ $key ] = $value;
		return true;
	}
}

if ( ! function_exists( 'maybe_serialize' ) ) {
	/**
	 * Stub of WordPress's maybe_serialize().
	 *
	 * @param mixed $data Value to maybe serialize.
	 * @return mixed Serialized string for arrays/objects, the original value otherwise.
	 * @since 2.3.0
	 */
	function maybe_serialize( $data ) {
		return is_array( $data ) || is_object( $data ) ? serialize( $data ) : $data;
	}
}

if ( ! function_exists( 'wp_is_post_revision' ) ) {
	/**
	 * Stub of WordPress's wp_is_post_revision(); always false, since none of
	 * these tests exercise the revision-skip branch.
	 *
	 * @param int $id Post ID.
	 * @return bool Always false.
	 * @since 2.3.0
	 */
	function wp_is_post_revision( $id ) {
		return false;
	}
}

if ( ! function_exists( 'wp_is_post_autosave' ) ) {
	/**
	 * Stub of WordPress's wp_is_post_autosave(); always false, since none of
	 * these tests exercise the autosave-skip branch.
	 *
	 * @param int $id Post ID.
	 * @return bool Always false.
	 * @since 2.3.0
	 */
	function wp_is_post_autosave( $id ) {
		return false;
	}
}

if ( ! function_exists( 'get_option' ) ) {
	/**
	 * Stub of WordPress's get_option(), backed by an in-memory array instead
	 * of wp_options.
	 *
	 * @param string $option  Option name.
	 * @param mixed  $default Value to return if the option isn't set.
	 * @return mixed Stored value, or $default.
	 * @since 2.3.0
	 */
	function get_option( $option, $default = false ) {
		return $GLOBALS['__test_option_store'][ $option ] ?? $default;
	}
}

if ( ! function_exists( 'update_option' ) ) {
	/**
	 * Stub of WordPress's update_option(); autoload is accepted but not
	 * enforced, since these tests only assert on the stored value.
	 *
	 * @param string $option   Option name.
	 * @param mixed  $value    Value to store.
	 * @param bool   $autoload Autoload flag (unused by the stub).
	 * @return bool Always true.
	 * @since 2.3.0
	 */
	function update_option( $option, $value, $autoload = null ) {
		$GLOBALS['__test_option_store'][ $option ] = $value;
		return true;
	}
}

require_once dirname( __DIR__, 2 ) . '/includes/classes/blocks/class-query-loop.php';

/**
 * Tests for Query_Loop's featured-query cache-generation logic.
 *
 * @since 2.3.0
 */
class TestQueryLoopFeaturedCache extends TestCase {

	/**
	 * Reflection handle on Query_Loop::get_featured_cache_generation(), which
	 * is protected and has no other test-facing entry point.
	 *
	 * @var \ReflectionMethod
	 * @since 2.3.0
	 */
	private \ReflectionMethod $get_generation;

	/**
	 * Reflection handle on Query_Loop::bump_featured_cache_generation(), which
	 * is protected and has no other test-facing entry point.
	 *
	 * @var \ReflectionMethod
	 * @since 2.3.0
	 */
	private \ReflectionMethod $bump_generation;

	/**
	 * Reset the stubbed transient/option stores and re-bind the reflected
	 * methods before each test.
	 *
	 * @return void
	 * @since 2.3.0
	 */
	protected function setUp(): void {
		parent::setUp();
		// Each test gets a clean slate. The generation counter lives in the
		// stubbed options store (a real WP option, not a cache entry -- see the
		// class's own FEATURED_CACHE_GENERATION_OPTION docblock for why); the
		// cached featured-query results go through the stubbed transient
		// functions, which is what find_featured_items() itself now uses so the
		// cache is real even on a site with no persistent object cache.
		$GLOBALS['__test_transient_store'] = [];
		$GLOBALS['__test_option_store']    = [];

		$this->get_generation  = new \ReflectionMethod( \lsx\blocks\Query_Loop::class, 'get_featured_cache_generation' );
		$this->bump_generation = new \ReflectionMethod( \lsx\blocks\Query_Loop::class, 'bump_featured_cache_generation' );
	}

	/**
	 * A fresh option store has no generation recorded yet, so the getter must
	 * default to 1 rather than 0 or null.
	 *
	 * @return void
	 * @since 2.3.0
	 */
	public function test_generation_starts_at_one_when_nothing_cached() {
		$this->assertSame( 1, $this->get_generation->invoke( null ) );
	}

	/**
	 * A single bump must move the generation from 1 to 2.
	 *
	 * @return void
	 * @since 2.3.0
	 */
	public function test_bump_advances_the_generation() {
		$this->assertSame( 1, $this->get_generation->invoke( null ) );
		$this->bump_generation->invoke( null );
		$this->assertSame( 2, $this->get_generation->invoke( null ) );
	}

	/**
	 * Repeated bumps must keep advancing the generation rather than resetting
	 * or plateauing.
	 *
	 * @return void
	 * @since 2.3.0
	 */
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
	 *
	 * Mirrors find_featured_items()'s own key construction exactly (a single
	 * md5 of the generation plus the serialized query args) rather than
	 * re-deriving it differently here, since testing against a hand-rolled
	 * variant of the real key format wouldn't catch a mismatch between the two.
	 *
	 * @return void
	 * @since 2.3.0
	 */
	public function test_a_cache_key_from_before_a_bump_never_resolves_after_it() {
		$query = [
			'post_type' => 'tour',
			'meta_key'  => 'featured',
		];

		$generation_before = $this->get_generation->invoke( null );
		$key_before        = 'lsx_to_ft_' . md5( $generation_before . '_' . maybe_serialize( $query ) );
		set_transient( $key_before, [ 'stale-result' ], HOUR_IN_SECONDS );

		$this->bump_generation->invoke( null );

		$generation_after = $this->get_generation->invoke( null );
		$key_after        = 'lsx_to_ft_' . md5( $generation_after . '_' . maybe_serialize( $query ) );

		$this->assertNotSame( $key_before, $key_after, 'cache key must change across a generation bump' );
		$this->assertFalse(
			get_transient( $key_after ),
			'the post-bump key must not resolve to the pre-bump (stale) cached value'
		);
	}
}
