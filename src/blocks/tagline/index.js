import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    // Register variation function
    const registerTaglineVariation = () => {
        wp.blocks.registerBlockVariation('core/paragraph', {
            name: 'lsx-tour-operator/tagline',
            title: __('Tagline', 'tour-operator'),
            category: 'lsx-tour-operator',
            icon: 'text-page',
            description: __('Displays the tagline or slogan for this tour.', 'tour-operator'),
            keywords: [
                __('tagline', 'tour-operator'),
                __('slogan', 'tour-operator'),
                __('description', 'tour-operator'),
                __('headline', 'tour-operator'),
                __('catchphrase', 'tour-operator'),
                __('tour', 'tour-operator'),
            ],
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            attributes: {
                metadata: {
                    name: 'Tagline',
                    bindings: {
                        content: {
                            source: 'lsx/post-meta',
                            args: {
                                key: 'tagline',
                            },
                        },
                    },
                },
                align: 'center',
                className: 'lsx-tagline-wrapper',
            },
            isDefault: false,
            example: {
                innerBlocks: [
                    {
                        name: 'core/paragraph',
                        attributes: {
                            content: __('Discover the breathtaking beauty of Africa\'s premier safari destination', 'tour-operator'),
                        },
                    },
                ],
            },
        });
    };

    // Initialize conditional registration
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour'], // Supported post types
        ['tour'], // Template slug patterns
        registerTaglineVariation
    );

    conditionalRegister();
});
