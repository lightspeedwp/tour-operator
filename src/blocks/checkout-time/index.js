/**
 * Check Out Time Block Variation
 *
 * Registers a block variation for accommodation check-out time display.
 * Only available on accommodation post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerCheckoutTimeVariation = () => {
        wp.blocks.registerBlockVariation("core/group", {
            name: "lsx-tour-operator/checkout-time",
            title: __("Check out time", "tour-operator"),
            icon: "clock",
            category: "lsx-tour-operator",
            description: __("Displays the check-out time for this accommodation.", "tour-operator"),
            keywords: [
                __("checkout", "tour-operator"),
                __("time", "tour-operator"),
                __("check out", "tour-operator"),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __("Check out time", "tour-operator"),
                },
                className: "lsx-checkout-time-wrapper",
                layout: {
                    type: "flex",
                    flexWrap: "nowrap",
                },
            },
            innerBlocks: [
                [
                    "core/group",
                    {
                        layout: {
                            type: "flex",
                            flexWrap: "nowrap",
                            verticalAlignment: "middle",
                        },
                    },
                    [
                        [
                            "lsx-tour-operator/icons",
                            {
                                iconType: "solid",
                                iconName: "checkInAccommodationIcon",
                            },
                        ]
                    ],
                ],
                [
                    "core/group",
                    {
                        layout: {
                            type: "flex",
                            flexWrap: "nowrap",
                        },
                    },
                    [
                        [
                            "core/paragraph",
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: "lsx/post-meta",
                                            args: {
                                                key: "checkout_time",
                                            },
                                        },
                                    },
                                },
								prefixText : __('Check out time: ', 'tour-operator'),
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
                                            content: '<strong>' + __('Check out time: ', 'tour-operator') + '</strong>' + ' ' + __('3:00 PM', 'tour-operator'),
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
        registerCheckoutTimeVariation
    );

    conditionalRegister();
});
