wp.domReady(() => {

	// Itinerary Wrapper
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/itinerary",
		title: "Itinerary",
		icon: "clipboard",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Itinerary",
			},
			align: "wide",
			layout: {
				type: "constrained",
			},
			className: "lsx-itinerary-wrapper"
		},
		innerBlocks: [
			['core/group',
				{
					layout: {
						type: "flex",
						flexWrap: "nowrap",
					}
				},
				[
					[
						'core/separator',
						{
							style: {
								layout: {
									selfStretch: 'fill',
									flexSize: null,
								},
							},
							backgroundColor: 'primary',
						}
					],
					[
						'core/heading',
						{
							textAlign: 'center',
							content: 'Tour Itinerary',
						},
					],
					[
						'core/separator',
						{
							style: {
								layout: {
									selfStretch: 'fill',
									flexSize: null,
								},
							},
							backgroundColor: 'primary',
						}
					]
				]
			],
			[
				"core/paragraph",
				{
					placeholder: "Replace this with the Day by Day block, and select a pattern.",
					align: "center",
				},
			]
		],
		supports: {
			renaming: false
		}
	});

	// Itinerary Day by Day
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/day-by-day",
		title: "Day by day",
		icon: "clipboard",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Day by day",
				bindings: {
					content: {
						source: "lsx/tour-itinerary",
					},
				},
			},
			align: "wide",
			layout: {
				type: "constrained",
			},
		},
		innerBlocks: [
			['core/pattern', {
				slug: 'lsx-tour-operator/itinerary-list'
			}]
		],
		supports: {
			renaming: false
		},
		parent: ["lsx-tour-operator/itinerary"], // Restricts to "lsx/itinerary" block
	});

	// WETU Map Embed
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/wetu-map',
		title: 'WETU Map',
		icon: 'admin-site-alt',
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
		allowedPostTypes: ['tour'],
		supports: {
			renaming: false
		}
	});

	// Single Supplement
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/single-supplement-wrapper',
		title: 'Single Supplement',
		icon: 'money-alt',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Single Supplement',
			},
			className: 'lsx-single-supplement-wrapper',
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
						id: 122733,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/11/single-supplement-icon-black-52px-1.svg',
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
						content: '<strong>Single supplement:</strong>'
					}]
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px'
						},
						layout: {
							type: 'flex',
							flexWrap: 'nowrap'
						}
					}
				},
				[
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'single_supplement'
									}
								}
							}
						},
						className: 'amount has-primary-color has-text-color has-link-color',
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
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// Destination to Tour
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-destination-to-tour",
		title: "Destination to Tour",
		icon: 'location-alt',
		category: "lsx-tour-operator",
		attributes: {
			name: "Destination to Tour",
			className: "lsx-destination-to-tour-wrapper",
			style: {
				spacing: {
					blockGap: "5px",
				},
			},
			layout: {
				type: "constrained",
			},
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
							url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/Typelocation-icon.png',
							alt: ''
						}
					],
					[
						'core/paragraph',
						{
							content: '<strong>Destinations:</strong>',
							style: {
								spacing: {
									padding: {
										top: '2px',
										bottom: '2px'
									}
								}
							},
							fontSize: 'x-small'
						}
					]
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
					[
						"core/paragraph",
						{
							metadata: {
								bindings: {
									content: {
										source: "lsx/post-connection",
										args: {
											key: "destination_to_tour",
										},
									},
								},
							},
							className: "has-primary-color has-text-color has-link-color",
							style: {
								elements: {
									link: {
										color: {
											text: "var:preset|color|primary-700",
										},
									},
								},
								spacing: {
									padding: {
										top: "2px",
										bottom: "2px",
									},
								},
							},
							textColor: "primary-700",
							content: "",
						},
					],
				]
			]
		],
		supports: {
			renaming: false
		}
	});
	
	// Duration
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/duration",
		title: "Duration",
		icon: 'clock',
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Duration"
			},
			className: "lsx-duration-wrapper",
			style: {
				spacing: {
					blockGap: "5px",
				},
			},
			layout: {
				type: "flex",
				flexWrap: "nowrap",
			},
		},
		innerBlocks: [
			[
				"core/group",
				{
					style: {
						spacing: {
							blockGap: "5px",
						},
					},
					layout: {
						type: "flex",
						flexWrap: "nowrap",
						verticalAlignment: "top",
					},
				},
				[
					[
						"core/image",
						{
							width: '20px',
							sizeSlug: "large",
							url: "https://tour-operator.lsx.design/wp-content/uploads/2024/09/duration-TO-black-20px-icon.png",
							alt: "",
						},
					],
					[
						"core/paragraph",
						{
							style: {
								spacing: {
									padding: {
										top: "2px",
										bottom: "2px",
									},
								},
							},
							fontSize: "x-small",
							content: "<strong>Duration:</strong>",
						},
					],
				],
			],
			[
				"core/group",
				{
					style: {
						spacing: {
							blockGap: "5px",
						},
					},
					layout: {
						type: "flex",
						flexWrap: "nowrap",
					},
				},
				[
					[
						"core/paragraph",
						{
							metadata: {
								bindings: {
									content: {
										source: "lsx/post-meta",
										args: {
											key: "duration",
										},
									},
								},
							},
							className: "has-primary-color has-text-color has-link-color",
							style: {
								elements: {
									link: {
										color: {
											text: "var:preset|color|primary-700",
										},
									},
								},
								spacing: {
									padding: {
										top: "2px",
										bottom: "2px",
									},
								},
							},
							textColor: "primary-700",
							content: "",
						},
					],
					[
						"core/paragraph",
						{
							className: "has-primary-color has-text-color has-link-color",
							style: {
								elements: {
									link: {
										color: {
											text: "var:preset|color|primary-700",
										},
									},
								},
								spacing: {
									padding: {
										top: "2px",
										bottom: "2px",
									},
								},
							},
							textColor: "primary-700",
							content: "Days",
						},
					],
				],
			],
		],
		supports: {
			renaming: false
		}
	});

	// Group Size
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/group-size',
		title: 'Group Size',
		icon: 'groups',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Group Size',
			},
			className: 'lsx-group-size-wrapper',
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
						id: 122731,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/11/group-size-icon-black-52px-1.svg',
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
						content: '<strong>Group size:</strong>'
					}]
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px'
						},
						layout: {
							type: 'flex',
							flexWrap: 'nowrap'
						}
					}
				},
				[
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'group_size'
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
						content: ''
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// Booking Validity 
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/booking-validity-start',
		title: 'Booking Validity',
		icon: 'calendar',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Booking Validity',
			},
			className: 'lsx-booking-validity-start-wrapper',
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
						id: 122730,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/11/booking-validity-icon-black-52px-1.svg',
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
						content: '<strong>Booking validity:</strong>'
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
										key: 'booking_validity_start'
									}
								}
							}
						},
						className: 'has-primary-color has-text-color has-link-color',
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
						content: '-'
					}],
					['core/paragraph', {
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'booking_validity_end'
									}
								}
							}
						},
						style: {
							spacing: {
								padding: {
									top: '2px',
									bottom: '2px'
								}
							}
						},
						textColor: 'primary-700',
						content: 'End'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// Departs From
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/departs-from',
		title: 'Departs From',
		icon: 'airplane',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Departs From',
			},
			className: 'lsx-departs-from-wrapper',
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
						url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/map-TO-black-20px-icon.png',
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
						content: '<strong>Departs From:</strong>'
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
									source: 'lsx/post-connection',
									args: {
										key: 'departs_from'
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
						content: ''
					}],
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// Ends In
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/ends-in',
		title: 'Ends In',
		icon: 'airplane',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Ends In',
			},
			className: 'lsx-ends-in-wrapper',
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
						url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/map-TO-black-20px-icon.png',
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
						content: '<strong>Ends In:</strong>'
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
									source: 'lsx/post-connection',
									args: {
										key: 'ends_in'
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
						content: ''
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// Price Included + Excluded
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
