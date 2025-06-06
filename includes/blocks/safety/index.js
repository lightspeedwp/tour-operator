wp.domReady(() => {

wp.blocks.registerBlockVariation(
		'core/group', {
			name: 'lsx-tour-operator/safety',
			title: 'Safety',
			icon: "shield",
			category: 'lsx-tour-operator',
			attributes: {
				metadata: {
					name: 'Safety',
				},
				className: 'lsx-safety-wrapper',
				style: {
					border: {
						radius: '8px',
					},
					spacing: {
						padding: {
							top: '0px',
							right: '0px',
							bottom: '0px',
							left: '0px',
						},
						blockGap: '0px',
					},
				},
			},
			innerBlocks: [
				[
					'core/group',
					{
						style: {
							spacing: {
								margin: {
									top: '0',
									bottom: '0',
								},
								padding: {
									top: '10px',
									right: '10px',
									bottom: '10px',
									left: '10px',
								},
							},
							dimensions: {
								minHeight: '',
							},
						},
					},
					[
						[
							'core/group',
							{
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0',
										},
									},
									dimensions: {
										minHeight: '',
									},
								},
							},
							[
								[
									'core/paragraph',
									{
										content: '<strong>Safety</strong>',
										align: 'center',
										fontSize: 'small',
										style: {
											spacing: {
												padding: {
													top: '0',
													bottom: '0',
												},
											},
										},
									},
								],
							],
						],
						[
							'core/group',
							{
								style: {
									spacing: {
										padding: {
											right: '10px',
											left: '10px',
											top: '0px',
											bottom: '0px',
										},
										blockGap: '0',
									},
								},
							},
							[
								[
									'core/paragraph',
									{
										style: {
											spacing: {
												padding: {
													top: '2px',
													bottom: '2px',
												},
											},
										},
									},
								],
							],
						],
					],
				],
				[
					'core/buttons',
					{},
					[
						[
							'core/button',
							{
								backgroundColor: 'primary',
								width: 100,
								style: {
									border: {
										radius: {
											bottomLeft: '8px',
											bottomRight: '8px',
										},
									},
								},
							},
							[
								[
									'core/paragraph',
									{
										content: 'View More',
										className: 'has-primary-background-color has-background wp-element-button',
										style: {
											border: {
												bottomLeftRadius: '8px',
												bottomRightRadius: '8px',
											},
										},
									},
								],
							],
						],
					],
				],
			],
			supports: {
				renaming: false
			}
		}
	);

	// Travel Information - Visa Wrapper
	wp.blocks.registerBlockVariation(
		'core/group', {
			name: 'lsx-tour-operator/visa',
			title: 'Visa',
			icon: "id-alt",
			category: 'lsx-tour-operator',
			attributes: {
				metadata: {
					name: 'Visa',
				},
				className: 'lsx-visa-wrapper',
				style: {
					border: {
						radius: '8px',
					},
					spacing: {
						padding: {
							top: '0px',
							right: '0px',
							bottom: '0px',
							left: '0px',
						},
						blockGap: '0px',
					},
				},
			},
			innerBlocks: [
				[
					'core/group',
					{
						style: {
							spacing: {
								margin: {
									top: '0',
									bottom: '0',
								},
								padding: {
									top: '10px',
									right: '10px',
									bottom: '10px',
									left: '10px',
								},
							},
							dimensions: {
								minHeight: '',
							},
						},
					},
					[
						[
							'core/group',
							{
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0',
										},
									},
									dimensions: {
										minHeight: '',
									},
								},
							},
							[
								[
									'core/paragraph',
									{
										content: '<strong>Visa</strong>',
										align: 'center',
										fontSize: 'small',
										style: {
											spacing: {
												padding: {
													top: '0',
													bottom: '0',
												},
											},
										},
									},
								],
							],
						],
						[
							'core/group',
							{
								style: {
									spacing: {
										padding: {
											right: '10px',
											left: '10px',
											top: '0px',
											bottom: '0px',
										},
										blockGap: '0',
									},
								},
							},
							[
								[
									'core/paragraph',
									{
										style: {
											spacing: {
												padding: {
													top: '2px',
													bottom: '2px',
												},
											},
										},
									},
								],
							],
						],
					],
				],
				[
					'core/buttons',
					{},
					[
						[
							'core/button',
							{
								backgroundColor: 'primary',
								width: 100,
								style: {
									border: {
										radius: {
											bottomLeft: '8px',
											bottomRight: '8px',
										},
									},
								},
							},
							[
								[
									'core/paragraph',
									{
										content: 'View More',
										className: 'has-primary-background-color has-background wp-element-button',
										style: {
											border: {
												bottomLeftRadius: '8px',
												bottomRightRadius: '8px',
											},
										},
									},
								],
							],
						],
					],
				],
			],
			supports: {
				renaming: false
			}
		}
	);

	// Destination - Regions
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/facts-regions-wrapper',
		title: 'Regions List',
		icon: "clipboard",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Regions List'
			},
			className: 'facts-regions-query-wrapper',
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
			[
				'core/group',
				{
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
					[
						'core/image',
						{
							width: '20px',
							sizeSlug: 'large',
							url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/destinations-icon-black-20px.png',
							alt: ''
						}
					],
					[
						'core/paragraph',
						{
							style: {
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							fontSize: 'x-small',
							content: '<strong>Regions:</strong>'
						}
					]
				]
			],
			[
				'core/group',
				{
					style: {
						spacing: {
							blockGap: '5px',
							padding: {
								top: '0',
								bottom: '0'
							}
						}
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
				},
				[
					[
						'core/paragraph',
						{
							metadata: {
								bindings: {
									content: {
										source: "lsx/post-connection",
										args: {
											key: "post_children"
										},
									},
								},
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
						}
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});