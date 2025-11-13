/**
 * Register Tour Related Destination block variation
 */
import { registerForPostTypes } from '@utils/conditional-block-registration.js';

const { __ } = wp.i18n;

/**
 * Register the tour related destination block variation
 */
function registerTourRelatedDestinationVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/tour-related-destination',
        title: __('Related Tours - Destination', 'tour-operator'),
        icon: 'admin-site',
        description: __('Displays tours related to a destination.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('tours', 'tour-operator'),
            __('destination', 'tour-operator'),
            __('related', 'tour-operator'),
            __('cross-reference', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Tours - Destinations', 'tour-operator'),
            },
            className: 'lsx-tour-related-destination-query-wrapper',
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
                                name: __('Related Tours Query - Destination', 'tour-operator'),
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
                                    className: 'lsx-tour-related-destination-query',
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

// Register conditionally for destination post types and destination templates
const conditionalRegister = registerForPostTypes(
    ['destination'],
    registerTourRelatedDestinationVariation
);

wp.domReady(conditionalRegister);
