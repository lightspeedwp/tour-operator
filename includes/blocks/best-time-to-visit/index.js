wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/best-time-to-visit',
		title: 'Best Time to Visit',
		icon: 'calendar-alt',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Best Time to Visit',
			},
			className: 'lsx-best-time-to-visit-wrapper',
			
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
						width: '20px',
						sizeSlug: 'large',
						url: lsxToEditor.homeUrl + 'wp-content/uploads/2024/11/booking-validity-icon-black-52px-1.svg',
						alt: ''
					}],
					['core/paragraph', {
						
						fontSize: 'x-small',
						content: '<strong>Best Months to Visit</strong>'
					}]
				]
			],
			[
				'core/group',
				{
					
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
						content: 'Best Months to Visit'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});