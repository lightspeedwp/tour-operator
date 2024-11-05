wp.domReady( function() {


	// DESTINATION - COUNTRY - REGION
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/regions',
		title: 'Regions',
		description: 'Display any regions attached to this destination.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Regions'
			},
			className: "lsx-regions-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
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
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Regions' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
					metadata: {
						name: 'Regions Query'
					},
					query: {
						perPage: 8,
						postType: 'destination',
						order: 'asc',
						orderBy: 'date'
					},
					align: 'wide'
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-regions-query",
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
			]]
		]
	});
	// DESTINATION - REGION - RELATED REGIONS

	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/related-regions',
		title: 'Related Regions',
		description: 'Display any regions from the parent country.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Regions'
			},
			className: "lsx-related-regions-query-wrapper",
			align: 'full',
			style: {
				spacing: {
					padding: {
						top: 'var:preset|spacing|medium',
						bottom: 'var:preset|spacing|medium',
						left: 'var:preset|spacing|x-small',
						right: 'var:preset|spacing|x-small'
					},
					blockGap: 'var:preset|spacing|small'
				}
			},
			backgroundColor: 'primary-200',
			layout: {
				type: 'constrained'
			}
		},
		innerBlocks: [
			[ 'core/group', { align: 'wide', layout: { type: 'constrained' } }, [
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
				}, [
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ],
					[ 'core/heading', { textAlign: 'center', content: 'Related Regions' } ],
					[ 'core/separator', { style: { layout: { selfStretch: 'fill', flexSize: null } }, backgroundColor: 'primary' } ]
				] ],
				[ 'core/query', {
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
				}, [
					[ 
						'core/post-template', 
						{
							className: "lsx-related-regions-query",
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
			]]
		]
	});
});
