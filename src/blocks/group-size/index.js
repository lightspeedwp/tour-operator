/**
 * Group Size Block Variation
 *
 * Registers a block variation for displaying tour group size.
 * Only available on tour post type edit screens.
 *
 * @since 2.1.0
 * @package
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerGroupSizeVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/group-size',
            title: __('Group size', 'tour-operator'),
            description: __(
                'Displays the group size for a tour.',
                'tour-operator'
            ),
            icon: 'groups',
            category: 'lsx-tour-operator',
            keywords: [
                __('group size', 'tour-operator'),
                __('size', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return (
                    blockAttributes.className === variationAttributes.className
                );
            },
            attributes: {
                metadata: {
                    name: __('Group size', 'tour-operator'),
                },
                className: 'lsx-group-size-wrapper',
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
                                iconName: 'groupSizeIcon',
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
                                                key: 'group_size',
                                            },
                                        },
                                    },
                                },
                                prefix: __('Group size:', 'tour-operator'),
                                prefixBold: true,
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
                                            iconName: 'groupSizeIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content:
                                                '<strong>' +
                                                __(
                                                    'Group size:',
                                                    'tour-operator'
                                                ) +
                                                '</strong>' +
                                                ' ' +
                                                __(
                                                    '10 people',
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
        registerGroupSizeVariation
    );

    conditionalRegister();
});
