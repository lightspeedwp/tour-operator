/**
 * Register Accommodation Related Tour block variation
 */
import { registerForPostTypes } from '@utils/conditional-block-registration.js';

const { __ } = wp.i18n;

/**
 * Register the accommodation related tour block variation
 */
function registerAccommodationRelatedTourVariation() {
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/accommodation-related-tour',
		title: __('Related Accommodation - Tour', 'tour-operator'),
		icon: 'palmtree',
		description: __('Displays accommodations related to this tour via the destinations.', 'tour-operator'),
		category: 'lsx-tour-operator',
		keywords: [
			__('accommodation', 'tour-operator'),
			__('tour', 'tour-operator'),
			__('related', 'tour-operator'),
			__('cross-reference', 'tour-operator'),
		],
		attributes: {
			metadata: {
				name: __('Related Accommodation - Tour', 'tour-operator'),
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
							content: __('Related Accommodations', 'tour-operator'),
							level: 2,
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
								name: __('Related accommodation query', 'tour-operator'),
							},
							query: {
								perPage: 6,
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
									className: 'lsx-accommodation-related-tour-query',
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
					name: __('Related tours', 'tour-operator'),
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
								content: __('Related tours', 'tour-operator'),
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
										['core/heading', { content: __('African Safari Adventure', 'tour-operator'), level: 3 }],
										['core/paragraph', { content: __("Embark on an unforgettable 7-day safari experience through Kenya's most spectacular wildlife reserves.", 'tour-operator') }],
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
										['core/heading', { content: __('European Cultural Journey', 'tour-operator'), level: 3 }],
										['core/paragraph', { content: __('Discover the rich history and culture of Europe with visits to iconic cities and historic landmarks.', 'tour-operator') }],
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
										['core/heading', { content: __('Tropical Island Escape', 'tour-operator'), level: 3 }],
										['core/paragraph', { content: __('Relax and unwind on pristine beaches with crystal clear waters and vibrant coral reefs.', 'tour-operator') }],
									],
								],
							],
						],
					],
				],
			],
		},
	});
}

// Register conditionally for tour post types and tour templates
const conditionalRegister = registerForPostTypes(
	['tour'],
	registerAccommodationRelatedTourVariation
);

wp.domReady(conditionalRegister);
