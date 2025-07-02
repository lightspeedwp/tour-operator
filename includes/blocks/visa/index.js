wp.domReady(() => {

wp.blocks.registerBlockVariation(
		'core/group', {
			name: 'lsx-tour-operator/visa',
			title: 'Visa',
			icon: "id-alt",
			category: 'lsx-tour-operator',
			attributes: {
				metadata: {
					name: 'Visa',
				},
				className: 'lsx-visa-wrapper',
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
									content: '<strong>Visa</strong>'
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
													key: 'visa'
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
		}
	);

});