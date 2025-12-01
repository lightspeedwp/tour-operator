/**
 * Review Related Tour Block Variation
 *
 * Registers a block variation for displaying tours related to the current review.
 * Only available on review post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { registerForPostTypesAndTemplates } from '../../utils/conditional-block-registration';
import { __ } from '@wordpress/i18n';

/**
 * Register the review related tour block variation
 */
function registerReviewRelatedTourVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/review-related-tour',
        title: __('Related Reviews', 'tour-operator'),
        icon: 'star-filled',
        description: __('Displays reviews related to this tour.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('reviews', 'tour-operator'),
            __('tour', 'tour-operator'),
            __('related', 'tour-operator'),
            __('testimonials', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Reviews', 'tour-operator'),
            },
            className: 'lsx-review-related-tour-query-wrapper',
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
                                name: __('Related Reviews Query - Tour', 'tour-operator'),
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
                                    className: 'lsx-review-related-tour-query',
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
                                className: 'lsx-review-related-tour-query',
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
                                                content: __('Amazing Safari Experience', 'tour-operator'),
                                                level: 3,
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('Our family had the most incredible time on the African safari. The guides were knowledgeable and the wildlife viewing was spectacular.', 'tour-operator'),
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
                                                content: __('Perfect Beach Getaway', 'tour-operator'),
                                                level: 3,
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: __('The resort was beautiful and the staff went above and beyond to make our vacation memorable. Highly recommended!', 'tour-operator'),
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
                blockAttributes.className === 'lsx-review-related-tour-query-wrapper' ||
                (blockAttributes.className &&
                    blockAttributes.className.includes('lsx-review-related-tour-query-wrapper'))
            );
        },
    });
}

// Register conditionally for tour post types and tour templates
const conditionalRegister = registerForPostTypesAndTemplates(
    ['tour'],
    ['tour'],
    registerReviewRelatedTourVariation
);

wp.domReady(conditionalRegister);
