/**
 * Best Time to Visit Block Variation
 *
 * Registers a block variation for displaying best time to visit information.
 * Only available on destination post types and destination, country, and region templates screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '../../utils/conditional-block-registration';

wp.domReady(() => {
    const registerBestTimeToVisitVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/best-time-to-visit',
            title: __('Best months to visit', 'tour-operator'),
            icon: 'calendar-alt',
            category: 'lsx-tour-operator',
            keywords: [
                __('best months to visit', 'tour-operator'),
                __('best time to visit', 'tour-operator'),
                __('travel', 'tour-operator'),
                __('visit', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Best months to visit', 'tour-operator'),
                },
                className: 'lsx-best-time-to-visit-wrapper',
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
                                iconType: 'outline',
                                iconName: 'bestMonthsToTravelIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: `<strong>${__('Best months to visit', 'tour-operator')}</strong>`,
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
                                                key: 'best_time_to_visit',
                                            },
                                        },
                                    },
                                },
                                content: __('Best months to visit', 'tour-operator'),
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
                                            iconType: 'outline',
                                            iconName: 'bestMonthsToTravelIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Best months to visit', 'tour-operator') + '</strong>',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: 'January, February, March',
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
        registerBestTimeToVisitVariation
    );

    conditionalRegister();
});
