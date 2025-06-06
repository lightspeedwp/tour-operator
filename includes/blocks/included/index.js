wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/included',
		title: 'Included Items',
		icon: 'plus-alt',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Included',
			},
			style: {
				spacing: {
					blockGap: '0'
				},
				width: '50%'
			},
			className: 'lsx-included-wrapper'
		},
		innerBlocks: [
			['core/paragraph', {
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
				fontSize: 'medium',
				content: '<strong>Price Includes: </strong>'
			}],
			['core/paragraph', {
				metadata: {
					bindings: {
						content: {
							source: 'lsx/post-meta',
							args: {
								key: 'included'
							}
						}
					}
				}
			}]
		],
		supports: {
			renaming: false
		}
	});

});