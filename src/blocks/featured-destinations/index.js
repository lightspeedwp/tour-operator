/**
 * Featured Destinations Block Variation
 *
 * Registers a block variation for displaying destinations with featured tag.
 * Available across all post types and templates.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */

import { __ } from '@wordpress/i18n';

wp.domReady(() => {
    wp.blocks.registerBlockVariation("core/group", {
        name: "lsx-tour-operator/featured-destinations",
        title: __("Featured Destinations", "tour-operator"),
        icon: "admin-site",
        description: __("Displays Destinations with Featured tag.", "tour-operator"),
        category: "lsx-tour-operator",
        keywords: [
            __('featured', 'tour-operator'),
            __('destinations', 'tour-operator'),
            __('locations', 'tour-operator'),
        ],
        attributes: {
            metadata: {
                name: "Featured Destinations",
            },
            className: "lsx-featured-destinations-query-wrapper",
            align: "full",
            layout: {
                type: "constrained",
            },
            tagName: "section",
        },
        innerBlocks: [
            [
                "core/group",
                {
                    align: "wide",
                    layout: { type: "flex", flexWrap: "nowrap" },
                },
                [
                    ["core/separator", { style: { layout: { selfStretch: "fill", flexSize: null } } }],
                    ["core/heading", { textAlign: "center", content: __("Featured Destinations", "tour-operator") }],
                    ["core/separator", { style: { layout: { selfStretch: "fill", flexSize: null } } }],
                ],
            ],
            [
                "core/group",
                { align: "wide", layout: { type: "constrained" } },
                [
                    [
                        "core/query",
                        {
                            metadata: {
                                name: "Featured Destination Query",
                            },
                            query: {
                                perPage: 8,
                                postType: "destination",
                                order: "asc",
                                orderBy: "date",
                            },
                            align: "wide",
                        },
                        [
                            [
                                "core/post-template",
                                {
                                    className: "lsx-featured-destinations-query",
                                    layout: {
                                        type: "grid",
                                        columnCount: 3,
                                    },
                                },
                                [["core/pattern", { slug: "lsx-tour-operator/destination-card" }]],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        example: {
            attributes: {
                metadata: {
                    name: "Featured Destinations",
                },
            },
            innerBlocks: [
                {
                    name: "core/group",
                    attributes: {
                        align: "wide",
                        layout: { type: "flex", flexWrap: "nowrap" },
                    },
                    innerBlocks: [
                        {
                            name: "core/separator",
                            attributes: {
                                style: {
                                    layout: { selfStretch: "fill", flexSize: null },
                                },
                            },
                        },
                        {
                            name: "core/heading",
                            attributes: {
                                textAlign: "center",
                                content: "Featured Destinations",
                                level: 2,
                            },
                        },
                        {
                            name: "core/separator",
                            attributes: {
                                style: {
                                    layout: { selfStretch: "fill", flexSize: null },
                                },
                            },
                        },
                    ],
                },
                {
                    name: "core/group",
                    attributes: {
                        align: "wide",
                        layout: { type: "constrained" },
                    },
                    innerBlocks: [
                        {
                            name: "core/group",
                            attributes: {
                                className: "lsx-featured-destinations-query",
                                layout: {
                                    type: "grid",
                                    columnCount: 2,
                                },
                            },
                            innerBlocks: [
                                {
                                    name: "core/group",
                                    attributes: {
                                        className: "destination-card",
                                    },
                                    innerBlocks: [
                                        {
                                            name: "core/image",
                                            attributes: {
                                                alt: "Emilia Romagna countryside",
                                                caption: "",
                                                aspectRatio: "3/2",
                                                style: {
                                                    border: { radius: { topLeft: "8px", topRight: "8px" } }
                                                }
                                            },
                                        },
                                        {
                                            name: "core/heading",
                                            attributes: {
                                                level: 3,
                                                content: "Emilia Romagna, Italy",
                                            },
                                        },
                                        {
                                            name: "core/paragraph",
                                            attributes: {
                                                content: "Explore the Emilia Romagna countryside with its charming villages, delicious cuisine, and rich history.",
                                            },
                                        },
                                    ],
                                },
                                {
                                    name: "core/group",
                                    attributes: {
                                        className: "destination-card",
                                    },
                                    innerBlocks: [
                                        {
                                            name: "core/image",
                                            attributes: {
                                                alt: "Biarritz coastline",
                                                caption: "",
                                                aspectRatio: "3/2",
                                                style: {
                                                    border: { radius: { topLeft: "8px", topRight: "8px" } }
                                                }
                                            },
                                        },
                                        {
                                            name: "core/heading",
                                            attributes: {
                                                level: 3,
                                                content: "Biarritz, France",
                                            },
                                        },
                                        {
                                            name: "core/paragraph",
                                            attributes: {
                                                content: "Discover pristine beaches and vibrant coastal communities.",
                                            },
                                        },
                                    ],
                                },
                            ],
                        },
                    ],
                },
            ],
        },
        isActive: (blockAttributes, variationAttributes) => {
            return blockAttributes.className === variationAttributes.className;
        },
    });
});
