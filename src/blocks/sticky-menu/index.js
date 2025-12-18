/**
 * Sticky Menu Block - Main Entry Point
 *
 * @package Tour_Operator
 * @subpackage Blocks
 * @since 2.1.0
 */

/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { store as blockEditorStore } from '@wordpress/block-editor';
import { useEffect } from '@wordpress/element';

/**
 * Internal dependencies
 */
import blockConfig from './block.json';
import Inspector from './inspector';
import './style.scss';

/**
 * Edit component for the Sticky Menu block.
 *
 * Renders the block in the editor with live preview of menu items
 * based on group blocks that have sticky menu functionality enabled.
 *
 * @since 2.1.0
 * @param {Object} props Component props.
 * @param {Object} props.attributes Block attributes.
 * @param {Function} props.setAttributes Function to update block attributes.
 * @param {string} props.clientId Block client ID.
 * @return {JSX.Element} The edit component.
 */
function Edit({ attributes, setAttributes, clientId }) {
  const {
    backgroundColor,
    textColor,
    menuItems = [],
    activeBackgroundColor,
    customActiveBackgroundColor,
    activeTextColor,
    customActiveTextColor,
    hoverBackgroundColor,
    customHoverBackgroundColor,
    hoverTextColor,
    customHoverTextColor,
  } = attributes;

  // Helper function to get CSS variable or custom color value
  const getColorValue = (presetSlug, customValue) => {
    if (customValue) {
      return customValue;
    }
    if (presetSlug) {
      return `var(--wp--preset--color--${presetSlug})`;
    }
    return undefined;
  };

  const blockProps = useBlockProps({
    style: {
      '--active-bg-color': getColorValue(activeBackgroundColor, customActiveBackgroundColor),
      '--active-text-color': getColorValue(activeTextColor, customActiveTextColor),
      '--hover-bg-color': getColorValue(hoverBackgroundColor, customHoverBackgroundColor),
      '--hover-text-color': getColorValue(hoverTextColor, customHoverTextColor),
    },
  });

  // Extract padding from blockProps.style to apply to buttons
  const buttonStyle = {
    paddingTop: blockProps.style?.paddingTop,
    paddingRight: blockProps.style?.paddingRight,
    paddingBottom: blockProps.style?.paddingBottom,
    paddingLeft: blockProps.style?.paddingLeft,
  };

  // Remove padding from wrapper
  const wrapperStyle = {
    ...blockProps.style,
    paddingTop: undefined,
    paddingRight: undefined,
    paddingBottom: undefined,
    paddingLeft: undefined,
  };

  // Get all blocks data but with debounced updates
  const allBlocks = useSelect((select) => {
    return select(blockEditorStore).getBlocks();
  }, []);

  // Update menu items with debounce to prevent focus interruption
  useEffect(() => {
    const timeoutId = setTimeout(() => {
      const find_sticky_menu_blocks = (blocks) => {
        let sticky_blocks = [];

        blocks.forEach(block => {
          // Only include section groups with sticky menu enabled and valid native ID
          if (block.name === 'core/group' &&
            block.attributes.tagName === 'section' &&
            block.attributes.addToStickyMenu &&
            block.attributes.anchor &&
            block.attributes.anchor.trim() !== '') {

            const sectionId = block.attributes.anchor;
            const sectionTitle = block.attributes.metadata?.name || sectionId;

            sticky_blocks.push({
              id: sectionId,
              title: sectionTitle
            });
          }

          // Recursively check inner blocks
          if (block.innerBlocks && block.innerBlocks.length > 0) {
            sticky_blocks = sticky_blocks.concat(find_sticky_menu_blocks(block.innerBlocks));
          }
        });

        return sticky_blocks;
      };

      const new_menu_items = find_sticky_menu_blocks(allBlocks);

      // Only update if the actual menu items changed
      const current_ids = menuItems.map(item => `${item.id}:${item.title}`).sort().join('|');
      const new_ids = new_menu_items.map(item => `${item.id}:${item.title}`).sort().join('|');

      if (current_ids !== new_ids) {
        setAttributes({ menuItems: new_menu_items });
      }
    }, 100); // 100ms debounce - faster response while still preventing focus interruption


    return () => clearTimeout(timeoutId);
  }, [allBlocks, menuItems, setAttributes]);

  return (
    <>
      <Inspector
        attributes={attributes}
        setAttributes={setAttributes}
        clientId={clientId}
      />
      <div {...blockProps} style={wrapperStyle}>
        <nav className="lsx-to-sticky-menu-nav is-layout-constrained" aria-label={__('Page section navigation', 'tour-operator')}>
          {menuItems.length > 0 ? (
            <>
              <ul className="lsx-to-sticky-menu-list alignwide" aria-label={__('Page sections', 'tour-operator')}>
                {menuItems.map((item) => (
                  <li key={item.id} className="lsx-to-sticky-menu-item">
                    <a
                      className="lsx-to-sticky-menu-button"
                      href={`#${item.id}`}
                      aria-current="false"
                      aria-label={__('Navigate to %s section', 'tour-operator').replace('%s', item.title)}
                      style={buttonStyle}
                    >
                      {item.title}
                    </a>
                  </li>
                ))}
              </ul>
            </>
          ) : (
            <div className="lsx-to-sticky-menu-placeholder">
              <p>
                {__('Add section groups with "Add to Sticky Menu" enabled to populate this menu.', 'tour-operator')}
              </p>
              <details style={{ fontSize: '11px', color: '#666', marginTop: '8px' }}>
                <summary>{__('How to add menu items', 'tour-operator')}</summary>
                <ol style={{ marginLeft: '16px', lineHeight: '1.4' }}>
                  <li>{__('Add a Group block and set HTML element to "section"', 'tour-operator')}</li>
                  <li>{__('Set an HTML Anchor in Block Settings → Advanced', 'tour-operator')}</li>
                  <li>{__('Name the block in the List View or toolbar', 'tour-operator')}</li>
                  <li>{__('Enable "Add to Sticky Menu" in the block sidebar', 'tour-operator')}</li>
                  <li>{__('The menu will automatically populate with the block name and anchor', 'tour-operator')}</li>
                </ol>
              </details>
            </div>
          )}
        </nav>
      </div>
    </>
  );
}

