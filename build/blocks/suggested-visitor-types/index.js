/******/ (() => { // webpackBootstrap
/*!*****************************************************!*\
  !*** ./src/blocks/suggested-visitor-types/index.js ***!
  \*****************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/suggested-visitor-types",
    title: "Suggested Visitor Types",
    icon: "groups",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Suggested Visitor Types"
      },
      className: "lsx-suggested-visitor-types-wrapper",
      layout: {
        type: "constrained"
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
      url: lsxToEditor.assetsUrl + "blocks/friendly-TO-icon.png",
      alt: ""
    }], ["core/paragraph", {
      content: "<strong>Friendly</strong>:"
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
              key: "suggested_visitor_types"
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
          name: "Suggested Visitor Types"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Suggested Visitor Types",
        level: 3
      }], ["core/paragraph", {
        content: "Families, Couples, Adventure seekers"
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map