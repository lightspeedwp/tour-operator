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
  !*** ./src/blocks/dress/index.js ***!
  \***********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @utils/conditional-block-registration.js */ "./src/js/conditional-block-registration.js");


wp.domReady(() => {
  // Register variation function
  const registerDressVariation = () => {
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/dress',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Dress', 'tour-operator'),
      description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Display dress code and clothing recommendations for destinations.', 'tour-operator'),
      icon: wp.element.createElement('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        width: 20,
        height: 20,
        viewBox: '0 0 20 20',
        fill: 'none'
      }, wp.element.createElement('path', {
        d: 'M9.99853 4.66667C11.2955 4.66667 12.3459 3.47333 12.3459 2H13.9157C14.4145 2 14.8928 2.22333 15.2449 2.62333L18.7249 6.58C19.0917 6.99667 19.0917 7.67333 18.7249 8.09L17.2373 9.78C16.8705 10.1967 16.2748 10.1967 15.9081 9.78L14.6933 8.4V15.8667C14.6933 17.0433 13.8512 18 12.8154 18H7.18168C6.1459 18 5.30377 17.0433 5.30377 15.8667V8.4L4.08901 9.78C3.72223 10.1967 3.12658 10.1967 2.7598 9.78L1.27508 8.08667C0.908305 7.67 0.908305 6.99333 1.27508 6.57667L4.75507 2.62333C5.10718 2.22333 5.58546 2 6.08428 2H7.65409C7.65409 3.47333 8.70454 4.66667 10.0015 4.66667H9.99853Z',
        fill: '#currentColor'
      })),
      category: 'lsx-tour-operator',
      keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('dress', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('clothing', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('attire', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('code', 'tour-operator')],
      isActive: (blockAttributes, variationAttributes) => {
        return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
      },
      attributes: {
        metadata: {
          name: 'Dress'
        },
        className: 'lsx-dress-wrapper',
        layout: {
          type: 'constrained'
        }
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
        content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Dress', 'tour-operator') + '</strong>'
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
                key: 'dress'
              }
            }
          }
        }
      }]]]]], ['core/buttons', {}, [['core/button', {
        backgroundColor: 'primary',
        width: 100,
        text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('View More', 'tour-operator')
      }]]]],
      supports: {
        renaming: false
      },
      example: {
        attributes: {
          className: 'lsx-dress-wrapper'
        },
        innerBlocks: [{
          name: 'core/group',
          attributes: {
            layout: {
              type: 'constrained'
            }
          },
          innerBlocks: [{
            name: 'core/group',
            attributes: {
              layout: {
                type: 'constrained'
              }
            },
            innerBlocks: [{
              name: 'core/paragraph',
              attributes: {
                align: 'center',
                content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Dress', 'tour-operator') + '</strong>'
              }
            }]
          }, {
            name: 'core/group',
            attributes: {
              layout: {
                type: 'constrained'
              }
            },
            innerBlocks: [{
              name: 'core/paragraph',
              attributes: {
                content: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Smart casual attire is recommended. Lightweight clothing suitable for warm weather. Comfortable walking shoes advised for outdoor activities.', 'tour-operator')
              }
            }]
          }]
        }, {
          name: 'core/buttons',
          attributes: {},
          innerBlocks: [{
            name: 'core/button',
            attributes: {
              backgroundColor: 'primary',
              width: 100,
              text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('View More', 'tour-operator')
            }
          }]
        }]
      }
    });
  };

  // Initialize conditional registration
  const conditionalRegister = (0,_utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__.registerForPostTypesAndTemplates)(['destination'],
  // Supported post types
  ['destination'],
  // Template slug patterns
  registerDressVariation);
  conditionalRegister();
});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map