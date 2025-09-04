/******/ (() => { // webpackBootstrap
/*!********************************************************!*\
  !*** ./src/blocks/tour-related-accommodation/index.js ***!
  \********************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/tour-related-accommodation",
    title: "Related Tours - Accommodation",
    icon: "admin-multisite",
    description: "Displays Tours related to an Accommodation via the destination.",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Related Tour - Accommodation"
      },
      className: "lsx-tour-related-accommodation-query-wrapper",
      align: "full",
      layout: {
        type: "constrained"
      },
      tagName: "section"
    },
    innerBlocks: [["core/group", {
      align: "wide",
      layout: {
        type: "flex",
        flexWrap: "nowrap"
      }
    }, [["core/separator", {
      style: {
        layout: {
          selfStretch: "fill",
          flexSize: null
        }
      }
    }], ["core/heading", {
      textAlign: "center",
      content: "Related Tours"
    }], ["core/separator", {
      style: {
        layout: {
          selfStretch: "fill",
          flexSize: null
        }
      }
    }]]], ["core/group", {
      align: "wide",
      layout: {
        type: "constrained"
      }
    }, [["core/query", {
      metadata: {
        name: "Related Tours Query"
      },
      query: {
        perPage: 8,
        postType: "tour",
        order: "asc",
        orderBy: "date"
      },
      align: "wide"
    }, [["core/post-template", {
      className: "lsx-tour-related-accommodation-query",
      layout: {
        type: "grid",
        columnCount: 3
      }
    }, [["core/pattern", {
      slug: "lsx-tour-operator/destination-card"
    }]]]]]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Related Accommodation"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Related Accommodation",
        textAlign: "center"
      }], ["core/group", {
        style: {
          spacing: {
            blockGap: "2rem"
          }
        },
        layout: {
          type: "grid",
          columnCount: 3
        }
      }, [["core/group", {
        style: {
          border: {
            width: "1px",
            style: "solid",
            color: "#e0e0e0"
          },
          spacing: {
            padding: "1rem"
          }
        }
      }, [["core/heading", {
        content: "Safari Lodge",
        level: 3
      }], ["core/paragraph", {
        content: "Luxury safari lodge with panoramic views of the Serengeti and exceptional wildlife viewing opportunities."
      }]]], ["core/group", {
        style: {
          border: {
            width: "1px",
            style: "solid",
            color: "#e0e0e0"
          },
          spacing: {
            padding: "1rem"
          }
        }
      }, [["core/heading", {
        content: "Boutique Resort",
        level: 3
      }], ["core/paragraph", {
        content: "Intimate boutique resort offering personalized service and unique cultural experiences."
      }]]], ["core/group", {
        style: {
          border: {
            width: "1px",
            style: "solid",
            color: "#e0e0e0"
          },
          spacing: {
            padding: "1rem"
          }
        }
      }, [["core/heading", {
        content: "Eco Camp",
        level: 3
      }], ["core/paragraph", {
        content: "Sustainable eco-camp providing authentic wilderness experiences with minimal environmental impact."
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map