/**
 * Included Block Variation
 *
 * Registers a block variation for displaying what's included.
 * Only available on tour and accommodation post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerIncludedVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/included',
            title: __('Included items', 'tour-operator'),
            icon: 'plus-alt',
            category: 'lsx-tour-operator',
            description: __('A block to list what is included in the tour or accommodation price.', 'tour-operator'),
            keywords: [
                __('included', 'tour-operator'),
                __('items', 'tour-operator'),
                __('what is included', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: __('Included', 'tour-operator'),
                },
                className: 'lsx-included-wrapper',
            },
            innerBlocks: [
                [
                    'core/paragraph',
                    {
                        content: '<strong>' + __('Price includes:', 'tour-operator') + '</strong>',
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
                                        key: 'included',
                                    },
                                },
                            },
                        },
                    },
                ],
            ],
            example: {
                attributes: {
                    className: 'lsx-included-wrapper',
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
                                            content: '<strong>' + __('Price includes:', 'tour-operator') + '</strong>',
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
                                    content: __('Accommodation', 'tour-operator'),
                                },
                            },
                            {
                                name: 'core/list-item',
                                attributes: {
                                    content: __('All meals and local brand drinks', 'tour-operator'),
                                },
                            },
                            {
                                name: 'core/list-item',
                                attributes: {
                                    content: __('Guided excursions', 'tour-operator'),
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
        registerIncludedVariation
    );

    conditionalRegister();
});
