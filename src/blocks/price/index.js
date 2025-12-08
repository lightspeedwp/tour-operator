/**
 * Price Block Variation
 *
 * Registers a block variation for displaying the starting price of a tour.
 * Only available on tour post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

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
            description: __('Displays the starting price of a tour.', 'tour-operator'),
            keywords: [
                __('price', 'tour-operator'),
                __('cost', 'tour-operator'),
                __('amount', 'tour-operator'),
                __('from', 'tour-operator'),
                __('starting', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: 'Price',
                },
                align: 'wide',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
					verticalAlignment: 'top'
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
                        },
                    },
                    [
                        [
                            'lsx-tour-operator/icons',
                            {
                                iconType: 'solid',
                                iconName: 'priceIcon',
                            },
                        ]
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
						prefix : __('From:', 'tour-operator'),
						prefixBold: true,
                        className: 'amount',
                    },
                ],
            ],
            isDefault: false,
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
