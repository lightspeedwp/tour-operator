wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/accommodation-type',
		title: 'Accommodation Type',
		icon: "admin-multisite",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Accommodation Type',
			},
			className: 'lsx-accommodation-type-wrapper',
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
						url: lsxToEditor.assetsUrl + 'blocks/accommodation-type.png',
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
						content: '<strong>Accommodation Type</strong>:'
					}]
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px',
							padding: {
								left: '25px',
							}
						}
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
				},
				[
					['core/post-terms', {
						term: 'accommodation-type',
						style: {
							elements: {
								link: {
									color: {
										text: 'var:preset|color|primary-700'
									}
								}
							}
						},
						textColor: 'primary-700',
						fontSize: 'x-small',
						fontFamily: 'secondary'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});