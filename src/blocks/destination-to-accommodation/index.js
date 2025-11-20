/**
 * Destination to Accommodation Block Variation
 *
 * Registers a block variation for displaying accommodations linked to this destination.
 * Only available on destination post types, destinations, country, and region templates screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerDestinationToAccommodationVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/destination-to-accommodation',
            title: __('Destination to Accommodation', 'tour-operator'),
            icon: 'admin-site',
            category: 'lsx-tour-operator',
            description: __('Displays the destinations associated with this accommodation.', 'tour-operator'),
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            keywords: [
                __('destination', 'tour-operator'),
                __('accommodation', 'tour-operator'),
                __('locations', 'tour-operator'),
            ],
            attributes: {
                metadata: {
                    name: __('Destination to Accommodation', 'tour-operator'),
                },
                className: 'lsx-destination-to-accommodation-wrapper',

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
                                content: '<strong>Location</strong>:',
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
                                                key: 'destination_to_accommodation',
                                            },
                                        },
                                    },
                                },
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

    // Initialize conditional registration for accommodation context
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['accommodation'], // Supported post types
        ['accommodation'], // Template slug patterns
        registerDestinationToAccommodationVariation
    );

    conditionalRegister();

});
