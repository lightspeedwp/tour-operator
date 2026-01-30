( function ( blocks, element, editor, components ) {
    const el = element.createElement;
    const InspectorControls = editor.InspectorControls;
    const PanelBody = components.PanelBody;
    const CheckboxControl = components.CheckboxControl;

    const withInspectorControls = wp.compose.createHigherOrderComponent(
        function ( BlockEdit ) {
            return function ( props ) {
                if ( props.name !== 'core/query' ) {
                    return el( BlockEdit, props );
                }

                let hasCustomClass = props.attributes.hasCustomClass || false;
                if ( undefined === props.attributes.hasCustomClass ) {
                    if (
                        props.attributes.className &&
                        props.attributes.className.includes( 'lsx-to-slider' )
                    ) {
                        hasCustomClass = true;
                    }
                } else {
                    hasCustomClass = props.attributes.hasCustomClass;
                }

                let filterByOnsale = props.attributes.filterByOnsale || false;
                if ( undefined === props.attributes.filterByOnsale ) {
                    if (
                        props.attributes.className &&
                        props.attributes.className.includes( 'on-sale' )
                    ) {
                        filterByOnsale = true;
                    }
                } else {
                    filterByOnsale = props.attributes.filterByOnsale;
                }

                let parentsOnly = props.attributes.parentsOnly || false;
                if ( undefined === props.attributes.parentsOnly ) {
                    if (
                        props.attributes.className &&
                        props.attributes.className.includes( 'parents-only' )
                    ) {
                        parentsOnly = true;
                    }
                } else {
                    parentsOnly = props.attributes.parentsOnly;
                }

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
                            el( CheckboxControl, {
                                label: 'Enable Slider',
                                checked: hasCustomClass,
                                onChange( value ) {
                                    console.log( value );
                                    props.setAttributes( {
                                        hasCustomClass: value,
                                    } );
                                },
                            } ),
                            el( CheckboxControl, {
                                label: 'Filter by On Sale',
                                checked: filterByOnsale,
                                onChange( value ) {
                                    // Update the filterByOnsale attribute
                                    const newAttributes = {
                                        filterByOnsale: value,
                                    };
                                    
                                    // Also update className attribute to include/remove 'on-sale'
                                    let className = props.attributes.className || '';
                                    if ( value ) {
                                        // Add on-sale class if not present
                                        if ( ! className.includes( 'on-sale' ) ) {
                                            className = ( className + ' on-sale' ).trim();
                                        }
                                    } else {
                                        // Remove on-sale class
                                        className = className.replace( /\bon-sale\b\s*/g, '' ).trim();
                                    }
                                    newAttributes.className = className;
                                    
                                    props.setAttributes( newAttributes );
                                },
                            } ),
                            el( CheckboxControl, {
                                label: 'Parents Only',
                                checked: parentsOnly,
                                onChange( value ) {
                                    props.setAttributes( {
                                        parentsOnly: value,
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
        'lsx-tour-operator/settings-panel',
        withInspectorControls
    );

    wp.hooks.addFilter(
        'blocks.getSaveContent.extraProps',
        'lsx-tour-operator/save-settings-panel',
        function ( extraProps, blockType, attributes ) {
            if ( blockType.name === 'core/query' ) {
                if ( true === attributes.hasCustomClass ) {
                    extraProps.className =
                        ( extraProps.className || '' ) + ' lsx-to-slider';
                    console.log( 'adding' );
                } else if (
                    false === attributes.hasCustomClass &&
                    extraProps.className
                ) {
                    extraProps.className = extraProps.className
                        .replace( /\blsx-to-slider\b\s*/g, '' )
                        .trim();
                    console.log( 'removing' );
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
