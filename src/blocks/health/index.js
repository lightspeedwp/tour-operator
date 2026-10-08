/**
 * Health Block Variation
 *
 * Registers a block variation for displaying health and medical information.
 * Only available on destination post types, destinations, country, and region templates screens.
 *
 * @since 2.1.0
 * @package
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerHealthVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/health',
            title: __('Health', 'tour-operator'),
            description: __(
                'Display health and medical information for destinations.',
                'tour-operator'
            ),
            icon: 'insert',
            category: 'lsx-tour-operator',
            keywords: [
                __('health', 'tour-operator'),
                __('medical', 'tour-operator'),
                __('safety', 'tour-operator'),
                __('vaccination', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return (
                    blockAttributes.className === variationAttributes.className
                );
            },
            attributes: {
                metadata: {
                    name: __('Health', 'tour-operator'),
                },
                className: 'lsx-health-wrapper',
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
                                            __('Health', 'tour-operator') +
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
                                                        key: 'health',
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
                    className: 'lsx-health-wrapper',
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
                                                __('Health', 'tour-operator') +
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
                                                'Consult your doctor for travel vaccinations. Quality medical facilities available in main cities. Travel insurance recommended.',
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
        registerHealthVariation
    );

    conditionalRegister();
});
