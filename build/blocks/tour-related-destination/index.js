/******/ (() => { // webpackBootstrap
/*!******************************************************!*\
  !*** ./src/blocks/tour-related-destination/index.js ***!
  \******************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/tour-related-destination",
    title: "Related Tours - Destinations",
    icon: "admin-site",
    description: "Displays Tours related to a Destination.",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Related Tour - Destination"
      },
      className: "lsx-tour-related-destination-query-wrapper",
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
      className: "lsx-tour-related-destination-query",
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
          name: "Related Destinations"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Related Destinations",
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
        content: "Cape Town, South Africa",
        level: 3
      }], ["core/paragraph", {
        content: "Stunning coastal city with Table Mountain, beautiful beaches, and rich cultural heritage."
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
        content: "Serengeti National Park",
        level: 3
      }], ["core/paragraph", {
        content: "World-renowned wildlife sanctuary famous for the Great Migration and Big Five game viewing."
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
        content: "Victoria Falls",
        level: 3
      }], ["core/paragraph", {
        content: "One of the world's largest waterfalls offering breathtaking views and adventure activities."
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map