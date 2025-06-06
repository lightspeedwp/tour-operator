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
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|x-small',
						bottom: 'var:preset|spacing|x-small',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					}
				},
				border: {
					radius: '8px',
					width: '1px'
				}
			},
			backgroundColor: 'base',
			borderColor: 'primary',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			[ 'core/columns', {
					align: 'wide',
					style: {
						spacing: {
							blockGap: {
								top: 'var:preset|spacing|medium',
								left: 'var:preset|spacing|medium'
							}
						}
					}
				},
				[
					['core/column', {
							width: '50%',
							id: 'lsx-included-wrapper',
							style: {
								spacing: {
									blockGap: '0'
								}
							}
						},
						[
							[ 'core/paragraph', {
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
							className: 'lsx-not-included-wrapper',
							style: {
								spacing: {
									blockGap: '0'
								}
							}
						},
						[
							[ 'core/paragraph', {
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