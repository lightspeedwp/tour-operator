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
			style: {
				spacing: {
					blockGap: "5px",
				},
			},
			layout: {
				type: "flex",
				flexWrap: "nowrap",
			},
		},
		innerBlocks: [
			[
				"core/group",
				{
					style: {
						spacing: {
							blockGap: "5px",
						},
					},
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
							style: {
								spacing: {
									padding: {
										top: "2px",
										bottom: "2px",
									},
								},
							},
							fontSize: "x-small",
							content: "<strong>Duration:</strong>",
						},
					],
				],
			],
			[
				"core/group",
				{
					style: {
						spacing: {
							blockGap: "5px",
						},
					},
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
							
							style: {
								elements: {
									link: {
										color: {
											text: "var:preset|color|primary-700",
										},
									},
								},
								spacing: {
									padding: {
										top: "2px",
										bottom: "2px",
									},
								},
							},
							content: "",
						},
					],
					[
						"core/paragraph",
						{
							
							style: {
								elements: {
									link: {
										color: {
											text: "var:preset|color|primary-700",
										},
									},
								},
								spacing: {
									padding: {
										top: "2px",
										bottom: "2px",
									},
								},
							},
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