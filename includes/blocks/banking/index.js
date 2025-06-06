wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/banking',
		title: 'Banking',
		icon: "bank",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Banking',
			},
			className: 'lsx-banking-wrapper',
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
				},
				layout: {
					selfStretch: 'fixed',
					flexSize: '25%'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
					metadata: {
						name: 'Content'
					},
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
							metadata: {
								name: 'Title'
							},
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
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Banking</strong>'
							}]
						]
					],
					['core/group', {
							className: 'lsx-to-more-content',
							metadata: {
								name: 'Description'
							},
							style: {
								spacing: {
									padding: {
										right: '10px',
										left: '10px',
										top: '0px',
										bottom: '0px'
									},
									blockGap: '0'
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
									}
								},
								metadata: {
									bindings: {
										content: {
											source: 'lsx/post-meta',
											args: {
												key: 'banking'
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
						metadata: {
							name: 'More Button'
						},
						className: 'lsx-to-more-link more-link',
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
						text: 'View More'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});