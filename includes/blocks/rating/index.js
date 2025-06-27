wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/rating',
		title: 'Rating',
		icon: "star-empty",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Rating',
			},
			className: 'lsx-rating-wrapper',
			
			layout: {
				type: 'flex',
				flexWrap: 'nowrap'
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
						url: lsxToEditor.assetsUrl + 'blocks/rating-icon-TO.png',
						alt: ''
					}],
					['core/paragraph', {
						
						content: '<strong>Rating</strong>:'
					}]
				]
			],
			['core/group', {
					
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'bottom'
					}
				},
				[
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'rating'
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
						}],
					['core/group', {
							
							layout: {
								type: 'flex',
								flexWrap: 'nowrap'
							}
						},
						[
							['core/paragraph', {
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
								fontSize: 'tiny',
								content: '('
							}],
							['core/paragraph', {
								metadata: {
									bindings: {
										content: {
											source: 'lsx/post-meta',
											args: {
												key: 'rating_type'
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
								fontSize: 'tiny'
							}],
							['core/paragraph', {
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
								fontSize: 'tiny',
								content: ')'
							}]
						]
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});