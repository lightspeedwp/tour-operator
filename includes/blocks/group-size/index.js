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
						id: 122731,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: lsxToEditor.assetsUrl + 'blocks/group-size.svg',
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
						content: '<strong>Group size:</strong>'
					}]
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px'
						},
						layout: {
							type: 'flex',
							flexWrap: 'nowrap'
						}
					}
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