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
			//setChecked(newChecked);
			console.log(newChecked);
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

	const StickyPostPlugin = function() {
		return createElement(
			PluginPostStatusInfo,
			{
				name: 'sticky-post-toggle',
				className: 'sticky-post-toggle-panel'
			},
			createElement(StickyToggle)
		);
	};

	registerPlugin('sticky-post-toggle', {
		render: StickyPostPlugin,
		icon: null,
	});
})(window.wp);
