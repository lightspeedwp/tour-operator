/**
 * Test conditional block registration utility
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

import {
	createConditionalRegistration,
	registerForPostTypes,
	registerForTemplates,
	registerForPostTypesAndTemplates,
} from '../../src/js/conditional-block-registration';

// Mock WordPress data module
const mockSelect = jest.fn();
const mockSubscribe = jest.fn();

global.wp = {
	data: {
		select: mockSelect,
		subscribe: mockSubscribe,
	},
};

describe('Conditional Block Registration', () => {
	beforeEach(() => {
		jest.clearAllMocks();
		jest.useFakeTimers();
	});

	afterEach(() => {
		jest.runOnlyPendingTimers();
		jest.useRealTimers();
	});

	describe('createConditionalRegistration', () => {
		it('should export createConditionalRegistration function', () => {
			expect(createConditionalRegistration).toBeDefined();
			expect(typeof createConditionalRegistration).toBe('function');
		});

		it('should throw error if registerFunction is not provided', () => {
			expect(() => {
				createConditionalRegistration({
					postTypes: ['tour'],
				});
			}).toThrow('registerFunction is required and must be a function');
		});

		it('should return a handler function', () => {
			const registerFn = jest.fn();
			const handler = createConditionalRegistration({
				postTypes: ['tour'],
				registerFunction: registerFn,
			});

			expect(typeof handler).toBe('function');
		});

		it('should register immediately for matching post type', () => {
			const registerFn = jest.fn();

			// Mock editor returning tour post type
			mockSelect.mockReturnValue({
				getCurrentPostType: () => 'tour',
				getEditedPostSlug: () => 'test-tour',
			});

			const handler = createConditionalRegistration({
				postTypes: ['tour'],
				registerFunction: registerFn,
			});

			handler();

			// Fast-forward past the initial timeout
			jest.advanceTimersByTime(100);

			expect(registerFn).toHaveBeenCalledTimes(1);
		});

		it('should not register for non-matching post type', () => {
			const registerFn = jest.fn();

			// Mock editor returning post post type (not tour)
			mockSelect.mockReturnValue({
				getCurrentPostType: () => 'post',
				getEditedPostSlug: () => 'test-post',
			});

			const handler = createConditionalRegistration({
				postTypes: ['tour'],
				registerFunction: registerFn,
			});

			handler();

			// Fast-forward past the initial timeout
			jest.advanceTimersByTime(100);

			expect(registerFn).not.toHaveBeenCalled();
		});

		it('should match template slug patterns', () => {
			const registerFn = jest.fn();

			// Mock template context
			mockSelect.mockReturnValue({
				getCurrentPostType: () => 'wp_template',
				getEditedPostSlug: () => 'single-tour',
			});

			const handler = createConditionalRegistration({
				templateSlugs: ['single-tour'],
				registerFunction: registerFn,
			});

			handler();

			// Fast-forward past the initial timeout
			jest.advanceTimersByTime(100);

			expect(registerFn).toHaveBeenCalledTimes(1);
		});

		it('should match partial template slug patterns', () => {
			const registerFn = jest.fn();

			// Mock template context with archive-tour slug
			mockSelect.mockReturnValue({
				getCurrentPostType: () => 'wp_template',
				getEditedPostSlug: () => 'archive-tour',
			});

			const handler = createConditionalRegistration({
				templateSlugs: ['tour'],
				registerFunction: registerFn,
			});

			handler();

			// Fast-forward past the initial timeout
			jest.advanceTimersByTime(100);

			expect(registerFn).toHaveBeenCalledTimes(1);
		});
	});

	describe('Helper Functions', () => {
		it('should export registerForPostTypes helper', () => {
			expect(registerForPostTypes).toBeDefined();
			expect(typeof registerForPostTypes).toBe('function');
		});

		it('should export registerForTemplates helper', () => {
			expect(registerForTemplates).toBeDefined();
			expect(typeof registerForTemplates).toBe('function');
		});

		it('should export registerForPostTypesAndTemplates helper', () => {
			expect(registerForPostTypesAndTemplates).toBeDefined();
			expect(typeof registerForPostTypesAndTemplates).toBe('function');
		});

		it('registerForPostTypes should create handler for post types', () => {
			const registerFn = jest.fn();

			// Mock editor with tour post type
			mockSelect.mockReturnValue({
				getCurrentPostType: () => 'tour',
				getEditedPostSlug: () => 'test-tour',
			});

			const handler = registerForPostTypes(['tour'], registerFn);
			handler();

			jest.advanceTimersByTime(100);

			expect(registerFn).toHaveBeenCalledTimes(1);
		});

		it('registerForTemplates should create handler for templates', () => {
			const registerFn = jest.fn();

			// Mock template context
			mockSelect.mockReturnValue({
				getCurrentPostType: () => 'wp_template',
				getEditedPostSlug: () => 'single-accommodation',
			});

			const handler = registerForTemplates(['accommodation'], registerFn);
			handler();

			jest.advanceTimersByTime(100);

			expect(registerFn).toHaveBeenCalledTimes(1);
		});
	});
});
