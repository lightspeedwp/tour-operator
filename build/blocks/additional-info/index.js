/******/ (() => { // webpackBootstrap
/*!*********************************************!*\
  !*** ./src/blocks/additional-info/index.js ***!
  \*********************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/additional-info",
    title: "Additional Information",
    icon: "info-outline",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Additional Info"
      },
      className: "lsx-additional-info-wrapper",
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
      content: "<strong>General</strong>"
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
              key: "additional_info"
            }
          }
        }
      }
    }]]]]], ["core/buttons", {}, [["core/button", {
      width: 100,
      content: "View More"
    }]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Additional Information"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Additional Information",
        level: 3
      }], ["core/paragraph", {
        content: "Important details and extra information for travelers."
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map