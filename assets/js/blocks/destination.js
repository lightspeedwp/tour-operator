wp.domReady(() => {
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
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									},
									blockGap: '0'
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>General</strong>'
							}]
						]
					],
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
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
				]
			]
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
			className: 'lsx-electricity-wrapper',
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
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Electricity</strong>'
							}]
						]
					],
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
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
				]
			]
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
			className: 'lsx-banking-wrapper',
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
				},
				layout: {
					selfStretch: 'fixed',
					flexSize: '25%'
				}
			},
			backgroundColor: 'base',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
					metadata: {
						name: 'Content'
					},
					style: {
						spacing: {
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							metadata: {
								name: 'Title'
							},
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Banking</strong>'
							}]
						]
					],
					['core/group', {
							className: 'lsx-to-more-content',
							metadata: {
								name: 'Description'
							},
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
					['core/button', {
						metadata: {
							name: 'More Button'
						},
						className: 'lsx-to-more-link more-link',
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
						text: 'View More'
					}]
				]
			]
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
			className: 'lsx-cuisine-wrapper',
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
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Cuisine</strong>'
							}]
						]
					],
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
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
				]
			]
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
			className: 'lsx-climate-wrapper',
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
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Climate</strong>'
							}]
						]
					],
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
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
				]
			]
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
			className: 'lsx-transport-wrapper',
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
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Transport</strong>'
							}]
						]
					],
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
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
				]
			]
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
			className: 'lsx-dress-wrapper',
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
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Dress</strong>'
							}]
						]
					],
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
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
				]
			]
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
			className: 'lsx-health-wrapper',
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
							margin: {
								top: '0',
								bottom: '0'
							},
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
				},
				[
					['core/group', {
							style: {
								dimensions: {
									minHeight: ''
								},
								spacing: {
									padding: {
										top: '0',
										bottom: '0'
									}
								}
							},
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								style: {
									spacing: {
										padding: {
											top: '0',
											bottom: '0'
										}
									}
								},
								fontSize: 'small',
								content: '<strong>Health</strong>'
							}]
						]
					],
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
						},
						[
							['core/paragraph', {
								style: {
									spacing: {
										padding: {
											top: '2px',
											bottom: '2px'
										}
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
						]
					]
				]
			],
			['core/buttons', {},
				[
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
				]
			]
		]
	});

	// Travel Information - Safety Wrapper
	wp.blocks.registerBlockVariation(
		'core/group', {
			name: 'lsx-tour-operator/safety',
			title: 'Safety',
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
		}
	);

	// Travel Information - Visa Wrapper
	wp.blocks.registerBlockVariation(
		'core/group', {
			name: 'lsx-tour-operator/visa',
			title: 'Visa',
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
										args: {
											key: "post_parent"
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
		]
	});
});