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

                // Clean up on-sale class and attribute when post type changes from tour to something else
                const currentPostType = props.attributes.query && props.attributes.query.postType;
                const previousPostType = wp.element.useRef( currentPostType );
                
                wp.element.useEffect( () => {
                    if ( previousPostType.current === 'tour' && currentPostType !== 'tour' ) {
                        // Post type changed from tour to something else, clear on-sale
                        const hasOnSale = props.attributes.filterByOnsale || 
                            ( props.attributes.className && props.attributes.className.includes( 'on-sale' ) );
                        
                        if ( hasOnSale ) {
                            const newAttributes = { filterByOnsale: false };
                            let className = props.attributes.className || '';
                            className = className.replace( /\bon-sale\b\s*/g, '' ).trim();
                            if ( className ) {
                                newAttributes.className = className;
                            }
                            props.setAttributes( newAttributes );
                        }
                    }
                    previousPostType.current = currentPostType;
                }, [ currentPostType ] );

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

                let customOrder = props.attributes.customOrder || false;
                if ( undefined === props.attributes.customOrder ) {
                    if (
                        props.attributes.className &&
                        props.attributes.className.includes( 'custom-order' )
                    ) {
                        customOrder = true;
                    }
                } else {
                    customOrder = props.attributes.customOrder;
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
                                    props.setAttributes( {
                                        hasCustomClass: value,
                                    } );
                                },
                            } ),
                            // Only show Filter by On Sale for tour post type
                            props.attributes.query && props.attributes.query.postType === 'tour' && el( CheckboxControl, {
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
                                            className = [ className.trim(), 'on-sale' ].filter( Boolean ).join( ' ' );
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
                            } ),
                            el( CheckboxControl, {
                                label: 'Custom Order',
                                checked: customOrder,
                                help: 'Preserve the order from connected posts (e.g., tours ordered in destination multiselect field)',
                                onChange( value ) {
                                    props.setAttributes( {
                                        customOrder: value,
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
                } else if (
                    false === attributes.hasCustomClass &&
                    extraProps.className
                ) {
                    extraProps.className = extraProps.className
                        .replace( /\blsx-to-slider\b\s*/g, '' )
                        .trim();
                }

                if ( true === attributes.parentsOnly ) {
                    extraProps.className =
                        ( extraProps.className || '' ) + ' parents-only';
                } else if (
                    false === attributes.parentsOnly &&
                    extraProps.className
                ) {
                    extraProps.className = extraProps.className
                        .replace( /\bparents-only\b\s*/g, '' )
                        .trim();
                }

                if ( true === attributes.customOrder ) {
                    if (
                        ! /\bcustom-order\b/.test(
                            extraProps.className || ''
                        )
                    ) {
                        extraProps.className =
                            ( extraProps.className || '' ) + ' custom-order';
                    }
                } else if (
                    false === attributes.customOrder &&
                    extraProps.className
                ) {
                    extraProps.className = extraProps.className
                        .replace( /\bcustom-order\b\s*/g, '' )
                        .trim();
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
