wp.domReady(() => {

wp.blocks.registerBlockVariation("core/group", {
		name: "lsx-tour-operator/price",
		title: "Price",
		category: 'lsx-tour-operator',
		icon: 'money-alt',
		attributes: {
			metadata: {
				name: "Price",
			},
			align: "wide",
			layout: {
				type: "flex",
				flexWrap: "nowrap",
			},
			className: 'lsx-price-wrapper'
		},
		innerBlocks: [
			[
				"core/paragraph",
				{
					content: "<strong>From:</strong>",
				},
			],
			[
				"core/paragraph",
				{
					metadata: {
						bindings: {
							content: {
								source: "lsx/post-meta",
								args: {
									key: "price"
								},
							},
						},
					},
					className: 'amount'
				},
			],
		],
		isDefault: false,
		supports: {
			renaming: false
		}
	});

});