wp.domReady(() => {

wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/tour-related-tour',
		title: 'Related Tours - Tour',
		icon: 'palmtree',
		description: 'Displays tours related to this Tour via the destinations.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Tours - Tour'
			},
			className: 'lsx-tour-related-tour-query-wrapper',
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
					[ 'core/heading', { textAlign: 'center', content: 'Related Tours' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				]
			],
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } },
				[
					[ 'core/query', {
							metadata: {
								name: 'Related Tours Query'
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
									className: 'lsx-tour-related-tour-query',
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