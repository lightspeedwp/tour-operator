/**
 * Number of Rooms Block Variation
 *
 * Registers a block variation for displaying accommodation room count.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */
import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerNumberOfRoomsVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/number-of-rooms',
            title: __('Number of Rooms', 'tour-operator'),
            icon: 'admin-multisite',
            category: 'lsx-tour-operator',
            description: __('Displays the number of rooms available for this accommodation.', 'tour-operator'),
            keywords: [
                __('number', 'tour-operator'),
                __('rooms', 'tour-operator'),
                __('units', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Number of Rooms', 'tour-operator'),
                },
                className: 'lsx-number-of-rooms-wrapper',
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
                            verticalAlignment: 'top',
                        },
                    },
                    [
                        [
                            'lsx-tour-operator/icons',
                            {
                                iconType: 'solid',
                                iconName: 'numberOfUnitsIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '<strong>Number of Units</strong>:',
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
                                            source: 'lsx/post-meta',
                                            args: {
                                                key: 'number_of_rooms',
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
                                verticalAlignment: 'middle',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'lsx-tour-operator/icons',
                                attributes: {
                                    iconType: 'solid',
                                    iconName: 'numberOfUnitsIcon',
                                },
                            },
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: '<strong>' + __('Number of Units: ', 'tour-operator') + '</strong>' + '12',
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
        ['accommodation'], // Supported post types
        ['accommodation'], // Template slug patterns
        registerNumberOfRoomsVariation
    );

    conditionalRegister();
});
