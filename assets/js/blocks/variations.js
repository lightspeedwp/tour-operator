wp.domReady(function () {
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
        icon: 'admin-multisite',
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

    wp.blocks.egisterBlockVariation('core/gallery', {
        name: 'lsx/gallery',
        title: 'TO Gallery',
        icon: 'admin-multisite',
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

    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx/price',
        title: 'Price',
        icon: 'bank',
        attributes: {
            metadata: {
                name: 'Price',
            },
            align: 'wide',
            layout: {
                type: 'flex',
                flexWrap: 'nowrap'
            },
            className: 'lsx-price-wrapper'
        },
        innerBlocks: [
            ['core/paragraph', {
                padding: {
                    top: '2px',
                    bottom: '2px'
                },
                typography: {
                    fontSize: 'x-small'
                },
                content: '<strong>From:</strong>',
                className: 'has-x-small-font-size',
            }],
            ['core/paragraph', {
                metadata: {
                    bindings: {
                        content: {
                            source: 'lsx/post-meta',
                            args: { key: 'price' }
                        }
                    }
                },
                className: 'has-primary-color has-text-color has-link-color',
                color: {
                    link: 'primary-700',
                    text: 'primary-700'
                }
            }]
        ],
        isDefault: false
    });

    wp.blocks.registerBlockVariation('core/cover', {
        name: 'cover-with-link',
        title: 'Cover with Link',
        description: 'A Cover block that can be linked.',
        attributes: {
        },
        isDefault: false,
    });
});
