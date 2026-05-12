/**
 * Wetu Map Block Variation
 *
 * Registers a block variation for displaying Wetu map integration.
 * Only available on tour post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerWetuMapBlock = () => {
        // Check if lsxToEditor and assetsUrl are available
        const hasAssetsUrl = typeof lsxToEditor !== 'undefined' && lsxToEditor?.assetsUrl;

        // Build innerBlocks conditionally
        const groupInnerBlocks = hasAssetsUrl ? [
            [
                'core/image',
                {
                    align: 'full',
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/wetu-map-figme-prototype-image.png',
                    alt: '',
                },
            ],
        ] : [];

        // Build example innerBlocks conditionally
        const exampleInnerBlocks = hasAssetsUrl ? [
            {
                name: 'core/image',
                attributes: {
                    align: 'full',
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/wetu-map-figme-prototype-image.png',
                },
            }
        ] : [];

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/wetu-map',
            title: __('WETU Map', 'tour-operator'),
            icon: 'admin-site-alt3',
            category: 'lsx-tour-operator',
            description: __('Displays a WETU map for itineraries.', 'tour-operator'),
            keywords: [
                __('wetu', 'tour-operator'),
                __('map', 'tour-operator'),
                __('itinerary', 'tour-operator'),
            ],
            attributes: {
                metadata: {
                    name: 'WETU Map',
                    bindings: {
                        content: {
                            source: 'lsx/map',
                            type: 'wetu',
                        },
                    },
                },
                layout: {
                    type: 'constrained',
                },
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        align: 'wide',
                        layout: {
                            type: 'default',
                        },
                    },
                    groupInnerBlocks,
                ],
            ],
            example: {
                innerBlocks: [
                    {
                        name: 'core/group',
                        attributes: {
                            align: 'wide',
                            layout: {
                                type: 'default',
                            },
                        },
                        innerBlocks: exampleInnerBlocks,
                    },
                ]
            },
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
        });
    }

    // Initialize conditional registration for tour context
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour'], // Supported post types
        ['tour'], // Template slug patterns
        registerWetuMapBlock
    );

    conditionalRegister();
});
