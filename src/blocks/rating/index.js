/**
 * Rating Block Variation
 *
 * Registers a block variation for displaying accommodation and tour ratings.
 * Only available on accommodation and tour post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerRatingVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/rating',
            title: __('Rating', 'tour-operator'),
            description: __('Displays rating and star classification for accommodations.', 'tour-operator'),
            icon: 'star-empty',
            category: 'lsx-tour-operator',
            keywords: [
                __('rating', 'tour-operator'),
                __('stars', 'tour-operator'),
                __('classification', 'tour-operator'),
                __('quality', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: 'Rating',
                },
                className: 'lsx-rating-wrapper',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
                },
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        metadata: {
                            name: __('Title', 'tour-operator'),
                        },
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
                                iconName: 'ratingIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '<strong>' + __('Rating:', 'tour-operator') + '</strong>',
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {
                        metadata: {
                            name: __('Rating Content', 'tour-operator'),
                        },
                        layout: {
                            type: 'flex',
                            flexWrap: 'nowrap',
                            verticalAlignment: 'bottom',
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
                                                key: 'rating',
                                            },
                                        },
                                    },
                                },
                            },
                        ],
                        [
                            'core/group',
                            {
                                metadata: {
                                    name: __('Rating Type', 'tour-operator'),
                                },
                                layout: {
                                    type: 'flex',
                                    flexWrap: 'nowrap',
                                },
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        content: '(',
                                    },
                                ],
                                [
                                    'core/paragraph',
                                    {
                                        metadata: {
                                            bindings: {
                                                content: {
                                                    source: 'lsx/post-meta',
                                                    args: {
                                                        key: 'rating_type',
                                                    },
                                                },
                                            },
                                        },
                                    },
                                ],
                                [
                                    'core/paragraph',
                                    {
                                        content: ')',
                                    },
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            example: {
                attributes: {
                    className: 'lsx-rating-wrapper',
                    layout: {
                        type: 'flex',
                        flexWrap: 'nowrap',
                    },
                },
                innerBlocks: [
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'flex',
                                flexWrap: 'nowrap',
                                verticalAlignment: 'middle',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'lsx-tour-operator/icons',
                                attributes: {
                                    iconType: 'solid',
                                    iconName: 'ratingIcon',
                                },
                            },
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: '<strong>' + __('Rating:', 'tour-operator') + '</strong>',
                                },
                            },
                        ],
                    },
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'flex',
                                flexWrap: 'nowrap',
                                verticalAlignment: 'middle',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: __('4.5', 'tour-operator'),
                                },
                            },
                            {
                                name: 'core/group',
                                attributes: {
                                    layout: {
                                        type: 'flex',
                                        flexWrap: 'nowrap',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '(',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('Star Rating', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: ')',
                                        },
                                    },
                                ],
                            },
                        ],
                    },
                ],
            },
        });
    };

    // Initialize conditional registration for accommodation context
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['accommodation'], // Supported post types
        ['accommodation'], // Template slug patterns
        registerRatingVariation
    );

    conditionalRegister();
});
