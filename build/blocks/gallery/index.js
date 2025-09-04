/******/ (() => { // webpackBootstrap
/*!*************************************!*\
  !*** ./src/blocks/gallery/index.js ***!
  \*************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/gallery", {
    name: "lsx-tour-operator/gallery",
    title: "TO Gallery",
    icon: "format-gallery",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "TO Gallery",
        bindings: {
          content: {
            source: "lsx/gallery"
          }
        }
      },
      linkTo: "none",
      sizeSlug: "thumbnail"
    },
    innerBlocks: [["core/image", {
      sizeSlug: "large",
      url: lsxToEditor.assetsUrl + "blocks/placeholder.png"
    }], ["core/image", {
      sizeSlug: "large",
      url: lsxToEditor.assetsUrl + "blocks/placeholder.png"
    }], ["core/image", {
      sizeSlug: "large",
      url: lsxToEditor.assetsUrl + "blocks/placeholder.png"
    }]],
    isDefault: false,
    example: {
      attributes: {
        metadata: {
          name: "Gallery"
        }
      },
      innerBlocks: [["core/gallery", {
        images: [{
          url: "",
          alt: "Safari landscape"
        }, {
          url: "",
          alt: "Wildlife viewing"
        }, {
          url: "",
          alt: "Accommodation view"
        }]
      }]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map