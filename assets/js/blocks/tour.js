wp.domReady(() => {

	// WETU Map Embed
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/wetu-map',
		title: 'WETU Map',
		icon: 'admin-site',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'WETU Map',
				bindings: {
					content: {
						source: 'lsx/map',
						type: 'wetu'
					}
				}
			},
			style: {
				spacing: {
					margin: {
						top: 0,
						bottom: 0
					},
					padding: {
						top: "var:preset|spacing|medium",
						bottom: "var:preset|spacing|medium",
						left: 0,
						right: 0
					}
				}
			},
			layout: {
				type: "constrained"
			}
		},
		innerBlocks: [
			[
				"core/group",
				{
					align: "wide",
					layout:{
						type:"default"
					}
				},
				[
					[
						"core/image",
						{
							align: "full",
							sizeSlug: "large",
							url: "https://tour-operator.lsx.design/wp-content/uploads/2024/09/wetu-map-figme-prototype-image.png",
							alt: "",
						}
					]
				]
			]
		],
		isDefault: false,
		allowedPostTypes: ['tour']
	});

	wp.registerBlockVariation( 'core/group', {
		name: 'price-include-exclude',
		title: 'Price Include & Exclude',
		category: 'layout',
		attributes: {
			align: 'wide',
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
			[
			'core/columns', {
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
				[
				'core/column', {
					width: '50%',
					id: 'lsx-included-wrapper',
					style: {
					spacing: {
						blockGap: '0'
					}
					}
				},
				[
					[
					'core/paragraph', {
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
						fontSize: 'medium'
					},
					[ 'Price Includes:' ]
					],
					[
					'core/paragraph', {
						metadata: {
						bindings: {
							content: {
							source: 'lsx/post-meta',
							args: { key: 'included' }
							}
						}
						}
					},
					[]
					]
				]
				],
				[
				'core/column', {
					width: '50%',
					className: 'lsx-not-included-wrapper',
					style: {
					spacing: {
						blockGap: '0'
					}
					}
				},
				[
					[
					'core/paragraph', {
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
						fontSize: 'medium'
					},
					[ 'Price Excludes:' ]
					],
					[
					'core/paragraph', {
						metadata: {
						bindings: {
							content: {
							source: 'lsx/post-meta',
							args: { key: 'not_included' }
							}
						}
						}
					},
					[]
					]
				]
				]
			]
			]
		]
	} );
});
