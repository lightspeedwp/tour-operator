import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/cover', {
        name: 'lsx-tour-operator/banner-cover',
        title: __('Banner Cover', 'tour-operator'),
        description: __('Cover block using banner image from custom field', 'tour-operator'),
        icon: 'cover-image',
        category: 'lsx-tour-operator',
        keywords: [
            __('banner', 'tour-operator'),
            __('cover', 'tour-operator'),
            __('image', 'tour-operator'),
            __('header', 'tour-operator'),
        ],
        isActive: (blockAttributes, variationAttributes) => {
            return blockAttributes.className === variationAttributes.className;
        },
        attributes: {
            metadata: {
                name: __('Banner Cover', 'tour-operator'),
                bindings: {
                    content: {
                        source: 'lsx/post-meta',
                        args: {
                            key: 'banner_image',
                        },
                    },
                },
            },
            dimRatio: 50,
            minHeight: 400,
            align: 'full',
            className: 'lsx-banner-cover',
            useFeaturedImage: true,
        },
        innerBlocks: [
            [
                'core/post-title',
                {
                    textAlign: 'center',
                },
            ],
            [
                'core/paragraph',
                {
                    align: 'center',
                    metadata: {
                        name: __('Tagline', 'tour-operator'),
                        bindings: {
                            content: {
                                source: 'lsx/post-meta',
                                args: {
                                    key: 'tagline',
                                },
                            },
                        },
                    },
                    className: 'lsx-tagline-wrapper',
                },
            ],
        ],
        example: {
            innerBlocks: [
                {
                    name: 'core/group',
                    innerBlocks: [
                        {
                            name: 'core/heading',
                            attributes: {
                                content: __('Page Title', 'tour-operator'),
                                textAlign: 'center',
                            },
                        },
                        {
                            name: 'core/paragraph',
                            attributes: {
                                content: `<strong>${__('Tagline', 'tour-operator')}</strong>`,
                                align: 'center',
                            },
                        },
                    ],
                },
            ],
        },
    });
});
