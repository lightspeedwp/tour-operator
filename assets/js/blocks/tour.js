wp.domReady(() => {

	// WETU Map Embed
	wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/wetu-map',
		title: 'WETU Map',
		icon: 'admin-site',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'WETU Map',
				bindings: {
					content: {
						source: 'lsx/map',
						type: 'wetu'
					}
				},
				style: {
					spacing: {
						margin: {
							top: 0,
							bottom: 0
						},
						padding: {
							top: 0,
							bottom: 0,
							left: 0,
							right: 0
						}
					}
				},
				layout: {
					type: "constrained"
				}
			}
		},
		innerBlocks: [
			[
				"core/image",
				{
					align: "full",
					sizeSlug: "large",
					url: "https://tour-operator.lsx.design/wp-content/uploads/2024/09/wetu-map-figme-prototype-image.png",
					alt: "",
				}
			]
		],
		isDefault: false,
		allowedPostTypes: ['tour']
	});
});
