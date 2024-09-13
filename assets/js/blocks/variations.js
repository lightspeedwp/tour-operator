
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
});
