/**
 * Facts Country Wrapper Block Variation
 *
 * Registers a block variation for destination country display.
 * Only available on destination post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';

function registerFactsCountryWrapperVariation() {
    try {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/facts-country-wrapper',
            title: __('Country', 'tour-operator'),
            icon: 'admin-site',
            category: 'lsx-tour-operator',
            isActive: (blockAttributes) =>
                blockAttributes?.className?.includes('facts-country-query-wrapper'),
            attributes: {
                metadata: {
                    name: __('Country', 'tour-operator'),
                },
                className: 'facts-country-query-wrapper',
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
                                iconName: 'destinationIcon',
                            },
                        ],
                        [
                            'core/paragraph',
                            {
                                content: `<strong>${__('Country', 'tour-operator')}</strong>`,
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
                                            source: 'lsx/post-connection',
                                            args: {
                                                key: 'post_parent',
                                            },
                                        },
                                    },
                                },
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
                attributes: {
                    metadata: {
                        name: __('Country', 'tour-operator'),
                    },
                },
                innerBlocks: [
                    [
                        'core/group',
                        {},
                        [
                            [
                                'core/heading',
                                {
                                    content: __('Country', 'tour-operator'),
                                    level: 3,
                                },
                            ],
                            [
                                'core/paragraph',
                                {
                                    content: 'South Africa',
                                },
                            ],
                        ],
                    ],
                ],
            },
        });
        return true;
    } catch (error) {
        console.error('Failed to register facts-country-wrapper block:', error);
        return false;
    }
}

wp.domReady(() => {
    const { select } = wp.data;

    // Define supported post types
    const supportedPostTypes = ['destination'];
    let registered = false;

    // Check if current post type is supported
    const checkAndRegister = () => {
        if (registered) {
            return true;
        }

        const postType = select('core/editor')?.getCurrentPostType();
        const postSlug = select('core/editor')?.getEditedPostSlug();

        if (!postType) {
            return false;
        }

        const isTemplateContext =
            postType === 'wp_template' || postType === 'wp_template_part';

        if (
            supportedPostTypes.includes(postType) ||
            (isTemplateContext &&
                postSlug &&
                (postSlug.includes('destination') ||
                    postSlug.includes('country') ||
                    postSlug.includes('region')))
        ) {
            registerFactsCountryWrapperVariation();
            registered = true;
        }

        return registered;
    };

    // Try immediate registration
    if (!checkAndRegister()) {
        // If not ready, check periodically
        const interval = setInterval(() => {
            if (checkAndRegister()) {
                clearInterval(interval);
            }
        }, 100);

        // Clean up after 5 seconds to prevent infinite checking
        setTimeout(() => clearInterval(interval), 5000);
    }
});
