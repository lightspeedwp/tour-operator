/**
 * Register Review Related Accommodation block variation
 */
import { registerForPostTypes } from '@utils/conditional-block-registration.js';

const { __ } = wp.i18n;

/**
 * Register the review related accommodation block variation
 */
function registerReviewRelatedAccommodationVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/review-related-accommodation',
        title: __('Related Reviews - Accommodation', 'tour-operator'),
        icon: 'admin-multisite',
        description: __('Displays reviews related to an accommodation.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('reviews', 'tour-operator'),
            __('accommodation', 'tour-operator'),
            __('related', 'tour-operator'),
            __('testimonials', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Reviews - Accommodation', 'tour-operator'),
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
                                name: __('Related Review Query - Accommodation', 'tour-operator'),
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
        supports: {
            renaming: false,
        },
    });
}

// Register conditionally for accommodation post types and accommodation templates
const conditionalRegister = registerForPostTypes(
    ['accommodation'],
    registerReviewRelatedAccommodationVariation
);

wp.domReady(conditionalRegister);
