wp.domReady(() => {
	const { __ } = wp.i18n;
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/accommodation-related-tour',
		title: __( 'Related accommodation - tour', 'tour-operator' ),
		icon: 'palmtree',
		description: __( 'Displays accommodation related to this tour via the destinations.', 'tour-operator' ),
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: __( 'Related accommodation - tour', 'tour-operator' ),
			},
			className: 'lsx-accommodation-related-tour-query-wrapper',
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
							content: __( 'Related accommodation', 'tour-operator' ),
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
								name: __( 'Related accommodation query', 'tour-operator' ),
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
									className:
										'lsx-accommodation-related-tour-query',
									layout: {
										type: 'grid',
										columnCount: 3,
									},
								},
								[
									[
										'core/pattern',
										{
											slug: 'lsx-tour-operator/destination-card',
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
					name: __( 'Related tours', 'tour-operator' ),
				},
			},
			innerBlocks: [
				[
					'core/group',
					{},
					[
						[
							'core/heading',
							{
								content: __( 'Related tours', 'tour-operator' ),
								textAlign: 'center',
							},
						],
						[
							'core/group',
							{
								style: {
									spacing: {
										blockGap: '2rem',
									},
								},
								layout: {
									type: 'grid',
									columnCount: 3,
								},
							},
							[
								[
									'core/group',
									{
										style: {
											border: {
												width: '1px',
												style: 'solid',
												color: '#e0e0e0',
											},
											spacing: {
												padding: '1rem',
											},
										},
									},
									[
										['core/heading', { content: __( 'African Safari Adventure', 'tour-operator' ), level: 3 }],
										['core/paragraph', { content: __( "Embark on an unforgettable 7-day safari experience through Kenya's most spectacular wildlife reserves.", 'tour-operator' ) }],
									],
								],
								[
									'core/group',
									{
										style: {
											border: {
												width: '1px',
												style: 'solid',
												color: '#e0e0e0',
											},
											spacing: {
												padding: '1rem',
											},
										},
									},
									[
										['core/heading', { content: __( 'European Cultural Journey', 'tour-operator' ), level: 3 }],
										['core/paragraph', { content: __( 'Discover the rich history and culture of Europe with visits to iconic cities and historic landmarks.', 'tour-operator' ) }],
									],
								],
								[
									'core/group',
									{
										style: {
											border: {
												width: '1px',
												style: 'solid',
												color: '#e0e0e0',
											},
											spacing: {
												padding: '1rem',
											},
										},
									},
									[
										['core/heading', { content: __( 'Tropical Island Escape', 'tour-operator' ), level: 3 }],
										['core/paragraph', { content: __( 'Relax and unwind on pristine beaches with crystal clear waters and vibrant coral reefs.', 'tour-operator' ) }],
									],
								],
							],
						],
					],
				],
			],
		},
	});
});
