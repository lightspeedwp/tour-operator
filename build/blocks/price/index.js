/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/conditional-block-registration.js":
/*!**************************************************!*\
  !*** ./src/js/conditional-block-registration.js ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   createConditionalRegistration: function() { return /* binding */ createConditionalRegistration; },
/* harmony export */   registerForPostTypes: function() { return /* binding */ registerForPostTypes; },
/* harmony export */   registerForPostTypesAndTemplates: function() { return /* binding */ registerForPostTypesAndTemplates; },
/* harmony export */   registerForTemplates: function() { return /* binding */ registerForTemplates; }
/* harmony export */ });
/**
 * Conditional Block Registration Utility
 *
 * Provides a unified way to conditionally register WordPress block variations
 * based on post types and template slugs.
 */

/**
 * Creates a conditional block registration handler
 *
 * @param {Object} config - Configuration object
 * @param {string[]} config.postTypes - Array of post types that support the block
 * @param {string[]} config.templateSlugs - Array of template slug patterns to match
 * @param {Function} config.registerFunction - Function to call when conditions are met
 * @param {number} [config.timeout=100] - Initial timeout before checking registration
 *
 * @return {Function} A function that handles the conditional registration logic
 */
function createConditionalRegistration(config) {
  const {
    postTypes = [],
    templateSlugs = [],
    registerFunction,
    timeout = 100
  } = config;
  if (!registerFunction || typeof registerFunction !== 'function') {
    throw new Error('registerFunction is required and must be a function');
  }
  return function conditionallyRegister() {
    const {
      select
    } = wp.data;
    let registered = false;
    let checking = false;

    /**
     * Check if current context matches the registration criteria
     *
     * @return {boolean} True if block should be registered
     */
    const shouldRegister = () => {
      try {
        const postType = select('core/editor')?.getCurrentPostType();
        const postSlug = select('core/editor')?.getEditedPostSlug();
        if (!postType) {
          return false;
        }

        // Check direct post type match
        if (postTypes.includes(postType)) {
          return true;
        }

        // Check template context
        const isTemplateContext = postType === 'wp_template' || postType === 'wp_template_part';
        if (isTemplateContext && postSlug && templateSlugs.length > 0) {
          return templateSlugs.some(slugPattern => {
            if (typeof slugPattern === 'string') {
              return postSlug.includes(slugPattern);
            }
            if (slugPattern instanceof RegExp) {
              return slugPattern.test(postSlug);
            }
            return false;
          });
        }
        return false;
      } catch (error) {
        console.error('Error in shouldRegister:', error);
        return false;
      }
    };

    /**
     * Attempt to register the block if conditions are met
     *
     * @return {boolean} True if registration was successful
     */
    const checkAndRegister = () => {
      if (registered || checking) {
        return registered;
      }
      checking = true;
      if (shouldRegister()) {
        try {
          registerFunction();
          registered = true;
          checking = false;
          return true;
        } catch (error) {
          console.error('Error during block registration:', error);
          checking = false;
          return false;
        }
      }
      checking = false;
      return false;
    };

    // Try initial registration with timeout
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
    }, timeout);
  };
}

/**
 * Simplified registration for blocks that only support specific post types
 *
 * @param {string[]} postTypes - Array of supported post types
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
function registerForPostTypes(postTypes, registerFunction, options = {}) {
  return createConditionalRegistration({
    postTypes,
    registerFunction,
    ...options
  });
}

/**
 * Simplified registration for blocks that support templates with specific slug patterns
 *
 * @param {string[]} templateSlugs - Array of template slug patterns
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
function registerForTemplates(templateSlugs, registerFunction, options = {}) {
  return createConditionalRegistration({
    templateSlugs,
    registerFunction,
    ...options
  });
}

/**
 * Registration for blocks that support both post types and template patterns
 *
 * @param {string[]} postTypes - Array of supported post types
 * @param {string[]} templateSlugs - Array of template slug patterns
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
function registerForPostTypesAndTemplates(postTypes, templateSlugs, registerFunction, options = {}) {
  return createConditionalRegistration({
    postTypes,
    templateSlugs,
    registerFunction,
    ...options
  });
}

/***/ }),

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
/*!***********************************!*\
  !*** ./src/blocks/price/index.js ***!
  \***********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @utils/conditional-block-registration.js */ "./src/js/conditional-block-registration.js");


wp.domReady(() => {
  // Register variation function
  const registerPriceVariation = () => {
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/price',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Price', 'tour-operator'),
      category: 'lsx-tour-operator',
      icon: 'money-alt',
      keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('price', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('cost', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('amount', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('from', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('starting', 'tour-operator')],
      isActive: (blockAttributes, variationAttributes) => {
        return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
      },
      attributes: {
        metadata: {
          name: 'Price'
        },
        align: 'wide',
        layout: {
          type: 'flex',
          flexWrap: 'nowrap'
        },
        className: 'lsx-price-wrapper'
      },
      innerBlocks: [['core/group', {
        layout: {
          type: 'flex',
          flexWrap: 'nowrap',
          verticalAlignment: 'middle'
        }
      }, [['lsx-tour-operator/icons', {
        iconType: 'solid',
        iconName: 'priceIcon'
      }], ['core/paragraph', {
        content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('From:', 'tour-operator') + '</strong>'
      }]]], ['core/paragraph', {
        metadata: {
          bindings: {
            content: {
              source: 'lsx/post-meta',
              args: {
                key: 'price'
              }
            }
          }
        },
        className: 'amount'
      }]],
      isDefault: false,
      supports: {
        renaming: false
      },
      example: {
        innerBlocks: [{
          name: 'core/group',
          attributes: {
            layout: {
              type: 'flex',
              flexWrap: 'nowrap'
            }
          },
          innerBlocks: [{
            name: 'core/group',
            attributes: {
              layout: {
                type: 'flex',
                flexWrap: 'nowrap',
                verticalAlignment: 'middle'
              }
            },
            innerBlocks: [{
              name: 'lsx-tour-operator/icons',
              attributes: {
                iconType: 'solid',
                iconName: 'priceIcon'
              }
            }, {
              name: 'core/paragraph',
              attributes: {
                content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('From: ', 'tour-operator') + '</strong>' + '$1,999'
              }
            }]
          }]
        }]
      }
    });
  };

  // Initialize conditional registration
  const conditionalRegister = (0,_utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__.registerForPostTypesAndTemplates)(['tour'],
  // Supported post types
  ['tour'],
  // Template slug patterns
  registerPriceVariation);
  conditionalRegister();
});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map