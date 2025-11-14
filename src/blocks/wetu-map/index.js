import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerWetuMapBlock = () => {
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
                    [
                        [
                            'core/image',
                            {
                                align: 'full',
                                sizeSlug: 'large',
                                url:
                                    lsxToEditor.assetsUrl +
                                    'blocks/wetu-map-figme-prototype-image.png',
                                alt: '',
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
                            align: 'wide',
                            layout: {
                                type: 'default',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/image',
                                attributes: {
                                    align: 'full',
                                    sizeSlug: 'large',
                                    url: lsxToEditor.assetsUrl + 'blocks/wetu-map-figme-prototype-image.png',
                                },
                            }
                        ],
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
