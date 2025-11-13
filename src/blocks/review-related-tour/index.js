/**
 * Register Review Related Tour block variation
 */
import { registerForPostTypes } from '@utils/conditional-block-registration.js';

const { __ } = wp.i18n;

/**
 * Register the review related tour block variation
 */
function registerReviewRelatedTourVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/review-related-tour',
        title: __('Related Reviews - Tour', 'tour-operator'),
        icon: 'palmtree',
        description: __('Displays reviews related to a tour.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('reviews', 'tour-operator'),
            __('tour', 'tour-operator'),
            __('related', 'tour-operator'),
            __('testimonials', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Reviews - Tour', 'tour-operator'),
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
        supports: {
            renaming: false,
        },
    });
}

// Register conditionally for tour post types and tour templates
const conditionalRegister = registerForPostTypes(
    ['tour'],
    registerReviewRelatedTourVariation
);

wp.domReady(conditionalRegister);
