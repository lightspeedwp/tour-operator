/**
 * Dress Block Variation
 *
 * Registers a block variation for displaying dress code and clothing recommendations.
 * Only available on destination post types, destinations, country, and region templates screens.
 *
 * @since 2.1.0
 * @package
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerDressVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/dress',
            title: __('Dress', 'tour-operator'),
            description: __(
                'Display dress code and clothing recommendations for destinations.',
                'tour-operator'
            ),
            icon: wp.element.createElement(
                'svg',
                {
                    xmlns: 'http://www.w3.org/2000/svg',
                    width: 20,
                    height: 20,
                    viewBox: '0 0 20 20',
                    fill: 'none',
                },
                wp.element.createElement('path', {
                    d: 'M9.99853 4.66667C11.2955 4.66667 12.3459 3.47333 12.3459 2H13.9157C14.4145 2 14.8928 2.22333 15.2449 2.62333L18.7249 6.58C19.0917 6.99667 19.0917 7.67333 18.7249 8.09L17.2373 9.78C16.8705 10.1967 16.2748 10.1967 15.9081 9.78L14.6933 8.4V15.8667C14.6933 17.0433 13.8512 18 12.8154 18H7.18168C6.1459 18 5.30377 17.0433 5.30377 15.8667V8.4L4.08901 9.78C3.72223 10.1967 3.12658 10.1967 2.7598 9.78L1.27508 8.08667C0.908305 7.67 0.908305 6.99333 1.27508 6.57667L4.75507 2.62333C5.10718 2.22333 5.58546 2 6.08428 2H7.65409C7.65409 3.47333 8.70454 4.66667 10.0015 4.66667H9.99853Z',
                    fill: 'currentColor',
                })
            ),
            category: 'lsx-tour-operator',
            keywords: [
                __('dress', 'tour-operator'),
                __('clothing', 'tour-operator'),
                __('attire', 'tour-operator'),
                __('code', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return (
                    blockAttributes.className === variationAttributes.className
                );
            },
            attributes: {
                metadata: {
                    name: __('Dress', 'tour-operator'),
                },
                className: 'lsx-dress-wrapper',
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
                                        content:
                                            '<strong>' +
                                            __('Dress', 'tour-operator') +
                                            '</strong>',
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
                                                        key: 'dress',
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
                                backgroundColor: 'primary',
                                width: 100,
                                text: __('View More', 'tour-operator'),
                            },
                        ],
                    ],
                ],
            ],
            example: {
                attributes: {
                    className: 'lsx-dress-wrapper',
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
                                                __('Dress', 'tour-operator') +
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
                                                'Smart casual attire is recommended. Lightweight clothing suitable for warm weather. Comfortable walking shoes advised for outdoor activities.',
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
        registerDressVariation
    );

    conditionalRegister();
});
