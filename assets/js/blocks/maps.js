wp.domReady(() => {

	// Map Block
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/google-map",
		title: "Google Map",
		description: "Display a Google Map based on the current Tour Operator page.",
		category: 'lsx-tour-operator',
		icon: 'location-alt',
		attributes: {
			metadata: {
				name: "Google Map",
			},
			className: "lsx-location-wrapper",
			style: {
				spacing: {
					padding: {
						top: 'var(--wp--preset--spacing--medium)',
						bottom: 'var(--wp--preset--spacing--medium)',
						left: 'var(--wp--preset--spacing--x-small)',
						right: 'var(--wp--preset--spacing--x-small)'
					},
					margin: {
						top: '0',
						bottom: '0'
					}
				}
			},
			align: 'full',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[
				'core/group',
				{
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var(--wp--preset--spacing--small)', left: '0', right: '0' },
							blockGap: 'var(--wp--preset--spacing--small)'
						}
					},
					metadata: {
						name: "Title"
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					['core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' }],
					['core/heading', { textAlign: 'center', content: 'Location' }],
					['core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' }]
				]
			],
			[
				'core/group',
				{
					align: 'wide',
					layout: { type: 'default' },
					name: "Map Container",
					metadata: {
						name: "Map Container",
					}
				},
				[
					[
						'core/cover',
						{
							url: lsxToEditor.assetsUrl + 'placeholders/placeholder-map-1920x656.jpg',
							dimRatio: 50,
							customOverlayColor: '#e2f0f7',
							isUserOverlayColor: false,
							isDark: false,
							layout: { type: 'constrained' },
							className: "lsx-map-preview",
							name: "Preview",
						},
						[]
					],
					[
						'core/group',
						{
							align: 'wide',
							layout: { type: 'default' },
							metadata: {
								name: "Map Details",
								bindings: {
									content: {
										source: 'lsx/map',
										type: 'google'
									}
								}
							}
						},
						[]
					]
				]
			]
		],
		isDefault: false,
		/*supports: {
			renaming: false
		}*/
	});
});