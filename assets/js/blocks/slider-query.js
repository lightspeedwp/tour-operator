(function (blocks, element, editor, components) {
	var el = element.createElement;
	var InspectorControls = editor.InspectorControls;
	var PanelBody = components.PanelBody;
	var CheckboxControl = components.CheckboxControl;

	var withInspectorControls = wp.compose.createHigherOrderComponent(function (BlockEdit) {
		return function (props) {
			if (props.name !== 'core/query') {
				return el(BlockEdit, props);
			}

			var hasCustomClass = props.attributes.hasCustomClass || false;
			var filterByOnsale = props.attributes.filterByOnsale || false;

			return el(
				element.Fragment,
				{},
				el(BlockEdit, props),
				el(InspectorControls, {},
					el(PanelBody, { title: 'Tour Operator', initialOpen: true },
						el(CheckboxControl, {
							label: 'Enable Slider',
							checked: hasCustomClass,
							onChange: function (value) {
								props.setAttributes({
									hasCustomClass: value
								});
							}
						}),
						el(CheckboxControl, {
							label: 'Filter by Onsale',
							checked: filterByOnsale,
							onChange: function (value) {
								props.setAttributes({
									filterByOnsale: value
								});
							}
						})
					)
				)
			);
		};
	}, 'withInspectorControls');

	wp.hooks.addFilter(
		'editor.BlockEdit',
		'lsx-tour-operator/settings-panel',
		withInspectorControls
	);

	wp.hooks.addFilter(
		'blocks.getSaveContent.extraProps',
		'lsx-tour-operator/save-settings-panel',
		function (extraProps, blockType, attributes) {
			if ( blockType.name === 'core/query' ) {

				if (attributes.hasCustomClass) {
					extraProps.className = (extraProps.className || '') + ' lsx-to-slider';
				}

				if (attributes.filterByOnsale) {
					extraProps.className = (extraProps.className || '') + ' on-sale';
				}

			}
			return extraProps;
		}
	);

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
