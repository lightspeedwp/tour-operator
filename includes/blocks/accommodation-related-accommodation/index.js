wp.domReady(() => {

wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/accommodation-related-accommodation',
		title: 'Related Accommodation - Accommodation',
		icon: 'admin-home',
		description: 'Displays other accommodation in the area.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Accommodation - Accommodation'
			},
			className: 'lsx-accommodation-related-accommodation-query-wrapper',
			align: 'full',
			
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', {
					align: 'wide',
					style: {
						spacing: {
							margin: { top: '0', bottom: '0' },
							padding: { top: '0', bottom: 'var:preset|spacing|small', left: '0', right: '0' },
							blockGap: 'var:preset|spacing|small'
						}
					},
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Accommodation' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query', {
							metadata: {
								name: 'Related Accommodation Query'
							},
							query: {
								perPage: 8,
								postType: 'accommodation',
								order: 'asc',
								orderBy: 'date'
							},
							align: 'wide'
						},
						[
							[ 
								'core/post-template', 
								{
									className: 'lsx-accommodation-related-accommodation-query',
									layout: {
										type: 'grid',
										columnCount: 3
									}
								},
								[
									[ 'core/pattern', { slug: 'lsx-tour-operator/destination-card' } ]
								]
							]
						]
					]
				]
			]
		],
		supports: {
			renaming: false
		},
		isActive: ( blockAttributes, variationAttributes ) => {
			console.log('test this one');
			return (
				blockAttributes.className === "lsx-accommodation-related-accommodation-query-wrapper" ||
				(blockAttributes.className && blockAttributes.className.includes("lsx-accommodation-related-accommodation-query-wrapper"))
			);
		}
	});

});