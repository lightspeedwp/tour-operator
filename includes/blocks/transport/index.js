wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/transport',
		title: 'Transport',
		icon: "car",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Transport',
			},
			className: 'lsx-transport-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
					style: {
						spacing: {
							margin: {
								top: '0',
								bottom: '0'
							},
							padding: {
								top: '10px',
								bottom: '10px',
								left: '10px',
								right: '10px'
							}
						},
						dimensions: {
							minHeight: ''
						}
					},
					layout: {
						type: 'constrained'
					}
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								
								fontSize: 'small',
								content: '<strong>Transport</strong>'
							}]
						]
					],
					['core/group', {
							
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								
								metadata: {
									bindings: {
										content: {
											source: 'lsx/post-meta',
											args: {
												key: 'transport'
											}
										}
									}
								}
							}]
						]
					]
				]
			],
			['core/buttons', {},
				[
					['core/button', {
						backgroundColor: 'primary',
						width: 100,
						style: {
							border: {
								radius: {
									bottomLeft: '8px',
									bottomRight: '8px'
								}
							}
						},
						content: 'View More'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});