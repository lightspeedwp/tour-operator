/**
 * Jest setup file for Tour Operator plugin
 * Configures test environment and global mocks
 */

// Mock WordPress globals - only include installed packages
global.wp = {
	element: require('@wordpress/element'),
	blocks: require('@wordpress/blocks'),
	i18n: require('@wordpress/i18n'),
	data: {
		select: jest.fn(),
		subscribe: jest.fn(),
	},
};

// Mock console methods in tests to reduce noise
global.console = {
	...console,
	error: jest.fn(),
	warning: jest.fn(),
};

// Set up test timeouts
jest.setTimeout(10000);
