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
 * @return {JSX.Element} The edit component.
 */
function Edit({ attributes, setAttributes }) {
  const { backgroundColor, textColor, menuItems = [] } = attributes;

  const blockProps = useBlockProps({
    className: `lsx-to-sticky-menu`,
    style: {
      backgroundColor: backgroundColor || undefined,
      color: textColor || undefined,
    },
  });

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
          // Only include blocks with both enabled AND valid ID
          if (block.name === 'core/group' &&
            block.attributes.addToStickyMenu &&
            block.attributes.stickyMenuId &&
            block.attributes.stickyMenuId.trim() !== '') {
            sticky_blocks.push({
              id: block.attributes.stickyMenuId,
              title: block.attributes.stickyMenuTitle || block.attributes.stickyMenuId
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
    }, 500); // 500ms debounce


    return () => clearTimeout(timeoutId);
  }, [allBlocks, menuItems, setAttributes]);

  return (
    <>
      <div {...blockProps}>
        <nav className="lsx-to-sticky-menu-nav" aria-label={__('Page section navigation', 'tour-operator')}>
          {menuItems.length > 0 ? (
            <>
              <ul className="lsx-to-sticky-menu-list" aria-label={__('Page sections', 'tour-operator')}>
                {menuItems.map((item) => (
                  <li key={item.id} className="lsx-to-sticky-menu-item">
                    <a
                      className="lsx-to-sticky-menu-button"
                      href="javascript:void(0);"
                      aria-current="false"
                      aria-label={__('Navigate to %s section', 'tour-operator').replace('%s', item.title)}
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
                {__('Add groups with "Add to Sticky Menu" enabled to populate this menu.', 'tour-operator')}
              </p>
              <details style={{ fontSize: '11px', color: '#666', marginTop: '8px' }}>
                <summary>{__('Troubleshooting', 'tour-operator')}</summary>
                <ol style={{ marginLeft: '16px', lineHeight: '1.4' }}>
                  <li>{__('Add a Group block to your page', 'tour-operator')}</li>
                  <li>{__('In the Group block sidebar, find "Sticky Menu Settings"', 'tour-operator')}</li>
                  <li>{__('Check "Add to Sticky Menu"', 'tour-operator')}</li>
                  <li>{__('Enter a unique CSS ID and Menu Title', 'tour-operator')}</li>
                  <li>{__('The menu will automatically populate', 'tour-operator')}</li>
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
  const { backgroundColor, textColor, menuItems = [] } = attributes;

  const blockProps = useBlockProps.save({
    className: `lsx-to-sticky-menu`,
    style: {
      backgroundColor: backgroundColor || undefined,
      color: textColor || undefined,
    },
  });

  return (
    <div {...blockProps}>
      <nav className="lsx-to-sticky-menu-nav" aria-label={__('Page section navigation', 'tour-operator')}>
        {menuItems.length > 0 && (
          <ul className="lsx-to-sticky-menu-list" aria-label={__('Page sections', 'tour-operator')}>
            {menuItems.map((item) => (
              <li key={item.id} className="lsx-to-sticky-menu-item" data-section-id={item.id}>
                <a
                  className="lsx-to-sticky-menu-button"
                  href={`#${item.id}`}
                  data-section-id={item.id}
                  aria-current="false"
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
