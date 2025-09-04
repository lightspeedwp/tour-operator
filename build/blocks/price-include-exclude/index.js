/******/ (() => { // webpackBootstrap
/*!***************************************************!*\
  !*** ./src/blocks/price-include-exclude/index.js ***!
  \***************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/price-include-exclude",
    title: "Price Include & Exclude",
    icon: "money-alt",
    category: "lsx-tour-operator",
    attributes: {
      align: "wide",
      metadata: {
        name: "Price Include & Exclude"
      },
      className: "lsx-include-exclude-wrapper",
      layout: {
        type: "constrained"
      }
    },
    innerBlocks: [["core/columns", {
      align: "wide"
    }, [["core/column", {
      width: "50%",
      id: "lsx-included-wrapper"
    }, [["core/paragraph", {
      content: "<strong>Price Includes:</strong>"
    }], ["core/paragraph", {
      metadata: {
        bindings: {
          content: {
            source: "lsx/post-meta",
            args: {
              key: "included"
            }
          }
        }
      }
    }]]], ["core/column", {
      width: "50%",
      className: "lsx-not-included-wrapper"
    }, [["core/paragraph", {
      content: "<strong>Price Excludes:</strong>"
    }], ["core/paragraph", {
      metadata: {
        bindings: {
          content: {
            source: "lsx/post-meta",
            args: {
              key: "not_included"
            }
          }
        }
      }
    }]]]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Price Include & Exclude"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "What's Included & Excluded",
        level: 3
      }], ["core/columns", {}, [["core/column", {}, [["core/heading", {
        content: "Included",
        level: 4
      }], ["core/list", {
        values: "<li>Accommodation</li><li>Meals</li>"
      }]]], ["core/column", {}, [["core/heading", {
        content: "Excluded",
        level: 4
      }], ["core/list", {
        values: "<li>Flights</li><li>Insurance</li>"
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map