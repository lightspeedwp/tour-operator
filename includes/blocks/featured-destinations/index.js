wp.domReady(() => {

wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/featured-destinations',
		title: 'Featured Destinations',
		icon: 'admin-site',
		description: 'Displays Destinations with Featured tag.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Featured Destinations'
			},
			className: 'lsx-featured-destinations-query-wrapper',
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
					[ 'core/heading', { textAlign: 'center', content: 'Featured Destinations' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } } } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query', {
							metadata: {
								name: 'Featured Destination Query'
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
									className: 'lsx-featured-destinations-query',
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