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
  !*** ./src/blocks/not-included/index.js ***!
  \******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);

wp.domReady(() => {
  const {
    select
  } = wp.data;

  // Define supported post types
  const supportedPostTypes = ['tour', 'accommodation'];
  let registered = false;
  let checking = false;

  // Register variation function
  const registerNotIncludedVariation = () => {
    if (registered) {
      return;
    }
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/not-included',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Excluded items', 'tour-operator'),
      icon: 'dismiss',
      category: 'lsx-tour-operator',
      isActive: (blockAttributes, variationAttributes) => {
        return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
      },
      attributes: {
        metadata: {
          name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Not included', 'tour-operator')
        },
        className: 'lsx-not-included-wrapper'
      },
      innerBlocks: [['core/paragraph', {
        content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Price excludes:', 'tour-operator') + '</strong>'
      }], ['core/paragraph', {
        metadata: {
          bindings: {
            content: {
              source: 'lsx/post-meta',
              args: {
                key: 'not_included'
              }
            }
          }
        }
      }]],
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
      if (supportedPostTypes.includes(postType) || (postType === 'wp_template' || postType === 'wp_template_part') && (postSlug.includes('tour') || postSlug.includes('accommodation'))) {
        registerNotIncludedVariation();
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