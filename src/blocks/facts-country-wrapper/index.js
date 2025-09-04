wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/facts-country-wrapper",
		title: "Country",
		icon: "admin-site",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Country",
			},
			className: "facts-country-query-wrapper",
			layout: {
				type: "flex",
				flexWrap: "nowrap",
			},
		},
		innerBlocks: [
			[
				"core/group",
				{
					layout: {
						type: "flex",
						flexWrap: "nowrap",
						verticalAlignment: "top",
					},
				},
				[
					[
						"core/image",
						{
							width: "20px",
							sizeSlug: "large",
							url: "https://tour-operator.lsx.design/wp-content/uploads/2024/09/destinations-icon-black-20px.png",
							alt: "",
						},
					],
					[
						"core/paragraph",
						{
							content: "<strong>Country:</strong>",
						},
					],
				],
			],
			[
				"core/group",
				{
					layout: {
						type: "flex",
						flexWrap: "nowrap",
					},
				},
				[
					[
						"core/paragraph",
						{
							metadata: {
								bindings: {
									content: {
										source: "lsx/post-connection",
										args: {
											key: "post_parent",
										},
									},
								},
							},
							content: "",
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
					name: "Country Facts",
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
								content: "Country Facts",
								level: 3,
							},
						],
						[
							"core/paragraph",
							{
								content: "Capital: Cape Town | Population: 59 million | Currency: ZAR",
							},
						],
					],
				],
			],
		},
	});
});
