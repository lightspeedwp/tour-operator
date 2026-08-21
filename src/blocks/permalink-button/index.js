/**
 * Permalink Button Block Variation
 *
 * Registers a block variation for creating permalink buttons.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package
 */
import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/buttons', {
        name: 'lsx-tour-operator/permalink-button',
        title: __('Permalink Button', 'tour-operator'),
        description: __(
            'Add a button with a link to the current item.',
            'tour-operator'
        ),
        category: 'lsx-tour-operator',
        attributes: {
            metadata: {
                name: __('Permalink Button', 'tour-operator'),
            },
            className: 'lsx-to-permalink-button-wrapper',
        },
        keywords: [
            __('permalink', 'tour-operator'),
            __('button', 'tour-operator'),
            __('link', 'tour-operator'),
        ],
        innerBlocks: [
            [
                'core/button',
                {
                    className: 'lsx-to-link permalink',
                    text: __('View More', 'tour-operator'),
                    url: '#permalink',
                    metadata: {
                        name: __('Permalink', 'tour-operator'),
                    },
                },
            ],
        ],
        example: {
            attributes: {
                className: 'lsx-to-link permalink',
            },
            innerBlocks: [
                {
                    name: 'core/button',
                    attributes: {
                        className: 'lsx-to-link permalink',
                        text: __('View More', 'tour-operator'),
                        url: '#permalink',
                    },
                },
            ],
        },
    });
});
