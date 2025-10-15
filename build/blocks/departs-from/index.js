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
/*!******************************************!*\
  !*** ./src/blocks/departs-from/index.js ***!
  \******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);

wp.domReady(() => {
  const {
    select
  } = wp.data;

  // Define supported post types
  const supportedPostTypes = ['tour'];
  let registered = false;
  let checking = false;

  // Register variation function
  const registerDepartsFromVariation = () => {
    if (registered) {
      return;
    }
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/departs-from',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Departs from', 'tour-operator'),
      icon: wp.element.createElement('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        width: 20,
        height: 20,
        viewBox: '0 0 20 20',
        fill: 'none'
      }, wp.element.createElement('path', {
        d: 'M12.6241 6.49648L6.39595 3.25585C6.14595 3.12773 5.85533 3.10585 5.59283 3.20273L4.30845 3.67148C3.98658 3.7871 3.8772 4.18398 4.08658 4.45273L7.25845 8.4496L4.1272 9.5871L2.24908 8.44335C2.05533 8.3246 1.81783 8.30273 1.6022 8.37773L1.09283 8.56523C0.799077 8.67148 0.674077 9.01835 0.833452 9.2871L2.50845 12.1559C2.99595 12.9902 4.01158 13.3559 4.91783 13.0246L5.32095 12.8777L17.771 8.34648C18.6803 8.01523 19.146 7.0121 18.8178 6.10273C18.4897 5.19335 17.4835 4.72773 16.5741 5.05585L12.6241 6.49648ZM2.00533 15.9996C1.4522 15.9996 1.00533 16.4465 1.00533 16.9996C1.00533 17.5527 1.4522 17.9996 2.00533 17.9996H18.0053C18.5585 17.9996 19.0053 17.5527 19.0053 16.9996C19.0053 16.4465 18.5585 15.9996 18.0053 15.9996H2.00533Z',
        fill: '#currentColor'
      })),
      category: 'lsx-tour-operator',
      isActive: (blockAttributes, variationAttributes) => {
        return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
      },
      attributes: {
        metadata: {
          name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Departs from', 'tour-operator')
        },
        className: 'lsx-departs-from-wrapper',
        layout: {
          type: 'constrained'
        }
      },
      innerBlocks: [['core/group', {
        layout: {
          type: 'flex',
          flexWrap: 'nowrap',
          verticalAlignment: 'middle'
        }
      }, [['lsx-tour-operator/icons', {
        iconType: 'outline',
        iconName: 'departsFromEndsInIcon'
      }], ['core/paragraph', {
        content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Departs From:', 'tour-operator') + '</strong>'
      }]]], ['core/group', {
        layout: {
          type: 'flex',
          flexWrap: 'nowrap'
        }
      }, [['core/paragraph', {
        metadata: {
          bindings: {
            content: {
              source: 'lsx/post-connection',
              args: {
                key: 'departs_from'
              }
            }
          }
        },
        content: ''
      }]]]],
      supports: {
        renaming: false
      }
    });
  };

  // Check if current post type is supported
  const checkAndRegister = () => {
    if (registered || checking) {
      return registered;
    }
    checking = true;
    try {
      const postType = select('core/editor')?.getCurrentPostType();
      const postSlug = select('core/editor')?.getEditedPostSlug();
      if (!postType || !postSlug) {
        checking = false;
        return false;
      }
      if (supportedPostTypes.includes(postType) || (postType === 'wp_template' || postType === 'wp_template_part') && postSlug.includes('tour')) {
        registerDepartsFromVariation();
        registered = true;
        checking = false;
        return true;
      }
    } catch (error) {
      console.error('Error in checkAndRegister:', error);
    }
    checking = false;
    return false;
  };

  // Try initial registration with a small delay
  setTimeout(() => {
    if (!checkAndRegister()) {
      // Subscribe to editor changes if initial check failed
      let unsubscribed = false;
      const unsubscribe = wp.data.subscribe(() => {
        if (unsubscribed) {
          return;
        }
        if (checkAndRegister()) {
          unsubscribed = true;
          unsubscribe();
        }
      });
    }
  }, 100);
});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map