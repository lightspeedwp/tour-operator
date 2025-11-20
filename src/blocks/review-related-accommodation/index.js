/**
 * Review Related Accommodation Block Variation
 *
 * Registers a block variation for displaying reviews related to the current accommodation.
 * Only available on accommodation post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';
import { __ } from '@wordpress/i18n';

/**
 * Register the review related accommodation block variation
 */
function registerReviewRelatedAccommodationVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/review-related-accommodation',
        title: __('Related Reviews', 'tour-operator'),
        icon: 'star-filled',
        description: __('Displays reviews related to this accommodation.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('reviews', 'tour-operator'),
            __('accommodation', 'tour-operator'),
            __('related', 'tour-operator'),
            __('testimonials', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Reviews', 'tour-operator'),
            },
            className: 'lsx-review-related-accommodation-query-wrapper',
            align: 'full',
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
                                    className: 'lsx-review-related-accommodation-query',
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
                                className: 'lsx-review-related-accommodation-query',
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
                                                content: __('Excellent Hotel Stay', 'tour-operator'),
                                                level: 3,
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('The hotel exceeded our expectations with comfortable rooms, excellent service, and a fantastic location. The staff were friendly and helpful throughout our stay.', 'tour-operator'),
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
                                                content: __('Beautiful Resort Experience', 'tour-operator'),
                                                level: 3,
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('Amazing resort with stunning ocean views, clean facilities, and top-notch amenities. Perfect for a romantic getaway. Would definitely return!', 'tour-operator'),
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
        isActive: (blockAttributes) => {
            return (
                blockAttributes.className === 'lsx-review-related-accommodation-query-wrapper' ||
                (blockAttributes.className &&
                    blockAttributes.className.includes('lsx-review-related-accommodation-query-wrapper'))
            );
        },
    });
}

// Register conditionally for accommodation post types and accommodation templates
const conditionalRegister = registerForPostTypesAndTemplates(
    ['accommodation'],
    ['accommodation'],
    registerReviewRelatedAccommodationVariation
);

wp.domReady(conditionalRegister);
