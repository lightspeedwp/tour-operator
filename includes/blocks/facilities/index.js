wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/facilities',
		title: 'Facilities',
		icon: "food",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Facilities',
			},
			className: 'lsx-facility-wrapper',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			['core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: {
								top: '0',
								bottom: '0'
							},
							padding: {
								top: '0',
								bottom: 'var(--wp--preset--spacing--small)',
								left: '0',
								right: '0'
							},
							blockGap: 'var(--wp--preset--spacing--small)'
						}
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
				},
				[
					['core/separator', {
						style: {
							layout: {
								selfStretch: 'fill',
								flexSize: null
							}
						},
						backgroundColor: 'primary'
					}],
					['core/heading', {
						textAlign: 'center',
						content: 'Facilities'
					}],
					['core/separator', {
						style: {
							layout: {
								selfStretch: 'fill',
								flexSize: null
							}
						},
						backgroundColor: 'primary'
					}]
				]
			],
			['core/group', {
					align: 'wide',
					layout: {
						type: 'default'
					}
				},
				[
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-connection',
									args: {
										key: 'facilities'
									}
								}
							}
						},
						
						
						}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});