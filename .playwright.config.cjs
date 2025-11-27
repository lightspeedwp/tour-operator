const { defineConfig, devices } = require( '@playwright/test' );

/**
 * Playwright configuration for Tour Operator Plugin E2E tests
 * @see https://playwright.dev/docs/test-configuration
 */
module.exports = defineConfig( {
    testDir: './tests/e2e',
    /* Run tests in files in parallel */
    fullyParallel: true,
    /* Fail the build on CI if you accidentally left test.only in the source code. */
    forbidOnly: !! process.env.CI,
    /* Retry on CI only */
    retries: process.env.CI ? 2 : 0,
    /* Opt out of parallel tests on CI. */
    workers: process.env.CI ? 1 : undefined,
    /* Reporter to use. See https://playwright.dev/docs/test-reporters */
    reporter: 'html',
    /* Shared settings for all the projects below. See https://playwright.dev/docs/api/class-testoptions. */
    use: {
        /* Base URL to use in actions like `await page.goto('/')`. */
        baseURL: process.env.WP_BASE_URL || 'http://localhost:8889',

        /* Collect trace when retrying the failed test. See https://playwright.dev/docs/trace-viewer */
        trace: 'on-first-retry',

        /* Take screenshot on failure */
        screenshot: 'only-on-failure',

        /* Global timeout for each test */
        actionTimeout: 15000,
    },

    /* Global test timeout - longer for complex tour operations */
    timeout: 45000,

    /* Configure projects for major browsers */
    projects: [
        {
            name: 'chromium',
            use: { ...devices[ 'Desktop Chrome' ] },
        },

        {
            name: 'firefox',
            use: { ...devices[ 'Desktop Firefox' ] },
        },

        {
            name: 'webkit',
            use: { ...devices[ 'Desktop Safari' ] },
        },

        /* Test against mobile viewports for tour booking */
        {
            name: 'Mobile Chrome',
            use: { ...devices[ 'Pixel 5' ] },
        },
        {
            name: 'Mobile Safari',
            use: { ...devices[ 'iPhone 12' ] },
        },

        /* Test against tablet viewports for tour galleries */
        {
            name: 'Tablet',
            use: { ...devices[ 'iPad Pro' ] },
        },
    ],

    /* Run your local dev server before starting the tests */
    webServer: process.env.CI
        ? undefined
        : {
              command: 'npm run start',
              url: 'http://localhost:8889',
              reuseExistingServer: ! process.env.CI,
          },
} );
