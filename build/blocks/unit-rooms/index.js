/******/ (() => { // webpackBootstrap
/*!****************************************!*\
  !*** ./src/blocks/unit-rooms/index.js ***!
  \****************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/unit-rooms",
    title: "Rooms",
    icon: "admin-home",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Rooms",
        bindings: {
          content: {
            source: "lsx/accommodation-units",
            type: "rooms"
          }
        }
      },
      align: "wide",
      layout: {
        type: "constrained"
      }
    },
    innerBlocks: [["core/pattern", {
      slug: "lsx-tour-operator/room-card"
    }]],
    parent: ["lsx-tour-operator/units"],
    // Restricts to "lsx-tour-operator/units" block
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Rooms"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Rooms",
        level: 3
      }], ["core/paragraph", {
        content: "Spacious rooms with safari views"
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map