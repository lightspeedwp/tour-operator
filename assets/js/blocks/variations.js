wp.domReady(() => {
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx/itinerary',
		title: 'Itinerary',
		icon: 'list-view',
		attributes: {
			metadata: {
				name: 'Itinerary',
				bindings: {
					content: {
						source: 'lsx/tour-itinerary'
					}
				}
			},
			align: 'wide',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/paragraph', {
				placeholder: 'Insert your Itinerary pattern here.',
				align: 'center'
			}]
		],
		isDefault: false
	});

	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx/accommodation-units',
		title: 'Units',
		icon : 'admin-multisite',
		attributes: {
			metadata: {
				name: 'Units',
				bindings: {
					content: {
						source: 'lsx/accommodation-units'
					}
				}
			},
			align: 'wide',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/paragraph', {
				placeholder: 'Insert your Room pattern here.',
				align: 'center'
			}]
		],
		isDefault: false
	});

	wp.blocks.registerBlockVariation('core/gallery', {
		name: 'lsx/gallery',
		title: 'TO Gallery',
		icon : 'admin-multisite',
		attributes: {
			metadata: {
				name: 'TO Gallery',
				bindings: {
					content: {
						source: 'lsx/gallery'
					}
				}
			},
			linkTo: 'none',
			sizeSlug: 'thumbnail'
		},
		innerBlocks: [
			['core/image', {
				href: 'https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg'
			}],
			['core/image', {
				href: 'https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg'
			}],
			['core/image', {
				href: 'https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg'
			}]
		],
		isDefault: false
	});

	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx/price',
		title: 'Price',
		icon : 'bank',
		attributes: {
			metadata: {
				name: 'Price',
			},
			align: 'wide',
            layout: {
                type: 'flex',
                flexWrap: 'nowrap'
            },
			className: 'lsx-price-wrapper',
			style: {
				spacing: {
					blockGap: "5px"
				}
			}
		},
		innerBlocks: [
			[ 'core/paragraph', {
					padding: {
						top: '2px',
						bottom: '2px'
					},
					typography: { 
						fontSize: 'x-small'
					},
					content : '<strong>From:</strong>',
					className: 'has-x-small-font-size',
				}
			],
			[ 'core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: { key: 'price' }
							}
						}
					},
					className: 'amount has-primary-color has-text-color has-link-color',
					color: {
						link: 'primary-700',
						text: 'primary-700'
					}
				}
			]
		],
		isDefault: false
	});

	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-destination-to-tour',
		title: 'Destination to Tour Wrapper',
		attributes: {
			name: 'Destination to Tour Wrapper',
			className: 'lsx-destination-to-tour-wrapper',
			style: {
				spacing: {
					blockGap: '5px'
				}
			},
			layout: {
				type: 'constrained'
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
							width: 20,
							sizeSlug: 'large',
							url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/Typelocation-icon.png',
							alt: ''
						}
					],
					[
						'core/paragraph',
						{
							style: {
								spacing: {
									padding: {
										top: '2px',
										bottom: '2px'
									}
								}
							},
							fontSize: 'x-small',
							content: '<strong>Destinations:</strong>'
						}
					]
				]
			],
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
										source: 'lsx/post-connection',
										args: {
											key: 'destination_to_tour'
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
								}
							},
							textColor: 'primary-700',
							content: ''
						}
					]
				]
			]
		]
	});
});
