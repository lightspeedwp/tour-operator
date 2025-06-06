wp.domReady(() => {

wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/lsx-destination-to-tour",
		title: "Destination to Tour",
		icon: 'location-alt',
		category: "lsx-tour-operator",
		attributes: {
			name: "Destination to Tour",
			className: "lsx-destination-to-tour-wrapper",
			style: {
				spacing: {
					blockGap: "5px",
				},
			},
			layout: {
				type: "constrained",
			},
		},
		innerBlocks: [
			[
				'core/group',
				{
					style: {
						spacing: {
							blockGap: '5px'
						}
					},
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
							content: '<strong>Destinations:</strong>',
							style: {
								spacing: {
									padding: {
										top: '2px',
										bottom: '2px'
									}
								}
							},
							fontSize: 'x-small'
						}
					]
				]
			],
			[
				'core/group',
				{
					style: {
						spacing: {
							padding: {
								left: '25px'
							}
						}
					},
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
							className: "has-primary-color has-text-color has-link-color",
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
							textColor: "primary-700",
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