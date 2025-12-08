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

                // Only show prefix controls for paragraphs with bindings
                const hasBindings = props.attributes.metadata &&
                                  props.attributes.metadata.bindings &&
                                  props.attributes.metadata.bindings.content;

                if ( ! hasBindings ) {
                    return el( BlockEdit, props );
                }

                let prefix = props.attributes.prefix || '';
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
                            { title: 'Tour Operator', initialOpen: true },
                            el( TextControl, {
                                label: 'Prefix Text',
                                value: prefix,
                                onChange( value ) {
                                    props.setAttributes( {
                                        prefix: value,
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
                    prefix: {
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

    // Add visual prefix display in the editor using CSS
    const withPrefixDisplay = wp.compose.createHigherOrderComponent(
        function ( BlockListBlock ) {
            return function ( props ) {
                if ( props.name !== 'core/paragraph' ) {
                    return el( BlockListBlock, props );
                }

                const { attributes } = props;
                const prefix = attributes.prefix || '';
                const prefixBold = attributes.prefixBold || false;

                if ( ! prefix ) {
                    return el( BlockListBlock, props );
                }

                // Add a space after prefix if it doesn't end with punctuation or space
                const needsSpace = ! /[\s\p{P}]$/u.test( prefix );
                const displayPrefix = prefix + ( needsSpace ? ' ' : '' );

                // Create CSS for the pseudo-element
                const uniqueId = 'prefix-' + Math.random().toString(36).substr(2, 9);
                const css = `
                    p.${uniqueId}::before {
                        content: "${displayPrefix.replace(/"/g, '\\"')} ";
                        font-weight: ${prefixBold ? 'bold' : 'normal'};
                    }
                `;

                // Inject the style into the editor iframe
                if ( typeof document !== 'undefined' ) {
                    // Find the editor iframe (canvas)
                    const editorCanvas = document.querySelector( 'iframe[name="editor-canvas"]' );
                    const targetDoc = editorCanvas ? editorCanvas.contentDocument : document;

                    if ( targetDoc ) {
                        const existingStyle = targetDoc.getElementById( uniqueId );
                        if ( ! existingStyle ) {
                            const styleEl = targetDoc.createElement( 'style' );
                            styleEl.id = uniqueId;
                            styleEl.textContent = css;
                            targetDoc.head.appendChild( styleEl );
                        }
                    }
                }

                // Add custom wrapper props with the unique class
                const wrapperProps = {
                    ...( props.wrapperProps || {} ),
                    className: [ props.wrapperProps?.className, uniqueId ].filter(Boolean).join(' ')
                };

                return el( BlockListBlock, { ...props, wrapperProps } );
            };
        },
        'withPrefixDisplay'
    );

    wp.hooks.addFilter(
        'editor.BlockListBlock',
        'lsx-tour-operator/paragraph-prefix-display',
        withPrefixDisplay
    );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);