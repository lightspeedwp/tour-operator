wp.domReady(() => {

wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/duration",
		title: "Duration",
		icon: 'clock',
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Duration"
			},
			className: 'lsx-duration-wrapper',
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
							width: '20px',
							sizeSlug: "large",
							url: lsxToEditor.assetsUrl + 'blocks/duration.png',
							alt: "",
						},
					],
					[
						"core/paragraph",
						{
							content: "<strong>Duration:</strong>",
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
										source: "lsx/post-meta",
										args: {
											key: "duration",
										},
									},
								},
							},
							content: "",
						},
					],
					[
						"core/paragraph",
						{
							content: "Days",
						},
					],
				],
			],
		],
		supports: {
			renaming: false
		}
	});

});