/**
 * Permalink Button Block Variation
 *
 * Registers a block variation for creating permalink buttons.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/permalink-button',
        title: 'Permalink',
        description: 'Add a button with a link to the current item.',
        category: 'lsx-tour-operator',
        attributes: {
            className: 'lsx-to-link permalink',
            metadata: {
                name: 'Permalink',
            },
            text: 'View More',
            url: '#permalink',
        },
        supports: {
            renaming: false,
        },
    });
});
