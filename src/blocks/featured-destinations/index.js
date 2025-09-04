wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/featured-destinations",
		title: "Featured Destinations",
		icon: "admin-site",
		description: "Displays Destinations with Featured tag.",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Featured Destinations",
			},
			className: "lsx-featured-destinations-query-wrapper",
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
					["core/heading", { textAlign: "center", content: "Featured Destinations" }],
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
								name: "Featured Destination Query",
							},
							query: {
								perPage: 8,
								postType: "destination",
								order: "asc",
								orderBy: "date",
							},
							align: "wide",
						},
						[
							[
								"core/post-template",
								{
									className: "lsx-featured-destinations-query",
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
					name: "Featured Destinations",
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
								content: "Featured Destinations",
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
									columnCount: 2,
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
										["core/heading", { content: "Maasai Mara, Kenya", level: 3 }],
										[
											"core/paragraph",
											{
												content:
													"World-famous safari destination offering incredible wildlife viewing opportunities and authentic cultural experiences.",
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
										["core/heading", { content: "Swiss Alps, Switzerland", level: 3 }],
										[
											"core/paragraph",
											{
												content:
													"Breathtaking alpine scenery with pristine mountain peaks, charming villages, and world-class skiing.",
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
										["core/heading", { content: "Bali, Indonesia", level: 3 }],
										[
											"core/paragraph",
											{
												content:
													"Tropical paradise with stunning beaches, ancient temples, and rich cultural heritage.",
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
										["core/heading", { content: "Patagonia, Chile", level: 3 }],
										[
											"core/paragraph",
											{
												content:
													"Wild and remote landscape featuring dramatic glaciers, towering mountains, and pristine wilderness.",
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
