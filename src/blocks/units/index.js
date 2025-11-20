/**
 * Units Block Variation
 *
 * Registers a block variation for displaying accommodation units.
 * Only available on accommodation post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerUnitsVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/units',
            title: __('Units', 'tour-operator'),
            icon: 'admin-multisite',
            category: 'lsx-tour-operator',
            description: __('Displays all the unit (rooms/camps) types for this accommodation', 'tour-operator'),
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            keywords: [
                __('units', 'tour-operator'),
                __('rooms', 'tour-operator'),
                __('camps', 'tour-operator')],
            attributes: {
                metadata: {
                    name: __('Units', 'tour-operator'),
                    bindings: {
                        content: {
                            source: 'lsx/accommodation-units',
                            type: 'rooms',
                        },
                    },
                },
                align: 'wide',
                layout: {
                    type: 'constrained',
                },
                className: 'lsx-units-wrapper',
                tagName: 'section',
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        align: 'wide',
                        layout: {
                            type: 'flex',
                            flexWrap: 'nowrap',
                        },
                    },
                    [
                        [
                            'core/separator',
                            {
                                style: {
                                    layout: {
                                        selfStretch: 'fill',
                                        flexSize: null,
                                    },
                                },
                            },
                        ],
                        [
                            'core/heading',
                            {
                                textAlign: 'center',
                                content: __('Units', 'tour-operator'),
                            },
                        ],
                        [
                            'core/separator',
                            {
                                style: {
                                    layout: {
                                        selfStretch: 'fill',
                                        flexSize: null,
                                    },
                                },
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {
                        align: 'wide',

                        layout: {
                            type: 'constrained',
                        },
                    },
                    [
                        [
                            'core/pattern',
                            {
                                slug: 'lsx-tour-operator/room-card',
                            },
                        ],
                    ],
                ],
            ],
            example: {
                innerBlocks: [
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
                                name: 'core/separator',
                            },
                            {
                                name: 'core/heading',
                                attributes: {
                                    textAlign: 'center',
                                    content: __('Units', 'tour-operator'),
                                    level: 2,
                                },
                            },
                            {
                                name: 'core/separator',
                            },
                        ],
                    },
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'grid',
                                columnCount: 3,
                                minimumColumnWidth: null,
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/image',
                                attributes: {
                                    url: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 75"%3E%3Crect fill="%23ddd" width="100" height="75"/%3E%3C/svg%3E',
                                    alt: '',
                                },
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/heading',
                                        attributes: {
                                            level: 3,
                                            content: __('Double Room', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/separator',
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('Comfortable room with amenities', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('From:', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('$150', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/image',
                                attributes: {
                                    url: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 75"%3E%3Crect fill="%23ddd" width="100" height="75"/%3E%3C/svg%3E',
                                    alt: '',
                                },
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/heading',
                                        attributes: {
                                            level: 3,
                                            content: __('King Room', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/separator',
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('Luxury room with premium features', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('From:', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: __('$250', 'tour-operator'),
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
        registerUnitsVariation
    );

    conditionalRegister();
});
