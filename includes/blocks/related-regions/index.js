wp.domReady(() => {

wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/related-regions',
		title: 'Related Regions',
		icon: 'admin-site-alt3',
		description: 'Display any regions from the parent country.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Regions'
			},
			className: 'lsx-related-regions-query-wrapper',
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
					[ 'core/heading', { textAlign: 'center', content: 'Related Regions' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query',
						{
							metadata: {
								name: 'Related Regions Query'
							},
							query: {
								perPage: 8,
								postType: 'destination',
								order: 'asc',
								orderBy: 'date'
							},
							align: 'wide'
						},
						[
							[ 
								'core/post-template', 
								{
									className: 'lsx-related-regions-query',
									layout: {
										type: 'grid',
										columnCount: 4
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
		]
	});

});