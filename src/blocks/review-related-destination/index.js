/**
 * Register Review Related Destination block variation
 */
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';
import { __ } from '@wordpress/i18n';

/**
 * Register the review related destination block variation
 */
function registerReviewRelatedDestinationVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/review-related-destination',
        title: __('Related Reviews', 'tour-operator'),
        icon: 'star-filled',
        description: __('Displays reviews related to this destination.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('reviews', 'tour-operator'),
            __('destination', 'tour-operator'),
            __('related', 'tour-operator'),
            __('testimonials', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Reviews', 'tour-operator'),
            },
            className: 'lsx-review-related-destination-query-wrapper',
            align: 'full',
            backgroundColor: 'primary-200',
            layout: {
                type: 'constrained',
            },
            tagName: 'section',
        },
        innerBlocks: [
            [
                'core/group',
                {
                    align: 'wide',
                    layout: { type: 'flex', flexWrap: 'nowrap' },
                },
                [
                    [
                        'core/separator',
                        {
                            style: {
                                layout: { selfStretch: 'fill', flexSize: null },
                            },
                        },
                    ],
                    [
                        'core/heading',
                        {
                            textAlign: 'center',
                            content: __('Reviews', 'tour-operator'),
                            level: 2,
                        },
                    ],
                    [
                        'core/separator',
                        {
                            style: {
                                layout: { selfStretch: 'fill', flexSize: null },
                            },
                        },
                    ],
                ],
            ],
            [
                'core/group',
                { align: 'wide', layout: { type: 'constrained' } },
                [
                    [
                        'core/query',
                        {
                            metadata: {
                                name: __('Related Reviews Query', 'tour-operator'),
                            },
                            query: {
                                perPage: 8,
                                postType: 'review',
                                order: 'desc',
                                orderBy: 'date',
                            },
                            align: 'wide',
                        },
                        [
                            [
                                'core/post-template',
                                {
                                    className: 'lsx-review-related-destination-query',
                                    layout: {
                                        type: 'grid',
                                        columnCount: 2,
                                    },
                                },
                                [
                                    [
                                        'core/pattern',
                                        {
                                            slug: 'lsx-tour-operator/review-card',
                                        },
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        example: {
            innerBlocks: [
                {
                    name: 'core/group',
                    attributes: {
                        align: 'wide',
                        layout: { type: 'flex', flexWrap: 'nowrap' },
                    },
                    innerBlocks: [
                        {
                            name: 'core/separator',
                            attributes: {
                                style: {
                                    layout: { selfStretch: 'fill', flexSize: null },
                                },
                            },
                        },
                        {
                            name: 'core/heading',
                            attributes: {
                                textAlign: 'center',
                                content: __('Reviews', 'tour-operator'),
                                level: 2,
                            },
                        },
                        {
                            name: 'core/separator',
                            attributes: {
                                style: {
                                    layout: { selfStretch: 'fill', flexSize: null },
                                },
                            },
                        },
                    ],
                },
                {
                    name: 'core/group',
                    attributes: {
                        align: 'wide',
                        layout: { type: 'constrained' },
                    },
                    innerBlocks: [
                        {
                            name: 'core/group',
                            attributes: {
                                className: 'lsx-review-related-destination-query',
                                layout: {
                                    type: 'grid',
                                    columnCount: 2,
                                },
                            },
                            innerBlocks: [
                                {
                                    name: 'core/group',
                                    attributes: {
                                        className: 'lsx-review-card',
                                        style: {
                                            border: {
                                                width: '1px',
                                                style: 'solid',
                                                color: '#e2e8f0',
                                            },
                                            spacing: {
                                                padding: '1.5rem',
                                            },
                                        },
                                    },
                                    innerBlocks: [
                                        {
                                            name: 'core/heading',
                                            attributes: {
                                                content: __('Beautiful South Africa Experience', 'tour-operator'),
                                                level: 3,
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('South Africa exceeded all expectations! The wildlife, landscapes, and culture were truly unforgettable.', 'tour-operator'),
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('— Sarah Johnson', 'tour-operator'),
                                                style: {
                                                    typography: {
                                                        fontStyle: 'italic',
                                                    },
                                                },
                                            },
                                        },
                                    ],
                                },
                                {
                                    name: 'core/group',
                                    attributes: {
                                        className: 'lsx-review-card',
                                        style: {
                                            border: {
                                                width: '1px',
                                                style: 'solid',
                                                color: '#e2e8f0',
                                            },
                                            spacing: {
                                                padding: '1.5rem',
                                            },
                                        },
                                    },
                                    innerBlocks: [
                                        {
                                            name: 'core/heading',
                                            attributes: {
                                                content: __('Amazing Zimbabwe Adventure', 'tour-operator'),
                                                level: 3,
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('Zimbabwe offers a unique blend of natural beauty and cultural richness. The adventure was truly unforgettable.', 'tour-operator'),
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('— Michael Chen', 'tour-operator'),
                                                style: {
                                                    typography: {
                                                        fontStyle: 'italic',
                                                    },
                                                },
                                            },
                                        },
                                    ],
                                },
                            ],
                        },
                    ],
                },
            ],
        },
        supports: {
            renaming: false,
        },
        isActive: (blockAttributes) => {
            return (
                blockAttributes.className === 'lsx-review-related-destination-query-wrapper' ||
                (blockAttributes.className &&
                    blockAttributes.className.includes('lsx-review-related-destination-query-wrapper'))
            );
        },
    });
}

// Register conditionally for destination post types and destination templates
const conditionalRegister = registerForPostTypesAndTemplates(
    ['destination'],
    ['destination', 'country', 'region'],
    registerReviewRelatedDestinationVariation
);

wp.domReady(conditionalRegister);
