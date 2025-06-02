wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/checkout-time',
		title: 'Check Out Time',
		icon: "clock",
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
						url: lsxToEditor.assetsUrl + 'blocks/check-in-check-out-time.svg',
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
		],
		supports: {
			renaming: false
		}
	});

});