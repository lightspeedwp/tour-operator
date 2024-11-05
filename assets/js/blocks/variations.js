wp.domReady(() => {

	// Itinerary Wrapper
	wp.blocks.registerBlockVariation("core/group", {
	  name: "lsx-tour-operator/itinerary",
	  title: "Itinerary",
	  icon: "list-view",
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
        [ 	'core/group',
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
	  isDefault: false,
	});

	// Itinerary Day by Day
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/day-by-day",
		title: "Day by day",
		icon: "list-view",
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
			[ 'core/pattern', { slug: 'lsx-tour-operator/itinerary-list' } ]
		],
		isDefault: false,
		scope: ["inserter"],
		parent: ["lsx-tour-operator/itinerary"], // Restricts to "lsx/itinerary" block
	  });
  
	// Accommodation Units Wrapper
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/units",
		title: "Units",
		icon: "admin-multisite",
		category: "lsx-tour-operator",
		attributes: {
			metadata: {
				name: "Units",
			},
			align: "wide",
			layout: {
				type: "constrained",
			},
			className: "lsx-units-wrapper",
			backgroundColor: 'primary-bg',
			style: {
				spacing: {
					padding: {
						top: "var:preset|spacing|medium",
						bottom: "var:preset|spacing|medium",
						left: "var:preset|spacing|x-small",
						right: "var:preset|spacing|x-small",
					},
					margin : {
						top : 0,
						bottom: 0
					}
				}
			}
		},
		innerBlocks: [
		  [ 	'core/group',
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
						  content: 'Units',
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
				placeholder: "Replace this with the Rooms block, and select a pattern.",
				align: "center",
			  },
		  ]
	  ],
		isDefault: false,
	  });

	  wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/unit-rooms",
		title: "Rooms",
		icon: "admin-multisite",
		category: "lsx-tour-operator",
		attributes: {
		  metadata: {
			name: "Rooms",
			bindings: {
			  content: {
				source: "lsx/accommodation-units",
				type: "rooms"
			  },
			},
		  },
		  align: "wide",
		  layout: {
			type: "constrained",
		  },
		},
		innerBlocks: [
			[ 'core/pattern', { slug: 'lsx-tour-operator/room-card' } ]
		],
		isDefault: false,
		scope: ["inserter"],
		parent: ["lsx-tour-operator/units"], // Restricts to "lsx-tour-operator/units" block
	  });
  
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
				  args: { key: "price" },
				},
			  },
			},
			className: "amount has-primary-color has-text-color has-link-color",
			color: {
			  link: "primary-700",
			  text: "primary-700",
			},
		  },
		],
	  ],
	  isDefault: false,
	});
  
	// Destination to Tour Wrapper
	wp.blocks.registerBlockVariation("core/group", {
	  name: "lsx-destination-to-tour",
	  title: "Destination to Tour",
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
					width: 20,
					sizeSlug: "large",
					url: "https://tour-operator.lsx.design/wp-content/uploads/2024/09/Typelocation-icon.png",
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
					content: "<strong>Destinations:</strong>",
				},
				],
			],
			]
		],
		isDefault: false
	});

	// Destination to Tour
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/destination-to-tour',
		title: 'Destination to Tour',
		attributes: {
			metadata: {
				name: 'Destination to Tour',
			},
			className: 'lsx-destination-to-tour-wrapper',
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
				"core/paragraph",
				{
				metadata: {
					bindings: {
						content: {
							source: "lsx/post-connection",
							args: {
								key: "destination_to_tour",
							}
						}
					}
				},
				style: {
					elements: {
						link: {
								color: {
								text: "var:preset|color|primary-700",
							}
						}
					}
				},
				textColor: "primary-700",
				content: "",
				}
			]
		]
	});
  
	// Duration Wrapper
	wp.blocks.registerBlockVariation("core/group", {
	  name: "lsx-duration-wrapper",
	  title: "Duration",
	  category: "lsx-tour-operator",
	  attributes: {
		metadata: { name: "Duration" },
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
				width: 20,
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
	});

	// Duration
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/duration',
		title: 'Duration',
		category: 'layout',
		attributes: {
			metadata: {
				name: 'Duration',
			},
			className: 'lsx-duration-wrapper',
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
			}, [
				['core/image', {
					width: 20,
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/duration-TO-black-20px-icon.png',
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
					content: '<strong>Duration:</strong>'
				}]
			]],
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
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'duration'
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
					content: 'Days'
				}]
			]]
		]
	});
	
	// Group Size
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/group-size',
		title: 'Group Size',
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
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				}
			}, [
				['core/image', {
					id: 122731,
					width: 20,
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
			]],
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
			}, [
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
			]]
		]
	});
	
	// Single Supplement
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/single-supplement-wrapper',
		title: 'Single Supplement',
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
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				}
			}, [
				['core/image', {
					id: 122733,
					width: 20,
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
			]],
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
			}, [
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
				}]
			]]
		]
	});
	
	// Booking Validity Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/booking-validity-start',
		title: 'Booking Validity Start',
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
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				}
			}, [
				['core/image', {
					id: 122730,
					width: 20,
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
			]],
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
			}, [
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
			]]
		]
	});
	
	// Departs From
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/departs-from',
		title: 'Departs From',
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
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				}
			}, [
				['core/image', {
					width: 20,
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
			]],
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
			}]
		]
	});
	
	// Ends In
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/ends-in',
		title: 'Ends In Wrapper',
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
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				}
			}, [
				['core/image', {
					width: 20,
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
			]],
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
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				}
			}, [
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
			]],
			['core/group', {
				style: {
					layout: {
						selfStretch: 'fill',
						flexSize: null
					},
					spacing: {
						blockGap: '5px'
					}
				},
				layout: {
					type: 'flex',
					orientation: 'vertical'
				}
			}, [
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
			]]
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
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap',
						verticalAlignment: 'top'
					}
				}
			}, [
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
			]],
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
				className: 'has-septenary-color has-text-color has-link-color has-primary-700-color',
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
	
	// Rating Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/rating',
		title: 'Rating',
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
			}, [
				['core/image', {
					width: '20px',
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/rating-icon-TO-black-20px-1.png',
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
			]],
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
			}, [
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
				}, [
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
				]]
			]]
		]
	});
	
	// Number of Units Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/number-of-rooms',
		title: 'Number of Rooms',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Number if Rooms',
			},
			className: 'lsx-number-of-rooms-wrapper',
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
			}, [
				['core/image', {
					width: '20px',
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/TO-accommodation-rooms-icon-black-52px.png',
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
					content: '<strong>Number of units</strong>:'
				}]
			]],
			['core/group', {
				layout: {
					type: 'flex',
					flexWrap: 'nowrap'
				}
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'number_of_rooms'
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
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Check In Time Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/checkin-time',
		title: 'Check In Time',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Check In Time',
			},
			className: 'lsx-checkin-time-wrapper',
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
			}, [
				['core/image', {
					id: 122720,
					width: '20px',
					sizeSlug: 'large',
					linkDestination: 'none',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/11/check-in-check-out-time-icon-black-52px-1.svg',
					alt: '',
					className: 'wp-image-122720'
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
					content: '<strong>Check in time:</strong>'
				}]
			]],
			['core/group', {
				layout: {
					type: 'flex',
					flexWrap: 'nowrap'
				}
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'checkin_time'
								}
							}
						}
					},
					className: 'has-septenary-color has-text-color has-link-color has-primary-color has-primary-700-color',
					style: {
						spacing: {
							padding: {
								top: '2px',
								bottom: '2px'
							}
						}
					},
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Check Out Time Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/checkout-time',
		title: 'Check Out Time',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Check Out Time',
			},
			className: 'lsx-checkout-time-wrapper',
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
			}, [
				['core/image', {
					id: 122720,
					width: '20px',
					sizeSlug: 'large',
					linkDestination: 'none',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/11/check-in-check-out-time-icon-black-52px-1.svg',
					alt: '',
					className: 'wp-image-122720'
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
					content: '<strong>Check out time:</strong>'
				}]
			]],
			['core/group', {
				layout: {
					type: 'flex',
					flexWrap: 'nowrap'
				}
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'checkout_time'
								}
							}
						}
					},
					className: 'has-septenary-color has-text-color has-link-color has-primary-color has-primary-700-color',
					style: {
						spacing: {
							padding: {
								top: '2px',
								bottom: '2px'
							}
						}
					},
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Minimum Child Age Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/minimum-child-age',
		title: 'Minimum Child Age',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Minimum Child Age',
			},
			className: 'lsx-minimum-child-age-wrapper',
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
			}, [
				['core/image', {
					id: 122719,
					width: '20px',
					sizeSlug: 'large',
					linkDestination: 'none',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/11/minimum-child-age-icon-black-52px-1.svg',
					alt: '',
					className: 'wp-image-122719'
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
					content: '<strong>Minimum child age:</strong>'
				}]
			]],
			['core/group', {
				layout: {
					type: 'flex',
					flexWrap: 'nowrap'
				}
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'minimum_child_age'
								}
							}
						}
					},
					className: 'has-septenary-color has-text-color has-link-color has-primary-color has-primary-700-color',
					style: {
						spacing: {
							padding: {
								top: '2px',
								bottom: '2px'
							}
						}
					},
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Location Wrapper (Destination to Accommodation)
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/destination-to-accommodation',
		title: 'Destination to Accommodation',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Destination to Accommodation',
			},
			className: 'lsx-destination-to-accommodation-wrapper',
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
			}, [
				['core/image', {
					width: '20px',
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/Typelocation-icon.png',
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
					content: '<strong>Location</strong>:'
				}]
			]],
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
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-connection',
								args: {
									key: 'destination_to_accommodation'
								}
							}
						}
					},
					className: 'has-septenary-color has-text-color has-link-color',
					style: {
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
						},
						spacing: {
							padding: {
								top: '2px',
								bottom: '2px'
							}
						}
					},
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Spoken Languages Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/spoken-languages',
		title: 'Spoken Languages',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Spoken Languages',
			},
			className: 'lsx-spoken-languages-wrapper',
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
			}, [
				['core/image', {
					width: '20px',
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/spoken-languages-TO-icon-black-20px-1.png',
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
					content: '<strong>Spoken</strong> <strong>Languages:</strong>'
				}]
			]],
			['core/group', {
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
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'spoken_languages'
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
						typography: {
							textTransform: 'capitalize'
						}
					},
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Accommodation Type Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/accommodation-type',
		title: 'Accommodation Type',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Accommodation Type',
			},
			className: 'lsx-accommodation-type-wrapper',
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
			}, [
				['core/image', {
					width: '20px',
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/accommodation-type-TO-icon-black-20px-2.png',
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
					content: '<strong>Accommodation Type</strong>:'
				}]
			]],
			['core/group', {
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
			}, [
				['core/post-terms', {
					term: 'accommodation-type',
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
					fontSize: 'x-small',
					fontFamily: 'secondary'
				}]
			]]
		]
	});
	
	// Suggested Visitor Types (Friendly) Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'llsx-tour-operator/suggested-visitor-types',
		title: 'Suggested Visitor Types',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Suggested Visitor Types',
			},
			className: 'lsx-suggested-visitor-types-wrapper',
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
			}, [
				['core/image', {
					width: '20px',
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/09/friendly-TO-icon-black-20px-1.png',
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
					content: '<strong>Friendly</strong>:'
				}]
			]],
			['core/group', {
				layout: {
					type: 'flex',
					flexWrap: 'nowrap'
				}
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'suggested_visitor_types'
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
						typography: {
							textTransform: 'capitalize'
						}
					},
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Special Interests Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/special-interests',
		title: 'Special Interests',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Special Interests',
			},
			className: 'lsx-special-interests-wrapper',
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
			}, [
				['core/image', {
					id: 122726,
					width: '20px',
					sizeSlug: 'large',
					url: 'https://tour-operator.lsx.design/wp-content/uploads/2024/11/special-interests-icon-black-52px-1.svg',
					alt: '',
					linkDestination: 'none'
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
					content: '<strong>Special interests</strong>:'
				}]
			]],
			['core/group', {
				layout: {
					type: 'flex',
					flexWrap: 'nowrap'
				}
			}, [
				['core/paragraph', {
					metadata: {
						bindings: {
							content: {
								source: 'lsx/post-meta',
								args: {
									key: 'special-interests'
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
						typography: {
							textTransform: 'capitalize'
						}
					},
					textColor: 'primary-700'
				}]
			]]
		]
	});
	
	// Facilities Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/facilities',
		title: 'Facilities',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Facilities',
			},
			className: 'lsx-facilities-wrapper',
			style: {
				spacing: {
					padding: {
						top: 'var(--wp--preset--spacing--medium)',
						bottom: 'var(--wp--preset--spacing--medium)',
						left: 'var(--wp--preset--spacing--x-small)',
						right: 'var(--wp--preset--spacing--x-small)'
					},
					margin: {
						top: '0',
						bottom: '0'
					}
				}
			},
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				align: 'wide',
				style: {
					spacing: {
						margin: {
							top: '0',
							bottom: '0'
						},
						padding: {
							top: '0',
							bottom: 'var(--wp--preset--spacing--small)',
							left: '0',
							right: '0'
						},
						blockGap: 'var(--wp--preset--spacing--small)'
					}
				},
				layout: {
					type: 'flex',
					flexWrap: 'nowrap'
				}
			}, [
				['core/separator', {
					style: {
						layout: {
							selfStretch: 'fill',
							flexSize: null
						}
					},
					backgroundColor: 'primary'
				}],
				['core/heading', {
					textAlign: 'center',
					content: 'Facilities'
				}],
				['core/separator', {
					style: {
						layout: {
							selfStretch: 'fill',
							flexSize: null
						}
					},
					backgroundColor: 'primary'
				}]
			]],
			['core/group', {
				align: 'wide',
				layout: {
					type: 'default'
				}
			}, [
				['core/post-terms', {
					term: 'facility',
					fontSize: 'x-small'
				}]
			]]
		]
	});

	// Travel Information - Additional Information Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/additional-info',
		title: 'Additional Information',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Additional Info',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' },
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**General**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'additional_info'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Electricity Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/electricity',
		title: 'Electricity',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Electricity',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' }
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**Electricity**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'electricity'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Banking Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/banking',
		title: 'Banking',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Banking',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' }
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**Banking**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'banking'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Cuisine Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/cuisine',
		title: 'Cuisine',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Cuisine',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' }
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**Cuisine**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'cuisine'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Climate Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/climate',
		title: 'Climate',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Climate',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' }
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**Climate**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'climate'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Transport Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/transport',
		title: 'Transport',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Transport',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' }
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**Transport**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'transport'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Dress Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/dress',
		title: 'Dress',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Dress',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' }
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**Dress**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'dress'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Health Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/health',
		title: 'Health',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Health',
			},
			className: 'lsx-additional-info-wrapper',
			style: {
				border: {
					radius: '8px'
				},
				spacing: {
					padding: {
						top: '0px',
						bottom: '0px',
						left: '0px',
						right: '0px'
					},
					blockGap: '0px'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
				style: {
					spacing: {
						margin: { top: '0', bottom: '0' },
						padding: {
							top: '10px',
							bottom: '10px',
							left: '10px',
							right: '10px'
						}
					},
					dimensions: {
						minHeight: ''
					}
				},
				layout: {
					type: 'constrained'
				}
			}, [
				['core/group', {
					style: {
						dimensions: { minHeight: '' },
						spacing: {
							padding: { top: '0', bottom: '0' }
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						align: 'center',
						style: {
							spacing: {
								padding: { top: '0', bottom: '0' }
							}
						},
						fontSize: 'small',
						content: '**Health**'
					}]
				]],
				['core/group', {
					style: {
						spacing: {
							padding: {
								right: '10px',
								left: '10px',
								top: '0px',
								bottom: '0px'
							},
							blockGap: '0'
						}
					},
					layout: {
						type: 'constrained'
					}
				}, [
					['core/paragraph', {
						style: {
							spacing: {
								padding: { top: '2px', bottom: '2px' }
							}
						},
						metadata: {
							bindings: {
								content: {
									source: 'lsx/post-meta',
									args: {
										key: 'health'
									}
								}
							}
						}
					}]
				]]
			]],
			['core/buttons', {}, [
				['core/button', {
					backgroundColor: 'primary',
					width: 100,
					style: {
						border: {
							radius: {
								bottomLeft: '8px',
								bottomRight: '8px'
							}
						}
					},
					content: 'View More'
				}]
			]]
		]
	});
	
	// Travel Information - Safety Wrapper
	wp.blocks.registerBlockVariation(
		'core/group',
		{
			name: 'lsx-tour-operator/safety',
			title: 'Safety',
			category: 'lsx-tour-operator',
			attributes: {
				metadata: {
					name: 'Safety',
				},
				className: 'lsx-additional-info-wrapper',
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
		}
	);
	
	// Travel Information - Visa Wrapper
	wp.blocks.registerBlockVariation(
		'core/group',
		{
			name: 'lsx-tour-operator/visa',
			title: 'Visa',
			category: 'lsx-tour-operator',
			attributes: {
				metadata: {
					name: 'Visa',
				},
				className: 'lsx-additional-info-wrapper',
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
		}
	);

	// Destination - Regions
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/facts-regions-wrapper',
		title: 'Regions List',
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
										args: { key: "post_children" },
									},
								},
							},
							style: {
								elements: {
									link: {
										color: {
											text: 'var:preset|color|septenary'
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
							textColor: 'septenary',
							content: ''
						}
					]
				]
			]
		]
	});

	// Destination - Country List
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/facts-country-wrapper',
		title: 'Country',
		attributes: {
			metadata: {
				name: 'Country'
			},
			className: 'facts-country-query-wrapper',
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
							content: '<strong>Country:</strong>'
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
										args: { key: "post_parent" },
									},
								},
							},
							style: {
								elements: {
									link: {
										color: {
											text: 'var:preset|color|septenary'
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
							textColor: 'septenary',
							content: ''
						}
					]
				]
			]
		]
	});
  });
  
