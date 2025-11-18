import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/gallery', {
        name: 'lsx-tour-operator/videos',
        title: __('TO Videos', 'tour-operator'),
        icon: 'video-alt3',
        category: 'lsx-tour-operator',
        description: __('Display a gallery of videos related to the tour or destination.', 'tour-operator'),
        attributes: {
            metadata: {
                name: 'TO Videos',
                bindings: {
                    content: {
                        source: 'lsx/videos',
                    },
                },
            },
            linkTo: 'none',
            sizeSlug: 'thumbnail',
        },
        innerBlocks: [
            [
                'core/image',
                {
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/placeholder.png',
                    alt: __('Video placeholder', 'tour-operator'),
                },
            ],
            [
                'core/image',
                {
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/placeholder.png',
                    alt: __('Video placeholder', 'tour-operator'),
                },
            ],
            [
                'core/image',
                {
                    sizeSlug: 'large',
                    url: lsxToEditor.assetsUrl + 'blocks/placeholder.png',
                    alt: __('Video placeholder', 'tour-operator'),
                },
            ],
        ],
        isDefault: false,
    });

    // Add slider toggle functionality for videos block
    (function (blocks, element, editor, components) {
        const el = element.createElement;
        const InspectorControls = editor.InspectorControls;
        const PanelBody = components.PanelBody;
        const CheckboxControl = components.CheckboxControl;

        const withInspectorControls = wp.compose.createHigherOrderComponent(
            function (BlockEdit) {
                return function (props) {
                    // Only apply to core/gallery blocks that are the videos variation
                    if (
                        props.name !== 'core/gallery' ||
                        !props.attributes.metadata ||
                        props.attributes.metadata.name !== 'TO Videos'
                    ) {
                        return el(BlockEdit, props);
                    }

                    let hasSlider = props.attributes.hasSlider || false;
                    if (undefined === props.attributes.hasSlider) {
                        if (
                            props.attributes.className &&
                            props.attributes.className.includes(
                                'lsx-to-slider'
                            )
                        ) {
                            hasSlider = true;
                        }
                    } else {
                        hasSlider = props.attributes.hasSlider;
                    }

                    return el(
                        element.Fragment,
                        {},
                        el(BlockEdit, props),
                        el(
                            InspectorControls,
                            {},
                            el(
                                PanelBody,
                                {
                                    title: __(
                                        'Tour Operator',
                                        'tour-operator'
                                    ),
                                    initialOpen: true,
                                },
                                el(CheckboxControl, {
                                    label: __(
                                        'Enable Slider',
                                        'tour-operator'
                                    ),
                                    checked: hasSlider,
                                    onChange(value) {
                                        props.setAttributes({
                                            hasSlider: value,
                                        });
                                    },
                                })
                            )
                        )
                    );
                };
            },
            'withVideosInspectorControls'
        );

        wp.hooks.addFilter(
            'editor.BlockEdit',
            'lsx-tour-operator/videos-settings-panel',
            withInspectorControls
        );

        wp.hooks.addFilter(
            'blocks.getSaveContent.extraProps',
            'lsx-tour-operator/videos-save-settings-panel',
            function (extraProps, blockType, attributes) {
                if (
                    blockType.name === 'core/gallery' &&
                    attributes.metadata &&
                    attributes.metadata.name === 'TO Videos'
                ) {
                    if (true === attributes.hasSlider) {
                        extraProps.className =
                            (extraProps.className || '') + ' lsx-to-slider';
                    } else if (
                        false === attributes.hasSlider &&
                        extraProps.className
                    ) {
                        extraProps.className = extraProps.className
                            .replace(/\blsx-to-slider\b\s*/g, '')
                            .trim();
                    }
                }
                return extraProps;
            }
        );
    })(
        window.wp.blocks,
        window.wp.element,
        window.wp.blockEditor || window.wp.editor,
        window.wp.components
    );
});
