/**
 * More Link Block Variation
 *
 * Registers a block variation for creating "read more" links.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/button', {
        name: 'lsx-tour-operator/more-link',
        title: 'More Button',
        icon: 'insert-after',
        name: 'core/button',
        category: 'lsx-tour-operator',
        attributes: {
            className: 'lsx-to-more-link more-link',
            metadata: {
                name: 'More Button',
            },
            width: 100,
            text: 'View More',
        },
        supports: {
            renaming: false,
        },
    });
});
