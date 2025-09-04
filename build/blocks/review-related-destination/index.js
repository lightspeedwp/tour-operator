/******/ (() => { // webpackBootstrap
/*!********************************************************!*\
  !*** ./src/blocks/review-related-destination/index.js ***!
  \********************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/review-related-destination",
    title: "Related Reviews - Destinations",
    icon: "admin-site",
    description: "Displays Reviews related to an Destination.",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Related Reviews - Destination"
      },
      className: "lsx-review-related-destination-query-wrapper",
      align: "full",
      backgroundColor: "primary-200",
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
      content: "Reviews"
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
        name: "Related Review Query - Destination"
      },
      query: {
        perPage: 8,
        postType: "review",
        order: "asc",
        orderBy: "date"
      },
      align: "wide"
    }, [["core/post-template", {
      className: "lsx-review-related-destination-query",
      layout: {
        type: "grid",
        columnCount: 2
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
          name: "Destination Reviews"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Destination Reviews",
        level: 3
      }], ["core/group", {
        style: {
          spacing: {
            blockGap: "1.5rem"
          }
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
        content: "Breathtaking Destination",
        level: 4
      }], ["core/paragraph", {
        content: '"Absolutely stunning scenery and rich cultural experiences. This destination exceeded all expectations!" - Alexandra P.'
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
        content: "Incredible Adventure",
        level: 4
      }], ["core/paragraph", {
        content: '"Perfect blend of adventure and relaxation. The local guides were fantastic and very knowledgeable." - Michael B.'
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
        content: "Must-Visit Location",
        level: 4
      }], ["core/paragraph", {
        content: '"A truly magical place with so much to see and do. We can\'t wait to return to explore more!" - Lisa and James H.'
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map