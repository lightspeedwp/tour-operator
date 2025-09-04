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
		
		example: {
		"attributes": {
				"metadata": {
						"name": "Day by Day"
				}
		},
		"innerBlocks": [
				[
						"core/group",
						{},
						[
								[
										"core/heading",
										{
												"content": "Day by Day",
												"level": 3
										}
								],
								[
										"core/paragraph",
										{
												"content": "Detailed daily breakdown of your tour experience."
										}
								]
						]
				]
		]
},
parent: ["lsx-tour-operator/itinerary"], // Restricts to "lsx/itinerary" block
	});

});