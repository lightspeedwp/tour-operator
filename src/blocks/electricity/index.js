wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/electricity',
		title: 'Electricity',
		icon: "admin-plugins",
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Electricity',
			},
			className: 'lsx-electricity-wrapper',
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
								content: '<strong>Electricity</strong>'
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