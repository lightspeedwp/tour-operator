import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerBankingVariation = () => {

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/banking',
            title: __('Banking', 'tour-operator'),
            description: __('Display banking and financial information for destinations.', 'tour-operator'),
            icon: 'bank',
            category: 'lsx-tour-operator',
            keywords: [
                __('banking', 'tour-operator'),
                __('finance', 'tour-operator'),
                __('currency', 'tour-operator'),
                __('money', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: 'Banking',
                },
                className: 'lsx-banking-wrapper',
                layout: {
                    type: 'constrained',
                },
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        metadata: {
                            name: __('Content', 'tour-operator'),
                        },
                        layout: {
                            type: 'constrained',
                        },
                    },
                    [
                        [
                            'core/group',
                            {
                                metadata: {
                                    name: __('Title', 'tour-operator'),
                                },
                                layout: {
                                    type: 'constrained',
                                },
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        align: 'center',
                                        content: '<strong>' + __('Banking', 'tour-operator') + '</strong>',
                                    },
                                ],
                            ],
                        ],
                        [
                            'core/group',
                            {
                                className: 'lsx-to-more-content',
                                metadata: {
                                    name: __('Description', 'tour-operator'),
                                },
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
                                                        key: 'banking',
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
                                metadata: {
                                    name: __('More Button', 'tour-operator'),
                                },
                                className: 'lsx-to-more-link more-link',
                                width: 100,
                                text: __('View More', 'tour-operator'),
                            },
                        ],
                    ],
                ],
            ],
            supports: {
                renaming: false,
            },
            example: {
                attributes: {
                    className: 'lsx-banking-wrapper',
                },
                innerBlocks: [
                    {
                        name: 'core/group',
                        attributes: {
                            metadata: {
                                name: __('Content', 'tour-operator'),
                            },
                            layout: {
                                type: 'constrained',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/group',
                                attributes: {
                                    metadata: {
                                        name: __('Title', 'tour-operator'),
                                    },
                                    layout: {
                                        type: 'constrained',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            align: 'center',
                                            content: '<strong>' + __('Banking', 'tour-operator') + '</strong>',
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/group',
                                attributes: {
                                    className: 'lsx-to-more-content',
                                    metadata: {
                                        name: __('Description', 'tour-operator'),
                                    },
                                    layout: {
                                        type: 'constrained',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('Local currency is widely accepted. ATMs are available throughout the city center. Major credit cards accepted at most establishments.', 'tour-operator'),
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
                                    metadata: {
                                        name: __('More Button', 'tour-operator'),
                                    },
                                    className: 'lsx-to-more-link more-link',
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
        ['destination'], // Template slug patterns
        registerBankingVariation
    );

    conditionalRegister();
});
