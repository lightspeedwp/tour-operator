/**
 * Register Review Related Destination block variation
 */
import { registerForPostTypes } from '@utils/conditional-block-registration.js';

const { __ } = wp.i18n;

/**
 * Register the review related destination block variation
 */
function registerReviewRelatedDestinationVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/review-related-destination',
        title: __('Related Reviews - Destination', 'tour-operator'),
        icon: 'admin-site',
        description: __('Displays reviews related to a destination.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('reviews', 'tour-operator'),
            __('destination', 'tour-operator'),
            __('related', 'tour-operator'),
            __('testimonials', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Reviews - Destination', 'tour-operator'),
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
                                name: __('Related Review Query - Destinations', 'tour-operator'),
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
        supports: {
            renaming: false,
        },
    });
}

// Register conditionally for destination post types and destination templates
const conditionalRegister = registerForPostTypes(
    ['destination'],
    registerReviewRelatedDestinationVariation
);

wp.domReady(conditionalRegister);
