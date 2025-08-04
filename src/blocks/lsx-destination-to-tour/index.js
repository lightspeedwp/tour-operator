wp.domReady(() => {

wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/lsx-destination-to-tour",
		title: "Destination to Tour",
		icon: 'location-alt',
		category: "lsx-tour-operator",
		attributes: {
			name: "Destination to Tour",
			className: "lsx-destination-to-tour-wrapper",
			layout: {
				type: "constrained",
			},
		},
		innerBlocks: [
			[
				'core/group',
				{
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				},
				[
					[
						'core/image',
						{
							width: '20px',
							sizeSlug: 'large',
							url: lsxToEditor.assetsUrl + 'blocks/Typelocation-icon.png',
							alt: ''
						}
					],
					[
						'core/paragraph',
						{
							content: '<strong>Destinations:</strong>'
						}
					]
				]
			],
			[
				'core/group',
				{
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
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
											key: "destination_to_tour",
										},
									},
								},
							},
							content: "",
						},
					],
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});