import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['tour', 'accommodation'];
    let registered = false;
    let checking = false;

    // Register variation function
    const registerNotIncludedVariation = () => {
        if (registered) {
            return;
        }

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/not-included',
            title: __('Excluded items', 'tour-operator'),
            icon: 'dismiss',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
            },
            attributes: {
                metadata: {
                    name: __('Not included', 'tour-operator'),
                },
                className: 'lsx-not-included-wrapper',
            },
            innerBlocks: [
                [
                    'core/paragraph',
                    {
                        content: '<strong>' + __('Price excludes:', 'tour-operator') + '</strong>',
                    },
                ],
                [
                    'core/paragraph',
                    {
                        metadata: {
                            bindings: {
                                content: {
                                    source: 'lsx/post-meta',
                                    args: {
                                        key: 'not_included',
                                    },
                                },
                            },
                        },
                    },
                ],
            ],
            supports: {
                renaming: false,
            },
        });
    };

    // Check if current post type is supported
    const checkAndRegister = () => {
        if (registered || checking) {
            return registered;
        }

        checking = true;

        try {
            const postType = select('core/editor')?.getCurrentPostType();
            const postSlug = select('core/editor')?.getEditedPostSlug();

            if (!postType || !postSlug) {
                checking = false;
                return false;
            }

            if (supportedPostTypes.includes(postType) || ((postType === 'wp_template' || postType === 'wp_template_part') && (postSlug.includes('tour') || postSlug.includes('accommodation')))) {
                registerNotIncludedVariation();
                registered = true;
                checking = false;
                return true;
            }
        } catch (error) {
            console.error('Error in checkAndRegister:', error);
        }

        checking = false;
        return false;
    };

    // Try initial registration with a small delay
    setTimeout(() => {
        if (!checkAndRegister()) {
            // Subscribe to editor changes if initial check failed
            let unsubscribed = false;
            const unsubscribe = wp.data.subscribe(() => {
                if (unsubscribed) {
                    return;
                }

                if (checkAndRegister()) {
                    unsubscribed = true;
                    unsubscribe();
                }
            });
        }
    }, 100);
});
