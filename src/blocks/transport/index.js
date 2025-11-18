import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerTransportVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/transport',
            title: __('Transport', 'tour-operator'),
            description: __('Display transportation information and options for destinations.', 'tour-operator'),
            icon: 'car',
            category: 'lsx-tour-operator',
            keywords: [
                __('transport', 'tour-operator'),
                __('transportation', 'tour-operator'),
                __('travel', 'tour-operator'),
                __('getting around', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: 'Transport',
                },
                className: 'lsx-transport-wrapper',
                layout: {
                    type: 'constrained',
                },
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        layout: {
                            type: 'constrained',
                        },
                    },
                    [
                        [
                            'core/group',
                            {
                                layout: {
                                    type: 'constrained',
                                },
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        align: 'center',
                                        content: '<strong>' + __('Transport', 'tour-operator') + '</strong>',
                                    },
                                ],
                            ],
                        ],
                        [
                            'core/group',
                            {
                                layout: {
                                    type: 'constrained',
                                },
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        metadata: {
                                            bindings: {
                                                content: {
                                                    source: 'lsx/post-meta',
                                                    args: {
                                                        key: 'transport',
                                                    },
                                                },
                                            },
                                        },
                                    },
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'core/buttons',
                    {},
                    [
                        [
                            'core/button',
                            {
                                width: 100,
                                text: __('View More', 'tour-operator'),
                            },
                        ],
                    ],
                ],
            ],
            example: {
                attributes: {
                    className: 'lsx-transport-wrapper',
                },
                innerBlocks: [
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'constrained',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/group',
                                attributes: {
                                    layout: {
                                        type: 'constrained',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            align: 'center',
                                            content: '<strong>' + __('Transport', 'tour-operator') + '</strong>',
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/group',
                                attributes: {
                                    layout: {
                                        type: 'constrained',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('Excellent public transport network including buses, trains, and taxis. Car rentals available. Airport transfers and shuttle services widely available.', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                        ],
                    },
                    {
                        name: 'core/buttons',
                        attributes: {},
                        innerBlocks: [
                            {
                                name: 'core/button',
                                attributes: {
                                    backgroundColor: 'primary',
                                    width: 100,
                                    text: __('View More', 'tour-operator'),
                                },
                            },
                        ],
                    },
                ],
            },
        });
    };

    // Initialize conditional registration
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['destination'], // Supported post types
        ['destination', 'country', 'region'], // Template slug patterns
        registerTransportVariation
    );

    conditionalRegister();
});
