wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/ends-in',
		title: 'Ends In',
		icon: 'airplane',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Ends In',
			},
			className: 'lsx-ends-in-wrapper',
			style: {
				spacing: {
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
						url: lsxToEditor.assetsUrl + 'blocks/map-TO-icon.png',
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
						fontSize: 'x-small',
						content: '<strong>Ends In:</strong>'
					}]
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
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-connection',
									args: {
										key: 'ends_in'
									}
								}
							}
						},
						style: {
							elements: {
								link: {
									color: {
										text: 'var:preset|color|primary-700'
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
						textColor: 'primary-700',
						content: ''
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});