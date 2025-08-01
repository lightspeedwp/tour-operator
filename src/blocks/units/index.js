wp.domReady(() => {	
	console.log('test');
	// Accommodation Units Wrapper
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/units",
		title: "Units",
		icon: "admin-multisite",
		category: "lsx-tour-operator",
		description: "A Units layout block to display your rooms and camps.",
		attributes: {
			metadata: {
				name: "Units",
			},
			align: "wide",
			layout: {
				type: "constrained",
			},
			className: 'lsx-units-wrapper',
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
							}
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
							}
						}
					]
				]
			],
			['core/group',
				{
					align: 'wide',
					
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
		},
		isActive: ( blockAttributes, variationAttributes ) => {
			return (
				blockAttributes.className === "lsx-units-wrapper" ||
				(blockAttributes.className && blockAttributes.className.includes("lsx-units-wrapper"))
			);
		}
	});
});