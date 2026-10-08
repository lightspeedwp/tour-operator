/**
 * Safety Block Variation
 *
 * Registers a block variation for displaying safety information and guidelines.
 * Only available on destination post types, destinations, country, and region templates screens.
 *
 * @since 2.1.0
 * @package
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerSafetyVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/safety',
            title: __('Safety', 'tour-operator'),
            icon: 'shield',
            category: 'lsx-tour-operator',
            description: __(
                'Displays safety information for this destination.',
                'tour-operator'
            ),
            keywords: [
                __('safety', 'tour-operator'),
                __('information', 'tour-operator'),
                __('travel safety', 'tour-operator'),
                __('destination safety', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return (
                    blockAttributes.className === variationAttributes.className
                );
            },
            attributes: {
                metadata: {
                    name: __('Safety', 'tour-operator'),
                },
                className: 'lsx-safety-wrapper',
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
                                        content: `<strong>${__('Safety', 'tour-operator')}</strong>`,
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
                                                        key: 'safety',
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
                                content: __('View More', 'tour-operator'),
                            },
                        ],
                    ],
                ],
            ],
            example: {
                attributes: {
                    className: 'lsx-safety-wrapper',
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
                                            content:
                                                '<strong>' +
                                                __('Safety', 'tour-operator') +
                                                '</strong>',
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
                                            content: __(
                                                'This is a generally safe destination with low crime rates. Stay alert in crowded tourist areas, use hotel safes for valuables, and follow local guidance. Emergency services are reliable and English is widely spoken.',
                                                'tour-operator'
                                            ),
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
        registerSafetyVariation
    );

    conditionalRegister();
});
