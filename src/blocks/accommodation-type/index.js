/**
 * Accommodation Type Block Variation
 *
 * Registers a block variation for displaying accommodation type taxonomy information.
 * Only available on accommodation post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
	const registerAccommodationTypeVariation = () => {
		wp.blocks.registerBlockVariation("core/group", {
			name: "lsx-tour-operator/accommodation-type",
			title: __("Accommodation type", "tour-operator"),
			icon: "admin-multisite",
			category: "lsx-tour-operator",
			description: __("Displays the accommodation type(s).", "tour-operator"),
			keywords: [
				__("accommodation", "tour-operator"),
				__("type", "tour-operator"),
			],
			isActive: (blockAttributes, variationAttributes) => {
				return blockAttributes.className === variationAttributes.className;
			},
			attributes: {
				metadata: {
					name: __("Accommodation type", "tour-operator"),
				},
				className: "lsx-accommodation-type-wrapper",
				layout: {
					type: "flex",
					flexWrap: "nowrap",
					verticalAlignment: 'top'
				},
			},
			innerBlocks: [
				[
					"core/group",
					{
						layout: {
							type: "flex",
							flexWrap: "nowrap",
							verticalAlignment: "middle",
						},
					},
					[
						[
							"lsx-tour-operator/icons",
							{
								iconType: "solid",
								iconName: "accommodationTypeIcon",
							},
						]
					],
				],
				[
					"core/group",
					{
						layout: {
							type: "flex",
							flexWrap: "nowrap",
						},
					},
					[
						[
							"core/post-terms",
							{
								term: "accommodation-type",
								prefix: '<strong>' + __('Accommodation Type: ', 'tour-operator') + '</strong>'
							},
						],
					],
				],
			],
			example: {
				innerBlocks: [
					{
						name: 'core/group',
						attributes: {
							layout: {
								type: 'flex',
								flexWrap: 'nowrap',
							},
						},
						innerBlocks: [
							{
								name: 'core/group',
								attributes: {
									layout: {
										type: 'flex',
										flexWrap: 'nowrap',
										verticalAlignment: 'middle',
									},
								},
								innerBlocks: [
									{
										name: 'lsx-tour-operator/icons',
										attributes: {
											iconType: 'solid',
											iconName: 'accommodationTypeIcon',
										},
									},
									{
										name: 'core/paragraph',
										attributes: {
											content: '<strong>' + __('Accommodation Type: ', 'tour-operator') + '</strong>' + ' ' + __('Hotel', 'tour-operator'),
										},
									},
								],
							},
						],
					},
				],
			},
		});
	}

	// Initialize conditional registration
	const conditionalRegister = registerForPostTypesAndTemplates(
		['accommodation'], // Supported post types
		['accommodation'], // Template slug patterns
		registerAccommodationTypeVariation
	);

	conditionalRegister();
});
