/**
 * Playwright Configuration for Tour Operator Plugin
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

const { defineConfig, devices } = require('@playwright/test');

/**
 * Read environment variables for WordPress test environment
 * These should match your local WordPress installation
 */
const baseURL = process.env.WP_BASE_URL || 'http://localhost:8888';
const adminUsername = process.env.WP_ADMIN_USER || 'admin';
const adminPassword = process.env.WP_ADMIN_PASS || 'password';

/**
 * Playwright Test Configuration
 *
 * @see https://playwright.dev/docs/test-configuration
 */
module.exports = defineConfig({
	testDir: './tests/e2e',

	/**
	 * Maximum time one test can run for
	 */
	timeout: 60 * 1000,

	/**
	 * Test execution settings
	 */
	fullyParallel: false, // Run tests in series for WordPress
	forbidOnly: !!process.env.CI, // Fail if test.only in CI
	retries: process.env.CI ? 2 : 0, // Retry on CI failures
	workers: 1, // Single worker for WordPress (avoids conflicts)

	/**
	 * Reporter configuration
	 */
	reporter: [
		['html', { open: 'never' }],
		['list'],
		...(process.env.CI ? [['github']] : []),
	],

	/**
	 * Shared test configuration
	 */
	use: {
		baseURL,
		trace: 'on-first-retry',
		screenshot: 'only-on-failure',
		video: 'retain-on-failure',

		/**
		 * WordPress-specific configuration
		 */
		storageState: {
			cookies: [],
			origins: [],
		},
	},

	/**
	 * Test projects (browsers)
	 */
	projects: [
		{
			name: 'chromium',
			use: { ...devices['Desktop Chrome'] },
		},

		// Uncomment to test in additional browsers
		// {
		// 	name: 'firefox',
		// 	use: { ...devices['Desktop Firefox'] },
		// },
		// {
		// 	name: 'webkit',
		// 	use: { ...devices['Desktop Safari'] },
		// },
	],

	/**
	 * WordPress E2E Test Utils Configuration
	 */
	globalSetup: require.resolve(
		'@wordpress/e2e-test-utils-playwright/playwright.config'
	),

	/**
	 * Environment setup for @wordpress/e2e-test-utils-playwright
	 */
	env: {
		WP_BASE_URL: baseURL,
		WP_ADMIN_USER: adminUsername,
		WP_ADMIN_PASS: adminPassword,
	},

	/**
	 * Web server configuration (optional - if you want Playwright to start WordPress)
	 * Comment out if your WordPress is already running
	 */
	// webServer: {
	// 	command: 'npm run wp-env start',
	// 	port: 8888,
	// 	timeout: 120 * 1000,
	// 	reuseExistingServer: !process.env.CI,
	// },
});
