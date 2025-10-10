/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
!function() {
/*!**********************************!*\
  !*** ./src/blocks/visa/index.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/**
 * Visa Block Variation
 *
 * Registers a block variation for destination visa information display.
 * Only available on destination post type edit screens.
 *
 * @since 2.1.0
 * @package Tour_Operator
 */


function registerVisaVariation() {
  try {
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/visa',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Visa', 'tour-operator'),
      icon: 'id-alt',
      category: 'lsx-tour-operator',
      isActive: blockAttributes => blockAttributes?.className?.includes('lsx-visa-wrapper'),
      attributes: {
        metadata: {
          name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Visa', 'tour-operator')
        },
        className: 'lsx-visa-wrapper'
      },
      innerBlocks: [['core/group', {
        layout: {
          type: 'constrained'
        }
      }, [['core/group', {
        layout: {
          type: 'constrained'
        }
      }, [['core/paragraph', {
        align: 'center',
        content: `<strong>${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Visa', 'tour-operator')}</strong>`
      }]]], ['core/group', {
        layout: {
          type: 'constrained'
        }
      }, [['core/paragraph', {
        metadata: {
          bindings: {
            content: {
              source: 'lsx/post-meta',
              args: {
                key: 'visa'
              }
            }
          }
        }
      }]]]]], ['core/buttons', {}, [['core/button', {
        width: 100,
        content: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('View More', 'tour-operator')
      }]]]],
      supports: {
        renaming: false
      },
      example: {
        attributes: {
          metadata: {
            name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Visa', 'tour-operator')
          }
        },
        innerBlocks: [['core/group', {}, [['core/heading', {
          content: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Visa', 'tour-operator'),
          level: 3
        }], ['core/paragraph', {
          content: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Visa requirements and information.', 'tour-operator')
        }]]]]
      }
    });
    return true;
  } catch (error) {
    console.error('Failed to register visa block:', error);
    return false;
  }
}
wp.domReady(() => {
  const {
    select
  } = wp.data;

  // Define supported post types
  const supportedPostTypes = ['destination'];
  let registered = false;

  // Check if current post type is supported
  const checkAndRegister = () => {
    if (registered) {
      return true;
    }
    const postType = select('core/editor')?.getCurrentPostType();
    const postSlug = select('core/editor')?.getEditedPostSlug();
    if (!postType || !postSlug) {
      return false;
    }
    if (supportedPostTypes.includes(postType) || (postType === 'wp_template' || postType === 'wp_template_part') && (postSlug.includes('destination') || postSlug.includes('country') || postSlug.includes('region'))) {
      registerVisaVariation();
      registered = true;
    }
    return registered;
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
}();
/******/ })()
;
//# sourceMappingURL=index.js.map