/******/ (() => { // webpackBootstrap
/*!****************************************************!*\
  !*** ./src/blocks/featured-accommodation/index.js ***!
  \****************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/featured-accommodation",
    title: "Featured Accommodation",
    icon: "admin-multisite",
    description: "Displays Accommodation with the Featured tag.",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Featured Accommodation"
      },
      className: "lsx-featured-accommodation-query-wrapper",
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
      content: "Featured Accommodation"
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
        name: "Featured Accommodation Query"
      },
      query: {
        perPage: 8,
        postType: "accommodation",
        order: "asc",
        orderBy: "date"
      },
      align: "wide"
    }, [["core/post-template", {
      className: "lsx-featured-accommodation-query",
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
          name: "Featured Accommodation"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Featured Accommodation",
        textAlign: "center"
      }], ["core/group", {
        style: {
          spacing: {
            blockGap: "2rem"
          }
        },
        layout: {
          type: "grid",
          columnCount: 2
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
        content: "Premium Ocean View Suite",
        level: 3
      }], ["core/paragraph", {
        content: "Luxury beachfront accommodation with panoramic ocean views, private balcony, and exclusive amenities."
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
        content: "Executive Mountain Lodge",
        level: 3
      }], ["core/paragraph", {
        content: "Featured mountain retreat with stunning alpine views and world-class spa facilities."
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
        content: "Boutique City Hotel",
        level: 3
      }], ["core/paragraph", {
        content: "Award-winning boutique hotel in the heart of downtown with personalized service and modern design."
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
        content: "Safari Camp Deluxe",
        level: 3
      }], ["core/paragraph", {
        content: "Exclusive safari camp offering luxury tented accommodation with wildlife viewing and gourmet dining."
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map