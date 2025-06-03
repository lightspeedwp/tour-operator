wp.domReady(() => {

wp.blocks.registerBlockVariation('core/group', {
		name: 'lsx-tour-operator/wetu-map',
		title: 'WETU Map',
		icon: 'admin-site-alt',
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
			style: {
				spacing: {
					margin: {
						top: 0,
						bottom: 0
					},
					padding: {
						top: "var:preset|spacing|medium",
						bottom: "var:preset|spacing|medium",
						left: 0,
						right: 0
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