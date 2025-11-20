/**
 * Accommodation Related Destination Block Variation
 *
 * Registers a block variation for displaying accommodations related to destination.
 * Only available on destination post types and destination, country, and region template screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';
import { __ } from '@wordpress/i18n';

/**
 * Register the accommodation related destination block variation
 */
function registerAccommodationRelatedDestinationVariation() {
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/accommodation-related-destination',
		title: __('Related Accommodations', 'tour-operator'),
		icon: 'admin-multisite',
		description: __('Displays accommodation related to this destination.', 'tour-operator'),
		category: 'lsx-tour-operator',
		keywords: [
			__('accommodations', 'tour-operator'),
			__('related', 'tour-operator'),
			__('similar', 'tour-operator'),
		],
		attributes: {
			metadata: {
				name: __('Related Accommodations', 'tour-operator'),
			},
			className: 'lsx-accommodation-related-destination-query-wrapper',
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
										'lsx-accommodation-related-destination-query',
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
		example: {
			innerBlocks: [
				{
					name: 'core/group',
					attributes: {
						align: 'wide',
						layout: { type: 'flex', flexWrap: 'nowrap' },
					},
					innerBlocks: [
						{
							name: 'core/separator',
							attributes: {
								style: {
									layout: { selfStretch: 'fill', flexSize: null },
								},
							},
						},
						{
							name: 'core/heading',
							attributes: {
								textAlign: 'center',
								content: __('Related Accommodations', 'tour-operator'),
								level: 2,
							},
						},
						{
							name: 'core/separator',
							attributes: {
								style: {
									layout: { selfStretch: 'fill', flexSize: null },
								},
							},
						},
					],
				},
				{
					name: 'core/group',
					attributes: {
						align: 'wide',
						layout: { type: 'constrained' },
					},
					innerBlocks: [
						{
							name: 'core/group',
							attributes: {
								className: 'lsx-accommodation-related-destination-query',
								layout: {
									type: 'grid',
									columnCount: 3,
								},
							},
							innerBlocks: [
								{
									name: 'core/group',
									attributes: {
										className: 'is-style-shadow-sm',
										style: {
											spacing: { blockGap: '0px', padding: { top: '0px', bottom: '0px', left: '0px', right: '0px' } },
											border: { radius: '8px' },
										},
										backgroundColor: 'base',
										layout: { type: 'constrained' },
									},
									innerBlocks: [
										{
											name: 'core/group',
											attributes: {
												style: {
													spacing: { padding: { top: '5px', bottom: '0px', left: '5px', right: '5px' } },
												},
												layout: { type: 'constrained' },
											},
											innerBlocks: [
												{
													name: 'core/heading',
													attributes: {
														textAlign: 'center',
														content: __('Serengeti Safari Lodge', 'tour-operator'),
														level: 3,
														fontSize: 'small',
														style: {
															spacing: { margin: { top: '0', bottom: '0' } },
														},
													},
												},
												{
													name: 'core/group',
													attributes: {
														style: {
															spacing: { padding: { top: '5px', bottom: '10px', left: '5px', right: '5px' }, blockGap: '2px' },
															border: { top: { width: '2px' }, bottom: { width: '2px' } },
														},
														layout: { type: 'constrained' },
													},
													innerBlocks: [
														{
															name: 'core/paragraph',
															attributes: {
																content: '<strong>' + __('From: $450/night', 'tour-operator') + '</strong>',
																className: 'amount price',
															},
														},
														{
															name: 'core/paragraph',
															attributes: {
																content: '<strong>' + __('Rating: 5 stars', 'tour-operator') + '</strong>',
															},
														},
													],
												},
												{
													name: 'core/paragraph',
													attributes: {
														content: __('Experience luxury in the heart of the Serengeti. Our lodge offers stunning views of the African wilderness with world-class amenities and service.', 'tour-operator'),
														style: {
															spacing: { padding: { left: '5px', right: '5px' } },
														},
													},
												},
											],
										},
									],
								},
								{
									name: 'core/group',
									attributes: {
										className: 'is-style-shadow-sm',
										style: {
											spacing: { blockGap: '0px', padding: { top: '0px', bottom: '0px', left: '0px', right: '0px' } },
											border: { radius: '8px' },
										},
										backgroundColor: 'base',
										layout: { type: 'constrained' },
									},
									innerBlocks: [
										{
											name: 'core/group',
											attributes: {
												style: {
													spacing: { padding: { top: '5px', bottom: '0px', left: '5px', right: '5px' } },
												},
												layout: { type: 'constrained' },
											},
											innerBlocks: [
												{
													name: 'core/heading',
													attributes: {
														textAlign: 'center',
														content: __('Kilimanjaro View Hotel', 'tour-operator'),
														level: 3,
														fontSize: 'small',
														style: {
															spacing: { margin: { top: '0', bottom: '0' } },
														},
													},
												},
												{
													name: 'core/group',
													attributes: {
														style: {
															spacing: { padding: { top: '5px', bottom: '10px', left: '5px', right: '5px' }, blockGap: '2px' },
															border: { top: { width: '2px' }, bottom: { width: '2px' } },
														},
														layout: { type: 'constrained' },
													},
													innerBlocks: [
														{
															name: 'core/paragraph',
															attributes: {
																content: '<strong>' + __('From: $280/night', 'tour-operator') + '</strong>',
																className: 'amount price',
															},
														},
														{
															name: 'core/paragraph',
															attributes: {
																content: '<strong>' + __('Rating: 4 stars', 'tour-operator') + '</strong>',
															},
														},
													],
												},
												{
													name: 'core/paragraph',
													attributes: {
														content: __('Comfortable accommodation with breathtaking views of Mount Kilimanjaro. Perfect base for trekking adventures and exploring the region.', 'tour-operator'),
														style: {
															spacing: { padding: { left: '5px', right: '5px' } },
														},
													},
												},
											],
										},
									],
								},
								{
									name: 'core/group',
									attributes: {
										className: 'is-style-shadow-sm',
										style: {
											spacing: { blockGap: '0px', padding: { top: '0px', bottom: '0px', left: '0px', right: '0px' } },
											border: { radius: '8px' },
										},
										backgroundColor: 'base',
										layout: { type: 'constrained' },
									},
									innerBlocks: [
										{
											name: 'core/group',
											attributes: {
												style: {
													spacing: { padding: { top: '5px', bottom: '0px', left: '5px', right: '5px' } },
												},
												layout: { type: 'constrained' },
											},
											innerBlocks: [
												{
													name: 'core/heading',
													attributes: {
														textAlign: 'center',
														content: __('Zanzibar Beach Resort', 'tour-operator'),
														level: 3,
														fontSize: 'small',
														style: {
															spacing: { margin: { top: '0', bottom: '0' } },
														},
													},
												},
												{
													name: 'core/group',
													attributes: {
														style: {
															spacing: { padding: { top: '5px', bottom: '10px', left: '5px', right: '5px' }, blockGap: '2px' },
															border: { top: { width: '2px' }, bottom: { width: '2px' } },
														},
														layout: { type: 'constrained' },
													},
													innerBlocks: [
														{
															name: 'core/paragraph',
															attributes: {
																content: '<strong>' + __('From: $320/night', 'tour-operator') + '</strong>',
																className: 'amount price',
															},
														},
														{
															name: 'core/paragraph',
															attributes: {
																content: '<strong>' + __('Rating: 4.5 stars', 'tour-operator') + '</strong>',
															},
														},
													],
												},
												{
													name: 'core/paragraph',
													attributes: {
														content: __('Beachfront resort on the pristine shores of Zanzibar. Enjoy crystal clear waters, white sand beaches, and authentic Swahili culture.', 'tour-operator'),
														style: {
															spacing: { padding: { left: '5px', right: '5px' } },
														},
													},
												},
											],
										},
									],
								},
							],
						},
					],
				},
			],
		},
		isActive: (blockAttributes) => {
			return (
				blockAttributes.className === 'lsx-accommodation-related-destination-query-wrapper' ||
				(blockAttributes.className &&
					blockAttributes.className.includes('lsx-accommodation-related-destination-query-wrapper'))
			);
		},
	});
}

// Register conditionally for destination post types and destination templates
const conditionalRegister = registerForPostTypesAndTemplates(
	['destination'],
	['destination', 'country', 'region'],
	registerAccommodationRelatedDestinationVariation
);

wp.domReady(conditionalRegister);
