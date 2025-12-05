/**
 * Check In Time Block Variation
 *
 * Registers a block variation for displaying accommodation check-in time.
 * Only available on accommodation post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerCheckinTimeVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/checkin-time',
            title: __('Check in time', 'tour-operator'),
            icon: 'clock',
            category: 'lsx-tour-operator',
            description: __('Displays the check-in time for this accommodation.', 'tour-operator'),
            keywords: [
                __('check in', 'tour-operator'),
                __('time', 'tour-operator'),
                __('checkin', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Check in time', 'tour-operator'),
                },
                className: 'lsx-checkin-time-wrapper',
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
                                iconName: 'checkInAccommodationIcon',
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
                            'core/paragraph',
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: 'lsx/post-meta',
                                            args: {
                                                key: 'checkin_time',
                                            },
                                        },
                                    },
                                },
								prefix : __('Check in time: ', 'tour-operator'),
								prefixBold: true,
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
                                            iconName: 'checkInAccommodationIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Check in time: ', 'tour-operator') + '</strong>' + ' ' + __('11:00 AM', 'tour-operator'),
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
        ['accommodation'], // Supported post types
        ['accommodation'], // Template slug patterns
        registerCheckinTimeVariation
    );

    conditionalRegister();
});
