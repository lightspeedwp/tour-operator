/**
 * Facts Country Wrapper Block Variation
 *
 * Registers a block variation for destination country display.
 * Only available on destination post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerFactsCountryWrapperVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/facts-country-wrapper',
            title: __('Country', 'tour-operator'),
            icon: 'admin-site',
            category: 'lsx-tour-operator',
            description: __('Display the country associated with this destination.', 'tour-operator'),
            keywords: [
                __('country', 'tour-operator'),
                __('destination', 'tour-operator'),
                __('location', 'tour-operator'),
                __('facts', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Country', 'tour-operator'),
                },
                className: 'facts-country-query-wrapper',
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
                                content: `<strong>${__('Country', 'tour-operator')}</strong>`,
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
                                                key: 'post_parent',
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
                                            content: '<strong>' + __('Country: ', 'tour-operator') + '</strong>' + ' ' + __('South Africa', 'tour-operator'),
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
        registerFactsCountryWrapperVariation
    );

    conditionalRegister();
});
