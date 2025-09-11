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
							'core/group',
							{
								style: {
									spacing: {
										blockGap: '2rem'
									}
								},
								layout: {
									type: 'grid',
									columnCount: 3
								}
							},
							[
								[
									'core/group',
									{
										style: {
											border: {
												width: '1px',
												style: 'solid',
												color: '#e0e0e0'
											},
											spacing: {
												padding: '1rem'
											}
										}
									},
									[
										[ 'core/heading', { content: 'Luxury Beach Resort', level: 3 } ],
										[ 'core/paragraph', { content: 'Experience ultimate comfort at our beachfront resort with stunning ocean views and world-class amenities.' } ]
									]
								],
								[
									'core/group',
									{
										style: {
											border: {
												width: '1px',
												style: 'solid',
												color: '#e0e0e0'
											},
											spacing: {
												padding: '1rem'
											}
										}
									},
									[
										[ 'core/heading', { content: 'Mountain Lodge', level: 3 } ],
										[ 'core/paragraph', { content: 'Cozy mountain retreat perfect for nature lovers seeking tranquility and adventure in the wilderness.' } ]
									]
								],
								[
									'core/group',
									{
										style: {
											border: {
												width: '1px',
												style: 'solid',
												color: '#e0e0e0'
											},
											spacing: {
												padding: '1rem'
											}
										}
									},
									[
										[ 'core/heading', { content: 'City Center Hotel', level: 3 } ],
										[ 'core/paragraph', { content: 'Modern urban accommodation in the heart of the city with easy access to attractions and dining.' } ]
									]
								]
							]
						],
					],
				],
			],
		},
		isActive: ( blockAttributes ) => {
			return (
				blockAttributes.className === 'lsx-accommodation-related-accommodation-query-wrapper' ||
				( blockAttributes.className &&
					blockAttributes.className.includes( 'lsx-accommodation-related-accommodation-query-wrapper' ) )
			);
		},
	} );
} );
