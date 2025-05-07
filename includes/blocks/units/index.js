wp.domReady(() => {	
	// Accommodation Units Wrapper
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/units",
		title: "Units",
		icon: "admin-multisite",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Units",
			},
			align: "wide",
			layout: {
				type: "constrained",
			},
			className: "lsx-units-wrapper",
			backgroundColor: 'primary-bg',
			style: {
				spacing: {
					padding: {
						top: "var:preset|spacing|medium",
						bottom: "var:preset|spacing|medium",
						left: "var:preset|spacing|x-small",
						right: "var:preset|spacing|x-small",
					},
					margin: {
						top: 0,
						bottom: 0
					}
				}
			},
			tagName: "section"
		},
		innerBlocks: [
			['core/group',
				{
					layout: {
						type: "flex",
						flexWrap: "nowrap",
					}
				},
				[
					[
						'core/separator',
						{
							style: {
								layout: {
									selfStretch: 'fill',
									flexSize: null,
								},
							},
							backgroundColor: 'primary',
						}
					],
					[
						'core/heading',
						{
							textAlign: 'center',
							content: 'Units',
						},
					],
					[
						'core/separator',
						{
							style: {
								layout: {
									selfStretch: 'fill',
									flexSize: null,
								},
							},
							backgroundColor: 'primary',
						}
					]
				]
			],
			['core/group',
				{
					align: 'wide',
					style: {
						spacing: {
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: {
						type: 'constrained',
					}
				},
				[
					["core/paragraph",
						{
							placeholder: "Replace this with the Rooms block, and select a pattern.",
							align: "center",
						}
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	});
});