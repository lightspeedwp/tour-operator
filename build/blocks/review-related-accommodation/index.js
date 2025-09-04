/******/ (() => { // webpackBootstrap
/*!**********************************************************!*\
  !*** ./src/blocks/review-related-accommodation/index.js ***!
  \**********************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/review-related-accommodation",
    title: "Related Reviews - Accommodation",
    icon: "admin-multisite",
    description: "Displays Reviews related to an Accommodation.",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Related Reviews - Tour"
      },
      className: "lsx-review-related-accommodation-query-wrapper",
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
        name: "Related Review Query - Accommodation"
      },
      query: {
        perPage: 8,
        postType: "review",
        order: "asc",
        orderBy: "date"
      },
      align: "wide"
    }, [["core/post-template", {
      className: "lsx-review-related-accommodation-query",
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
          name: "Accommodation Reviews"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Accommodation Reviews",
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
        content: "Exceptional Service",
        level: 4
      }], ["core/paragraph", {
        content: '"Beautiful rooms with stunning views. The staff went above and beyond to make our stay memorable." - Maria S.'
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
        content: "Perfect Location",
        level: 4
      }], ["core/paragraph", {
        content: '"Amazing location with easy access to attractions. Clean, comfortable, and excellent amenities." - Robert T.'
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
        content: "Outstanding Experience",
        level: 4
      }], ["core/paragraph", {
        content: '"From check-in to check-out, everything was perfect. Highly recommend this accommodation!" - Emily R.'
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map