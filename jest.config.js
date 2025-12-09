/**
 * Jest configuration for Tour Operator Plugin
 */
module.exports = {
    preset: '@wordpress/jest-preset-default',
    testMatch: [
        '**/tests/js/**/*.test.js',
    ],
    testPathIgnorePatterns: [
        '/node_modules/',
        '/vendor/',
        '/build/',
        '/tests/e2e/',
    ],
    setupFiles: ['<rootDir>/tests/js/setup.js'],
    testEnvironment: 'jsdom',
    transformIgnorePatterns: [
        'node_modules/(?!(@wordpress)/)',
    ],
};
