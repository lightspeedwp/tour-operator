wp.domReady(() => {

wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/itinerary",
		title: "Itinerary",
		icon: "clipboard",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Itinerary",
			},
			align: "wide",
			layout: {
				type: "constrained",
			},
			className: "lsx-itinerary-wrapper",
			tagName: "section"
		},
		innerBlocks: [
			['core/group',
				{
					layout: {
						type: "flex",
						flexWrap: "nowrap",
					}
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
							backgroundColor: 'primary',
						}
					],
					[
						'core/heading',
						{
							textAlign: 'center',
							content: 'Tour Itinerary',
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
							backgroundColor: 'primary',
						}
					]
				]
			],
			[
				"core/paragraph",
				{
					placeholder: "Replace this with the Day by Day block, and select a pattern.",
					align: "center",
				},
			]
		],
		supports: {
			renaming: false
		}
	});

});