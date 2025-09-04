/******/ (() => { // webpackBootstrap
/*!**********************************************!*\
  !*** ./src/blocks/permalink-button/index.js ***!
  \**********************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/button", {
    name: "lsx-tour-operator/permalink-button",
    title: "Permalink",
    description: "Add a button with a link to the current item.",
    category: "lsx-tour-operator",
    attributes: {
      className: "lsx-to-link permalink",
      metadata: {
        name: "Permalink"
      },
      text: "View More",
      url: "#permalink"
    },
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Permalink Button"
        }
      },
      innerBlocks: [["core/buttons", {}, [["core/button", {
        text: "View Details",
        url: "#"
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map