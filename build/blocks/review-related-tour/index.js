/******/ (() => { // webpackBootstrap
/*!*************************************************!*\
  !*** ./src/blocks/review-related-tour/index.js ***!
  \*************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/review-related-tour",
    title: "Related Reviews - Tour",
    icon: "palmtree",
    description: "Displays Reviews related to a Tour.",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Related Reviews - Tour"
      },
      className: "lsx-review-related-tour-query-wrapper",
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
        name: "Related Reviews Query - Tour"
      },
      query: {
        perPage: 8,
        postType: "review",
        order: "asc",
        orderBy: "date"
      },
      align: "wide"
    }, [["core/post-template", {
      className: "lsx-review-related-tour-query",
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
          name: "Tour Reviews"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Tour Reviews",
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
        content: "Amazing Safari Experience",
        level: 4
      }], ["core/paragraph", {
        content: '"The tour exceeded all our expectations! The guide was knowledgeable and the wildlife viewing was incredible. Highly recommended!" - Sarah M.'
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
        content: "Unforgettable Journey",
        level: 4
      }], ["core/paragraph", {
        content: '"Perfect organization from start to finish. The accommodations were excellent and the itinerary was well-planned." - David L.'
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
        content: "Highly Professional",
        level: 4
      }], ["core/paragraph", {
        content: '"Outstanding service and attention to detail. This tour company knows how to create memorable experiences." - Jennifer K.'
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map