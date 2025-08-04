wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/transport',
		title: 'Transport',
		icon: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><g clip-path="url(#clip0_10050_75123)"><path d="M4.59453 5.33437L3.66328 8H7.50391V5H5.06953C4.85703 5 4.66641 5.13437 4.59766 5.33437H4.59453ZM1.51953 8.05937L2.70391 4.675C3.05703 3.67188 4.00391 3 5.06641 3H11.2508C12.0383 3 12.7789 3.37187 13.2508 4L16.257 8.00937C18.3477 8.14062 20.0008 9.87813 20.0008 12V12.5C20.0008 13.6031 19.1039 14.5 18.0008 14.5H17.4883C17.3633 15.9031 16.1852 17 14.7508 17C13.3164 17 12.1383 15.9031 12.0133 14.5H7.49141C7.36641 15.9031 6.18828 17 4.75391 17C3.31953 17 2.14141 15.9031 2.01641 14.5H2.00391C0.900781 14.5 0.00390625 13.6031 0.00390625 12.5V10C0.00390625 9.05937 0.650781 8.27187 1.52266 8.05937H1.51953ZM13.7508 8L11.6508 5.2C11.557 5.075 11.407 5 11.2508 5H9.00078V8H13.7508ZM4.75078 15.5C5.44141 15.5 6.00078 14.9406 6.00078 14.25C6.00078 13.5594 5.44141 13 4.75078 13C4.06016 13 3.50078 13.5594 3.50078 14.25C3.50078 14.9406 4.06016 15.5 4.75078 15.5ZM16.0008 14.25C16.0008 13.5594 15.4414 13 14.7508 13C14.0602 13 13.5008 13.5594 13.5008 14.25C13.5008 14.9406 14.0602 15.5 14.7508 15.5C15.4414 15.5 16.0008 14.9406 16.0008 14.25Z" fill="currentColor"/></g><defs><clipPath id="clip0_10050_75123"><rect width="20" height="20" fill="currentColor"/></clipPath></defs></svg>`,
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Transport',
			},
			className: 'lsx-transport-wrapper',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			['core/group', {
					layout: {
						type: 'constrained'
					}
				},
				[
					['core/group', {
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								align: 'center',
								content: '<strong>Transport</strong>'
							}]
						]
					],
					['core/group', {
							
							layout: {
								type: 'constrained'
							}
						},
						[
							['core/paragraph', {
								
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
						width: 100,
						content: 'View More'
					}]
				]
			]
		],
		supports: {
			renaming: false
		}
	});

});