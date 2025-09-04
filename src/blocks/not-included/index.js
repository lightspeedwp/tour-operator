wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/not-included",
		title: "Excluded Items",
		icon: "dismiss",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Not Included",
			},
			className: "lsx-not-included-wrapper",
		},
		innerBlocks: [
			[
				"core/paragraph",
				{
					content: "<strong>Price Excludes:</strong>",
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
									key: "not_included",
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
					name: "Not Included",
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
								content: "Price excludes:",
								level: 3,
							},
						],
						[
							"core/list",
							{
								values: "<li>International flights</li><li>Personal expenses</li><li>Travel insurance</li>",
							},
						],
					],
				],
			],
		},
	});
});
