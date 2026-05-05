/**
 * WordPress dependencies
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ToggleControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Accommodation Visibility Panel Component
 */
const AccommodationVisibilityPanel = () => {
	const { metaKey } = window.lsxAccommodationVisibility || {};

	// Get the current meta value
	const isHidden = useSelect(
		(select) => {
			const meta = select('core/editor').getEditedPostAttribute('meta');
			return meta && meta[metaKey] ? Boolean(meta[metaKey]) : false;
		},
		[metaKey]
	);

	// Get the editPost function to update meta
	const { editPost } = useDispatch('core/editor');

	// Handler for toggle change
	const handleToggleChange = (value) => {
		editPost({
			meta: {
				[metaKey]: value,
			},
		});
	};

	return (
		<PluginDocumentSettingPanel
			name="accommodation-visibility"
			title={__('Accommodation Visibility', 'tour-operator')}
			className="accommodation-visibility-panel"
		>
			<ToggleControl
				label={__('Hide from listings and search', 'tour-operator')}
				help={
					isHidden
						? __('This accommodation will not appear in category pages, search results, or show View More buttons in modals.', 'tour-operator')
						: __('This accommodation will be visible in listings and search results.', 'tour-operator')
				}
				checked={isHidden}
				onChange={handleToggleChange}
			/>
		</PluginDocumentSettingPanel>
	);
};

// Register the plugin
registerPlugin('lsx-accommodation-visibility', {
	render: AccommodationVisibilityPanel,
	icon: 'visibility',
});
