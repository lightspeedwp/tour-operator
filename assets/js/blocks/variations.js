wp.domReady(() => {

	// Itinerary Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx/itinerary',
		title: 'Itinerary',
		icon: 'list-view',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Itinerary',
				bindings: {
					content: {
						source: 'lsx/tour-itinerary'
					}
				}
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

	// Accommodation Units Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx/accommodation-units',
		title: 'Units',
		icon : 'admin-multisite',
		category: 'lsx-tour-operator',
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
		[
		  "core/paragraph",
		  {
			placeholder: "Insert your Itinerary pattern here.",
			align: "center",
		  },
		],
	  ],
	  isDefault: false,
	});

	// Gallery Wrapper
	wp.blocks.registerBlockVariation('core/gallery', {
		name: 'lsx/gallery',
		title: 'TO Gallery',
		icon : 'admin-multisite',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'TO Gallery',
				bindings: {
					content: {
						source: 'lsx/gallery'
					}
				}
			},
		  },
		align: "wide",
		layout: {
		  type: "constrained",
		},
	  innerBlocks: [
		[
		  "core/paragraph",
		  {
			placeholder: "Insert your Room pattern here.",
			align: "center",
		  },
		],
	  ],
	  isDefault: false,
	});

	// Price Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx/price',
		title: 'Price',
		icon : 'bank',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Price',
			},
		  },
		linkTo: "none",
		sizeSlug: "thumbnail",
	  innerBlocks: [
		[
		  "core/image",
		  {
			href: "https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg",
		  },
		],
		[
		  "core/image",
		  {
			href: "https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg",
		  },
		],
		[
		  "core/image",
		  {
			href: "https://tour-operator.lsx.design/wp-content/plugins/tour-operator/assets/img/placeholders/placeholder-general-350x350.jpg",
		  },
		],
	  ],
	  isDefault: false,
	});
  
	// Price Wrapper
	wp.blocks.registerBlockVariation("core/group", {
	  name: "lsx/price",
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

	// Destination to Tour Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-destination-to-tour',
		title: 'Destination to Tour Wrapper',
		attributes: {
			name: 'Destination to Tour Wrapper',
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

	// Duration Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-duration-wrapper',
		title: 'Duration Wrapper',
		category: 'layout',
		attributes: {
			name: 'Duration Wrapper',
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
	
	// Group Size Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-group-size-wrapper',
		title: 'Group Size Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-group-size-wrapper',
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
	
	// Single Supplement Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-single-supplement-wrapper',
		title: 'Single Supplement Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-single-supplement-wrapper',
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
		name: 'lsx-booking-validity-start-wrapper',
		title: 'Booking Validity Start Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-booking-validity-start-wrapper',
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
	
	// Departs From Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-departs-from-wrapper',
		title: 'Departs From Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-departs-from-wrapper',
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
	
	// Ends In Wrapper
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-ends-in-wrapper',
		title: 'Ends In Wrapper',
		category: 'layout',
		attributes: {
			name: 'Ends In',
			className: 'lsx-ends-in-wrapper',
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
		name: 'lsx-travel-style-wrapper',
		title: 'Travel Style Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-best-time-to-visit-wrapper',
		title: 'Best Time to Visit Wrapper',
		category: 'layout',
		attributes: {
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
	wp.blocks.registerBlockVariation('core/column', {
		name: 'lsx-included-wrapper',
		title: 'Included Items Wrapper',
		category: 'layout',
		attributes: {
			style: {
				spacing: {
					blockGap: '0'
				},
				width: '50%'
			},
			id: 'lsx-included-wrapper'
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
	wp.blocks.registerBlockVariation('core/column', {
		name: 'lsx-not-included-wrapper',
		title: 'Excluded Items Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-rating-wrapper',
		title: 'Rating Wrapper',
		category: 'layout',
		attributes: {
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
					className: 'has-septenary-color has-text-color has-link-color has-primary-700-color',
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
		name: 'lsx-number-of-rooms-wrapper',
		title: 'Number of Rooms Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-checkin-time-wrapper',
		title: 'Check In Time Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-checkout-time-wrapper',
		title: 'Check Out Time Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-minimum-child-age-wrapper',
		title: 'Minimum Child Age Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-destination-to-accommodation-wrapper',
		title: 'Destination to Accommodation Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-spoken-languages-wrapper',
		title: 'Spoken Languages Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-accommodation-type-wrapper',
		title: 'Accommodation Type Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-suggested-visitor-types-wrapper',
		title: 'Suggested Visitor Types Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-special-interests-wrapper',
		title: 'Special Interests Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-facilities-wrapper',
		title: 'Facilities Wrapper',
		category: 'layout',
		attributes: {
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
		name: 'lsx-additional-info-wrapper',
		title: 'Additional Information Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
		name: 'lsx-electricity-wrapper',
		title: 'Electricity Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
		name: 'lsx-banking-wrapper',
		title: 'Banking Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
		name: 'lsx-cuisine-wrapper',
		title: 'Cuisine Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
		name: 'lsx-climate-wrapper',
		title: 'Climate Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
		name: 'lsx-transport-wrapper',
		title: 'Transport Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
		name: 'lsx-dress-wrapper',
		title: 'Dress Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
		name: 'lsx-health-wrapper',
		title: 'Health Wrapper',
		category: 'layout',
		attributes: {
			className: 'lsx-additional-info-wrapper is-style-shadow-xsm',
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
			name: 'lsx-safety-info',
			title: 'Safety Info Block',
			description: 'A block variation for displaying safety information.',
			category: 'common',
			attributes: {
				className: 'lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background',
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
			name: 'lsx-visa-info',
			title: 'Visa Info Block',
			description: 'A block variation for displaying visa information.',
			category: 'common',
			attributes: {
				className: 'lsx-additional-info-wrapper is-style-shadow-xsm has-base-background-color has-background',
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
});


