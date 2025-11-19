/**
 * Itinerary Block Variation
 *
 * Registers a block variation for displaying tour itinerary.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */
import { __ } from '@wordpress/i18n';
import { registerForPostTypesAndTemplates } from '@utils/conditional-block-registration.js';

wp.domReady(() => {
    const registerItineraryVariation = () => {
        wp.blocks.registerBlockVariation('core/group', {
            name: 'lsx-tour-operator/itinerary',
            title: __('Itinerary', 'tour-operator'),
            icon: 'clipboard',
            category: 'lsx-tour-operator',
            description: __('A block to display the tour itinerary with a title and a list of day-by-day activities.', 'tour-operator'),
            isActive: (blockAttributes, variationAttributes) => {
                return blockAttributes.className === variationAttributes.className;
            },
            keywords: [
                __('itinerary', 'tour-operator'),
                __('schedule', 'tour-operator'),
                __('days', 'tour-operator'),
            ],
            attributes: {
                metadata: {
                    name: __('Itinerary', 'tour-operator'),
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
                className: 'lsx-itinerary-wrapper',
                tagName: 'section',
            },
            innerBlocks: [
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
                            'core/separator',
                            {
                                style: {
                                    layout: {
                                        selfStretch: 'fill',
                                        flexSize: null,
                                    },
                                },
                            },
                        ],
                        [
                            'core/heading',
                            {
                                textAlign: 'center',
                                content: __('Tour Itinerary', 'tour-operator'),
                            },
                        ],
                        [
                            'core/separator',
                            {
                                style: {
                                    layout: {
                                        selfStretch: 'fill',
                                        flexSize: null,
                                    },
                                },
                            },
                        ],
                    ],
                ],
                [
                    'core/group',
                    {
                        align: 'wide',
                        layout: {
                            type: 'constrained',
                        },
                    },
                    [
                        [
                            'core/pattern',
                            {
                                slug: 'lsx-tour-operator/itinerary-list',
                            },
                        ],
                    ],
                ],
            ],
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
                                name: 'core/separator',
                            },
                            {
                                name: 'core/heading',
                                attributes: {
                                    textAlign: 'center',
                                    content: __('Itinerary', 'tour-operator'),
                                    level: 2,
                                },
                            },
                            {
                                name: 'core/separator',
                            },
                        ],
                    },
                    {
                        name: 'core/group',
                        attributes: {
                            layout: {
                                type: 'grid',
                                columnCount: 3,
                                minimumColumnWidth: null,
                            },
                        },
                        innerBlocks: [
                            {
                                name: 'core/image',
                                attributes: {
                                    url: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 75"%3E%3Crect fill="%23ddd" width="100" height="75"/%3E%3C/svg%3E',
                                    alt: '',
                                },
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/heading',
                                        attributes: {
                                            level: 3,
                                            content: __('Day 1', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/separator',
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            fontSize: 'small',
                                            content: __('Arrival and transfer to hotel', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            fontSize: 'small',
                                            content: __('Accommodation:', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            fontSize: 'small',
                                            content: __('Post Hotel', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/image',
                                attributes: {
                                    url: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 75"%3E%3Crect fill="%23ddd" width="100" height="75"/%3E%3C/svg%3E',
                                    alt: '',
                                },
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/heading',
                                        attributes: {
                                            level: 3,
                                            content: __('Day 2', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/separator',
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            fontSize: 'small',
                                            content: __('Safari activities and details', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                            {
                                name: 'core/group',
                                innerBlocks: [
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            fontSize: 'small',
                                            content: __('Accommodation:', 'tour-operator'),
                                        },
                                    },
                                    {
                                        name: 'core/paragraph',
                                        attributes: {
                                            fontSize: 'small',
                                            content: __('Grand Hotel Africa', 'tour-operator'),
                                        },
                                    },
                                ],
                            },
                        ],
                    },
                ],
            },
        });
    }

    // Initialize conditional registration for tour context
    const conditionalRegister = registerForPostTypesAndTemplates(
        ['tour'], // Supported post types
        ['tour'], // Template slug patterns
        registerItineraryVariation
    );

    conditionalRegister();
});
