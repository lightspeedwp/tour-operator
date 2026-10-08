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
        const postId = useSelect(function (select) {
            return select('core/editor')?.getCurrentPostId?.();
        }, []);

        const { editPost } = useDispatch('core/editor');

        const isSticky = useSelect(function (select) {
            const meta = select('core/editor').getEditedPostAttribute('meta');
            return meta?.featured || false;
        }, []);

        const handleChange = async (newValue) => {
            try {
                if (!newValue) {
                    // When toggling off, delete the meta via REST API
                    await wp.apiFetch({
                        path: `/tour-operator/v1/meta/${postId}/featured`,
                        method: 'DELETE',
                    });
                    // Update editor state to reflect the deletion
                    editPost({ meta: { featured: false } });
                } else {
                    // When toggling on, update the meta via REST API
                    await wp.apiFetch({
                        path: `/tour-operator/v1/meta/${postId}/featured`,
                        method: 'POST',
                        data: {
                            value: true,
                        },
                    });
                    // Update editor state to reflect the update
                    editPost({ meta: { featured: true } });
                }
            } catch (error) {
                if (!newValue) {
                    console.error('Error deleting featured meta:', error);
                } else {
                    console.error('Error updating featured meta:', error);
                }
            }
        };

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

        const postId = useSelect(function (select) {
            return select('core/editor')?.getCurrentPostId?.();
        }, []);

        const { editPost } = useDispatch('core/editor');

        // Only show for tour, accommodation, and destination post types
        if (!['tour', 'accommodation', 'destination'].includes(postType)) {
            return null;
        }

        const toggleValue = useSelect(function (select) {
            const meta = select('core/editor').getEditedPostAttribute('meta');
            return meta?.lsx_to_hide_from_listings || false;
        }, []);

        const handleChange = async (newValue) => {
            try {
                if (!newValue) {
                    // When toggling off, delete the meta via REST API
                    await wp.apiFetch({
                        path: `/tour-operator/v1/meta/${postId}/lsx_to_hide_from_listings`,
                        method: 'DELETE',
                    });
                    // Update editor state to reflect the deletion
                    editPost({ meta: { lsx_to_hide_from_listings: false } });
                } else {
                    // When toggling on, update the meta via REST API
                    await wp.apiFetch({
                        path: `/tour-operator/v1/meta/${postId}/lsx_to_hide_from_listings`,
                        method: 'POST',
                        data: {
                            value: true,
                        },
                    });
                    // Update editor state to reflect the update
                    editPost({ meta: { lsx_to_hide_from_listings: true } });
                }
            } catch (error) {
                if (!newValue) {
                    console.error('Error deleting meta:', error);
                } else {
                    console.error('Error updating meta:', error);
                }
            }
        };

        return createElement(ToggleControl, {
            label: i18n.__('Hide from listings and search', 'tour-operator'),
            help: toggleValue
                ? i18n.__(
                      'This will not appear in category pages, search results, or show View More buttons in modals.',
                      'tour-operator'
                  )
                : i18n.__(
                      'This will be visible in listings and search results.',
                      'tour-operator'
                  ),
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
