/******/ (function() { // webpackBootstrap
/*!*******************************************!*\
  !*** ./src/blocks/checkout-time/index.js ***!
  \*******************************************/
wp.domReady(() => {
  const {
    select
  } = wp.data;

  // Define supported post types
  const supportedPostTypes = ['accommodation'];

  // Check if current post type is supported
  const checkAndRegister = () => {
    const postType = select('core/editor')?.getCurrentPostType();
    if (postType && supportedPostTypes.includes(postType)) {
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
            verticalAlignment: "middle"
          }
        }, [["lsx-tour-operator/icons", {
          iconType: "solid",
          iconName: "checkInAccommodationIcon"
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
      return true; // Registration successful
    }
    return false; // Post type not ready or not supported
  };

  // Try immediate registration
  if (!checkAndRegister()) {
    // If not ready, check periodically
    const interval = setInterval(() => {
      if (checkAndRegister()) {
        clearInterval(interval);
      }
    }, 100);

    // Clean up after 5 seconds to prevent infinite checking
    setTimeout(() => clearInterval(interval), 5000);
  }
});
/******/ })()
;
//# sourceMappingURL=index.js.map