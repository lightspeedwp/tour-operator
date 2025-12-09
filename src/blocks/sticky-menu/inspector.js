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
import {
  __experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
  InspectorControls,
  __experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

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
      customActiveBackgroundColor,
      customActiveTextColor,
      customHoverBackgroundColor,
      customHoverTextColor,
    },
    setAttributes,
    clientId,
  } = props;

  const colorGradientSettings = useMultipleOriginColorsAndGradients();

  return (
    <>
      <InspectorControls group="color">
        <ColorGradientSettingsDropdown
          settings={[
            {
              label: __('Active Background Color', 'tour-operator'),
              colorValue: customActiveBackgroundColor,
              onColorChange: (value) => {
                setAttributes({
                  customActiveBackgroundColor: value,
                });
              },
            },
            {
              label: __('Active Text Color', 'tour-operator'),
              colorValue: customActiveTextColor,
              onColorChange: (value) => {
                setAttributes({
                  customActiveTextColor: value,
                });
              },
            },
            {
              label: __('Hover Background Color', 'tour-operator'),
              colorValue: customHoverBackgroundColor,
              onColorChange: (value) => {
                setAttributes({
                  customHoverBackgroundColor: value,
                });
              },
            },
            {
              label: __('Hover Text Color', 'tour-operator'),
              colorValue: customHoverTextColor,
              onColorChange: (value) => {
                setAttributes({
                  customHoverTextColor: value,
                });
              },
            },
          ]}
          panelId={clientId}
          hasColorsOrGradients={false}
          disableCustomColors={false}
          __experimentalIsRenderedInSidebar
          {...colorGradientSettings}
        />
      </InspectorControls>
    </>
  );
};

export default Inspector;
