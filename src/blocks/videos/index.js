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

// Add slider toggle functionality for videos block
(function (blocks, element, editor, components) {
	var el = element.createElement;
	var InspectorControls = editor.InspectorControls;
	var PanelBody = components.PanelBody;
	var CheckboxControl = components.CheckboxControl;

	var withInspectorControls = wp.compose.createHigherOrderComponent(function (BlockEdit) {
		return function (props) {
			// Only apply to core/gallery blocks that are the videos variation
			if (props.name !== 'core/gallery' || 
				!props.attributes.metadata || 
				props.attributes.metadata.name !== 'TO Videos') {
				return el(BlockEdit, props);
			}

			var hasSlider = props.attributes.hasSlider || false;
			if (undefined === props.attributes.hasSlider) {
				if (props.attributes.className && props.attributes.className.includes('lsx-to-slider')) {
					hasSlider = true;
				}
			} else {
				hasSlider = props.attributes.hasSlider;
			}

			return el(
				element.Fragment,
				{},
				el(BlockEdit, props),
				el(InspectorControls, {},
					el(PanelBody, { title: 'Tour Operator', initialOpen: true },
						el(CheckboxControl, {
							label: 'Enable Slider',
							checked: hasSlider,
							onChange: function (value) {
								props.setAttributes({
									hasSlider: value
								});
							}
						})
					)
				)
			);
		};
	}, 'withVideosInspectorControls');

	wp.hooks.addFilter(
		'editor.BlockEdit',
		'lsx-tour-operator/videos-settings-panel',
		withInspectorControls
	);

	wp.hooks.addFilter(
		'blocks.getSaveContent.extraProps',
		'lsx-tour-operator/videos-save-settings-panel',
		function (extraProps, blockType, attributes) {
			if (blockType.name === 'core/gallery' && 
				attributes.metadata && 
				attributes.metadata.name === 'TO Videos') {

				if (true === attributes.hasSlider) {
					extraProps.className = (extraProps.className || '') + ' lsx-to-slider';
				} else if (false === attributes.hasSlider && extraProps.className) {
					extraProps.className = extraProps.className.replace(/\blsx-to-slider\b\s*/g, '').trim();
				}
			}
			return extraProps;
		}
	);

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);

});