wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/departs-from',
		title: 'Departs From',
		icon: 'airplane',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Departs From',
			},
			className: 'lsx-departs-from-wrapper',
			
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
						width: '20px',
						sizeSlug: 'large',
						url: lsxToEditor.assetsUrl + 'blocks/map-TO-icon.png',
						alt: ''
					}],
					['core/paragraph', {
						
						fontSize: 'x-small',
						content: '<strong>Departs From:</strong>'
					}]
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
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-connection',
									args: {
										key: 'departs_from'
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
					}],
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});