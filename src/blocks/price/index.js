import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerPriceVariation = () => {

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/price',
            title: __('Price', 'tour-operator'),
            category: 'lsx-tour-operator',
            icon: 'money-alt',
            keywords: [
                __('price', 'tour-operator'),
                __('cost', 'tour-operator'),
                __('amount', 'tour-operator'),
                __('from', 'tour-operator'),
                __('starting', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
            },
            attributes: {
                metadata: {
                    name: 'Price',
                },
                align: 'wide',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
                },
                className: 'lsx-price-wrapper',
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        layout: {
                            type: 'flex',
                            flexWrap: 'nowrap',
                            verticalAlignment: 'middle',
                        },
                    },
                    [
                        [
                            'lsx-tour-operator/icons',
                            {
                                iconType: 'solid',
                                iconName: 'priceIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '<strong>' + __('From:', 'tour-operator') + '</strong>',
                            },
                        ],
                    ],
                ],
                [
                    'core/paragraph',
                    {
                        metadata: {
                            bindings: {
                                content: {
                                    source: 'lsx/post-meta',
                                    args: {
                                        key: 'price',
                                    },
                                },
                            },
                        },
                        className: 'amount',
                    },
                ],
            ],
            isDefault: false,
            supports: {
                renaming: false,
            },
            example: {
                innerBlocks: [
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'flex',
                                flexWrap: 'nowrap',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/group',
                                attributes: {
                                    layout: {
                                        type: 'flex',
                                        flexWrap: 'nowrap',
                                        verticalAlignment: 'middle',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'lsx-tour-operator/icons',
                                        attributes: {
                                            iconType: 'solid',
                                            iconName: 'priceIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('From: ', 'tour-operator') + '</strong>' + '$1,999',
                                        },
                                    },
                                ],
                            },
                        ],
                    },
                ],
            },
        });
    };

    // Initialize conditional registration
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour'], // Supported post types
        ['tour'], // Template slug patterns
        registerPriceVariation
    );

    conditionalRegister();
});
