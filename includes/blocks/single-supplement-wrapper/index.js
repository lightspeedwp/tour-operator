wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/single-supplement-wrapper',
		title: 'Single Supplement',
		icon: 'money-alt',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Single Supplement',
			},
			className: 'lsx-single-supplement-wrapper',
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
						id: 122733,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: lsxToEditor.assetsUrl + 'blocks/single-supplement-icon.svg',
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
						content: '<strong>Single supplement:</strong>'
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
										key: 'single_supplement'
									}
								}
							}
						},
						className: 'amount has-primary-color has-text-color has-link-color',
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