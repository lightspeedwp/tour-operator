import { __ } from '@wordpress/i18n';

wp.domReady( () => {
    wp.blocks.registerBlockVariation( 'core/gallery', {
        name: 'lsx-tour-operator/gallery',
        title: __('TO Gallery', 'tour-operator'),
        icon: 'format-gallery',
        category: 'lsx-tour-operator',
        description: __('Display multiple images a Tour Operator gallery', 'tour-operator'),
        attributes: {
            metadata: {
                name: __('TO Gallery', 'tour-operator'),
                bindings: {
                    content: {
                        source: 'lsx/gallery',
                    },
                },
            },
            linkTo: 'none',
            sizeSlug: 'thumbnail',
        },
        innerBlocks: [
            [
                'core/image',
                {
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/placeholder.png',
                },
            ],
            [
                'core/image',
                {
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/placeholder.png',
                },
            ],
            [
                'core/image',
                {
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/placeholder.png',
                },
            ],
        ],
        isDefault: false,
    } );
} );
