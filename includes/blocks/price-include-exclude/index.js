wp.domReady(() => {

wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/price-include-exclude',
		title: 'Price Include & Exclude',
		icon: 'money-alt',
		category: 'lsx-tour-operator',
		attributes: {
			align: 'wide',
			metadata: {
				name: 'Price Include & Exclude',
			},
			className: 'lsx-include-exclude-wrapper',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			[ 'core/columns', {
					align: 'wide'
				},
				[
					['core/column', {
							width: '50%',
							id: 'lsx-included-wrapper',
							
						},
						[
							[ 'core/paragraph', {
								content: '<strong>Price Includes:</strong>'
							} ],
							[ 'core/paragraph', {
								metadata: {
									bindings: {
										content: {
											source: 'lsx/post-meta',
											args: { key: 'included' }
										}
									}
								}
							}]
						]
					],
					[ 'core/column', {
							width: '50%',
							className: 'lsx-not-included-wrapper'
							
						},
						[
							[ 'core/paragraph', {
								content: '<strong>Price Excludes:</strong>'
							}],
							[ 'core/paragraph', {
								metadata: {
									bindings: {
										content: {
											source: 'lsx/post-meta',
											args: { key: 'not_included' }
										}
									}
								}
							}]
						]
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	} );

});