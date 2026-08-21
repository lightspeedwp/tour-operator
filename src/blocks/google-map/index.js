/**
 * Google Map Block Variation
 *
 * Registers a block variation for displaying Google Maps integration.
 * Available across all TO post types and templates.
 *
 * @since 2.1.0
 * @package
 */
import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerGoogleMapVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/google-map',
            title: __('Google Map', 'tour-operator'),
            description: __(
                'Display a Google Map based on the current Tour Operator page.',
                'tour-operator'
            ),
            category: 'lsx-tour-operator',
            icon: 'admin-site-alt3',
            keywords: [
                __('google', 'tour-operator'),
                __('map', 'tour-operator'),
                __('maps', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return (
                    blockAttributes.className === variationAttributes.className
                );
            },
            attributes: {
                metadata: {
                    name: __('Google Map', 'tour-operator'),
                },
                className: 'lsx-location-wrapper',
                align: 'full',
                layout: {
                    type: 'constrained',
                },
                tagName: 'section',
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        align: 'wide',
                        metadata: {
                            name: 'Title',
                        },
                        layout: { type: 'flex', flexWrap: 'nowrap' },
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
                                content: __('Location', 'tour-operator'),
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
                        layout: { type: 'default' },
                        name: 'Map Container',
                        metadata: {
                            name: 'Map Container',
                        },
                    },
                    [
                        [
                            'core/cover',
                            {
                                url:
                                    lsxToEditor.assetsUrl +
                                    'blocks/placeholder-map-1920x656.jpg',
                                dimRatio: 50,
                                customOverlayColor: '#e2f0f7',
                                isUserOverlayColor: false,
                                isDark: false,
                                layout: { type: 'constrained' },
                                className: 'lsx-map-preview',
                                name: 'Preview',
                            },
                            [
                                [
                                    'core/paragraph',
                                    {
                                        align: 'center',
                                        fontSize: 'large',
                                        content:
                                            '<a href="#">Click here to display the map</a>',
                                        className:
                                            'has-text-align-center has-large-font-size',
                                    },
                                ],
                            ],
                        ],
                        [
                            'core/group',
                            {
                                align: 'wide',
                                layout: { type: 'default' },
                                className: 'hidden',
                                metadata: {
                                    name: 'Map Details',
                                    bindings: {
                                        content: {
                                            source: 'lsx/map',
                                            type: 'google',
                                        },
                                    },
                                },
                            },
                            [],
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
                            layout: { type: 'flex', flexWrap: 'nowrap' },
                        },
                        innerBlocks: [
                            {
                                name: 'core/separator',
                                attributes: {
                                    style: {
                                        layout: {
                                            selfStretch: 'fill',
                                            flexSize: null,
                                        },
                                    },
                                },
                            },
                            {
                                name: 'core/heading',
                                attributes: {
                                    textAlign: 'center',
                                    content: __('Location', 'tour-operator'),
                                    level: 2,
                                },
                            },
                            {
                                name: 'core/separator',
                                attributes: {
                                    style: {
                                        layout: {
                                            selfStretch: 'fill',
                                            flexSize: null,
                                        },
                                    },
                                },
                            },
                        ],
                    },
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
                                    url:
                                        lsxToEditor.assetsUrl +
                                        'blocks/placeholder-map-1920x656.jpg',
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
        ['accommodation', 'tour', 'destination'], // Supported post types
        ['accommodation', 'tour', 'destination', 'region', 'country'], // Template slug patterns
        registerGoogleMapVariation
    );

    conditionalRegister();
});
