( function ( blocks, element, editor, components ) {
    const el = element.createElement;
    const InspectorControls = editor.InspectorControls;
    const PanelBody = components.PanelBody;
    const CheckboxControl = components.CheckboxControl;
    const TextControl = components.TextControl;

    const withInspectorControls = wp.compose.createHigherOrderComponent(
        function ( BlockEdit ) {
            return function ( props ) {
                if ( props.name !== 'core/paragraph' ) {
                    return el( BlockEdit, props );
                }

                let prefixText = props.attributes.prefixText || '';
                let prefixBold = props.attributes.prefixBold || false;

                return el(
                    element.Fragment,
                    {},
                    el( BlockEdit, props ),
                    el(
                        InspectorControls,
                        {},
                        el(
                            PanelBody,
                            { title: 'Tour Operator - Prefix', initialOpen: true },
                            el( TextControl, {
                                label: 'Prefix Text',
                                value: prefixText,
                                onChange( value ) {
                                    props.setAttributes( {
                                        prefixText: value,
                                    } );
                                },
                            } ),
                            el( CheckboxControl, {
                                label: 'Bold Prefix',
                                checked: prefixBold,
                                onChange( value ) {
                                    props.setAttributes( {
                                        prefixBold: value,
                                    } );
                                },
                            } )
                        )
                    )
                );
            };
        },
        'withInspectorControls'
    );

    wp.hooks.addFilter(
        'editor.BlockEdit',
        'lsx-tour-operator/paragraph-prefix-panel',
        withInspectorControls
    );

    wp.hooks.addFilter(
        'blocks.getSaveContent.extraProps',
        'lsx-tour-operator/save-paragraph-prefix-panel',
        function ( extraProps, blockType, attributes ) {
            if ( blockType.name === 'core/paragraph' ) {
                if ( attributes.prefixText ) {
                    extraProps['data-prefix-text'] = attributes.prefixText;
                }
                if ( attributes.prefixBold ) {
                    extraProps['data-prefix-bold'] = attributes.prefixBold;
                }
            }
            return extraProps;
        }
    );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);