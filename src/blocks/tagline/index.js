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
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
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
            supports: {
                renaming: false,
            },
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
