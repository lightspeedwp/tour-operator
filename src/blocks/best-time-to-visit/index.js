/**
 * Best Time to Visit Block Variation
 *
 * Registers a block variation for destination best time to visit display.
 * Only available on destination post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';

function registerBestTimeToVisitVariation() {
    try {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/best-time-to-visit',
            title: __('Best time to visit', 'tour-operator'),
            icon: 'calendar-alt',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.name === variationAttributes.metadata?.name;
            },
            attributes: {
                metadata: {
                    name: __('Best time to visit', 'tour-operator'),
                },
                className: 'lsx-best-time-to-visit-wrapper',
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        layout: {
                            type: 'flex',
                            flexWrap: 'nowrap',
                            verticalAlignment: 'middle',
                        },
                    },
                    [
                        [
                            'lsx-tour-operator/icons',
                            {
                                iconName: 'bestMonthsToTravelIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: `<strong>${__('Best months to visit', 'tour-operator')}</strong>`,
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {
                        layout: {
                            type: 'flex',
                            flexWrap: 'nowrap',
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
                                                key: 'best_time_to_visit',
                                            },
                                        },
                                    },
                                },
                                content: __('Best months to visit', 'tour-operator'),
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
                        name: __('Best time to visit', 'tour-operator'),
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
                                    content: __('Best months to visit', 'tour-operator'),
                                    level: 3,
                                },
                            ],
                            [
                                'core/paragraph',
                                {
                                    content: 'January, February, March',
                                },
                            ],
                        ],
                    ],
                ],
            },
        });
        return true;
    } catch (error) {
        console.error('Failed to register best-time-to-visit block:', error);
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
            registerBestTimeToVisitVariation();
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
