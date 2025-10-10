/**
 * Safety Block Variation
 *
 * Registers block variations for destination safety display.
 * Only available on destination post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';

function registerSafetyVariation() {
    try {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/safety',
            title: __('Safety', 'tour-operator'),
            icon: 'shield',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes) =>
                blockAttributes?.className?.includes('lsx-safety-wrapper'),
            attributes: {
                metadata: {
                    name: __('Safety', 'tour-operator'),
                },
                className: 'lsx-safety-wrapper',
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        layout: {
                            type: 'constrained',
                        },
                    },
                    [
                        [
                            'core/group',
                            {
                                layout: {
                                    type: 'constrained',
                                },
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        align: 'center',
                                        content: `<strong>${__('Safety', 'tour-operator')}</strong>`,
                                    },
                                ],
                            ],
                        ],
                        [
                            'core/group',
                            {
                                layout: {
                                    type: 'constrained',
                                },
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        metadata: {
                                            bindings: {
                                                content: {
                                                    source: 'lsx/post-meta',
                                                    args: {
                                                        key: 'safety',
                                                    },
                                                },
                                            },
                                        },
                                    },
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'core/buttons',
                    {},
                    [
                        [
                            'core/button',
                            {
                                width: 100,
                                content: __('View More', 'tour-operator'),
                            },
                        ],
                    ],
                ],
            ],
            supports: {
                renaming: false,
            },
            example: {
                attributes: {
                    metadata: {
                        name: __('Safety', 'tour-operator'),
                    },
                },
                innerBlocks: [
                    [
                        'core/group',
                        {},
                        [
                            [
                                'core/heading',
                                {
                                    content: __('Safety', 'tour-operator'),
                                    level: 3,
                                },
                            ],
                            [
                                'core/paragraph',
                                {
                                    content: __('General safety information for travelers.', 'tour-operator'),
                                },
                            ],
                        ],
                    ],
                ],
            },
        });
        return true;
    } catch (error) {
        console.error('Failed to register safety block:', error);
        return false;
    }
}

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['destination'];
    let registeredSafety = false;

    // Check if current post type is supported
    const checkAndRegister = () => {
        if (registeredSafety) {
            return true;
        }

        const postType = select('core/editor')?.getCurrentPostType();
        const postSlug = select('core/editor')?.getEditedPostSlug();

        if (!postType) {
            return false;
        }

        const isTemplateContext =
            postType === 'wp_template' || postType === 'wp_template_part';

        if (
            supportedPostTypes.includes(postType) ||
            (isTemplateContext &&
                postSlug &&
                (postSlug.includes('destination') ||
                    postSlug.includes('country') ||
                    postSlug.includes('region')))
        ) {
            if (!registeredSafety) {
                registerSafetyVariation();
                registeredSafety = true;
            }
        }

        return registeredSafety;
    };

    // Try immediate registration
    if (!checkAndRegister()) {
        // If not ready, check periodically
        const interval = setInterval(() => {
            if (checkAndRegister()) {
                clearInterval(interval);
            }
        }, 100);

        // Clean up after 5 seconds to prevent infinite checking
        setTimeout(() => clearInterval(interval), 5000);
    }
});
