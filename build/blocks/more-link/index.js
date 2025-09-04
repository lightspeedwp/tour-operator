/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./src/blocks/more-link/index.js ***!
  \***************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/button", {
    // TODO: check if this works
    name: "lsx-tour-operator/more-link",
    title: "More Button",
    icon: "insert-after",
    category: "lsx-tour-operator",
    attributes: {
      className: "lsx-to-more-link more-link",
      metadata: {
        name: "More Button"
      },
      width: 100,
      text: "View More"
    },
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "More Link"
        }
      },
      innerBlocks: [["core/buttons", {}, [["core/button", {
        text: "Read More",
        url: "#"
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map