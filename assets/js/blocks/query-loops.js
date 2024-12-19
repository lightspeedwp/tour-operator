wp.domReady( function() {
	// DESTINATION - COUNTRY - REGION
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/regions',
		title: 'Regions',
		description: 'Display any regions attached to this destination.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Regions'
			},
			className: "lsx-regions-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Regions' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query', {
						metadata: {
							name: 'Regions Query'
						},
						query: {
							perPage: 8,
							postType: 'destination',
							order: 'asc',
							orderBy: 'date'
						},
						align: 'wide'
					}, [
						[ 
							'core/post-template', 
							{
								className: "lsx-regions-query",
								layout: {
									type: 'grid',
									columnCount: 4
								}
							},
							[
								[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
							]
						]
					]
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// DESTINATION - REGION - RELATED REGIONS
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/related-regions',
		title: 'Related Regions',
		description: 'Display any regions from the parent country.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Regions'
			},
			className: "lsx-related-regions-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Regions' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query',
						{
							metadata: {
								name: 'Related Regions Query'
							},
							query: {
								perPage: 8,
								postType: 'destination',
								order: 'asc',
								orderBy: 'date'
							},
							align: 'wide'
						},
						[
							[ 
								'core/post-template', 
								{
									className: "lsx-related-regions-query",
									layout: {
										type: 'grid',
										columnCount: 4
									}
								},
								[
									[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
								]
							]
						]
					]
				]
			]
		]
	});

	// Featured Accommodation
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/featured-accommodation',
		title: 'Featured Accommodation',
		description: 'Displays Accommodation with the Featured tag.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Featured Accommodation'
			},
			className: "lsx-featured-accommodation-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group',
				{
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Featured Accommodation' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query', {
							metadata: {
								name: 'Featured Accommodation Query'
							},
							query: {
								perPage: 8,
								postType: 'accommodation',
								order: 'asc',
								orderBy: 'date'
							},
							align: 'wide'
						},
						[
							[ 
								'core/post-template', 
								{
									className: "lsx-featured-accommodation-query",
									layout: {
										type: 'grid',
										columnCount: 3
									}
								},
								[
									[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
								]
							]
						]
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// Featured Tours
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/featured-tours',
		title: 'Featured Tours',
		description: 'Displays Tours with the Featured tag.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Featured Tours'
			},
			className: "lsx-featured-tours-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Featured Tours' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[			
					[ 'core/query', {
							metadata: {
								name: 'Featured Tours Query'
							},
							query: {
								perPage: 8,
								postType: 'tour',
								order: 'asc',
								orderBy: 'date'
							},
							align: 'wide'
						},
						[
							[ 
								'core/post-template', 
								{
									className: "lsx-featured-tours-query",
									layout: {
										type: 'grid',
										columnCount: 3
									}
								},
								[
									[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
								]
							]
						]
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	// Featured Destinations
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/featured-destinations',
		title: 'Featured Destinations',
		description: 'Displays Destinations with Featured tag.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Featured Destinations'
			},
			className: "lsx-featured-destinations-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Featured Destinations' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query', {
							metadata: {
								name: 'Featured Destination Query'
							},
							query: {
								perPage: 8,
								postType: 'destination',
								order: 'asc',
								orderBy: 'date'
							},
							align: 'wide'
						},
						[
							[ 
								'core/post-template', 
								{
									className: "lsx-featured-destinations-query",
									layout: {
										type: 'grid',
										columnCount: 3
									}
								},
								[
									[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
								]
							]
						]
					]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

	/**
	 * Query Loops for the Single Tour Page
	 */

	// Related Accommodation - Tour
	// Should displays accommodation in the same "destinations" as the tour.
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/accommodation-related-tour',
		title: 'Related Accommodation - Tour',
		description: 'Displays Accommodation related to this Tour via the destinations.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Accommodation - Tour'
			},
			className: "lsx-accommodation-related-tour-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Accommodation' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Accommodation Query'
					},
					query: {
						perPage: 8,
						postType: 'accommodation',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-accommodation-related-tour-query",
							layout: {
								type: 'grid',
								columnCount: 3
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});

	// Related Tours - Tour
	// Displays tours that run through the same "destinations" as this tour.

	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/tour-related-tour',
		title: 'Related Tours - Tour',
		description: 'Displays tours related to this Tour via the destinations.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Tours - Tour'
			},
			className: "lsx-tour-related-tour-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Tours' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Tours Query'
					},
					query: {
						perPage: 8,
						postType: 'tour',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-tour-related-tour-query",
							layout: {
								type: 'grid',
								columnCount: 3
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});	


	/**
	 * Query Loops for the Single Accommodation Page
	 */
	// Related Tours - Accommodation
	// Should display Tours that are tagged in the same "destination" as the accommodation.

	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/tour-related-accommodation',
		title: 'Related Tours - Accommodation',
		description: 'Displays Tours related to an Accommodation via the destination.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Tour - Accommodation'
			},
			className: "lsx-tour-related-accommodation-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Tours' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Tours Query'
					},
					query: {
						perPage: 8,
						postType: 'tour',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-tour-related-accommodation-query",
							layout: {
								type: 'grid',
								columnCount: 3
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});

	// Related Accommodation - Accommodation
	// Displays tours that run through the same "destinations" as this tour.

	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/accommodation-related-accommodation',
		title: 'Related Accommodation - Accommodation',
		description: 'Displays other accommodation in the area.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Accommodation - Accommodation'
			},
			className: "lsx-accommodation-related-accommodation-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Accommodation' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Accommodation Query'
					},
					query: {
						perPage: 8,
						postType: 'accommodation',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-accommodation-related-accommodation-query",
							layout: {
								type: 'grid',
								columnCount: 3
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});

	/**
	 * Query Loops for the Single Destination Page
	 */

	// Related Accommodation - Destination
	// Should display Accommodation listed in the Related Accommodation custom field for a Destination

	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/accommodation-related-destination',
		title: 'Related Accommodation - Destination',
		description: 'Displays Accommodation related to a Destination.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Accommodation - Destination'
			},
			className: "lsx-accommodation-related-destination-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Accommodation' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Accommodation Query'
					},
					query: {
						perPage: 8,
						postType: 'accommodation',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-accommodation-related-destination-query",
							layout: {
								type: 'grid',
								columnCount: 3
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});

	// Related Tours - Destination
	// Should display Tours listed in the Related Tours custom field for a Destination
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/tour-related-destination',
		title: 'Related Tours - Destinations',
		description: 'Displays Tours related to a Destination.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Tour - Destination'
			},
			className: "lsx-tour-related-destination-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Tours' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Tours Query'
					},
					query: {
						perPage: 8,
						postType: 'tour',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-tour-related-destination-query",
							layout: {
								type: 'grid',
								columnCount: 3
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});

	/**
	 * Query Loops for the Reviews to the custom post type Pages
	 */

	// Related Reviews - Destination
	// Should display Reviews listed in the Related Reviews custom field for a Destination
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/review-related-destination',
		title: 'Related Reviews - Destinations',
		description: 'Displays Reviews related to an Destination.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Reviews - Destination'
			},
			className: "lsx-review-related-destination-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Reviews' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Review Query - Destination'
					},
					query: {
						perPage: 8,
						postType: 'review',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-review-related-destination-query",
							layout: {
								type: 'grid',
								columnCount: 2
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});

	// Related Reviews - Tours
	// Should display Reviews listed in the Related Reviews custom field for a Tour
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/review-related-tour',
		title: 'Related Reviews - Tour',
		description: 'Displays Reviews related to a Tour.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Reviews - Tour'
			},
			className: "lsx-review-related-tour-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Reviews' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Reviews Query - Tour'
					},
					query: {
						perPage: 8,
						postType: 'review',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-review-related-tour-query",
							layout: {
								type: 'grid',
								columnCount: 2
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});

	// Related Reviews - Accommodation
	// Should display Reviews listed in the Related Reviews custom field for an Accommodation
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/review-related-accommodation',
		title: 'Related Reviews - Accommodation',
		description: 'Displays Reviews related to an Accommodation.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Reviews - Tour'
			},
			className: "lsx-review-related-accommodation-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
				[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Reviews' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Related Review Query - Accommodation'
					},
					query: {
						perPage: 8,
						postType: 'review',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-review-related-accommodation-query",
							layout: {
								type: 'grid',
								columnCount: 2
							}
						},
						[
							[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
						]
					]
				   ]
				]
			]]
		],
		supports: {
			renaming: false
		}
	});
});
