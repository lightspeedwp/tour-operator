import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerNotIncludedVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/not-included',
            title: __('Excluded items', 'tour-operator'),
            icon: 'dismiss',
            category: 'lsx-tour-operator',
            description: __('A block to list what is not included in the tour or accommodation price.', 'tour-operator'),
            keywords: [
                __('excluded', 'tour-operator'),
                __('items', 'tour-operator'),
                __('what is excluded', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Not included', 'tour-operator'),
                },
                className: 'lsx-not-included-wrapper',
            },
            innerBlocks: [
                [
                    'core/paragraph',
                    {
                        content: '<strong>' + __('Price excludes:', 'tour-operator') + '</strong>',
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
                                        key: 'not_included',
                                    },
                                },
                            },
                        },
                    },
                ],
            ],
            example: {
                attributes: {
                    className: 'lsx-not-included-wrapper',
                },
                innerBlocks: [
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'constrained',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/group',
                                attributes: {
                                    layout: {
                                        type: 'constrained',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Price excludes:', 'tour-operator') + '</strong>',
                                        },
                                    },
                                ],
                            },
                        ],
                    },
                    {
                        name: 'core/list',
                        attributes: {},
                        innerBlocks: [
                            {
                                name: 'core/list-item',
                                attributes: {
                                    content: __('International airfare', 'tour-operator'),
                                },
                            },
                            {
                                name: 'core/list-item',
                                attributes: {
                                    content: __('Travel insurance', 'tour-operator'),
                                },
                            },
                            {
                                name: 'core/list-item',
                                attributes: {
                                    content: __('Visas', 'tour-operator'),
                                },
                            },
                        ],
                    },
                ],
            },
        });
    };

    // Initialize conditional registration
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour', 'accommodation'], // Supported post types
        ['tour', 'accommodation'], // Template slug patterns
        registerNotIncludedVariation
    );

    conditionalRegister();
});
