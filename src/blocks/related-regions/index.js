import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerRelatedRegionsBlock = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/related-regions',
            title: __('Related Regions', 'tour-operator'),
            icon: 'admin-site-alt3',
            description: __('Displays any regions from the parent country.', 'tour-operator'),
            category: 'lsx-tour-operator',
            keywords: [
                __('related', 'tour-operator'),
                __('regions', 'tour-operator'),
                __('destinations', 'tour-operator'),
                __('locations', 'tour-operator'),
            ],
            attributes: {
                metadata: {
                    name: 'Related Regions',
                },
                className: 'lsx-related-regions-query-wrapper',
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
                            { textAlign: 'center', content: __('Related Regions', 'tour-operator') },
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
                                    name: __('Related Regions Query', 'tour-operator'),
                                },
                                query: {
                                    perPage: 8,
                                    postType: 'destination',
                                    order: 'asc',
                                    orderBy: 'date',
                                },
                                align: 'wide',
                            },
                            [
                                [
                                    'core/post-template',
                                    {
                                        className: 'lsx-related-regions-query',
                                        layout: {
                                            type: 'grid',
                                            columnCount: 4,
                                        },
                                    },
                                    [
                                        [
                                            'core/pattern',
                                            {
                                                slug: 'lsx-tour-operator/destination-card',
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
                                    content: __('Regions', 'tour-operator'),
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
                                    className: 'lsx-regions-query',
                                    layout: {
                                        type: 'grid',
                                        columnCount: 2,
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/group',
                                        attributes: {
                                            className: 'lsx-regions-card',
                                        },
                                        innerBlocks: [
                                            {
                                                name: 'core/image',
                                                attributes: {
                                                    alt: __('Northern Region Image', 'tour-operator'),
                                                    caption: '',
                                                },
                                            },
                                            {
                                                name: 'core/heading',
                                                attributes: {
                                                    content: __('Northern Region', 'tour-operator'),
                                                    level: 3,
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
                                            {
                                                name: 'core/paragraph',
                                                attributes: {
                                                    content: __('Explore the stunning landscapes and wildlife of the northern regions.', 'tour-operator'),
                                                },
                                            },
                                        ],
                                    },
                                    {
                                        name: 'core/group',
                                        attributes: {
                                            className: 'lsx-regions-card',
                                        },
                                        innerBlocks: [
                                            {
                                                name: 'core/image',
                                                attributes: {
                                                    alt: __('Coastal Region Image', 'tour-operator'),
                                                    caption: '',
                                                },
                                            },
                                            {
                                                name: 'core/heading',
                                                attributes: {
                                                    content: __('Coastal Region', 'tour-operator'),
                                                    level: 3,
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
                                            {
                                                name: 'core/paragraph',
                                                attributes: {
                                                    content: __('Discover pristine beaches and vibrant coastal communities.', 'tour-operator'),
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
    };

    // Initialize conditional registration for destination context
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['destination'], // Supported post types
        ['destination'], // Template slug patterns
        registerRelatedRegionsBlock
    );

    conditionalRegister();
});