/**
 * Save component for the Sticky Menu block.
 *
 * Renders the block content that will be saved to the database
 * and displayed on the frontend.
 *
 * @since 2.1.0
 * @param {Object} props Component props.
 * @param {Object} props.attributes Block attributes.
 * @return {JSX.Element} The save component.
 */
function Save({ attributes }) {
  const {
    backgroundColor,
    textColor,
    menuItems = [],
    activeBackgroundColor,
    customActiveBackgroundColor,
    activeTextColor,
    customActiveTextColor,
    hoverBackgroundColor,
    customHoverBackgroundColor,
    hoverTextColor,
    customHoverTextColor,
  } = attributes;

  // Helper function to get CSS variable or custom color value
  const getColorValue = (presetSlug, customValue) => {
    if (customValue) {
      return customValue;
    }
    if (presetSlug) {
      return `var(--wp--preset--color--${presetSlug})`;
    }
    return undefined;
  };

  const blockProps = useBlockProps.save({
    style: {
      '--active-bg-color': getColorValue(activeBackgroundColor, customActiveBackgroundColor),
      '--active-text-color': getColorValue(activeTextColor, customActiveTextColor),
      '--hover-bg-color': getColorValue(hoverBackgroundColor, customHoverBackgroundColor),
      '--hover-text-color': getColorValue(hoverTextColor, customHoverTextColor),
    },
  });

  // Extract padding from blockProps.style to apply to buttons
  const buttonStyle = {
    paddingTop: blockProps.style?.paddingTop,
    paddingRight: blockProps.style?.paddingRight,
    paddingBottom: blockProps.style?.paddingBottom,
    paddingLeft: blockProps.style?.paddingLeft,
  };

  // Remove padding from wrapper
  const wrapperStyle = {
    ...blockProps.style,
    paddingTop: undefined,
    paddingRight: undefined,
    paddingBottom: undefined,
    paddingLeft: undefined,
  };

  return (
    <div {...blockProps} style={wrapperStyle}>
      <nav className="lsx-to-sticky-menu-nav is-layout-constrained" aria-label={__('Page section navigation', 'tour-operator')}>
        {menuItems.length > 0 && (
          <ul className="lsx-to-sticky-menu-list alignwide" aria-label={__('Page sections', 'tour-operator')}>
            {menuItems.map((item) => (
              <li key={item.id} className="lsx-to-sticky-menu-item" data-section-id={item.id}>
                <a
                  className="lsx-to-sticky-menu-button"
                  href={`#${item.id}`}
                  data-section-id={item.id}
                  aria-current="false"
                  style={buttonStyle}
                >
                  {item.title}
                </a>
              </li>
            ))}
          </ul>
        )}
      </nav>
    </div>
  );
}

/**
 * Register the Sticky Menu block type.
 *
 * Combines the block configuration from block.json with the
 * edit and save components to create a fully functional block.
 *
 * @since 2.1.0
 */
registerBlockType(blockConfig.name, {
  ...blockConfig,
  edit: Edit,
  save: Save,
});
