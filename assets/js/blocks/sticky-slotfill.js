(function (wp) {
	const { registerPlugin } = wp.plugins;
	const { PluginPostStatusInfo } = wp.editPost;
	const { ToggleControl } = wp.components;
	const { useSelect, useDispatch } = wp.data;
	const { createElement, useState } = wp.element;
	const i18n = window.wp.i18n;

	// Custom Sticky Post Toggle Component
	const StickyToggle = () => {
		const { editPost } = useDispatch("core/editor");
		const handleChange = (newChecked) => {
			editPost({ meta: { 'featured': newChecked } });
		};

		const isSticky = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute(
				'meta'
			)[ 'featured' ];
		}, [] );

		return createElement(
			ToggleControl,
			{
				label: i18n.__('Sticky Post'),
				checked: isSticky,
				onChange: handleChange
			}
		);
	};

	// Custom Disable Single Toggle Component
	const DisableSingleToggle = () => {
		const { editPost } = useDispatch("core/editor");
		const handleChange = (newChecked) => {
			editPost({ meta: { 'disable_single': newChecked } });
		};

		const isSticky = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute(
				'meta'
			)[ 'disable_single' ];
		}, [] );

		return createElement(
			ToggleControl,
			{
				label: i18n.__('Disable Single'),
				checked: isSticky,
				onChange: handleChange
			}
		);
	};

	const LsxToStatusPlugin = function() {
		return createElement(
			PluginPostStatusInfo,
			{
				name: 'lsx-to-toggles',
				className: 'lsx-to-toggles'
			},
			createElement(StickyToggle),
			createElement(DisableSingleToggle)
		);
	};

	registerPlugin('lsx-to-status-plugin', {
		render: LsxToStatusPlugin,
		icon: null,
	});
})(window.wp);
