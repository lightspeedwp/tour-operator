/**
 * Visa Block Variation
 *
 * Registers a block variation for displaying visa requirements and information.
 * Only available on destination post types, destinations, country, and region templates screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '../../utils/conditional-block-registration';

wp.domReady(() => {
    const registerVisaVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/visa',
            title: __('Visa', 'tour-operator'),
            icon: 'id-alt',
            category: 'lsx-tour-operator',
            description: __('Displays visa information for this destination.', 'tour-operator'),
            keywords: [
                __('visa', 'tour-operator'),
                __('information', 'tour-operator'),
                __('travel visa', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Visa', 'tour-operator'),
                },
                className: 'lsx-visa-wrapper',
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
                                        content: `<strong>${__('Visa', 'tour-operator')}</strong>`,
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
                                                        key: 'visa',
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
                    className: 'lsx-visa-wrapper',
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
                                            content: '<strong>' + __('Visa', 'tour-operator') + '</strong>',
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
                                            content: __('Visa information will be displayed here.', 'tour-operator'),
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
    }

    // Initialize conditional registration
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['destination'], // Supported post types
        ['destination', 'country', 'region'], // Template slug patterns
        registerVisaVariation
    );

    conditionalRegister();
});
