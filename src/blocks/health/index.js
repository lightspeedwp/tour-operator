wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/health",
		title: "Health",
		icon: "insert",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Health",
			},
			className: "lsx-health-wrapper",
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
									content: "<strong>Health</strong>",
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
													key: "health",
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
							backgroundColor: "primary",
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
					name: "Health",
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
								content: "Health",
								level: 3,
							},
						],
						[
							"core/paragraph",
							{
								content: "No special vaccinations required. Malaria precautions recommended.",
							},
						],
					],
				],
			],
		},
	});
});
