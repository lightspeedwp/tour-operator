wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/minimum-child-age',
		title: 'Minimum Child Age',
		icon: "id",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Minimum Child Age',
			},
			className: 'lsx-minimum-child-age-wrapper',
			style: {
				spacing: {
					blockGap: '5px'
				}
			},
			layout: {
				type: 'flex',
				flexWrap: 'nowrap'
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
						id: 122719,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: lsxToEditor.assetsUrl + 'blocks/minimum-child-age.svg',
						alt: '',
						className: 'wp-image-122719'
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
						content: '<strong>Minimum child age:</strong>'
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
										key: 'minimum_child_age'
									}
								}
							}
						},
						className: 'has-septenary-color has-text-color has-link-color has-primary-color has-primary-700-color',
						style: {
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