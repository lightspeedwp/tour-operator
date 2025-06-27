wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/spoken-languages',
		title: 'Spoken Languages',
		icon: "translation",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Spoken Languages',
			},
			className: 'lsx-spoken-languages-wrapper',
			
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
						url: lsxToEditor.assetsUrl + 'blocks/spoken-languages.png',
						alt: ''
					}],
					['core/paragraph', {
						
						content: '<strong>Spoken</strong> <strong>Languages:</strong>'
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
										key: 'spoken_languages'
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