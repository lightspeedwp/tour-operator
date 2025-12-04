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

    // Register the custom attributes for the paragraph block
    wp.hooks.addFilter(
        'blocks.registerBlockType',
        'lsx-tour-operator/paragraph-prefix-attributes',
        function ( settings, name ) {
            if ( name === 'core/paragraph' ) {
                settings.attributes = {
                    ...settings.attributes,
                    prefixText: {
                        type: 'string',
                        default: '',
                    },
                    prefixBold: {
                        type: 'boolean',
                        default: false,
                    },
                };
            }
            return settings;
        }
    );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);