/**
 * Travel Styles Block Variation
 *
 * Registers a block variation for displaying travel styles taxonomy.
 * Only available on tour post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerTravelStylesVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/travel-styles',
            title: __('Travel styles', 'tour-operator'),
            icon: 'airplane',
            category: 'lsx-tour-operator',
            description: __('Display the travel styles associated with this tour.', 'tour-operator'),
            keyword: [
                __('travel', 'tour-operator'),
                __('styles', 'tour-operator'),
                __('category', 'tour-operator'),
                __('classification', 'tour-operator'),
                __('tour', 'tour-operator'),
                __('type', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: 'Travel styles',
                },
                className: 'lsx-travel-style-wrapper',
				layout: {
					type: 'flex',
					flexWrap: 'nowrap',
					verticalAlignment: 'top'
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
                                iconName: 'travelStyleIcon',
                            },
                        ]
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
                            'core/post-terms',
                            {
                                term: 'travel-style',
								prefix: '<strong>' + __('Travel Styles: ', 'tour-operator') + '</strong>'
                            }
                        ]
                    ]
                ]
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
                                    iconName: 'travelStyleIcon',
                                },
                            },
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: '<strong>' + __('Travel Styles:', 'tour-operator') + '</strong>' + ' ' + __('Adventure, Cultural, Wildlife', 'tour-operator'),
                                },
                            }
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
        registerTravelStylesVariation
    );

    conditionalRegister();
});
