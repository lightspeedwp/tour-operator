import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['tour'];
    let registered = false;
    let checking = false;

    // Register variation function
    const registerPriceVariation = () => {
        if (registered) {
            return;
        }

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/price',
            title: __('Price', 'tour-operator'),
            category: 'lsx-tour-operator',
            icon: 'money-alt',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
            },
            attributes: {
                metadata: {
                    name: 'Price',
                },
                align: 'wide',
                layout: {
                    type: 'flex',
                    flexWrap: 'nowrap',
                },
                className: 'lsx-price-wrapper',
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
                                iconName: 'priceIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: '<strong>' + __('From:', 'tour-operator') + '</strong>',
                            },
                        ],
                    ],
                ],
                [
                    'core/paragraph',
                    {
                        metadata: {
                            bindings: {
                                content: {
                                    source: 'lsx/post-meta',
                                    args: {
                                        key: 'price',
                                    },
                                },
                            },
                        },
                        className: 'amount',
                    },
                ],
            ],
            isDefault: false,
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
                                            iconType: 'solid',
                                            iconName: 'priceIcon',
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            content: '<strong>' + __('From: ', 'tour-operator') + '</strong>' + '$1,999',
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
                registerPriceVariation();
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
