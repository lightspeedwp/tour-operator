/******/ (() => { // webpackBootstrap
/*!*****************************************!*\
  !*** ./src/blocks/electricity/index.js ***!
  \*****************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/electricity",
    title: "Electricity",
    icon: "admin-plugins",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Electricity"
      },
      className: "lsx-electricity-wrapper",
      layout: {
        type: "constrained"
      }
    },
    innerBlocks: [["core/group", {
      layout: {
        type: "constrained"
      }
    }, [["core/group", {
      layout: {
        type: "constrained"
      }
    }, [["core/paragraph", {
      align: "center",
      content: "<strong>Electricity</strong>"
    }]]], ["core/group", {
      layout: {
        type: "constrained"
      }
    }, [["core/paragraph", {
      metadata: {
        bindings: {
          content: {
            source: "lsx/post-meta",
            args: {
              key: "electricity"
            }
          }
        }
      }
    }]]]]], ["core/buttons", {}, [["core/button", {
      backgroundColor: "primary",
      width: 100,
      content: "View More"
    }]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Electricity"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Electricity",
        level: 3
      }], ["core/paragraph", {
        content: "230V, 50Hz. Type M plugs (3-pin)."
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map