/**
 * Destination to Tour Block Variation
 *
 * Registers a block variation for displaying destinations linked to this tours.
 * Only available on tour post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerDestinationToTourVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/destination-to-tour',
            title: __('Destination to Tour', 'tour-operator'),
            icon: 'admin-site',
            category: 'lsx-tour-operator',
            description: __('Displays the destinations associated with this tour.', 'tour-operator'),
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            keywords: [
                __('destination', 'tour-operator'),
                __('tour', 'tour-operator'),
                __('locations', 'tour-operator'),
            ],
            attributes: {
                metadata: {
                    name: __('Destination to Tour', 'tour-operator'),
                },
                className: 'lsx-destination-to-tour-wrapper',
                layout: {
                    type: 'constrained',
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
                                content: '<strong>' + __('Destinations:', 'tour-operator') + '</strong>',
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
                                                key: 'destination_to_tour',
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
                                            iconName: 'destinationIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Destinations: ', 'tour-operator') + '</strong>' + ' ' + 'Cape Town, Johannesburg',
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

    // Initialize conditional registration for tour context
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour'], // Supported post types
        ['tour'], // Template slug patterns
        registerDestinationToTourVariation
    );

    conditionalRegister();
});
