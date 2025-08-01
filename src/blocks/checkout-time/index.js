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
			
			layout: {
				type: 'flex',
				flexWrap: 'nowrap'
			}
		},
		innerBlocks: [
			['core/group', {
					
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
						
						
						}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});