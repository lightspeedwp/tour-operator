/**
 * Sticky Menu Editor Extensions
 *
 * Extends the core/group block with sticky menu functionality
 * by adding custom attributes, inspector controls, and visual indicators.
 *
 * @package Tour_Operator
 * @subpackage Blocks
 * @since 2.1.0
 */

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { Fragment, useState, useEffect, useCallback } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

/**
 * Add sticky menu attributes to core/group block.
 *
 * Extends the core/group block with attributes needed for
 * sticky menu functionality.
 *
 * @since 2.1.0
 * @param {Object} settings Block registration settings.
 * @param {string} name Block name.
 * @return {Object} Modified block settings.
 */
function addStickyMenuAttributes(settings, name) {
	if (name !== 'core/group') {
		return settings;
	}

	return {
		...settings,
		attributes: {
			...settings.attributes,
			addToStickyMenu: {
				type: 'boolean',
				default: false,
			},
			stickyMenuId: {
				type: 'string',
				default: '',
			},
			stickyMenuTitle: {
				type: 'string',
				default: '',
			},
		},
	};
}

addFilter(
	'blocks.registerBlockType',
	'lsx-tour-operator/add-sticky-menu-attributes',
	addStickyMenuAttributes
);

/**
 * Add sticky menu controls to core/group block.
 *
 * Creates a higher-order component that adds sticky menu configuration
 * controls to the inspector panel of core/group blocks that have their
 * HTML element set to 'section'.
 *
 * @since 2.1.0
 * @param {Function} BlockEdit The original block edit component.
 * @return {Function} Enhanced block edit component with sticky menu controls.
 */
