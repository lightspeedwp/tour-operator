/******/ (() => { // webpackBootstrap
/*!*******************************************!*\
  !*** ./src/blocks/checkout-time/index.js ***!
  \*******************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/checkout-time",
    title: "Check Out Time",
    icon: "clock",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Check Out Time"
      },
      className: "lsx-checkout-time-wrapper",
      layout: {
        type: "flex",
        flexWrap: "nowrap"
      }
    },
    innerBlocks: [["core/group", {
      layout: {
        type: "flex",
        flexWrap: "nowrap",
        verticalAlignment: "top"
      }
    }, [["core/image", {
      id: 122720,
      width: "20px",
      sizeSlug: "large",
      linkDestination: "none",
      url: lsxToEditor.assetsUrl + "blocks/check-in-check-out-time.svg",
      alt: "",
      className: "wp-image-122720"
    }], ["core/paragraph", {
      content: "<strong>Check out time:</strong>"
    }]]], ["core/group", {
      layout: {
        type: "flex",
        flexWrap: "nowrap"
      }
    }, [["core/paragraph", {
      metadata: {
        bindings: {
          content: {
            source: "lsx/post-meta",
            args: {
              key: "checkout_time"
            }
          }
        }
      }
    }]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Check Out Time"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Check Out Time",
        level: 3
      }], ["core/paragraph", {
        content: "11:00 AM"
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map