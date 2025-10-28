/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { Fragment, useState, useEffect } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

/**
 * Add sticky menu attributes to core/group block
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
 * Add sticky menu controls to core/group block
 */
const withStickyMenuControls = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const { attributes, setAttributes, name } = props;

		if (name !== 'core/group') {
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

		const { addToStickyMenu, stickyMenuId, stickyMenuTitle } = attributes;

		// Local state for the CSS ID input to prevent focus loss
		const [localStickyMenuId, setLocalStickyMenuId] = useState(stickyMenuId || '');

		// Sync local state with attributes when attributes change externally
		useEffect(() => {
			setLocalStickyMenuId(stickyMenuId || '');
		}, [stickyMenuId]);

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
					>
						<ToggleControl
							label={__('Add to Sticky Menu', 'tour-operator')}
							help={__('Include this section in the sticky navigation menu', 'tour-operator')}
							checked={addToStickyMenu}
							onChange={(value) => {
								setAttributes({ addToStickyMenu: value });

								// If disabled, clear the other fields
								if (!value) {
									setAttributes({
										stickyMenuId: '',
										stickyMenuTitle: '',
									});
								}
							}}
						/>

						{addToStickyMenu && (
							<Fragment>
								<TextControl
									label={__('CSS ID', 'tour-operator')}
									help={__('Required: Unique ID for this section (without #)', 'tour-operator')}
									value={localStickyMenuId}
									onChange={(value) => {
										// Update local state immediately for smooth typing
										setLocalStickyMenuId(value);
									}}
									onBlur={() => {
										// Clean and save to attributes when user finishes typing
										const cleanId = localStickyMenuId.replace(/[^a-zA-Z0-9-_]/g, '').toLowerCase();
										setLocalStickyMenuId(cleanId);
										setAttributes({ stickyMenuId: cleanId });
									}}
									placeholder="section-id"
								/>

								<TextControl
									label={__('Menu Title', 'tour-operator')}
									help={__('Title to display in the sticky menu', 'tour-operator')}
									value={stickyMenuTitle}
									onChange={(value) => setAttributes({ stickyMenuTitle: value })}
									placeholder={__('Section Title', 'tour-operator')}
								/>
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
 * Add sticky menu attributes to save function
 * Note: This runs during save and doesn't need to check for sticky menu block presence
 * since the attributes will be cleared by the editor when no sticky menu block exists
 */
function addStickyMenuSaveProps(extraProps, blockType, attributes) {
	if (blockType.name !== 'core/group') {
		return extraProps;
	}

	const { addToStickyMenu, stickyMenuId, stickyMenuTitle } = attributes;

	if (addToStickyMenu && stickyMenuId) {
		extraProps.id = stickyMenuId;
		extraProps['data-sticky-menu-section'] = 'true';
		extraProps['data-section-title'] = stickyMenuTitle || stickyMenuId;

		// Add ARIA attributes for accessibility
		extraProps.role = 'region';
		extraProps['aria-labelledby'] = `${stickyMenuId}-header`;

		// Add custom CSS class for frontend styling/JavaScript targeting
		const existingClass = extraProps.className || '';
		extraProps.className = `${existingClass} lsx-to-lsx-sticky-menu-section`.trim();
	}

	return extraProps;
}

addFilter(
	'blocks.getSaveContent.extraProps',
	'lsx-tour-operator/add-sticky-menu-save-props',
	addStickyMenuSaveProps
);

/**
 * Add visual indicator in editor for sticky menu sections
 */
const withStickyMenuEditor = createHigherOrderComponent((BlockListBlock) => {
	return (props) => {
		const { attributes, name } = props;

		if (name !== 'core/group') {
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

		const { addToStickyMenu, stickyMenuId, stickyMenuTitle } = attributes;

		if (!hasStickyMenuBlock || !addToStickyMenu || !stickyMenuId) {
			return <BlockListBlock {...props} />;
		}

		// Add a visual indicator in the editor
		const wrapperProps = {
			...props.wrapperProps,
			style: {
				...props.wrapperProps?.style,
				border: '2px dashed #007cba',
				position: 'relative',
			},
		};

		// Add a badge to show it's part of sticky menu
		const badge = (
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
				📌 {__('Sticky Menu Section', 'tour-operator')}: {stickyMenuTitle || stickyMenuId}
			</div>
		);

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
