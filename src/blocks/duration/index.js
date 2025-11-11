import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['tour'];
    let registered = false;
    let checking = false;

    // Register variation function
    const registerDurationVariation = () => {
        if (registered) {
            return;
        }

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/duration',
            title: __('Duration', 'tour-operator'),
            icon: 'clock',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
            },
            attributes: {
                metadata: {
                    name: 'Duration',
                },
                className: 'lsx-duration-wrapper',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
                },
            },
            innerBlocks: [
                [
                    'core/group',
                    {
                        layout: {
                            type: 'flex',
                            flexWrap: 'nowrap',
                            verticalAlignment: 'middle',
                        },
                    },
                    [
                        [
                            'lsx-tour-operator/icons',
                            {
                                iconType: 'outline',
                                iconName: 'durationIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '<strong>' + __('Duration:', 'tour-operator') + '</strong>',
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {
                        layout: {
                            type: 'flex',
                            flexWrap: 'nowrap',
                        },
                    },
                    [
                        [
                            'core/paragraph',
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: 'lsx/post-meta',
                                            args: {
                                                key: 'duration',
                                            },
                                        },
                                    },
                                },
                                content: '',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: __('Days', 'tour-operator'),
                            },
                        ],
                    ],
                ],
            ],
            supports: {
                renaming: false,
            },
            example: {
                innerBlocks: [
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'flex',
                                flexWrap: 'nowrap',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/group',
                                attributes: {
                                    layout: {
                                        type: 'flex',
                                        flexWrap: 'nowrap',
                                        verticalAlignment: 'middle',
                                    },
                                },
                                innerBlocks: [
                                    {
                                        name: 'lsx-tour-operator/icons',
                                        attributes: {
                                            iconType: 'outline',
                                            iconName: 'durationIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('Duration: ', 'tour-operator') + '</strong>' + ' ' + __('7 Days', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                        ],
                    },
                ],
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

            if (supportedPostTypes.includes(postType) || ((postType === 'wp_template' || postType === 'wp_template_part') && postSlug.includes('tour'))) {
                registerDurationVariation();
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
