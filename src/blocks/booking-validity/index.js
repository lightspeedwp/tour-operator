/**
 * Booking Validity Block Variation
 *
 * Registers a block variation for displaying booking validity dates.
 * Only available on tour post type edit screens.
 *
 * @since 2.1.0
 * @package
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerBookingValidityVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/booking-validity',
            title: __('Booking validity', 'tour-operator'),
            icon: 'calendar',
            category: 'lsx-tour-operator',
            description: __(
                'Displays the booking validity period for a tour.',
                'tour-operator'
            ),
            keywords: [
                __('booking', 'tour-operator'),
                __('validity', 'tour-operator'),
                __('tour', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return (
                    blockAttributes.className === variationAttributes.className
                );
            },
            attributes: {
                metadata: {
                    name: __('Booking validity', 'tour-operator'),
                },
                className: 'lsx-booking-validity-wrapper',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
                    verticalAlignment: 'top',
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
                                iconName: 'bookingValidityIcon',
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
                                                key: 'booking_validity_start',
                                            },
                                        },
                                    },
                                },
                                prefix: __(
                                    'Booking validity:',
                                    'tour-operator'
                                ),
                                prefixBold: true,
                                content: '',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '-',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: 'lsx/post-meta',
                                            args: {
                                                key: 'booking_validity_end',
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
                                            iconName: 'bookingValidityIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content:
                                                '<strong>' +
                                                __(
                                                    'Booking validity:',
                                                    'tour-operator'
                                                ) +
                                                '</strong>' +
                                                __(
                                                    'Start Date - End Date',
                                                    'tour-operator'
                                                ),
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

    // Initialize conditional registration
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour'], // Supported post types
        ['tour'], // Template slug patterns
        registerBookingValidityVariation
    );

    conditionalRegister();
});
