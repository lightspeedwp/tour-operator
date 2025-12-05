/**
 * Single Supplement Wrapper Block Variation
 *
 * Registers a block variation for displaying single supplement pricing information.
 * Only available on tour post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerSingleSupplementVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/single-supplement-wrapper',
            title: __('Single supplement', 'tour-operator'),
            description: __('Displays the single supplement charge for solo travelers.', 'tour-operator'),
            icon: 'money-alt',
            category: 'lsx-tour-operator',
            keywords: [
                __('single', 'tour-operator'),
                __('supplement', 'tour-operator'),
                __('charge', 'tour-operator'),
                __('solo', 'tour-operator'),
                __('traveler', 'tour-operator'),
                __('additional', 'tour-operator'),
                __('cost', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Single supplement', 'tour-operator'),
                },
                className: 'lsx-single-supplement-wrapper',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
                },
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
                                iconName: 'singleSupplementIcon',
                            }
                        ]
                    ]
                ],
                [
                    'core/group',
                    {},
                    [
                        [
                            'core/paragraph',
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: 'lsx/post-meta',
                                            args: {
                                                key: 'single_supplement',
                                            },
                                        },
                                    },
                                },
                                className: 'amount',
								prefix : __('Single supplement:', 'tour-operator'),
								prefixBold: true,
                                content: '',
                            },
                        ],
                    ],
                ],
            ],
            example: {
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
                                    iconName: 'singleSupplementIcon',
                                },
                            },
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: '<strong>' + __('Single supplement: ', 'tour-operator') + '</strong>' + '$299',
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
        ['tour','accommodation'], // Supported post types
        ['tour','accommodation'], // Template slug patterns
        registerSingleSupplementVariation
    );

    conditionalRegister();
});
