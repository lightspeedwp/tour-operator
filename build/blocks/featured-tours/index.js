/******/ (() => { // webpackBootstrap
/*!********************************************!*\
  !*** ./src/blocks/featured-tours/index.js ***!
  \********************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/featured-tours",
    title: "Featured Tours",
    icon: "palmtree",
    description: "Displays Tours with the Featured tag.",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Featured Tours"
      },
      className: "lsx-featured-tours-query-wrapper",
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
      content: "Featured Tours"
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
        name: "Featured Tours Query"
      },
      query: {
        perPage: 8,
        postType: "tour",
        order: "asc",
        orderBy: "date"
      },
      align: "wide"
    }, [["core/post-template", {
      className: "lsx-featured-tours-query",
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
          name: "Featured Tours"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Featured Tours",
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
        content: "🌟 Classic Safari Adventure",
        level: 3
      }], ["core/paragraph", {
        content: "Award-winning 8-day safari experience featuring the Big Five and luxury accommodations."
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
        content: "🌟 Cultural Heritage Explorer",
        level: 3
      }], ["core/paragraph", {
        content: "Featured cultural journey exploring ancient traditions and historical landmarks."
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
        content: "🌟 Mountain Expedition Plus",
        level: 3
      }], ["core/paragraph", {
        content: "Premium mountain trekking adventure with expert guides and exclusive access."
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
        content: "🌟 Coastal Paradise Tour",
        level: 3
      }], ["core/paragraph", {
        content: "Featured coastal experience with pristine beaches and marine wildlife encounters."
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map