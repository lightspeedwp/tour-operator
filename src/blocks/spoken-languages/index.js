/**
 * Spoken Languages Block Variation
 *
 * Registers a block variation for displaying spoken languages information.
 * Only available on accommodations post types and templates screens.
 *
 * @since 2.1.0
 * @package
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerSpokenLanguagesVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/spoken-languages',
            title: __('Spoken Languages', 'tour-operator'),
            description: __(
                'Display spoken languages information for accommodations.',
                'tour-operator'
            ),
            icon: 'translation',
            category: 'lsx-tour-operator',
            keywords: [
                __('spoken', 'tour-operator'),
                __('languages', 'tour-operator'),
                __('communication', 'tour-operator'),
                __('multilingual', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return (
                    blockAttributes.className === variationAttributes.className
                );
            },
            attributes: {
                metadata: {
                    name: __('Spoken Languages', 'tour-operator'),
                },
                className: 'lsx-spoken-languages-wrapper',
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
                        metadata: {
                            name: __('Title', 'tour-operator'),
                        },
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
                                iconName: 'spokenLanguagesIcon',
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {
                        metadata: {
                            name: __('Languages Content', 'tour-operator'),
                        },
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
                                                key: 'spoken_languages',
                                            },
                                        },
                                    },
                                },
                                prefix: __(
                                    'Spoken Languages:',
                                    'tour-operator'
                                ),
                                prefixBold: true,
                            },
                        ],
                    ],
                ],
            ],
            example: {
                attributes: {
                    className: 'lsx-spoken-languages-wrapper',
                },
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
                                    iconName: 'spokenLanguagesIcon',
                                },
                            },
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content:
                                        '<strong>' +
                                        __(
                                            'Spoken Languages:',
                                            'tour-operator'
                                        ) +
                                        '</strong>',
                                },
                            },
                        ],
                    },
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'flex',
                                flexWrap: 'nowrap',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: __(
                                        'English, Spanish, French, German',
                                        'tour-operator'
                                    ),
                                },
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
        registerSpokenLanguagesVariation
    );

    conditionalRegister();
});
