wp.domReady(() => {

wp.blocks.registerBlockVariation('core/navigation', {
	name: 'lsx-tour-operator/anchored-navigation',
	title: 'Anchored Navigation',
	icon: 'menu-alt',
	category: 'lsx-tour-operator',
	attributes: {
		metadata: {
			name: 'Anchored Navigation',
		},
		className: 'lsx-anchored-navigation',
		layout: {
			type: 'flex',
			flexWrap: 'wrap',
			justifyContent: 'center'
		}
	},
	innerBlocks: [
		['core/navigation-link', {
			label: 'Overview',
			url: '#overview'
		}],
		['core/navigation-link', {
			label: 'Itinerary',
			url: '#itinerary'
		}],
		['core/navigation-link', {
			label: 'Accommodation',
			url: '#accommodation'
		}],
		['core/navigation-link', {
			label: 'Inclusions',
			url: '#inclusions'
		}],
		['core/navigation-link', {
			label: 'Map',
			url: '#map'
		}],
		['core/navigation-link', {
			label: 'Gallery',
			url: '#gallery'
		}]
	],
	supports: {
		renaming: false
	},
	isActive: (blockAttributes, variationAttributes) => {
		return blockAttributes.className && 
			blockAttributes.className.includes('lsx-anchored-navigation');
	}
});

});