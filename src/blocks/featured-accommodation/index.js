/**
 * Featured Accommodation Block Variation
 *
 * Registers a block variation for displaying featured accommodations.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package
 */

import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/featured-accommodation',
        title: __('Featured Accommodations', 'tour-operator'),
        icon: 'admin-multisite',
        description: __(
            'Displays Accommodations with the Featured tag.',
            'tour-operator'
        ),
        category: 'lsx-tour-operator',
        keywords: [
            __('featured', 'tour-operator'),
            __('accommodations', 'tour-operator'),
            __('lodging', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: 'Featured Accommodation',
            },
            className: 'lsx-featured-accommodation-query-wrapper',
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
                            content: __(
                                'Featured Accommodations',
                                'tour-operator'
                            ),
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
                                name: 'Featured Accommodation Query',
                            },
                            query: {
                                perPage: 8,
                                postType: 'accommodation',
                                order: 'asc',
                                orderBy: 'date',
                            },
                            align: 'wide',
                        },
                        [
                            [
                                'core/post-template',
                                {
                                    className:
                                        'lsx-featured-accommodation-query',
                                    layout: {
                                        type: 'grid',
                                        columnCount: 3,
                                    },
                                },
                                [
                                    [
                                        'core/pattern',
                                        {
                                            slug: 'lsx-tour-operator/accommodation-card',
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
            attributes: {
                metadata: {
                    name: 'Featured Accommodations',
                },
            },
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
                                    layout: {
                                        selfStretch: 'fill',
                                        flexSize: null,
                                    },
                                },
                            },
                        },
                        {
                            name: 'core/heading',
                            attributes: {
                                textAlign: 'center',
                                content: 'Featured Accommodations',
                                level: 3,
                            },
                        },
                        {
                            name: 'core/separator',
                            attributes: {
                                style: {
                                    layout: {
                                        selfStretch: 'fill',
                                        flexSize: null,
                                    },
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
                                className: 'lsx-featured-accommodation-query',
                                layout: {
                                    type: 'grid',
                                    columnCount: 2,
                                },
                            },
                            innerBlocks: [
                                {
                                    name: 'core/group',
                                    attributes: {
                                        className: 'accommodation-card',
                                    },
                                    innerBlocks: [
                                        {
                                            name: 'core/image',
                                            attributes: {
                                                alt: 'Luxury mountain lodge with scenic views',
                                                aspectRatio: '3/2',
                                                style: {
                                                    border: {
                                                        radius: {
                                                            topLeft: '8px',
                                                            topRight: '8px',
                                                        },
                                                    },
                                                },
                                            },
                                        },
                                        {
                                            name: 'core/heading',
                                            attributes: {
                                                level: 3,
                                                content:
                                                    'Alpine Mountain Lodge',
                                                textAlign: 'center',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content:
                                                    '<strong>From: $180/night</strong>',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: 'Type: Resort',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: 'Rooms: 25',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content:
                                                    'Experience luxury at its finest in our mountain lodge featuring breathtaking alpine views, spa services, and world-class dining.',
                                            },
                                        },
                                    ],
                                },
                                {
                                    name: 'core/group',
                                    attributes: {
                                        className: 'accommodation-card',
                                    },
                                    innerBlocks: [
                                        {
                                            name: 'core/image',
                                            attributes: {
                                                alt: 'Cozy beachfront hotel with ocean access',
                                                aspectRatio: '3/2',
                                                style: {
                                                    border: {
                                                        radius: {
                                                            topLeft: '8px',
                                                            topRight: '8px',
                                                        },
                                                    },
                                                },
                                            },
                                        },
                                        {
                                            name: 'core/heading',
                                            attributes: {
                                                level: 3,
                                                content:
                                                    'Seaside Boutique Hotel',
                                                textAlign: 'center',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content:
                                                    '<strong>From: $95/night</strong>',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: 'Type: Hotel',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content: 'Rooms: 42',
                                            },
                                        },
                                        {
                                            name: 'core/paragraph',
                                            attributes: {
                                                content:
                                                    'Relax in comfort just steps from the beach. Our boutique hotel offers modern amenities with personalized service and stunning ocean views.',
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
        isActive: (blockAttributes, variationAttributes) => {
            return blockAttributes.className === variationAttributes.className;
        },
    });
});
