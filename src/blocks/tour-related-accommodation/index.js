/**
 * Register Tour Related Accommodation block variation
 */
import { registerForPostTypes } from '@utils/conditional-block-registration.js';

const { __ } = wp.i18n;

/**
 * Register the tour related accommodation block variation
 */
function registerTourRelatedAccommodationVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/tour-related-accommodation',
        title: __('Related Tours - Accommodation', 'tour-operator'),
        icon: 'admin-multisite',
        description: __('Displays tours related to an accommodation via destination relationships.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('tours', 'tour-operator'),
            __('accommodation', 'tour-operator'),
            __('related', 'tour-operator'),
            __('cross-reference', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Tours - Accommodation', 'tour-operator'),
            },
            className: 'lsx-tour-related-accommodation-query-wrapper',
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
                            content: __('Related Tours', 'tour-operator'),
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
                                name: __('Related Tours Query - Accommodation', 'tour-operator'),
                            },
                            query: {
                                perPage: 8,
                                postType: 'tour',
                                order: 'asc',
                                orderBy: 'date',
                            },
                            align: 'wide',
                        },
                        [
                            [
                                'core/post-template',
                                {
                                    className: 'lsx-tour-related-accommodation-query',
                                    layout: {
                                        type: 'grid',
                                        columnCount: 3,
                                    },
                                },
                                [
                                    [
                                        'core/pattern',
                                        {
                                            slug: 'lsx-tour-operator/tour-card',
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
    registerTourRelatedAccommodationVariation
);

wp.domReady(conditionalRegister);
