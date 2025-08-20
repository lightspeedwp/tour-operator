wp.domReady(() => {

wp.blocks.registerBlockVariation("core/gallery", {
	name: "lsx-tour-operator/videos",
	title: "TO Videos",
	icon: "video-alt3",
	category: "lsx-tour-operator",
	attributes: {
		metadata: {
			name: "TO Videos",
			bindings: {
				content: {
					source: "lsx/videos",
				}
			}
		},
		linkTo: "none",
		sizeSlug: "thumbnail"
	},
	innerBlocks: [
		[
			"core/image",
			{
				sizeSlug: 'large',
				url: lsxToEditor.assetsUrl + "blocks/placeholder.png",
				alt: "Video placeholder"
			}
		],
		[
			"core/image",
			{
				sizeSlug: 'large',
				url: lsxToEditor.assetsUrl + "blocks/placeholder.png",
				alt: "Video placeholder"
			}
		],
		[
			"core/image",
			{
				sizeSlug: 'large',
				url: lsxToEditor.assetsUrl + "blocks/placeholder.png",
				alt: "Video placeholder"
			}
		]
	],
	isDefault: false
});

});