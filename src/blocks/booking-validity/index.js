import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['tour'];
    let registered = false;
    let checking = false;

    // Register variation function
    const registerBookingValidityVariation = () => {
        if (registered) {
            return;
        }

        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/booking-validity',
            title: __('Booking validity', 'tour-operator'),
            icon: 'calendar',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
            },
            attributes: {
                metadata: {
                    name: __('Booking validity', 'tour-operator'),
                },
                className: 'lsx-booking-validity-wrapper',
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
                                iconName: 'bookingValidityIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                fontSize: 'x-small',
                                content: '<strong>' + __('Booking validity:', 'tour-operator') + '</strong>',
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
                                                key: 'booking_validity_start',
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
                                content: '-',
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
                                                key: 'booking_validity_end',
                                            },
                                        },
                                    },
                                },
                                content: 'End',
                            },
                        ],
                    ],
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

            if (supportedPostTypes.includes(postType) || ((postType === 'wp_template' || postType === 'wp_template_part') && postSlug.includes('tour'))) {
                registerBookingValidityVariation();
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
