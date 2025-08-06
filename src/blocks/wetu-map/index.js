wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/wetu-map',
		title: 'WETU Map',
		icon: 'admin-site-alt3',
		category: 'lsx-tour-operator',
		attributes: {
			metadata: {
				name: 'WETU Map',
				bindings: {
					content: {
						source: 'lsx/map',
						type: 'wetu'
					}
				}
			},
			layout: {
				type: "constrained"
			}
		},
		innerBlocks: [
			[
				"core/group",
				{
					align: "wide",
					layout:{
						type:"default"
					}
				},
				[
					[
						"core/image",
						{
							align: "full",
							sizeSlug: "large",
							url: lsxToEditor.assetsUrl + "blocks/wetu-map-figme-prototype-image.png",
							alt: "",
						}
					]
				]
			]
		],
		isDefault: false,
		allowedPostTypes: ['tour'],
		supports: {
			renaming: false
		}
	});

});