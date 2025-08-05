wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/health',
		title: 'Health',
		icon: wp.element.createElement(
			"svg",
			{ xmlns: "http://www.w3.org/2000/svg", width: 20, height: 20, viewBox: "0 0 20 20", fill: "none" },
			wp.element.createElement("path", {
				d: "M8.03125 2.8H11.9688C12.1234 2.8 12.25 2.935 12.25 3.1V4.6H7.75V3.1C7.75 2.935 7.87656 2.8 8.03125 2.8ZM6.0625 3.1V4.6H3.25C2.00898 4.6 1 5.67625 1 7V16.6C1 17.9237 2.00898 19 3.25 19H16.75C17.991 19 19 17.9237 19 16.6V7C19 5.67625 17.991 4.6 16.75 4.6H13.9375V3.1C13.9375 1.94125 13.0551 1 11.9688 1H8.03125C6.94492 1 6.0625 1.94125 6.0625 3.1ZM8.875 9.1C8.875 8.77 9.12813 8.5 9.4375 8.5H10.5625C10.8719 8.5 11.125 8.77 11.125 9.1V10.6H12.5312C12.8406 10.6 13.0938 10.87 13.0938 11.2V12.4C13.0938 12.73 12.8406 13 12.5312 13H11.125V14.5C11.125 14.83 10.8719 15.1 10.5625 15.1H9.4375C9.12813 15.1 8.875 14.83 8.875 14.5V13H7.46875C7.15938 13 6.90625 12.73 6.90625 12.4V11.2C6.90625 10.87 7.15938 10.6 7.46875 10.6H8.875V9.1Z",
				fill: "#currentColor"
			})
		),
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Health',
			},
			className: 'lsx-health-wrapper',
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
								content: '<strong>Health</strong>'
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