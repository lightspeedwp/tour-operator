wp.domReady(() => {

wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/google-map",
		title: "Google Map",
		description: "Display a Google Map based on the current Tour Operator page.",
		category: 'lsx-tour-operator',
		icon: 'admin-site-alt3',
		attributes: {
			metadata: {
				name: "Google Map",
			},
			className: 'lsx-location-wrapper',
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
					metadata: {
						name: "Title"
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					['core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } } }],
					['core/heading', { textAlign: 'center', content: 'Location' }],
					['core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } } }]
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
							url: lsxToEditor.assetsUrl + 'blocks/placeholder-map-1920x656.jpg',
							dimRatio: 50,
							customOverlayColor: '#e2f0f7',
							isUserOverlayColor: false,
							isDark: false,
							layout: { type: 'constrained' },
							className: 'lsx-map-preview',
							name: "Preview",
						},
						[
							[
								'core/paragraph',
								{
									align: 'center',
									fontSize: 'large',
									content: '<a href="#">Click here to display the map</a>',
									className: 'has-text-align-center has-large-font-size'
								}
							]
						]
					],
					[
						'core/group',
						{
							align: 'wide',
							layout: { type: 'default' },
							className: 'hidden',
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