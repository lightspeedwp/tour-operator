/**
 * Check In Time Block Variation
 *
 * Registers a block variation for accommodation check-in time display.
 * Only available on accommodation post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';

function registerCheckinTimeVariation() {
    try {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/checkin-time',
            title: __('Check in time', 'tour-operator'),
            icon: 'clock',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.name === variationAttributes.metadata?.name;
            },
            attributes: {
                metadata: {
                    name: 'Check in time',
                },
                className: 'lsx-checkin-time-wrapper',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
                },
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
                                iconType: 'solid',
                                iconName: 'checkInAccommodationIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: __(
                                    'Check in time:',
                                    'tour-operator'
                                ),
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
                                                key: 'checkin_time',
                                            },
                                        },
                                    },
                                },
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
                        name: 'Check in time',
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
                                    content: 'Check in time',
                                    level: 3,
                                },
                            ],
                            [
                                'core/paragraph',
                                {
                                    content: '11:00 AM',
                                },
                            ],
                        ],
                    ],
                ],
            },
        });
        return true;
    } catch (error) {
        console.error('Failed to register checkin-time block:', error);
        return false;
    }
}

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['accommodation'];
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

        if (supportedPostTypes.includes(postType) || ((postType === 'wp_template' || postType === 'wp_template_part') && postSlug.includes('accommodation'))) {
            registerCheckinTimeVariation();
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
