/**
 * Visa Block Variation
 *
 * Registers a block variation for destination visa information display.
 * Only available on destination post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';

function registerVisaVariation() {
    try {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/visa',
            title: __('Visa', 'tour-operator'),
            icon: 'id-alt',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes) =>
                blockAttributes?.className?.includes('lsx-visa-wrapper'),
            attributes: {
                metadata: {
                    name: __('Visa', 'tour-operator'),
                },
                className: 'lsx-visa-wrapper',
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
                                        content: `<strong>${__('Visa', 'tour-operator')}</strong>`,
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
                                                        key: 'visa',
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
                        name: __('Visa', 'tour-operator'),
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
                                    content: __('Visa', 'tour-operator'),
                                    level: 3,
                                },
                            ],
                            [
                                'core/paragraph',
                                {
                                    content: __('Visa requirements and information.', 'tour-operator'),
                                },
                            ],
                        ],
                    ],
                ],
            },
        });
        return true;
    } catch (error) {
        console.error('Failed to register visa block:', error);
        return false;
    }
}

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['destination'];
    let registered = false;

    // Check if current post type is supported
    const checkAndRegister = () => {
        if (registered) {
            return true;
        }

        const postType = select('core/editor')?.getCurrentPostType();
        const postSlug = select('core/editor')?.getEditedPostSlug();

        if (!postType || !postSlug) {
            return false;
        }

        if (supportedPostTypes.includes(postType) || ((postType === 'wp_template' || postType === 'wp_template_part') && (postSlug.includes('destination') || postSlug.includes('country') || postSlug.includes('region')))) {
            registerVisaVariation();
            registered = true;
        }

        return registered;
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
