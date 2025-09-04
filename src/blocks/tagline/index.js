wp.domReady(() => {
	wp.blocks.registerBlockVariation("core/paragraph", {
		name: "lsx-tour-operator/tagline",
		title: "Tagline",
		category: "lsx-tour-operator",
		icon: "text-page",
		attributes: {
			metadata: {
				name: "Tagline",
				bindings: {
					content: {
						source: "lsx/post-meta",
						args: {
							key: "tagline",
						},
					},
				},
			},
			align: "center",
			className: "lsx-tagline-wrapper",
		},
		isDefault: false,
		supports: {
			renaming: false,
		},
		example: {
			attributes: {
				metadata: {
					name: "Tagline",
				},
			},
			innerBlocks: [
				[
					"core/paragraph",
					{
						content: "Discover the magic of Africa",
						style: {
							typography: {
								fontSize: "1.5rem",
							},
						},
					},
				],
			],
		},
	});
});