const withStickyMenuControls = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const { attributes, setAttributes, name } = props;

		// Only apply to core/group blocks
		if (name !== 'core/group') {
			return <BlockEdit {...props} />;
		}

		// Only show sticky menu settings for groups with tagName set to 'section'
		if (attributes.tagName !== 'section') {
			return <BlockEdit {...props} />;
		}

		// Check if there's a sticky-menu block in the editor
		const hasStickyMenuBlock = useSelect((select) => {
			const { getBlocks } = select('core/block-editor');

			// Recursively check all blocks and their inner blocks
			const checkBlocksForStickyMenu = (blocks) => {
				return blocks.some(block => {
					if (block.name === 'lsx-tour-operator/sticky-menu') {
						return true;
					}
					// Check inner blocks recursively
					if (block.innerBlocks && block.innerBlocks.length > 0) {
						return checkBlocksForStickyMenu(block.innerBlocks);
					}
					return false;
				});
			};

			const allBlocks = getBlocks();
			return checkBlocksForStickyMenu(allBlocks);
		}, []);

		const { addToStickyMenu, stickyMenuId, stickyMenuTitle, anchor, metadata } = attributes;

		// Get values from native WordPress attributes
		const nativeId = anchor || '';
		const nativeName = metadata?.name || '';

		// Sync sticky menu attributes with native WordPress attributes
		// Use a separate useEffect with debouncing to avoid focus interruption
		useEffect(() => {
			if (addToStickyMenu) {
				const timeoutId = setTimeout(() => {
					const updates = {};

					// Sync ID if it has changed
					if (nativeId !== stickyMenuId) {
						updates.stickyMenuId = nativeId;
					}

					// Sync title if it has changed and no custom title is set
					if (nativeName !== stickyMenuTitle) {
						updates.stickyMenuTitle = nativeName;
					}

					// Only update if there are changes
					if (Object.keys(updates).length > 0) {
						setAttributes(updates);
					}
				}, 50); // Small delay to prevent focus interruption

				return () => clearTimeout(timeoutId);
			}
		}, [addToStickyMenu, nativeId, nativeName, stickyMenuId, stickyMenuTitle, setAttributes]);

		// Clear sticky menu data when no sticky menu block is present
		useEffect(() => {
			if (!hasStickyMenuBlock && addToStickyMenu) {
				setAttributes({
					addToStickyMenu: false,
					stickyMenuId: '',
					stickyMenuTitle: '',
				});
			}
		}, [hasStickyMenuBlock, addToStickyMenu, setAttributes]);

		// Create a stable onChange handler to prevent unnecessary re-renders
		const handleToggleChange = useCallback((value) => {
			// Combine all attribute updates into a single setAttributes call
			// to prevent focus loss from multiple re-renders
			const updates = { addToStickyMenu: value };

			// If disabled, clear the sticky menu attributes
			if (!value) {
				updates.stickyMenuId = '';
				updates.stickyMenuTitle = '';
			}

			setAttributes(updates);
		}, [setAttributes]);

		// Don't show controls if no sticky menu block is present
		if (!hasStickyMenuBlock) {
			return <BlockEdit {...props} />;
		}

		return (
			<Fragment>
				<BlockEdit {...props} />
				<InspectorControls>
					<PanelBody
						title={__('Sticky Menu Settings', 'tour-operator')}
						initialOpen={false}
						key="sticky-menu-settings-panel"
					>
						<ToggleControl
							label={__('Add to Sticky Menu', 'tour-operator')}
							help={__('Include this section in the sticky navigation menu. ID and title will be taken from block settings.', 'tour-operator')}
							checked={addToStickyMenu}
							onChange={handleToggleChange}
						/>

						{addToStickyMenu && (
							<Fragment>
								<p style={{ fontSize: '12px', color: '#757575', margin: '8px 0' }}>
									{__('ID and Title are automatically taken from:', 'tour-operator')}
								</p>
								<ul style={{ fontSize: '11px', color: '#757575', margin: '0 0 16px 16px', listStyle: 'disc' }}>
									<li>{__('HTML Anchor (Block Settings → Advanced)', 'tour-operator')}</li>
									<li>{__('Block Name (rename in List View or toolbar)', 'tour-operator')}</li>
								</ul>
								{nativeId && (
									<p style={{ fontSize: '11px', color: '#007cba', margin: '8px 0' }}>
										<strong>{__('Current ID:', 'tour-operator')}</strong> #{nativeId}
									</p>
								)}
								{nativeName && (
									<p style={{ fontSize: '11px', color: '#007cba', margin: '8px 0' }}>
										<strong>{__('Current Title:', 'tour-operator')}</strong> {nativeName}
									</p>
								)}
								{!nativeId && (
									<p style={{ fontSize: '11px', color: '#d63638', margin: '8px 0' }}>
										{__('⚠️ No HTML Anchor set. Go to Block Settings → Advanced to add one.', 'tour-operator')}
									</p>
								)}
								{!nativeName && (
									<p style={{ fontSize: '11px', color: '#d63638', margin: '8px 0' }}>
										{__('⚠️ No block name set. Rename this block in the List View.', 'tour-operator')}
									</p>
								)}
							</Fragment>
						)}
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'withStickyMenuControls');

addFilter(
	'editor.BlockEdit',
	'lsx-tour-operator/with-sticky-menu-controls',
	withStickyMenuControls
);

/**
 * Add sticky menu attributes to block save props.
 *
 * Modifies the saved HTML attributes for group blocks with tagName 'section' that have
 * sticky menu functionality enabled. Adds necessary data attributes
 * and accessibility properties.
 *
 * Note: This runs during save and doesn't need to check for sticky menu block presence
 * since the attributes will be cleared by the editor when no sticky menu block exists.
 *
 * @since 2.1.0
 * @param {Object} extraProps Additional props to add to the block wrapper.
 * @param {Object} blockType Block type definition.
 * @param {Object} attributes Block attributes.
 * @return {Object} Modified extra props.
 */
