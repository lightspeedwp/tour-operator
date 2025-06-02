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
			style: {
				spacing: {
					padding: {
						top: '0',
						bottom: '0'
					},
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
						width: '20px',
						sizeSlug: 'large',
						url: lsxToEditor.assetsUrl + 'blocks/rating-icon-TO.png',
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
						content: '<strong>Rating</strong>:'
					}]
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px'
						}
					},
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
						className: 'has-text-color has-link-color has-primary-700-color',
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
						textColor: 'primary-700'
					}],
					['core/group', {
							style: {
								spacing: {
									blockGap: '0'
								}
							},
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
								textColor: 'primary-700',
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
								textColor: 'primary-700',
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
								textColor: 'primary-700',
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