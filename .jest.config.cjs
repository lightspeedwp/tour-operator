/**
 * Jest configuration for Tour Operator plugin
 * Uses WordPress default preset for testing
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-jest-preset-default/
 */
module.exports = {
	preset: '@wordpress/jest-preset-default',

	// Test environment
	testEnvironment: 'jsdom',

	// Setup files
	setupFilesAfterEnv: [
		'<rootDir>/tests/js/setup.js',
	],

	// Test paths
	testMatch: [
		'<rootDir>/tests/js/**/*.test.[jt]s?(x)',
		'<rootDir>/src/**/__tests__/**/*.[jt]s?(x)',
	],

	// Coverage configuration
	collectCoverageFrom: [
		'src/**/*.{js,jsx,ts,tsx}',
		'!src/**/index.js',
		'!src/**/*.stories.{js,jsx,ts,tsx}',
		'!src/**/__tests__/**',
	],

	// Module paths
	moduleNameMapper: {
		'^@utils/(.*)$': '<rootDir>/src/js/$1',
		'\\.(css|less|scss|sass)$': 'identity-obj-proxy',
	},

	// Transform
	transform: {
		'^.+\\.[jt]sx?$': '<rootDir>/node_modules/@wordpress/scripts/config/babel-transform',
	},

	// Ignore patterns
	testPathIgnorePatterns: [
		'/node_modules/',
		'/vendor/',
		'/build/',
	],

	// Coverage thresholds
	coverageThreshold: {
		global: {
			branches: 50,
			functions: 50,
			lines: 50,
			statements: 50,
		},
	},
};
