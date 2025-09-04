/******/ (() => { // webpackBootstrap
/*!*********************************************!*\
  !*** ./src/blocks/number-of-rooms/index.js ***!
  \*********************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/number-of-rooms",
    title: "Number of Rooms",
    icon: "admin-multisite",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Number of Rooms"
      },
      className: "lsx-number-of-rooms-wrapper",
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
      width: "20px",
      sizeSlug: "large",
      url: lsxToEditor.assetsUrl + "blocks/accommodation-rooms-icon.png",
      alt: ""
    }], ["core/paragraph", {
      content: "<strong>Number of Units</strong>:"
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
              key: "number_of_rooms"
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
          name: "Number of Rooms"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Number of Rooms",
        level: 3
      }], ["core/paragraph", {
        content: "25 rooms available"
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map