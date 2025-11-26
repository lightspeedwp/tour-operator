/**
 * Jest setup file for Tour Operator plugin
 * Configures test environment and global mocks
 */

// Mock WordPress globals
global.wp = {
	element: require('@wordpress/element'),
	blocks: require('@wordpress/blocks'),
	components: require('@wordpress/components'),
	i18n: require('@wordpress/i18n'),
	data: require('@wordpress/data'),
};

// Mock console methods in tests to reduce noise
global.console = {
	...console,
	error: jest.fn(),
	warning: jest.fn(),
};

// Set up test timeouts
jest.setTimeout(10000);
