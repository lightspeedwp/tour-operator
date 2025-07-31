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
			if ( undefined === props.attributes.hasCustomClass ) {
				if ( props.attributes.className && props.attributes.className.includes( 'lsx-to-slider' ) ) {
					hasCustomClass = true;
				}
			} else {
				hasCustomClass = props.attributes.hasCustomClass;
			}

			var filterByOnsale = props.attributes.filterByOnsale || false;
			if ( undefined === props.attributes.filterByOnsale ) {
				if ( props.attributes.className && props.attributes.className.includes( 'on-sale' ) ) {
					filterByOnsale = true;
				}
			} else {
				filterByOnsale = props.attributes.filterByOnsale;
			}

			var parentsOnly = props.attributes.parentsOnly || false;
			if ( undefined === props.attributes.parentsOnly ) {
				if ( props.attributes.className && props.attributes.className.includes( 'parents-only' ) ) {
					parentsOnly = true;
				}
			} else {
				parentsOnly = props.attributes.parentsOnly;
			}

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
								console.log(value);
								props.setAttributes({
									hasCustomClass: value
								});
							}
						}),
						el(CheckboxControl, {
							label: 'Filter by On Sale',
							checked: filterByOnsale,
							onChange: function (value) {
								props.setAttributes({
									filterByOnsale: value
								});
							}
						}),
						el(CheckboxControl, {
							label: 'Parents Only',
							checked: parentsOnly,
							onChange: function (value) {
								props.setAttributes({
									parentsOnly: value
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

				if (  true === attributes.hasCustomClass ) {
					extraProps.className = (extraProps.className || '') + ' lsx-to-slider';
					console.log('adding');
				} else if ( false === attributes.hasCustomClass && extraProps.className ) {
					extraProps.className = extraProps.className.replace(/\blsx-to-slider\b\s*/g, '').trim();
					console.log('removing');
				}

				if ( true === attributes.filterByOnsale ) {
					extraProps.className = (extraProps.className || '') + ' on-sale';
				} else if ( false === attributes.filterByOnsale && extraProps.className ) {
					extraProps.className = extraProps.className.replace(/\bon-sale\b\s*/g, '').trim();
				}

				if ( true === attributes.parentsOnly ) {
					extraProps.className = (extraProps.className || '') + ' parents-only';
				} else if ( false === attributes.parentsOnly && extraProps.className ) {
					extraProps.className = extraProps.className.replace(/\bparents-only\b\s*/g, '').trim();
				}

			}
			return extraProps;
		}
	);

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
