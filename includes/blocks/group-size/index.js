wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/group-size',
		title: 'Group Size',
		icon: 'groups',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Group Size',
			},
			className: 'lsx-group-size-wrapper',
			
			layout: {
				type: 'flex',
				flexWrap: 'nowrap'
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
						id: 122731,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: lsxToEditor.assetsUrl + 'blocks/group-size.svg',
						alt: ''
					}],
					['core/paragraph', {
						
						fontSize: 'x-small',
						content: '<strong>Group size:</strong>'
					}]
				]
			],
			['core/group', {
					
				},
				[
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'group_size'
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