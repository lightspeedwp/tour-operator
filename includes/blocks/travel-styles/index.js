wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/travel-styles',
		title: 'Travel Styles',
		icon: 'airplane',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Travel Styles',
			},
			className: 'lsx-travel-style-wrapper',
			
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
						url: lsxToEditor.assetsUrl + 'blocks/travel-styles.png',
						alt: ''
					}],
					['core/paragraph', {
						
						fontSize: 'x-small',
						content: '<strong>Travel Styles:</strong>'
					}]
				]
			],
			['core/group', {
					style: {
						layout: {
							selfStretch: 'fill',
							flexSize: null
						},
						spacing: {
							blockGap: '5px',
							padding: {'left': '25px'}
						}
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
				},
				[
					['core/post-terms', {
						term: 'travel-style'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});