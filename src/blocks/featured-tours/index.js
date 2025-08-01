wp.domReady(() => {

wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/featured-tours',
		title: 'Featured Tours',
		icon: 'palmtree',
		description: 'Displays Tours with the Featured tag.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Featured Tours'
			},
			className: 'lsx-featured-tours-query-wrapper',
			align: 'full',
			layout: {
				type: 'constrained'
			},
			tagName: "section"
		},
		innerBlocks: [
			[ 'core/group', {
					align: 'wide',
					layout: { type: 'flex', flexWrap: 'nowrap' }
				},
				[
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } } } ],
					[ 'core/heading', { textAlign: 'center', content: 'Featured Tours' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } } } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[			
					[ 'core/query', {
							metadata: {
								name: 'Featured Tours Query'
							},
							query: {
								perPage: 8,
								postType: 'tour',
								order: 'asc',
								orderBy: 'date'
							},
							align: 'wide'
						},
						[
							[ 
								'core/post-template', 
								{
									className: 'lsx-featured-tours-query',
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
		}
	});

});