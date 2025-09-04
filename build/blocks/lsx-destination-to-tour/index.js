/******/ (() => { // webpackBootstrap
/*!*****************************************************!*\
  !*** ./src/blocks/lsx-destination-to-tour/index.js ***!
  \*****************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/lsx-destination-to-tour",
    title: "Destination to Tour",
    icon: "admin-site",
    category: "lsx-tour-operator",
    attributes: {
      name: "Destination to Tour",
      className: "lsx-destination-to-tour-wrapper",
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
      url: lsxToEditor.assetsUrl + "blocks/Typelocation-icon.png",
      alt: ""
    }], ["core/paragraph", {
      content: "<strong>Destinations:</strong>"
    }]]], ["core/group", {
      layout: {
        type: "flex",
        flexWrap: "nowrap"
      }
    }, [["core/paragraph", {
      metadata: {
        bindings: {
          content: {
            source: "lsx/post-connection",
            args: {
              key: "destination_to_tour"
            }
          }
        }
      },
      content: ""
    }]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Tours from this Destination"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Tours from this Destination",
        level: 3
      }], ["core/group", {
        style: {
          spacing: {
            blockGap: "2rem"
          }
        },
        layout: {
          type: "grid",
          columnCount: 3
        }
      }, [["core/group", {
        style: {
          border: {
            width: "1px",
            style: "solid",
            color: "#e0e0e0"
          },
          spacing: {
            padding: "1rem"
          }
        }
      }, [["core/heading", {
        content: "Wildlife Photography Tour",
        level: 3
      }], ["core/paragraph", {
        content: "Capture stunning wildlife moments with professional photography guides in this breathtaking destination."
      }]]], ["core/group", {
        style: {
          border: {
            width: "1px",
            style: "solid",
            color: "#e0e0e0"
          },
          spacing: {
            padding: "1rem"
          }
        }
      }, [["core/heading", {
        content: "Adventure Hiking Expedition",
        level: 3
      }], ["core/paragraph", {
        content: "Explore scenic trails and discover hidden gems with experienced local guides."
      }]]], ["core/group", {
        style: {
          border: {
            width: "1px",
            style: "solid",
            color: "#e0e0e0"
          },
          spacing: {
            padding: "1rem"
          }
        }
      }, [["core/heading", {
        content: "Cultural Immersion Experience",
        level: 3
      }], ["core/paragraph", {
        content: "Connect with local communities and learn about traditional customs and heritage."
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map