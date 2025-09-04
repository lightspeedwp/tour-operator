wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/tour-related-tour",
		title: "Related Tours - Tour",
		icon: "palmtree",
		description: "Displays tours related to this Tour via the destinations.",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Related Tours - Tour",
			},
			className: "lsx-tour-related-tour-query-wrapper",
			align: "full",
			layout: {
				type: "constrained",
			},
			tagName: "section",
		},
		innerBlocks: [
			[
				"core/group",
				{
					align: "wide",
					layout: { type: "flex", flexWrap: "nowrap" },
				},
				[
					["core/separator", { style: { layout: { selfStretch: "fill", flexSize: null } } }],
					["core/heading", { textAlign: "center", content: "Related Tours" }],
					["core/separator", { style: { layout: { selfStretch: "fill", flexSize: null } } }],
				],
			],
			[
				"core/group",
				{ align: "wide", layout: { type: "constrained" } },
				[
					[
						"core/query",
						{
							metadata: {
								name: "Related Tours Query",
							},
							query: {
								perPage: 8,
								postType: "tour",
								order: "asc",
								orderBy: "date",
							},
							align: "wide",
						},
						[
							[
								"core/post-template",
								{
									className: "lsx-tour-related-tour-query",
									layout: {
										type: "grid",
										columnCount: 3,
									},
								},
								[["core/pattern", { slug: "lsx-tour-operator/destination-card" }]],
							],
						],
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
					name: "Related Tours",
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
								content: "Related Tours",
								textAlign: "center",
							},
						],
						[
							"core/group",
							{
								style: {
									spacing: {
										blockGap: "2rem",
									},
								},
								layout: {
									type: "grid",
									columnCount: 3,
								},
							},
							[
								[
									"core/group",
									{
										style: {
											border: {
												width: "1px",
												style: "solid",
												color: "#e0e0e0",
											},
											spacing: {
												padding: "1rem",
											},
										},
									},
									[
										["core/heading", { content: "Ultimate Safari Adventure", level: 3 }],
										[
											"core/paragraph",
											{
												content:
													"Comprehensive wildlife tour featuring Kenya's most famous national parks and reserves.",
											},
										],
									],
								],
								[
									"core/group",
									{
										style: {
											border: {
												width: "1px",
												style: "solid",
												color: "#e0e0e0",
											},
											spacing: {
												padding: "1rem",
											},
										},
									},
									[
										["core/heading", { content: "Cultural Heritage Journey", level: 3 }],
										[
											"core/paragraph",
											{
												content:
													"Immersive cultural experience exploring local traditions, communities, and historical sites.",
											},
										],
									],
								],
								[
									"core/group",
									{
										style: {
											border: {
												width: "1px",
												style: "solid",
												color: "#e0e0e0",
											},
											spacing: {
												padding: "1rem",
											},
										},
									},
									[
										["core/heading", { content: "Mountain Trekking Expedition", level: 3 }],
										[
											"core/paragraph",
											{
												content:
													"Challenging mountain adventure with breathtaking views and professional guides.",
											},
										],
									],
								],
							],
						],
					],
				],
			],
		},
	});
});
