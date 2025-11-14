import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerPriceIncludeExcludeVariation = () => {

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/price-include-exclude',
            title: __('Price Include & Exclude', 'tour-operator'),
            description: __('Display pricing inclusion and exclusion information for accommodations.', 'tour-operator'),
            icon: 'money-alt',
            category: 'lsx-tour-operator',
            keywords: [
                __('price', 'tour-operator'),
                __('includes', 'tour-operator'),
                __('excludes', 'tour-operator'),
                __('pricing', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                align: 'wide',
                metadata: {
                    name: 'Price Include & Exclude',
                },
                className: 'lsx-include-exclude-wrapper',
                layout: {
                    type: 'constrained',
                },
            },
            innerBlocks: [
                [
                    'core/columns',
                    {
                        align: 'wide',
                        metadata: {
                            name: __('Price Columns', 'tour-operator'),
                        },
                    },
                    [
                        [
                            'core/column',
                            {
                                width: '50%',
                                metadata: {
                                    name: __('Included Column', 'tour-operator'),
                                },
                                className: 'lsx-included-wrapper',
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        content: '<strong>' + __('Price Includes:', 'tour-operator') + '</strong>',
                                    },
                                ],
                                [
                                    'core/paragraph',
                                    {
                                        metadata: {
                                            bindings: {
                                                content: {
                                                    source: 'lsx/post-meta',
                                                    args: { key: 'included' },
                                                },
                                            },
                                        },
                                    },
                                ],
                            ],
                        ],
                        [
                            'core/column',
                            {
                                width: '50%',
                                metadata: {
                                    name: __('Excluded Column', 'tour-operator'),
                                },
                                className: 'lsx-not-included-wrapper',
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        content: '<strong>' + __('Price Excludes:', 'tour-operator') + '</strong>',
                                    },
                                ],
                                [
                                    'core/paragraph',
                                    {
                                        metadata: {
                                            bindings: {
                                                content: {
                                                    source: 'lsx/post-meta',
                                                    args: { key: 'not_included' },
                                                },
                                            },
                                        },
                                    },
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            supports: {
                renaming: false,
            },
            example: {
                attributes: {
                    align: 'wide',
                    className: 'lsx-include-exclude-wrapper',
                },
                innerBlocks: [
                    {
                        name: 'core/columns',
                        attributes: {
                            align: 'wide',
                        },
                        innerBlocks: [
                            {
                                name: 'core/column',
                                attributes: {
                                    width: '50%',
                                    className: 'lsx-included-wrapper',
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Price Includes:', 'tour-operator') + '</strong>',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('WiFi, breakfast, airport transfers, daily housekeeping', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/column',
                                attributes: {
                                    width: '50%',
                                    className: 'lsx-not-included-wrapper',
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Price Excludes:', 'tour-operator') + '</strong>',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('Meals not mentioned, tours, spa treatments, minibar', 'tour-operator'),
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
        registerPriceIncludeExcludeVariation
    );

    conditionalRegister();
});
