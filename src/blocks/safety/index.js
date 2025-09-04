wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/safety",
		title: "Safety",
		icon: "shield",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Safety",
			},
			className: "lsx-safety-wrapper",
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
									content: "<strong>Safety</strong>",
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
													key: "safety",
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
					name: "Safety",
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
								content: "Safety",
								level: 3,
							},
						],
						[
							"core/paragraph",
							{
								content: "Safe destination with professional guides and secure accommodation.",
							},
						],
					],
				],
			],
		},
	});
});
