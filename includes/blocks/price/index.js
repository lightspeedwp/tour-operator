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
			className: 'lsx-price-wrapper',
			style: {
				spacing: {
					blockGap: "5px",
				},
			},
		},
		innerBlocks: [
			[
				"core/paragraph",
				{
					padding: {
						top: "2px",
						bottom: "2px",
					},
					typography: {
						fontSize: "x-small",
					},
					content: "<strong>From:</strong>",
					className: 'has-x-small-font-size'
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
					className: 'amount',
					padding: {
						top: "2px",
						bottom: "2px",
					},
					color: {
						link: "primary-700",
						text: "primary-700",
					},
				},
			],
		],
		isDefault: false,
		supports: {
			renaming: false
		}
	});

});