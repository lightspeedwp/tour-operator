/**
 * Conditional Block Registration Utility
 *
 * Provides a unified way to conditionally register WordPress block variations
 * based on post types and template slugs.
 */

/**
 * Creates a conditional block registration handler
 *
 * @param {Object} config - Configuration object
 * @param {string[]} config.postTypes - Array of post types that support the block
 * @param {string[]} config.templateSlugs - Array of template slug patterns to match
 * @param {Function} config.registerFunction - Function to call when conditions are met
 * @param {number} [config.timeout=100] - Initial timeout before checking registration
 *
 * @return {Function} A function that handles the conditional registration logic
 */
export function createConditionalRegistration(config) {
    const {
        postTypes = [],
        templateSlugs = [],
        registerFunction,
        timeout = 100,
    } = config;

    if (!registerFunction || typeof registerFunction !== 'function') {
        throw new Error('registerFunction is required and must be a function');
    }

    return function conditionallyRegister() {
        const { select } = wp.data;
        let registered = false;
        let checking = false;

        /**
         * Check if current context matches the registration criteria
         *
         * @return {boolean} True if block should be registered
         */
        const shouldRegister = () => {
            try {
                const postType = select('core/editor')?.getCurrentPostType();
                const postSlug = select('core/editor')?.getEditedPostSlug();

                if (!postType) {
                    return false;
                }

                // Check direct post type match
                if (postTypes.includes(postType)) {
                    return true;
                }

                // Check template context
                const isTemplateContext = postType === 'wp_template' || postType === 'wp_template_part';

                if (isTemplateContext && postSlug && templateSlugs.length > 0) {
                    return templateSlugs.some(slugPattern => {
                        if (typeof slugPattern === 'string') {
                            return postSlug.includes(slugPattern);
                        }
                        if (slugPattern instanceof RegExp) {
                            return slugPattern.test(postSlug);
                        }
                        return false;
                    });
                }

                return false;
            } catch (error) {
                console.error('Error in shouldRegister:', error);
                return false;
            }
        };

        /**
         * Attempt to register the block if conditions are met
         *
         * @return {boolean} True if registration was successful
         */
        const checkAndRegister = () => {
            if (registered || checking) {
                return registered;
            }

            checking = true;

            if (shouldRegister()) {
                try {
                    registerFunction();
                    registered = true;
                    checking = false;
                    return true;
                } catch (error) {
                    console.error('Error during block registration:', error);
                    checking = false;
                    return false;
                }
            }

            checking = false;
            return false;
        };

        // Try initial registration with timeout
        setTimeout(() => {
            if (!checkAndRegister()) {
                // Subscribe to editor changes if initial check failed
                let unsubscribed = false;
                const unsubscribe = wp.data.subscribe(() => {
                    if (unsubscribed) {
                        return;
                    }

                    if (checkAndRegister()) {
                        unsubscribed = true;
                        unsubscribe();
                    }
                });
            }
        }, timeout);
    };
}

/**
 * Simplified registration for blocks that only support specific post types
 *
 * @param {string[]} postTypes - Array of supported post types
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
export function registerForPostTypes(postTypes, registerFunction, options = {}) {
    return createConditionalRegistration({
        postTypes,
        registerFunction,
        ...options,
    });
}

/**
 * Simplified registration for blocks that support templates with specific slug patterns
 *
 * @param {string[]} templateSlugs - Array of template slug patterns
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
export function registerForTemplates(templateSlugs, registerFunction, options = {}) {
    return createConditionalRegistration({
        templateSlugs,
        registerFunction,
        ...options,
    });
}

/**
 * Registration for blocks that support both post types and template patterns
 *
 * @param {string[]} postTypes - Array of supported post types
 * @param {string[]} templateSlugs - Array of template slug patterns
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
export function registerForPostTypesAndTemplates(postTypes, templateSlugs, registerFunction, options = {}) {
    return createConditionalRegistration({
        postTypes,
        templateSlugs,
        registerFunction,
        ...options,
    });
}
