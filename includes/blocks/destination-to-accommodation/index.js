wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/destination-to-accommodation',
		title: 'Destination to Accommodation',
		icon: "admin-site-alt3",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Destination to Accommodation',
			},
			className: 'lsx-destination-to-accommodation-wrapper',
			style: {
				spacing: {
					padding: {
						top: '0',
						bottom: '0'
					},
					blockGap: '5px'
				}
			},
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
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
					['core/image', {
						width: '20px',
						sizeSlug: 'large',
						url: lsxToEditor.assetsUrl + 'blocks/Typelocation-icon.png',
						alt: ''
					}],
					['core/paragraph', {
						style: {
							spacing: {
								padding: {
									top: '2px',
									bottom: '2px'
								}
							}
						},
						content: '<strong>Location</strong>:'
					}]
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px',
							padding: {left: '25px'}
						}
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
				},
				[
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-connection',
									args: {
										key: 'destination_to_accommodation'
									}
								}
							}
						},
						className: 'has-septenary-color has-text-color has-link-color',
						style: {
							elements: {
								link: {
									color: {
										text: 'var:preset|color|primary-700',
										':hover': {
											color: {
												text: 'var:preset|color|primary-900'
											}
										}
									}
								}
							},
							spacing: {
								padding: {
									top: '2px',
									bottom: '2px'
								}
							}
						},
						textColor: 'primary-700'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});