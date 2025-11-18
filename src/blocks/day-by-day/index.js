/**
 * Day by Day Block Variation
 *
 * Registers a block variation for displaying day-by-day itinerary.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/group', {
        name: 'lsx-tour-operator/day-by-day',
        title: 'Day by day',
        icon: 'clipboard',
        category: 'lsx-tour-operator',
        attributes: {
            metadata: {
                name: 'Day by day',
                bindings: {
                    content: {
                        source: 'lsx/tour-itinerary',
                    },
                },
            },
            align: 'wide',
            layout: {
                type: 'constrained',
            },
        },
        innerBlocks: [
            [
                'core/pattern',
                {
                    slug: 'lsx-tour-operator/itinerary-list',
                },
            ],
        ],
        supports: {
            renaming: false,
        },
        parent: ['lsx-tour-operator/itinerary'], // Restricts to "lsx/itinerary" block
    });
});
