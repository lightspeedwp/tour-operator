wp.domReady(() => {

wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/day-by-day",
		title: "Day by day",
		icon: "clipboard",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Day by day",
				bindings: {
					content: {
						source: "lsx/tour-itinerary",
					},
				},
			},
			align: "wide",
			layout: {
				type: "constrained",
			},
		},
		innerBlocks: [
			['core/pattern', {
				slug: 'lsx-tour-operator/itinerary-list'
			}]
		],
		supports: {
			renaming: false
		},
		parent: ["lsx-tour-operator/itinerary"], // Restricts to "lsx/itinerary" block
	});

});