function addStickyMenuSaveProps(extraProps, blockType, attributes) {
	// Only apply to core/group blocks with tagName 'section'
	if (blockType.name !== 'core/group' || attributes.tagName !== 'section') {
		return extraProps;
	}

	const { addToStickyMenu, anchor, metadata } = attributes;

	// Use native WordPress attributes for ID and title
	const sectionId = anchor || '';
	const sectionTitle = metadata?.name || '';

	if (addToStickyMenu && sectionId) {
		extraProps.id = sectionId;
		extraProps['data-sticky-menu-section'] = 'true';
		extraProps['data-section-title'] = sectionTitle || sectionId;

		// Add ARIA attributes for accessibility
		extraProps.role = 'region';
		extraProps['aria-labelledby'] = `${sectionId}-header`;

		// Add custom CSS class for frontend styling/JavaScript targeting
		const existingClass = extraProps.className || '';
		extraProps.className = `${existingClass} lsx-to-sticky-menu-section`.trim();
	}

	return extraProps;
}

addFilter(
	'blocks.getSaveContent.extraProps',
	'lsx-tour-operator/add-sticky-menu-save-props',
	addStickyMenuSaveProps
);

/**
 * Add visual indicator in editor for sticky menu sections.
 *
 * Creates a higher-order component that adds visual styling and badges
 * to group blocks with tagName 'section' that are part of the sticky menu system.
 *
 * @since 2.1.0
 * @param {Function} BlockListBlock The original block list block component.
 * @return {Function} Enhanced block list block component with visual indicators.
 */
const withStickyMenuEditor = createHigherOrderComponent((BlockListBlock) => {
	return (props) => {
		const { attributes, name } = props;

		// Only apply to core/group blocks with tagName 'section'
		if (name !== 'core/group' || attributes.tagName !== 'section') {
			return <BlockListBlock {...props} />;
		}

		// Check if there's a sticky-menu block in the editor
		const hasStickyMenuBlock = useSelect((select) => {
			const { getBlocks } = select('core/block-editor');

			// Recursively check all blocks and their inner blocks
			const checkBlocksForStickyMenu = (blocks) => {
				return blocks.some(block => {
					if (block.name === 'lsx-tour-operator/sticky-menu') {
						return true;
					}
					// Check inner blocks recursively
					if (block.innerBlocks && block.innerBlocks.length > 0) {
						return checkBlocksForStickyMenu(block.innerBlocks);
					}
					return false;
				});
			};

			const allBlocks = getBlocks();
			return checkBlocksForStickyMenu(allBlocks);
		}, []);

		const { addToStickyMenu, anchor, metadata } = attributes;

		// Use native WordPress attributes
		const sectionId = anchor || '';
		const sectionTitle = metadata?.name || '';

		// Always render the BlockListBlock, but conditionally apply styling
		const shouldShowIndicator = hasStickyMenuBlock && addToStickyMenu && sectionId;

		// Add visual indicator styling only when needed
		const wrapperProps = shouldShowIndicator ? {
			...props.wrapperProps,
			style: {
				...props.wrapperProps?.style,
				border: '2px dashed #007cba',
				position: 'relative',
			},
		} : props.wrapperProps;

		// Add a badge to show it's part of sticky menu (only when needed)
		const badge = shouldShowIndicator ? (
			<div
				style={{
					position: 'absolute',
					top: '-10px',
					left: '10px',
					background: '#007cba',
					color: 'white',
					padding: '2px 8px',
					fontSize: '11px',
					borderRadius: '3px',
					zIndex: 10,
					fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
				}}
			>
				📌 {__('Sticky Menu Section', 'tour-operator')}: {sectionTitle || sectionId}
			</div>
		) : null;

		return (
			<div style={{ position: 'relative' }}>
				{badge}
				<BlockListBlock {...props} wrapperProps={wrapperProps} />
			</div>
		);
	};
}, 'withStickyMenuEditor');

addFilter(
	'editor.BlockListBlock',
	'lsx-tour-operator/with-sticky-menu-editor',
	withStickyMenuEditor
);
