/******/ (() => { // webpackBootstrap
/*!****************************************************!*\
  !*** ./src/blocks/booking-validity-start/index.js ***!
  \****************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation("core/group", {
    name: "lsx-tour-operator/booking-validity-start",
    title: "Booking Validity",
    icon: "calendar",
    category: "lsx-tour-operator",
    attributes: {
      metadata: {
        name: "Booking Validity"
      },
      className: "lsx-booking-validity-start-wrapper",
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
      id: 122730,
      width: "20px",
      sizeSlug: "large",
      linkDestination: "none",
      url: lsxToEditor.assetsUrl + "blocks/booking-validity.svg",
      alt: ""
    }], ["core/paragraph", {
      fontSize: "x-small",
      content: "<strong>Booking validity:</strong>"
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
              key: "booking_validity_start"
            }
          }
        }
      },
      content: ""
    }], ["core/paragraph", {
      content: "-"
    }], ["core/paragraph", {
      metadata: {
        bindings: {
          content: {
            source: "lsx/post-meta",
            args: {
              key: "booking_validity_end"
            }
          }
        }
      },
      content: "End"
    }]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: "Booking Validity"
        }
      },
      innerBlocks: [["core/group", {}, [["core/heading", {
        content: "Booking Validity",
        level: 3
      }], ["core/paragraph", {
        content: "Valid for bookings made 30 days in advance."
      }]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map