
wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx/itinerary',
        title: 'Itinerary',
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
});
