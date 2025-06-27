wp.domReady(() => {

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
						id: 122730,
						width: '20px',
						sizeSlug: 'large',
						linkDestination: 'none',
						url: lsxToEditor.assetsUrl + 'blocks/booking-validity.svg',
						alt: ''
					}],
					['core/paragraph', {
						
						fontSize: 'x-small',
						content: '<strong>Booking validity:</strong>'
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
										key: 'booking_validity_start'
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
						content: ''
					}],
					['core/paragraph', {
						
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
						
						content: 'End'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});