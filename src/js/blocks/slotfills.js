(function (wp) {
    const { registerPlugin } = wp.plugins;
    const { PluginPostStatusInfo } = wp.editPost;
    const { ToggleControl } = wp.components;
    const { useSelect, useDispatch } = wp.data;
    const { useEntityProp } = wp.coreData;
    const { createElement } = wp.element;
    const i18n = window.wp.i18n;

    /**
     * Component for toggling featured status of a post.
     *
     * @since 2.1.0
     * @return {Element} The toggle control element.
     */
    const StickyToggle = () => {
        const { editPost } = useDispatch('core/editor');
        const handleChange = (newChecked) => {
			console.log(newChecked);
            editPost({ meta: { featured: newChecked } });
        };

        const isSticky = useSelect(function (select) {
            const meta = select('core/editor').getEditedPostAttribute('meta');
            return meta?.featured || 0;
        }, []);

        return createElement(ToggleControl, {
            label: i18n.__('Featured', 'tour-operator'),
            checked: isSticky,
            onChange: handleChange,
        });
    };

    /**
     * Component for toggling visibility (hide from listings and search).
     *
     * @since 2.1.0
     * @return {Element} The toggle control element or null if not allowed post type.
     */
    const HideFromListingsToggle = () => {
        const postType = useSelect(function (select) {
            return select('core/editor')?.getCurrentPostType?.();
        }, []);

        // Only show for tour, accommodation, and destination post types
        if (!['tour', 'accommodation', 'destination'].includes(postType)) {
            return null;
        }

        const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
        const toggleValue = meta?.lsx_to_hide_from_listings || false;

        const handleChange = (newValue) => {
            setMeta({ ...meta, lsx_to_hide_from_listings: newValue });
        };

        return createElement(ToggleControl, {
            label: i18n.__('Hide from listings and search', 'tour-operator'),
            help: toggleValue
                ? i18n.__('This will not appear in category pages, search results, or show View More buttons in modals.', 'tour-operator')
                : i18n.__('This will be visible in listings and search results.', 'tour-operator'),
            checked: toggleValue,
            onChange: handleChange,
        });
    };

    const LsxToStatusPlugin = function () {
        // Check if we're in a post editing context (not template editor)
        const isEditingPost = useSelect(function (select) {
            const currentPost = select('core/editor')?.getCurrentPost?.();
            const postType = select('core/editor')?.getCurrentPostType?.();

            // We're editing a post if we have a current post with an ID and it's not a template
            return currentPost && currentPost.id && postType !== 'wp_template';
        }, []);

        // Only show toggles when editing a post (not template)
        if (!isEditingPost) {
            return null;
        }

        return createElement(
            PluginPostStatusInfo,
            {
                name: 'lsx-to-toggles',
                className: 'lsx-to-toggles',
            },
            createElement(
                'div',
                {
                    className: 'lsx-to-toggles__inner',
                },
                createElement(
                    'div',
                    {
                        className: 'toggle-row',
                    },
                    createElement(StickyToggle)
                ),
                createElement(
                    'div',
                    {
                        className: 'toggle-row',
                    },
                    createElement(HideFromListingsToggle)
                )
            )
        );
    };

    registerPlugin('lsx-to-status-plugin', {
        render: LsxToStatusPlugin,
        icon: null,
    });
})(window.wp);
