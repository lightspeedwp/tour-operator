wp.domReady(() => {

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
					margin: {
						top: 0,
						bottom: 0
					}
				}
			}
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
			['core/pattern', {
				slug: 'lsx-tour-operator/room-card'
			}]
		],
		isDefault: false,
		scope: ["inserter"],
		parent: ["lsx-tour-operator/units"], // Restricts to "lsx-tour-operator/units" block
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
				},
				[
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
				},
				[
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
				]
			],
			['core/group', {
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
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
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
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
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
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
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
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px',
							padding: {
								left: '25px',
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
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px',
							padding: {
								left: '25px',
							}
						}
					},
					layout: {
						type: 'flex',
						flexWrap: 'nowrap'
					}
				},
				[
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
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
							style: {
						spacing: {
							padding: {
								left: '25px',
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
				]
			]
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
			className: 'lsx-special-interest-wrapper',
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
				]
			],
			['core/group', {
					style: {
						spacing: {
							padding: {
								left: '25px',
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
										key: 'special_interests'
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
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
					align: 'wide',
					layout: {
						type: 'default'
					}
				},
				[
					['core/post-terms', {
						term: 'facility',
						fontSize: 'x-small'
					}]
				]
			]
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
				},
				[
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
				]
			],
			['core/group', {
					style: {
						spacing: {
							blockGap: '5px',
							padding: {left: '25px'}
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
				]
			]
		]
	});
});