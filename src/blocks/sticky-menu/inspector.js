/**
 * Sticky Menu Block - Inspector Controls
 *
 * @package Tour_Operator
 * @subpackage Blocks
 * @since 2.1.0
 */

/**
 * WordPress dependencies
 */
import { InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';
import {
  __experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
  __experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
  useSetting,
} from '@wordpress/block-editor';

/**
 * Inspector component for Sticky Menu block.
 *
 * Provides color controls for active and hover states of menu buttons.
 *
 * @since 2.1.0
 * @param {Object} props Component props.
 * @param {Object} props.attributes Block attributes.
 * @param {Function} props.setAttributes Function to update block attributes.
 * @param {string} props.clientId Block client ID.
 * @return {JSX.Element} The inspector component.
 */
const Inspector = (props) => {
  const {
    attributes: {
      activeBackgroundColor,
      customActiveBackgroundColor,
      activeTextColor,
      customActiveTextColor,
      hoverBackgroundColor,
      customHoverBackgroundColor,
      hoverTextColor,
      customHoverTextColor,
      stickyOffsetSelector,
    },
    setAttributes,
    clientId,
  } = props;

  const colorGradientSettings = useMultipleOriginColorsAndGradients();
  const colors = useSetting('color.palette') || [];

  /**
   * Helper to find color object by value from theme palette
   *
   * @param {string} colorValue The color value to search for
   * @return {Object|undefined} The color object if found
   */
  const getColorObjectByColorValue = (colorValue) => {
    if (!colorValue || !colors) return undefined;
    
    // Flatten all color origins
    const allColors = colors.flatMap(origin => 
      Array.isArray(origin.colors) ? origin.colors : []
    );
    
    return allColors.find(color => color.color === colorValue);
  };

  /**
   * Create color change handler that stores preset slug when available
   *
   * @param {string} slugAttr The attribute name for the preset slug
   * @param {string} customAttr The attribute name for custom color
   * @return {Function} The color change handler
   */
  const createColorChangeHandler = (slugAttr, customAttr) => (newColor) => {
    const colorObject = getColorObjectByColorValue(newColor);
    
    if (colorObject && colorObject.slug) {
      // It's a preset color - store the slug, clear custom
      setAttributes({
        [slugAttr]: colorObject.slug,
        [customAttr]: undefined,
      });
    } else {
      // It's a custom color - store the value, clear slug
      setAttributes({
        [slugAttr]: undefined,
        [customAttr]: newColor,
      });
    }
  };

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Offset Settings', 'tour-operator')} initialOpen={false}>
          <TextControl
            label={__('Sticky Header Selector', 'tour-operator')}
            help={__('CSS selector for an additional sticky header whose height should be accounted for (e.g. #site-header, .my-sticky-bar).', 'tour-operator')}
            value={stickyOffsetSelector || ''}
            onChange={(value) => setAttributes({ stickyOffsetSelector: value })}
            placeholder="#site-header"
          />
        </PanelBody>
      </InspectorControls>
      <InspectorControls group="color">
        <ColorGradientSettingsDropdown
          __experimentalIsRenderedInSidebar
          settings={[
            {
              label: __('Active Background', 'tour-operator'),
              colorValue: customActiveBackgroundColor || 
                (activeBackgroundColor ? 
                  colors.flatMap(o => o.colors || []).find(c => c.slug === activeBackgroundColor)?.color 
                  : undefined),
              onColorChange: createColorChangeHandler('activeBackgroundColor', 'customActiveBackgroundColor'),
            },
            {
              label: __('Active Text', 'tour-operator'),
              colorValue: customActiveTextColor || 
                (activeTextColor ? 
                  colors.flatMap(o => o.colors || []).find(c => c.slug === activeTextColor)?.color 
                  : undefined),
              onColorChange: createColorChangeHandler('activeTextColor', 'customActiveTextColor'),
            },
            {
              label: __('Hover Background', 'tour-operator'),
              colorValue: customHoverBackgroundColor || 
                (hoverBackgroundColor ? 
                  colors.flatMap(o => o.colors || []).find(c => c.slug === hoverBackgroundColor)?.color 
                  : undefined),
              onColorChange: createColorChangeHandler('hoverBackgroundColor', 'customHoverBackgroundColor'),
            },
            {
              label: __('Hover Text', 'tour-operator'),
              colorValue: customHoverTextColor || 
                (hoverTextColor ? 
                  colors.flatMap(o => o.colors || []).find(c => c.slug === hoverTextColor)?.color 
                  : undefined),
              onColorChange: createColorChangeHandler('hoverTextColor', 'customHoverTextColor'),
            },
          ]}
          panelId={clientId}
          {...colorGradientSettings}
        />
      </InspectorControls>
    </>
  );
};

export default Inspector;
