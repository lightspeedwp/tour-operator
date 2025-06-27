wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/special-interests',
		title: 'Special Interests',
		icon: "camera",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Special Interests',
			},
			className: 'lsx-special-interest-wrapper',
			
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
					
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				},
				[
					['core/image', {
						id: 122726,
						width: '20px',
						sizeSlug: 'large',
						url: lsxToEditor.assetsUrl + 'blocks/special-interests-icon.svg',
						alt: '',
						linkDestination: 'none'
					}],
					['core/paragraph', {
						
						content: '<strong>Special interests</strong>:'
					}]
				]
			],
			['core/group', {
					
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
									source: 'lsx/post-meta',
									args: {
										key: 'special_interests'
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
							typography: {
								textTransform: 'capitalize'
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