import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerSingleSupplementVariation = () => {

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/single-supplement-wrapper',
            title: __('Single supplement', 'tour-operator'),
            icon: 'money-alt',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
            },
            attributes: {
                metadata: {
                    name: 'Single supplement',
                },
                className: 'lsx-single-supplement-wrapper',
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
                                iconName: 'singleSupplementIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '<strong>' + __('Single supplement:', 'tour-operator') + '</strong>',
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {},
                    [
                        [
                            'core/paragraph',
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: 'lsx/post-meta',
                                            args: {
                                                key: 'single_supplement',
                                            },
                                        },
                                    },
                                },
                                className: 'amount',
                                content: '',
                            },
                        ],
                    ],
                ],
            ],
            supports: {
                renaming: false,
            },
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
                                    iconName: 'singleSupplementIcon',
                                },
                            },
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: '<strong>' + __('Single supplement: ', 'tour-operator') + '</strong>' + '$299',
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
        ['tour'], // Supported post types
        ['tour'], // Template slug patterns
        registerSingleSupplementVariation
    );

    conditionalRegister();
});
