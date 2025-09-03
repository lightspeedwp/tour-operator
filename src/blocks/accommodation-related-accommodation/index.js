wp.domReady( () => {
	wp.blocks.registerBlockVariation( 'core/group', {
		name: 'lsx-tour-operator/accommodation-related-accommodation',
		title: 'Related Accommodation - Accommodation',
		icon: 'admin-multisite',
		description: 'Displays other accommodation in the area.',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'Related Accommodation - Accommodation',
			},
			className: 'lsx-accommodation-related-accommodation-query-wrapper',
			align: 'full',
			layout: {
				type: 'constrained',
			},
			tagName: 'section',
		},
		innerBlocks: [
			[
				'core/group',
				{
					align: 'wide',
					layout: { type: 'flex', flexWrap: 'nowrap' },
				},
				[
					[
						'core/separator',
						{
							style: {
								layout: { selfStretch: 'fill', flexSize: null },
							},
						},
					],
					[
						'core/heading',
						{
							textAlign: 'center',
							content: 'Related Accommodation',
						},
					],
					[
						'core/separator',
						{
							style: {
								layout: { selfStretch: 'fill', flexSize: null },
							},
						},
					],
				],
			],
			[
				'core/group',
				{ align: 'wide', layout: { type: 'constrained' } },
				[
					[
						'core/query',
						{
							metadata: {
								name: 'Related Accommodation Query',
							},
							query: {
								perPage: 8,
								postType: 'accommodation',
								order: 'asc',
								orderBy: 'date',
							},
							align: 'wide',
						},
						[
							[
								'core/post-template',
								{
									className: 'lsx-accommodation-related-accommodation-query',
									layout: {
										type: 'grid',
										columnCount: 3,
									},
								},
								[
									[
										'core/pattern',
										{
											slug: 'lsx-tour-operator/accommodation-card',
										},
									],
								],
							],
						],
					],
				],
			],
		],
		supports: {
			renaming: false,
		},

		example: {
			attributes: {
				metadata: {
					name: 'Related Accommodation',
				},
				className: 'lsx-accommodation-related-accommodation-query-wrapper',
			},
			innerBlocks: [
				[
					'core/group',
					{},
					[
						[
							'core/heading',
							{
								content: 'Related Accommodation',
								textAlign: 'center',
							},
						],
						[
							'core/query',
							{
								query: {
									postType: 'accommodation',
									perPage: 3,
								},
							},
							[ [ 'core/post-template', {}, [ [ 'core/post-title' ], [ 'core/post-excerpt' ] ] ] ],
						],
					],
				],
			],
		},
		isActive: ( blockAttributes, variationAttributes ) => {
			return (
				blockAttributes.className === 'lsx-accommodation-related-accommodation-query-wrapper' ||
				( blockAttributes.className &&
					blockAttributes.className.includes( 'lsx-accommodation-related-accommodation-query-wrapper' ) )
			);
		},
	} );
} );
