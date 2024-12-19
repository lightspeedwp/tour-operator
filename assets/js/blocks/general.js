// metadata.bindings not handle correctly

wp.domReady(() => {

	const svgElement = wp.element.createElement(
		'svg',
		{
			width: "52",
			height: "52",
			viewBox: "0 0 52 52",
			fill: "none",
			xmlns: "http://www.w3.org/2000/svg"
		},
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M25.8848 50.9803C39.6698 50.9803 50.8448 39.8053 50.8448 26.0203C50.8448 12.2353 39.6698 1.0603 25.8848 1.0603C12.0998 1.0603 0.924805 12.2353 0.924805 26.0203C0.924805 39.8053 12.0998 50.9803 25.8848 50.9803ZM25.9956 47.4606C37.8631 47.4606 47.4836 37.8401 47.4836 25.9726C47.4836 14.1051 37.8631 4.4846 25.9956 4.4846C14.1281 4.4846 4.50762 14.1051 4.50762 25.9726C4.50762 37.8401 14.1281 47.4606 25.9956 47.4606Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M24.375 10.2578C24.375 11.0992 25.0571 11.7812 25.8984 11.7812V11.7812C26.7398 11.7812 27.4219 11.0992 27.4219 10.2578V7.21094C27.4219 6.36957 26.7398 5.6875 25.8984 5.6875V5.6875C25.0571 5.6875 24.375 6.36957 24.375 7.21094V10.2578Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M13.4739 16.0447C14.0688 16.6396 15.0334 16.6396 15.6284 16.0447V16.0447C16.2233 15.4497 16.2233 14.4852 15.6284 13.8902L13.4739 11.7358C12.8789 11.1408 11.9144 11.1408 11.3194 11.7358V11.7358C10.7245 12.3307 10.7245 13.2953 11.3194 13.8902L13.4739 16.0447Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M36.4099 13.7583C35.815 14.3532 35.815 15.3178 36.4099 15.9128V15.9128C37.0048 16.5077 37.9694 16.5077 38.5644 15.9128L40.7188 13.7583C41.3138 13.1634 41.3138 12.1988 40.7188 11.6038V11.6038C40.1239 11.0089 39.1593 11.0089 38.5644 11.6038L36.4099 13.7583Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M9.95312 27.625C10.7945 27.625 11.4766 26.9429 11.4766 26.1016V26.1016C11.4766 25.2602 10.7945 24.5781 9.95312 24.5781H6.90625C6.06488 24.5781 5.38281 25.2602 5.38281 26.1016V26.1016C5.38281 26.9429 6.06488 27.625 6.90625 27.625H9.95312Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M44.9922 27.625C45.8336 27.625 46.5156 26.9429 46.5156 26.1016V26.1016C46.5156 25.2602 45.8336 24.5781 44.9922 24.5781H41.9453C41.1039 24.5781 40.4219 25.2602 40.4219 26.1016V26.1016C40.4219 26.9429 41.1039 27.625 41.9453 27.625H44.9922Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M11.9812 39.1257C11.3863 39.7207 11.3863 40.6853 11.9812 41.2802V41.2802C12.5761 41.8751 13.5407 41.8751 14.1357 41.2802L16.2901 39.1257C16.8851 38.5308 16.8851 37.5662 16.2901 36.9713V36.9713C15.6952 36.3763 14.7306 36.3763 14.1357 36.9713L11.9812 39.1257Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M38.2629 40.6555C38.8579 41.2505 39.8225 41.2505 40.4174 40.6555V40.6555C41.0124 40.0606 41.0124 39.096 40.4174 38.5011L38.2629 36.3466C37.668 35.7517 36.7034 35.7517 36.1085 36.3466V36.3466C35.5135 36.9415 35.5135 37.9061 36.1085 38.5011L38.2629 40.6555Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M24.8828 44.7891C24.8828 45.6304 25.5649 46.3125 26.4062 46.3125V46.3125C27.2476 46.3125 27.9297 45.6304 27.9297 44.7891V41.7422C27.9297 40.9008 27.2476 40.2188 26.4062 40.2188V40.2188C25.5649 40.2188 24.8828 40.9008 24.8828 41.7422V44.7891Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M28.6218 22.4428L28.6222 22.4426L28.6192 22.4407C28.3268 22.2199 28.0059 22.0334 27.6627 21.8875L13 13.4062L21.8155 27.8277C21.9285 28.0554 22.0616 28.2716 22.2115 28.4754L22.2174 28.4851L22.2181 28.4844C22.395 28.7237 22.5961 28.9449 22.8177 29.1446C22.9896 29.3271 23.1771 29.4954 23.3782 29.6475L23.3778 29.6477L23.3808 29.6495C23.6732 29.8704 23.9941 30.0569 24.3373 30.2028L39 38.684L30.1845 24.2626C30.0715 24.0349 29.9384 23.8187 29.7885 23.6149L29.7826 23.6052L29.7819 23.6058C29.605 23.3666 29.404 23.1454 29.1824 22.9457C29.0104 22.7632 28.8229 22.5949 28.6218 22.4428ZM24.3781 24.4125C23.9645 24.8126 23.7084 25.3675 23.7084 25.9808C23.7084 27.2003 24.7213 28.1889 25.9709 28.1889C26.5417 28.1889 27.0631 27.9826 27.4612 27.6422C27.8747 27.2421 28.1308 26.6872 28.1308 26.0739C28.1308 24.8544 27.118 23.8658 25.8685 23.8658C25.2976 23.8658 24.7762 24.0721 24.3781 24.4125Z",
			fill: "#090909"
		}),
		wp.element.createElement('path', {
			'fill-rule': "evenodd",
			'clip-rule': "evenodd",
			d: "M43.567 6.91088C43.3913 6.65906 43.2131 6.38092 43.0942 6.09685C42.6699 5.08228 42.7343 3.8416 43.1616 2.84063C43.1926 2.76922 43.2253 2.69875 43.2599 2.62913C43.2943 2.55942 43.3304 2.49059 43.3682 2.42266C43.4061 2.35473 43.4457 2.2878 43.4868 2.2217C43.5022 2.19713 43.5179 2.17271 43.5337 2.14836C43.5603 2.10759 43.5875 2.06721 43.6153 2.0272C43.6597 1.96332 43.7056 1.90064 43.7531 1.83904C43.8006 1.77739 43.8497 1.71711 43.9002 1.65803C43.9506 1.59885 44.0025 1.54098 44.056 1.48448C44.0751 1.46412 44.0945 1.44394 44.114 1.42386C44.1488 1.38829 44.1842 1.35331 44.22 1.31881C44.2761 1.26491 44.3336 1.21248 44.3923 1.16151C44.4509 1.11044 44.5109 1.0609 44.572 1.0129C44.6332 0.964895 44.6955 0.918498 44.7589 0.873496C44.8224 0.82852 44.8869 0.785151 44.9525 0.743478C44.9774 0.727538 45.0026 0.711935 45.0278 0.696495C45.069 0.671458 45.1104 0.646957 45.1523 0.62308C45.2198 0.584621 45.2883 0.547832 45.3578 0.512701C45.4271 0.477645 45.4973 0.444333 45.5684 0.412754C45.6394 0.381174 45.7113 0.351402 45.7838 0.323337C46.9073 -0.107222 48.1988 -0.125455 49.3033 0.375628C50.3912 0.869147 51.2751 1.85395 51.6838 2.97151C51.7096 3.04319 51.7337 3.11557 51.756 3.18855C51.7646 3.2165 51.7728 3.24452 51.7808 3.27261C51.7937 3.31778 51.8059 3.3632 51.8175 3.40885C51.8233 3.43194 51.829 3.45513 51.8345 3.47834C51.8466 3.52931 51.8579 3.58059 51.8682 3.6319C51.8834 3.70667 51.8966 3.78174 51.908 3.8571C51.9133 3.89208 51.9183 3.92719 51.9228 3.96231C51.9281 4.00289 51.9328 4.04346 51.937 4.08414C51.9447 4.15995 51.9506 4.23587 51.9546 4.31202C51.9587 4.38827 51.9609 4.46458 51.9612 4.54083C51.9616 4.61703 51.9601 4.69328 51.9567 4.76949C51.9534 4.84572 51.9482 4.92175 51.9411 4.99766C51.9388 5.02227 51.9363 5.04687 51.9337 5.07146C51.9281 5.12272 51.9216 5.17385 51.9143 5.22486C51.9107 5.25022 51.9068 5.27557 51.9028 5.30091C51.8949 5.35089 51.8861 5.40075 51.8765 5.45047C51.8621 5.52533 51.8458 5.5998 51.8279 5.67399C51.8098 5.74809 51.7899 5.82163 51.7683 5.89482C51.7467 5.96791 51.7232 6.04042 51.6981 6.11245C51.6729 6.18447 51.646 6.25582 51.6174 6.32646C51.5887 6.39709 51.5584 6.46709 51.5264 6.53637C51.0265 7.59911 50.0679 8.49389 48.9549 8.87753C47.5903 9.34807 46.3252 9.05145 45.0645 8.44598C45.0322 8.47617 44.9988 8.50644 44.9648 8.53711L44.9608 8.54076L44.9606 8.54093C44.7379 8.74234 44.4971 8.96006 44.4311 9.25287C44.4995 9.331 44.5707 9.36452 44.6414 9.39777L44.6415 9.39785C44.7261 9.43765 44.8097 9.47702 44.8869 9.59228C44.8499 10.0781 43.9245 10.8797 43.312 11.4103C43.2279 11.4832 43.1497 11.551 43.0805 11.6121C42.6465 11.1226 42.1952 10.6432 41.7265 10.1745C41.2678 9.71577 40.7988 9.27372 40.3203 8.84835C40.4071 8.75939 40.4938 8.67004 40.5806 8.5806L40.5806 8.58059C40.9383 8.21189 41.2975 7.84173 41.67 7.49145C41.6894 7.47332 41.7121 7.45102 41.7373 7.42615C41.8936 7.27233 42.149 7.02091 42.319 7.05068C42.5395 7.08935 42.6356 7.21956 42.7526 7.37811L42.7935 7.43314C43.0228 7.38867 43.2379 7.19892 43.4285 7.03071L43.4295 7.02979C43.4769 6.98793 43.5228 6.94742 43.567 6.91088ZM49.8764 4.49387C49.8764 5.83988 48.7852 6.93104 47.4392 6.93104C46.0932 6.93104 45.002 5.83988 45.002 4.49387C45.002 3.14785 46.0932 2.05669 47.4392 2.05669C48.7852 2.05669 49.8764 3.14785 49.8764 4.49387Z",
			fill: "#090909"
		})
	);

	wp.blocks.updateCategory( 'lsx-tour-operator', {
		icon: svgElement
	} );

	// Gallery Block
	wp.blocks.registerBlockVariation("core/gallery", {
		name: "lsx-tour-operator/gallery",
		title: "TO Gallery",
		icon: "format-gallery",
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
					sizeSlug: 'large',
					url: lsxToEditor.assetsUrl + "placeholders/placeholder-general-350x350.jpg",
				}
			],
			[
				"core/image",
				{
					sizeSlug: 'large',
					url: lsxToEditor.assetsUrl + "placeholders/placeholder-general-350x350.jpg",
				}
			],
			[
				"core/image",
				{
					sizeSlug: 'large',
					url: lsxToEditor.assetsUrl + "placeholders/placeholder-general-350x350.jpg",
				}
			]
		],
		isDefault: false
	});

	// Price Block
	wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/price",
		title: "Price",
		category: 'lsx-tour-operator',
		icon: 'bank',
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
		supports: {
			renaming: false
		}
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
						width: '20px',
						sizeSlug: 'large',
						url: lsxToEditor.assetsUrl + 'blocks/travel-styles.png',
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
		],
		supports: {
			renaming: false
		}
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
						width: '20px',
						sizeSlug: 'large',
						url: lsxToEditor.homeUrl + 'wp-content/uploads/2024/11/booking-validity-icon-black-52px-1.svg',
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
		],
		supports: {
			renaming: false
		}
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
		],
		supports: {
			renaming: false
		}
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
		],
		supports: {
			renaming: false
		}
	});

	// View More Button Block
	wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/more-link',
        title: 'More Button',
		name: 'core/button',
		category: "lsx-tour-operator",
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
		},
		supports: {
			renaming: false
		}
    });

	// View More Button Block
	wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/permalink-button',
        title: 'Permalink',
		name: 'core/button',
		category: "lsx-tour-operator",
		attributes: {
			className: 'lsx-to-link',
			metadata: {
				name: 'Permalink'
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
		},
		supports: {
			renaming: false
		}
    });
});

