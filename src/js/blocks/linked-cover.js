// assets/js/blocks/linked-cover.js

// Destructure necessary WordPress packages
const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { Fragment, createElement } = wp.element;
const { InspectorControls } = wp.blockEditor || wp.editor;
const { PanelBody, TextControl, ToggleControl } = wp.components;

// Add new attributes to the core/cover block
function addLinkAttributes(settings, name) {
    if (name !== 'core/cover') {
        return settings;
    }

    // Add new attributes
    settings.attributes = Object.assign({}, settings.attributes, {
        linkUrl: {
            type: 'string',
            default: ''
        },
        linkTarget: {
            type: 'string',
            default: '_self' // '_self' for same tab, '_blank' for new tab
        }
    });

    return settings;
}

addFilter('blocks.registerBlockType', 'lsx/cover/add-link-attributes', addLinkAttributes);

// Extend the edit component to include new controls
const withLinkInspectorControl = createHigherOrderComponent(function (BlockEdit) {
    return function (props) {
        if (props.name !== 'core/cover') {
            return createElement(BlockEdit, props);
        }

        const { attributes, setAttributes } = props;
        const { linkUrl, linkTarget } = attributes;

        return createElement(
            Fragment,
            null,
            createElement(BlockEdit, props),
            createElement(
                InspectorControls,
                null,
                createElement(
                    PanelBody,
                    { title: 'Cover Link Settings', initialOpen: true },
                    createElement(TextControl, {
                        label: 'Link URL',
                        value: linkUrl,
                        onChange: function (value) {
                            setAttributes({ linkUrl: value });
                        }
                    }),
                    createElement(ToggleControl, {
                        label: 'Open link in a new tab',
                        checked: linkTarget === '_blank',
                        onChange: function (value) {
                            setAttributes({ linkTarget: value ? '_blank' : '_self' });
                        }
                    })
                )
            )
        );
    };
}, 'withLinkInspectorControl');

addFilter('editor.BlockEdit', 'lsx/cover/with-link-inspector-control', withLinkInspectorControl);

// Modify the save element to wrap content in a link
function modifyCoverSaveElement(element, blockType, attributes) {
    if (blockType.name !== 'core/cover') {
        return element;
    }

    const { linkUrl, linkTarget } = attributes;

    if (linkUrl) {
        return createElement(
            'a',
            { href: linkUrl, target: linkTarget },
            element
        );
    }

    return element;
}

addFilter('blocks.getSaveElement', 'lsx/cover/modify-save-element', modifyCoverSaveElement);
