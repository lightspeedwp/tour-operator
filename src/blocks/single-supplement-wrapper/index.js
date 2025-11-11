import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['tour'];
    let registered = false;
    let checking = false;

    // Register variation function
    const registerSingleSupplementVariation = () => {
        if (registered) {
            return;
        }

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/single-supplement-wrapper',
            title: __('Single supplement', 'tour-operator'),
            icon: 'money-alt',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
            },
            attributes: {
                metadata: {
                    name: 'Single supplement',
                },
                className: 'lsx-single-supplement-wrapper',
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
                                iconType: 'solid',
                                iconName: 'singleSupplementIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '<strong>' + __('Single supplement:', 'tour-operator') + '</strong>',
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {},
                    [
                        [
                            'core/paragraph',
                            {
                                metadata: {
                                    bindings: {
                                        content: {
                                            source: 'lsx/post-meta',
                                            args: {
                                                key: 'single_supplement',
                                            },
                                        },
                                    },
                                },
                                className: 'amount',
                                content: '',
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
                                verticalAlignment: 'middle',
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'lsx-tour-operator/icons',
                                attributes: {
                                    iconType: 'solid',
                                    iconName: 'singleSupplementIcon',
                                },
                            },
                            {
                                name: 'core/paragraph',
                                attributes: {
                                    content: '<strong>' + __('Single supplement: ', 'tour-operator') + '</strong>' + '$299',
                                },
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
                registerSingleSupplementVariation();
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
