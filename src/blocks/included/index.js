wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/included",
		title: "Included Items",
		icon: "plus-alt",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Included",
			},
			className: "lsx-included-wrapper",
		},
		innerBlocks: [
			[
				"core/paragraph",
				{
					content: "<strong>Price Includes: </strong>",
				},
			],
			[
				"core/paragraph",
				{
					metadata: {
						bindings: {
							content: {
								source: "lsx/post-meta",
								args: {
									key: "included",
								},
							},
						},
					},
				},
			],
		],
		supports: {
			renaming: false,
		},
		example: {
			attributes: {
				metadata: {
					name: "Included",
				},
			},
			innerBlocks: [
				[
					"core/group",
					{},
					[
						[
							"core/heading",
							{
								content: "Included",
								level: 3,
							},
						],
						[
							"core/list",
							{
								values: "<li>Accommodation</li><li>Meals</li><li>Transportation</li><li>Guide services</li>",
							},
						],
					],
				],
			],
		},
	});
});
