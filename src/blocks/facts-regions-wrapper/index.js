/**
 * Facts Regions Wrapper Block Variation
 *
 * Registers a block variation for displaying regional facts in a structured wrapper.
 * Only available on destination post types, destinations, country, and region templates screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';



wp.domReady(() => {
    const registerFactsRegionsWrapperVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/facts-regions-wrapper',
            title: __('Regions list', 'tour-operator'),
            icon: 'admin-site-alt',
            category: 'lsx-tour-operator',
            description: __('Displays a list of regions associated with this destination.', 'tour-operator'),
            keywords: [
                __('regions', 'tour-operator'),
                __('destination', 'tour-operator'),
                __('location', 'tour-operator'),
                __('facts', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Regions list', 'tour-operator'),
                },
                className: 'facts-regions-query-wrapper',
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
                                iconName: 'destinationIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: `<strong>${__('Regions', 'tour-operator')}</strong>`,
                            },
                        ],
                    ],
                ],
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
                            'core/paragraph',
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: 'lsx/post-connection',
                                            args: {
                                                key: 'post_children',
                                            },
                                        },
                                    },
                                },
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
                        attributes: {},
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
                                            iconName: 'destinationIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Regions: ', 'tour-operator') + '</strong>' + ' ' + __('Kilimanjaro region', 'tour-operator'),
                                        },
                                    },
                                ],
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
        registerFactsRegionsWrapperVariation
    );

    conditionalRegister();
});
