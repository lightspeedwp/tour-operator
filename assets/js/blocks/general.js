wp.domReady(() => {
	// Gallery Wrapper
	wp.blocks.registerBlockVariation("core/gallery", {
		name: "lsx-tour-operator/gallery",
		title: "TO Gallery",
		icon: "admin-multisite",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "TO Gallery",
				bindings: {
					content: {
						source: "lsx/gallery",
					}
				}
			},
			linkTo: "none",
			sizeSlug: "thumbnail"
		},
		innerBlocks: [
			[
				"core/image",
				{
					href: "https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg",
				}
			],
			[
				"core/image",
				{
					href: "https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg",
				}
			],
			[
				"core/image",
				{
					href: "https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg",
				}
			]
		],
		isDefault: false
	});

	// Price Wrapper
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/price",
		title: "Price",
		icon: "bank",
		attributes: {
			metadata: {
				name: "Price",
			},
			align: "wide",
			layout: {
				type: "flex",
				flexWrap: "nowrap",
			},
			className: "lsx-price-wrapper",
			style: {
				spacing: {
					blockGap: "5px",
				},
			},
		},
		innerBlocks: [
			[
				"core/paragraph",
				{
					padding: {
						top: "2px",
						bottom: "2px",
					},
					typography: {
						fontSize: "x-small",
					},
					content: "<strong>From:</strong>",
					className: "has-x-small-font-size",
				},
			],
			[
				"core/paragraph",
				{
					metadata: {
						bindings: {
							content: {
								source: "lsx/post-meta",
								args: {
									key: "price"
								},
							},
						},
					},
					className: "amount has-primary-color has-text-color has-link-color",
					padding: {
						top: "2px",
						bottom: "2px",
					},
					color: {
						link: "primary-700",
						text: "primary-700",
					},
				},
			],
		],
		isDefault: false,
	});
	
	// Travel Styles Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/travel-styles',
		title: 'Travel Styles',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Travel Styles',
			},
			className: 'lsx-travel-style-wrapper',
			style: {
				spacing: {
					blockGap: '5px'
				},
				layout: {
					type: 'constrained'
				}
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
						width: 20,
						sizeSlug: 'large',
						url: 'http://localhost:8883/wp-content/themes/lsx-tour-operator/assets/images/Typetype-icon.png',
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
						term: 'travel-style',
						style: {
							spacing: {
								padding: {
									top: '0',
									bottom: '0'
								},
								margin: {
									top: '0',
									bottom: '0'
								}
							},
							elements: {
								link: {
									color: {
										text: 'var:preset|color|primary-700',
										':hover': {
											color: {
												text: 'var:preset|color|primary-900'
											}
										}
									}
								}
							}
						},
						textColor: 'primary-700',
						fontSize: 'x-small',
						fontFamily: 'secondary'
					}]
				]
			]
		]
	});

	// Best Months to Visit Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/best-time-to-visit',
		title: 'Best Time to Visit',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Best Time to Visit',
			},
			className: 'lsx-best-time-to-visit-wrapper',
			style: {
				spacing: {
					blockGap: '5px'
				},
				layout: {
					type: 'constrained'
				}
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
						width: 20,
						sizeSlug: 'large',
						url: 'http://localhost:8883/wp-content/themes/lsx-tour-operator/assets/images/best-months-to-travel-TO-icon-black-20px-1-1.png',
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
						content: '<strong>Best Months to Visit</strong>'
					}]
				]
			],
			[
				'core/group',
				{
					style: {
						spacing: {
							padding: {
								left: '25px'
							}
						}
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
				},
				[
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'best_time_to_visit'
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
							typography: {
								textTransform: 'capitalize'
							}
						},
						textColor: 'primary-700',
						content: 'Best Months to Visit'
					}]
				]
			]
		]
	});

	// Included Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/included',
		title: 'Included Items',
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
		]
	});

	// Not Included Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/not-included',
		title: 'Excluded Items',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Not Included',
			},
			style: {
				spacing: {
					blockGap: '0'
				},
				width: '50%'
			},
			className: 'lsx-not-included-wrapper'
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
				content: '<strong>Price Excludes:</strong>'
			}],
			['core/paragraph', {
				metadata: {
					bindings: {
						content: {
							source: 'lsx/post-meta',
							args: {
								key: 'not_included'
							}
						}
					}
				}
			}]
		]
	});

	wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/more-link',
        title: 'More Button',
		name: 'core/button',
		attributes: {
			className: 'lsx-to-more-link more-link',
			metadata: {
				name: 'More Button'
			},
			style: {
				border: {
					radius: {
						topLeft: '0px 8px 8px 0px',
						topRight: '0px 8px 8px 0px',
						bottomLeft: '8px',
						bottomRight: '8px'
					}
				}
			},
			backgroundColor: 'primary',
			width: 100,
			text: 'View More',
		}
    });
});

