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

            return el(
                element.Fragment,
                {},
                el(BlockEdit, props),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Slider', initialOpen: true },
                        el(CheckboxControl, {
                            label: 'Enable Slider',
                            checked: hasCustomClass,
                            onChange: function (value) {
                                props.setAttributes({
                                    hasCustomClass: value
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
        'lsx-tour-operator/slider-panel',
        withInspectorControls
    );

    wp.hooks.addFilter(
        'blocks.getSaveContent.extraProps',
        'lsx-tour-operator/save-slider-panel',
        function (extraProps, blockType, attributes) {
            if (blockType.name === 'core/query' && attributes.hasCustomClass) {
                extraProps.className = (extraProps.className || '') + ' lsx-to-slider';
            }
            return extraProps;
        }
    );

})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
