/**
 * Register Tour Related Destination block variation
 */
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';
import { __ } from '@wordpress/i18n';

/**
 * Register the tours related to destination block variation
 */
function registerTourRelatedDestinationVariation() {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/tour-related-destination',
        title: __('Related Tours', 'tour-operator'),
        icon: 'palmtree',
        description: __('Displays tours related to this destination.', 'tour-operator'),
        category: 'lsx-tour-operator',
        keywords: [
            __('tours', 'tour-operator'),
            __('destination', 'tour-operator'),
            __('related', 'tour-operator'),
            __('cross-reference', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: __('Related Tours', 'tour-operator'),
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
                                name: __('Related Tours Query', 'tour-operator'),
                            },
                            query: {
                                perPage: 6,
                                postType: 'tour',
                                order: 'asc',
                                orderBy: 'title',
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
                                content: __('Related Tours', 'tour-operator'),
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
                                className: 'lsx-tour-related-destination-query',
                                layout: {
                                    type: 'grid',
                                    columnCount: 3,
                                },
                            },
                            innerBlocks: [
                                {
                                    name: 'core/group',
                                    attributes: {
                                        layout: { type: 'constrained' },
                                    },
                                    innerBlocks: [
                                        {
                                            name: 'core/group',
                                            attributes: {
                                                style: {
                                                    spacing: { padding: { top: '5px', bottom: '0px', left: '5px', right: '5px' } },
                                                },
                                                layout: { type: 'constrained' },
                                            },
                                            innerBlocks: [
                                                {
                                                    name: 'core/heading',
                                                    attributes: {
                                                        textAlign: 'center',
                                                        content: __('African Safari Adventure', 'tour-operator'),
                                                        level: 3,
                                                        fontSize: 'small',
                                                        style: {
                                                            spacing: { margin: { top: '0', bottom: '0' } },
                                                        },
                                                    },
                                                },
                                                {
                                                    name: 'core/group',
                                                    attributes: {
                                                        style: {
                                                            spacing: { padding: { top: '5px', bottom: '10px', left: '5px', right: '5px' }, blockGap: '2px' },
                                                            border: { top: { width: '2px' }, bottom: { width: '2px' } },
                                                        },
                                                        layout: { type: 'constrained' },
                                                    },
                                                    innerBlocks: [
                                                        {
                                                            name: 'core/paragraph',
                                                            attributes: {
                                                                content: '<strong>' + __('From: $2,499', 'tour-operator') + '</strong>',
                                                                className: 'amount price',
                                                            },
                                                        },
                                                        {
                                                            name: 'core/paragraph',
                                                            attributes: {
                                                                content: '<strong>' + __('Duration: 7 Days', 'tour-operator') + '</strong>',
                                                            },
                                                        },
                                                    ],
                                                },
                                                {
                                                    name: 'core/paragraph',
                                                    attributes: {
                                                        content: __('Experience the breathtaking wildlife and stunning landscapes of Africa on this unforgettable safari adventure. Perfect for nature lovers and photography enthusiasts.', 'tour-operator'),
                                                        style: {
                                                            spacing: { padding: { left: '5px', right: '5px' } },
                                                        },
                                                    },
                                                },
                                            ],
                                        },
                                    ],
                                },
                                {
                                    name: 'core/group',
                                    attributes: {
                                        className: 'is-style-shadow-sm',
                                        style: {
                                            spacing: { blockGap: '0px', padding: { top: '0px', bottom: '0px', left: '0px', right: '0px' } },
                                            border: { radius: '8px' },
                                        },
                                        backgroundColor: 'base',
                                        layout: { type: 'constrained' },
                                    },
                                    innerBlocks: [
                                        {
                                            name: 'core/group',
                                            attributes: {
                                                style: {
                                                    spacing: { padding: { top: '5px', bottom: '0px', left: '5px', right: '5px' } },
                                                },
                                                layout: { type: 'constrained' },
                                            },
                                            innerBlocks: [
                                                {
                                                    name: 'core/heading',
                                                    attributes: {
                                                        textAlign: 'center',
                                                        content: __('Kilimanjaro Trek and Safari', 'tour-operator'),
                                                        level: 3,
                                                        fontSize: 'small',
                                                        style: {
                                                            spacing: { margin: { top: '0', bottom: '0' } },
                                                        },
                                                    },
                                                },
                                                {
                                                    name: 'core/group',
                                                    attributes: {
                                                        style: {
                                                            spacing: { padding: { top: '5px', bottom: '10px', left: '5px', right: '5px' }, blockGap: '2px' },
                                                            border: { top: { width: '2px' }, bottom: { width: '2px' } },
                                                        },
                                                        layout: { type: 'constrained' },
                                                    },
                                                    innerBlocks: [
                                                        {
                                                            name: 'core/paragraph',
                                                            attributes: {
                                                                content: '<strong>' + __('From: $1,899', 'tour-operator') + '</strong>',
                                                                className: 'amount price',
                                                            },
                                                        },
                                                        {
                                                            name: 'core/paragraph',
                                                            attributes: {
                                                                content: '<strong>' + __('Duration: 10 Days', 'tour-operator') + '</strong>',
                                                            },
                                                        },
                                                    ],
                                                },
                                                {
                                                    name: 'core/paragraph',
                                                    attributes: {
                                                        content: __('Discover the breathtaking landscapes and unique wildlife of Kilimanjaro. Experience an unforgettable adventure combining trekking and safari.', 'tour-operator'),
                                                        style: {
                                                            spacing: { padding: { left: '5px', right: '5px' } },
                                                        },
                                                    },
                                                },
                                            ],
                                        },
                                    ],
                                },
                                {
                                    name: 'core/group',
                                    attributes: {
                                        className: 'is-style-shadow-sm',
                                        style: {
                                            spacing: { blockGap: '0px', padding: { top: '0px', bottom: '0px', left: '0px', right: '0px' } },
                                            border: { radius: '8px' },
                                        },
                                        backgroundColor: 'base',
                                        layout: { type: 'constrained' },
                                    },
                                    innerBlocks: [
                                        {
                                            name: 'core/group',
                                            attributes: {
                                                style: {
                                                    spacing: { padding: { top: '5px', bottom: '0px', left: '5px', right: '5px' } },
                                                },
                                                layout: { type: 'constrained' },
                                            },
                                            innerBlocks: [
                                                {
                                                    name: 'core/heading',
                                                    attributes: {
                                                        textAlign: 'center',
                                                        content: __('Tropical Beach Getaway', 'tour-operator'),
                                                        level: 3,
                                                        fontSize: 'small',
                                                        style: {
                                                            spacing: { margin: { top: '0', bottom: '0' } },
                                                        },
                                                    },
                                                },
                                                {
                                                    name: 'core/group',
                                                    attributes: {
                                                        style: {
                                                            spacing: { padding: { top: '5px', bottom: '10px', left: '5px', right: '5px' }, blockGap: '2px' },
                                                            border: { top: { width: '2px' }, bottom: { width: '2px' } },
                                                        },
                                                        layout: { type: 'constrained' },
                                                    },
                                                    innerBlocks: [
                                                        {
                                                            name: 'core/paragraph',
                                                            attributes: {
                                                                content: '<strong>' + __('From: $1,299', 'tour-operator') + '</strong>',
                                                                className: 'amount price',
                                                            },
                                                        },
                                                        {
                                                            name: 'core/paragraph',
                                                            attributes: {
                                                                content: '<strong>' + __('Duration: 5 Days', 'tour-operator') + '</strong>',
                                                            },
                                                        },
                                                    ],
                                                },
                                                {
                                                    name: 'core/paragraph',
                                                    attributes: {
                                                        content: __('Relax and unwind on pristine beaches with crystal clear waters. Enjoy water sports, local cuisine, and stunning sunsets.', 'tour-operator'),
                                                        style: {
                                                            spacing: { padding: { left: '5px', right: '5px' } },
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
            ],
        },
        supports: {
            renaming: false,
        },
        isActive: (blockAttributes) => {
            return (
                blockAttributes.className === 'lsx-tour-related-destination-query-wrapper' ||
                (blockAttributes.className &&
                    blockAttributes.className.includes('lsx-tour-related-destination-query-wrapper'))
            );
        },
    });
}

// Register conditionally for destination post types and destination templates
const conditionalRegister = registerForPostTypesAndTemplates(
    ['destination'],
    ['destination', 'country', 'region'],
    registerTourRelatedDestinationVariation
);

wp.domReady(conditionalRegister);
