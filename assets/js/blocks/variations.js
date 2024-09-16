wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx/itinerary',
        title: 'Itinerary',
		icon: 'list-view',
        attributes: {
            metadata: {
                name: 'Itinerary',
                bindings: {
                    content: {
                        source: 'lsx/tour-itinerary'
                    }
                }
            },
            align: 'wide',
            layout: {
                type: 'constrained'
            }
        },
        innerBlocks: [
            ['core/paragraph', {
                placeholder: 'Insert your Itinerary pattern here.',
				align: 'center'
            }]
        ],
        isDefault: false
    });

    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx/accommodation-units',
        title: 'Units',
		icon : 'admin-multisite',
        attributes: {
            metadata: {
                name: 'Units',
                bindings: {
                    content: {
                        source: 'lsx/accommodation-units'
                    }
                }
            },
            align: 'wide',
            layout: {
                type: 'constrained'
            }
        },
        innerBlocks: [
            ['core/paragraph', {
                placeholder: 'Insert your Room pattern here.',
				align: 'center'
            }]
        ],
        isDefault: false
    });

    wp.blocks.registerBlockVariation('core/gallery', {
        name: 'lsx/gallery',
        title: 'TO Gallery',
		icon : 'admin-multisite',
        attributes: {
            metadata: {
                name: 'TO Gallery',
                bindings: {
                    content: {
                        source: 'lsx/gallery'
                    }
                }
            },
            linkTo: 'none',
            sizeSlug: 'thumbnail'
        },
        innerBlocks: [
            ['core/image', {
                href: 'https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg'
            }],
            ['core/image', {
                href: 'https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg'
            }],
            ['core/image', {
                href: 'https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg'
            }]
        ],
        isDefault: false
    });
});
