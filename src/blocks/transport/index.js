wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/transport",
		title: "Transport",
		icon: "car",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Transport",
			},
			className: "lsx-transport-wrapper",
			layout: {
				type: "constrained",
			},
		},
		innerBlocks: [
			[
				"core/group",
				{
					layout: {
						type: "constrained",
					},
				},
				[
					[
						"core/group",
						{
							layout: {
								type: "constrained",
							},
						},
						[
							[
								"core/paragraph",
								{
									align: "center",
									content: "<strong>Transport</strong>",
								},
							],
						],
					],
					[
						"core/group",
						{
							layout: {
								type: "constrained",
							},
						},
						[
							[
								"core/paragraph",
								{
									metadata: {
										bindings: {
											content: {
												source: "lsx/post-meta",
												args: {
													key: "transport",
												},
											},
										},
									},
								},
							],
						],
					],
				],
			],
			[
				"core/buttons",
				{},
				[
					[
						"core/button",
						{
							width: 100,
							content: "View More",
						},
					],
				],
			],
		],
		supports: {
			renaming: false,
		},
		example: {
			attributes: {
				metadata: {
					name: "Transport",
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
								content: "Transport",
								level: 3,
							},
						],
						[
							"core/paragraph",
							{
								content: "Private transfers and safari vehicles included.",
							},
						],
					],
				],
			],
		},
	});
});
