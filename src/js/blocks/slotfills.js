(function (wp) {
    const { registerPlugin } = wp.plugins;
    const { PluginPostStatusInfo } = wp.editPost;
    const { ToggleControl } = wp.components;
    const { useSelect, useDispatch } = wp.data;
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
            editPost({ meta: { featured: newChecked } });
        };

        const isSticky = useSelect(function (select) {
            const meta = select('core/editor').getEditedPostAttribute('meta');
            return meta?.featured || false;
        }, []);

        return createElement(ToggleControl, {
            label: i18n.__('Featured', 'tour-operator'),
            checked: isSticky,
            onChange: handleChange,
        });
    };

    /**
     * Component for toggling the disable single post view setting.
     *
     * @since 2.1.0
     * @return {Element} The toggle control element.
     */
    const DisableSingleToggle = () => {
        const { editPost } = useDispatch('core/editor');
        const handleChange = (newChecked) => {
            editPost({ meta: { disable_single: newChecked } });
        };

        const isDisabled = useSelect(function (select) {
            const meta = select('core/editor').getEditedPostAttribute('meta');
            return meta?.disable_single || false;
        }, []);

        return createElement(ToggleControl, {
            label: i18n.__('Disable Single', 'tour-operator'),
            checked: isDisabled,
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
                    createElement(DisableSingleToggle)
                )
            )
        );
    };

    registerPlugin('lsx-to-status-plugin', {
        render: LsxToStatusPlugin,
        icon: null,
    });
})(window.wp);
